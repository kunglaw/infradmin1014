<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Bulk
 * Handle bulk action for list.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */
class Bulk extends CI_Controller {

    private $_allowed_table = array();
    private $_notification_table = "admin_message";
    private $_session_table = "admin_sessions";

    public function __construct() {

        parent::__construct();

        check_auth();

        $this->_allowed_table = $this->config->item("bulk_allowed_table");

        // add user_admin table to be allowed to be deleted if
        // we login as super admin
        if ($this->session->userdata("role") == USER_SUPER_ADMIN) {
            $this->_allowed_table[] = "admin_user";
            $this->_allowed_table[] = "admin_role";
        }
    }

    /**
     * Delete one row.
     * @param string $table_name
     */
    public function ajax_delete_one($table_name = "") {

        $response = array();

        $object_id = json_decode($this->input->post("id"));

        if (in_array($table_name, $this->_allowed_table)) {

            // request for approval if not super admin
            if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

                // make notification for vessel delete operation.
                if ($table_name == "ship") {

                    // request for delete this vessel. (flag: not followed up yet)
                    $notification = array(
                        "source" => $this->session->userdata("id"),
                        "destination" => NULL,
                        "type" => NOTIF_DELETE_VESSEL,
                        "target" => $object_id,
                        "status" => false // haven't followed up yet
                    );

                    $this->generic->create($this->_notification_table, $notification);

                    // add to delete request table.
                    $this->generic->create("admin_ship_delete_request", array("ship_id" => $object_id));

                    $response["status"] = "success";
                    $response["notification"] = "Delete is waiting for super admin approval.";

                } else {
                    $response["status"] = "error";
                    $response["notification"] = "Unauthorized to delete";
                }


            } else {

                $primary_key = $this->generic->primary($table_name);

                // arrange delete configuration
                $delete_conf = array(
                    $primary_key => $object_id
                );

                // special for admin user, never delete our own account.
                if ($table_name == "admin_user") {
                    $delete_conf["id <>"] = $this->session->userdata("id");
                    $delete_conf["id <> 1"] = NULL;
                }

                $this->generic_model->delete(
                    $table_name, $delete_conf
                );

                // clear deleted user session
                if ($table_name == "admin_user") {

                    // find this piece of string in session data to match user ID.
                    $data_element = "id|s:";
                    $id_length = strlen(strval($object_id));
                    $data_element .= $id_length .':"'. $object_id .'"';

                    $this->generic->delete(
                        $this->_session_table,
                        array("data LIKE '%". $data_element ."%'" => NULL)
                    );

                }


                // clear notification for vessel delete operation.
                if ($table_name == "ship") {

                    $this->load->helper("notification");
                    follow_up_request($object_id, NOTIF_DELETE_VESSEL);
                }



                if ($table_name == "admin_user") {

                    if ($object_id == $this->session->userdata("id")) {

                        $response["status"] = "error";
                        $response["notification"] = "Failed to delete data";

                    } else {

                        $response["status"] = "success";
                        $response["notification"] = "Successfully delete data";
                    }

                } else {

                    $response["status"] = "success";
                    $response["notification"] = "Successfully delete data";
                }
            }

        } else {

            $response["status"] = "error";
            $response["notification"] = "Failed to delete data";
        }

        $this->output->set_status_header(200);
        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }

    /**
     * Delete several row.
     *
     * @param string $table_name
     */
    public function ajax_delete_several($table_name = "") {

        $response = array();

        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            $response["status"] = "error";
            $response["notification"] = "Unauthorized to delete";

            $this->output->set_content_type("application/json");
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($response));

            return;
        }

        // only allowed table is only allowed to be deleted
        if (in_array($table_name, $this->_allowed_table)) {

            // convert checked object to array
            $checked_object = json_decode($this->input->post("listCheckboxes"), true);

            // request for approval if not super admin
            if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

                // make notification for vessel delete operation.
                if ($table_name == "ship") {

                    foreach ($checked_object as $object_id) {

                        // request for delete this vessel. (flag: not followed up yet)
                        $notification = array(
                            "source" => $this->session->userdata("id"),
                            "destination" => NULL,
                            "type" => NOTIF_DELETE_VESSEL,
                            "target" => $object_id,
                            "status" => false
                        );

                        $this->generic->create($this->_notification_table, $notification);

                        // add to delete request table.
                        $this->generic->create("admin_ship_delete_request", array("ship_id" => $object_id));
                    }

                    $response["status"] = "success";
                    $response["notification"] = "Delete is waiting for super admin approval.";

                } else {
                    $response["status"] = "error";
                    $response["notification"] = "Unauthorized to delete";
                }


            } else {

                $primary_key = $this->generic->primary($table_name);

                $incomplete_delete = false;

                // exclude master admin ID from deletion.
                if ($table_name == "admin_user") {

                    // restriction for deleting current logged-in user.
                    if (isset($checked_object[$this->session->userdata("id")])) {
                        $incomplete_delete = true;
                        unset($checked_object[$this->session->userdata("id")]);
                    }

                    // special restriction for deleting super admin with ID 1
                    if (isset($checked_object[1])) {
                        $incomplete_delete = true;
                        unset($checked_object[1]);
                    }
                }

                // do not execute delete if checked object contains no data.
                if (! empty($checked_object)) {

                    $this->generic_model->delete_many($table_name, $checked_object, $primary_key);

                    foreach ($checked_object as $object_id) {

                        // clear notification for vessel delete operation.
                        if ($table_name == "ship") {

                            $this->load->helper("notification");
                            follow_up_request($object_id, NOTIF_DELETE_VESSEL);
                        }
                    }
                }

                // message for incomplete delete.
                if ($incomplete_delete) {
                    if (empty($checked_object)) {
                        $response["status"] = "error";
                        $response["notification"] = "Data can't be deleted.";
                    } else {
                        $response["status"] = "success";
                        $response["notification"] = "Some data can't be deleted.";
                    }
                } else { // message for complete delete.
                    if (empty($checked_object)) {
                        $response["status"] = "error";
                        $response["notification"] = "There is no data to be deleted";
                    } else {
                        $response["status"] = "success";
                        $response["notification"] = "Successfully delete data";
                    }
                }

            }

        } else { // if we try to delete entry in table not allowed for deletion.

            $response["status"] = "error";
            $response["notification"] = "Failed to delete data";
        }

        $this->output->set_status_header(200);
        $this->output->set_content_type("application/json");
        $this->output->set_output(json_encode($response));
    }
}

/* End of file bulk.php */
/* Location: ./application/controllers/web/bulk.php */