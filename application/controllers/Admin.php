<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Admin
 * Handle admin operation.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Admin extends CI_Controller {

    private $_primary_table = "admin_user";
    private $_role_table = "admin_role";

    private $_add_validation_rules = "add_admin";
    private $_edit_validation_rules = "edit_admin";

    private $_image_location = "assets/img/admin/";

    private $_menu = MENU_ADMIN;

    private $_route = "admin";
    private $_view_folder = "admin";

    public function __construct() {

        parent::__construct();
        check_auth();
        check_privileges($this->_menu);
    }


    /**
     * Show list page.
     */
    public function list_item() {

        set_page_title("Admin Management");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] = base_url();
        $data["controller_name"] = $this->_route;
        $data["view_folder"] = $this->_view_folder;
        $data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list";
        $data["table_name"] = $this->_primary_table;
        $data["delete_table_name"] = $this->_primary_table;

        $data["create_popup_header"] = "Create New Admin";
        $data["create_popup_submit"] = "Create";
        $data["edit_popup_header"] = "Edit Admin";
        $data["edit_popup_submit"] = "Save";

        $data["need_image_tools"] = true;

        // get list of role
        $this->load->helper("misc");
        $role_list = $this->generic->retrieve_many($this->_role_table);
        $data["role_list"] = convert_to_dropdown_conf($role_list);

        $this->load->view($data["view_folder"] ."/item_list", $data);
    }


	/**
     * Return all item in specified table.
     */
    public function get_list_item_ajax() {

        $this->load->library("datatables");

        $edit_button_area = ", ".
            $this->_primary_table .".id AS edit_link, ".
            $this->_primary_table .".id AS delete_link";

        // specify columns for datatables
        $this->datatables->select(
            $this->_primary_table .".id AS checkbox, ".

            $this->_primary_table .".name AS name, ".
            $this->_primary_table .".email AS email, ".
            $this->_primary_table .".role AS role".
            $edit_button_area
        );

        $this->datatables->from($this->_primary_table);

        // modify first and last column for table bulk or individual operation.
        $this->load->helper("admin");

        $this->datatables->edit_column("checkbox", "$1", "get_admin_checkboxes(email, checkbox)");

		$this->datatables->edit_column(
            "edit_link",
            '<a href="#create-edit-popup" class="edit-button open-popup">'.
            '<i class="fa fa-pencil"></i>' .
            '</a><input type="hidden" class="object-id" value="$1">'.
            '<a href="#create-edit-popup" class="edit-button-return-action"></a>',
            "edit_link");
			
        $this->datatables->edit_column(
            "delete_link",
            "$1",
            "get_admin_delete_link(email, delete_link)");

        $this->datatables->edit_column("role", "$1", "get_admin_status(role)");

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output($this->datatables->generate());
    }

    /**
     * Add item
     */
    public function add() {

        $response = array();

        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            $this->output->set_content_type("application/json");
            $this->output->set_status_header(403);
            $this->output->set_output(json_encode($response));

            return;
        }

        // if we load the form for the 1st time or wrong value on validation.
        if ($this->form_validation->run($this->_add_validation_rules) == FALSE) {

            $error = validation_errors();
            if ($error == "") {

            } else {

                set_notification("Incorrect input.", NOTIF_ERROR);
                $response["status"] = "error";
                $response["notification"] = get_notification();
                $response["errors"] = pack_error_message_ajax(array($this->_add_validation_rules));
            }

        } else {

            // set up a new password from random text.
            //$this->load->helper("string");
			$this->load->helper("password_generator_helper");
            $new_password = random_string(15);
			
			echo $new_password; 

            $new_item = array(
                "role" => $this->input->post("role"),
                "email" => $this->input->post("email"),
                "name" => $this->input->post("name"),
                "password" => $this->create_password($new_password),
                "image" => "",
                "last_view_notif" => 0
            );
			
			
            $new_item_id = $this->generic->create($this->_primary_table, $new_item);

            // move image from upload to img folder
            $image = $this->input->post("image");
            $new_image_file = "";

            if (! empty($image)) {

                $server_url = $this->config->item("server_url");
                $temp_image_file = $server_url . TEMP_IMAGE_UPLOAD_LOCATION . $image;
				// ../infradmin1014_upload/upload/upload/$image

                $this->load->helper("misc");
                $new_image_file = move_from_temp_loc(
                    $temp_image_file,
                    $server_url . $this->_image_location,
                    $new_item_id
                );
            }

            $this->generic_model->update(
                $this->_primary_table,
                array(
                    "image" => $new_image_file
                ),
                array("id" => $new_item_id)
            ); 


            // send email to new item.
            $data["plain_password"] = $new_password;
			
			
            $message = $this->load->view("email/new_admin", $data, TRUE);
            $subject = "New Admin Registration";

            $this->load->helper("email");
            $email_result = @send_email($new_item["email"], $subject, $message);

            if ($email_result)  {
                set_notification("A new admin has been created.", NOTIF_SUCCESS);
                $response["status"] = "success";
                $response["notification"] = "A new admin has been created.";
            } else {
                $response["status"] = "success";
                $response["notification"] = "A new admin has been created, however, system unable to send email.";
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));

    }

    /**
     * Edit item
     */
    public function edit() {

        $response = array();

        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            $this->output->set_content_type("application/json");
            $this->output->set_status_header(403);
            $this->output->set_output(json_encode($response));

            return;
        }


        // if we load the form for the 1st time or wrong value on validation.
        if ($this->form_validation->run($this->_edit_validation_rules) == FALSE) {

            if (validation_errors() == "") {

            } else {

                set_notification("Incorrect input.", NOTIF_ERROR);
                $response["status"] = "error";
                $response["notification"] = get_notification();
                $response["errors"] = pack_error_message_ajax(array($this->_edit_validation_rules));
            }


        } else {

            $item = $this->generic->retrieve_one(
                $this->_primary_table, array("id" => $this->input->post("id")));

            if (! $item) {

                set_notification("Incorrect input.", NOTIF_ERROR);
                $response["status"] = "error";
                $response["notification"] = get_notification();

            } else {

                $edited_item = array(
                    "role" => $this->input->post("role"),
                    "name" => $this->input->post("name"),
                );

                // update image if image is changed.
                $image = $this->input->post("image");

                if (! empty($image)) {
                    // move image from upload to img folder
                    $server_url = $this->config->item("server_url");
                    $temp_image_file = $server_url . TEMP_IMAGE_UPLOAD_LOCATION . $image;

                    $this->load->helper("misc");
                    $new_image_file = move_from_temp_loc(
                        $temp_image_file,
                        $server_url . $this->_image_location,
                        $item["id"]
                    );

                    $edited_item["image"] = $new_image_file;
                }

                $this->generic->update(
                    $this->_primary_table,
                    $edited_item,
                    array("id" => $this->input->post("id"))
                );

                // if edited user currently logged in, change the session too.
                if ($this->input->post("id") == $this->session->userdata("id")) {

                    // set session after editing name.
                    $this->session->set_userdata("name", $edited_item["name"]);
                }

                $response["status"] = "success";
                $response["notification"] = "Admin data has been saved.";
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }

    /**
     * Retrieve item detail, returning them as JSON.
     * @param $item_id
     */
    public function get_item_detail_ajax($item_id) {

        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            $this->output->set_content_type("application/json");
            $this->output->set_status_header(403);
            $this->output->set_output(json_encode(array()));

            return;
        }

        // retrieve item detail
        $item = $this->generic->retrieve_one(
            $this->_primary_table,
            array("id" => $item_id),
            array(),
            "id, email, name, role, image"
        );

        // give full URL to profile picture.
        if (! empty($item)) {
            $item["image"] = base_url() . $this->_image_location . $item["image"];
        }


        // pack them into json.
        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($item));
    }

    /**
     * Manually create password for user creation
     *
     * @param $raw_password
     * @return bool|string
     */
    private function create_password($raw_password) {

        $this->load->helper("password");
        return password_hash($raw_password, PASSWORD_BCRYPT);
    }

    /**
     * Generate encryption key for config.php
     */
    private function generate_encryption_key() {
        $this->load->library("encryption");
        echo bin2hex($this->encryption->create_key(16));
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/web/admin.php */