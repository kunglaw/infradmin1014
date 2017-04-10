<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Notification
 * Handle notification.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Notification extends CI_Controller {

    private $_primary_table = "admin_message";
    private $_user_table = "admin_user";

    private $_menu = MENU_DASHBOARD;

    private $_route = "notification";

    private $_block_route = "seatizen";
    private $_unblock_route = "seatizen";
    private $_notification_route = "notification";
    private $_delete_table_name = "ship";

    private $_view_folder = "notification";

    public function __construct() {

        parent::__construct();
        check_auth();
        check_privileges($this->_menu);

    }

    /**
     * Show list page.
     */
    public function list_item() {

        set_page_title("Notification List");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] = base_url();
        $data["controller_name"] = $this->_route;
        $data["view_folder"] = $this->_view_folder;
        $data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list";
        $data["table_name"] = $this->_primary_table;

        $data["block_route"] = $this->_block_route;
        $data["unblock_route"] = $this->_unblock_route;
        $data["notification_route"] = $this->_notification_route;
        $data["delete_table_name"] = $this->_delete_table_name;

        $data["need_image_tools"] = false;

        $this->load->view($data["view_folder"] ."/item_list", $data);
    }

    /**
     * Return all item in specified table.
     */
    public function get_list_item_ajax() {

        $this->load->library("datatables");

        $edit_button_area = "";

        // specify columns for datatables
//        $this->datatables->select(
//            $this->_primary_table .".type AS notification_text, ".
//            $this->_primary_table .".object_id AS notification_action,".
//            $this->_primary_table .".type AS type, ".
//            $this->_primary_table .".object_id AS object_id,".
//            $this->_primary_table .".author AS author_id,".
//            $this->_primary_table .".action_time AS action_time".
//            $edit_button_area
//        );


        $z = $this->db->query("SELECT * FROM admin_message");
        $f = $z->result_array();

        $this->datatables->select(
            $this->_primary_table .".type AS notification_text, ".
            $this->_primary_table .".target AS notification_action,".

            $this->_primary_table .".type AS type, ".
            $this->_primary_table .".target AS target,".
            $this->_primary_table .".source AS source,".
            $this->_primary_table .".destination AS destination,".
            $this->_primary_table .".status AS status,".
            $this->_primary_table .".time AS time".
            $this->_primary_table ." order by time DESC".
            $edit_button_area
        );

        $this->datatables->from($this->_primary_table);

        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            $restrict_admin_notif = "(".
                "type = ". NOTIF_NEW_AGENTSEA . " OR ".
                "type = ". NOTIF_NEW_SEATIZEN . " OR ".
                "type = ". NOTIF_DELETE_VESSEL_REPLY . " OR ".
                "type = ". NOTIF_BLOCK_SEATIZEN_REPLY . " OR ".
                "type = ". NOTIF_UNBLOCK_SEATIZEN_REPLY . " OR ".
                ")";

            $this->datatables->where($restrict_admin_notif      , NULL, false);
        } else if($this->session->userdata('name') == $f['destination']){

            $restrict_admin_notif = "(".
                "type = ". NOTIF_EDIT_PIC . " OR ".
                ")";

        }


        else {

            $restrict_super_admin_notif = "(".
                "type = ". NOTIF_NEW_AGENTSEA . " OR ".
                "type = ". NOTIF_NEW_SEATIZEN . " OR ".
                "type = ". NOTIF_DELETE_VESSEL . " OR ".
                "type = ". NOTIF_BLOCK_SEATIZEN . " OR ".
                "type = ". NOTIF_UNBLOCK_SEATIZEN . " OR ".
                "type = ". NOTIF_NEW_REPORT . " OR ".
                ")";

            $this->datatables->where($restrict_super_admin_notif, NULL, false);
        }

        $this->datatables->where("status <", 2);


        $this->load->helper("notification");
        $this->datatables->edit_column(
            "notification_text",
            '$1',
            "get_notification_text(type, target, source, status)");

        $this->datatables->edit_column(
            "notification_action",
            '$1',
            "get_notification_action(type, target, source, status)");

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output($this->datatables->generate());
    }

    /**
     * Get new notification for notification status.
     */
    public function get_new_notification_ajax() {

        $user = $this->generic->retrieve_one(
            $this->_user_table,
            array("id" => $this->session->userdata("id"))
        );

        $previous_notification = $this->session->userdata("prev_notif");
        $last_view_time = $user["last_view_notif"];
        $last_notification_time_from_session = $this->session->userdata("last_notification_time");


        $criteria = array("status <" => 2);

        if (empty($last_notification_time_from_session)) {
            $criteria["time >"] = $last_view_time;
        } else {
            $criteria["time >"] = date("Y-m-d H:i:s", $last_notification_time_from_session);
        }

        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            $restrict_admin_notif = "(".
                "type = ". NOTIF_NEW_AGENTSEA . " OR ".
                "type = ". NOTIF_NEW_SEATIZEN . " OR ".
                "type = ". NOTIF_DELETE_VESSEL_REPLY . " OR ".
                "type = ". NOTIF_BLOCK_SEATIZEN_REPLY . " OR ".
                "type = ". NOTIF_UNBLOCK_SEATIZEN_REPLY . " OR ".
                "type = ". NOTIF_EDIT_PIC . 
                ")";

            $criteria[$restrict_admin_notif] = NULL;
        } else {

            $restrict_super_admin_notif = "(".
                "type = ". NOTIF_NEW_AGENTSEA . " OR ".
                "type = ". NOTIF_NEW_SEATIZEN . " OR ".
                "type = ". NOTIF_DELETE_VESSEL . " OR ".
                "type = ". NOTIF_BLOCK_SEATIZEN . " OR ".
                "type = ". NOTIF_UNBLOCK_SEATIZEN ." OR ".
                "type = ". NOTIF_NEW_REPORT .
                ")";

            $criteria[$restrict_super_admin_notif] = NULL;
        }

        $new_notification = $this->generic->retrieve_many(
            $this->_primary_table,
            $criteria,
            array("time" => "DESC")
        );

        $result = array();

        // count new amount since last user view.
        $criteria["time >"] = $last_view_time;

        $result["new_amount"] = $this->generic->get_total_rows(
            $this->_primary_table,
            $criteria
        );


        $this->load->helper("notification");
        $packed_notification_status = array();

        // no new notification, retrieve saved notif from session.
        if (empty($new_notification)) {

            $packed_notification_status = $previous_notification;

            if ($previous_notification == NULL) {
                $packed_notification_status = array();
                $this->session->set_userdata("prev_notif", array());
            }

        } else { // new notification exists, merge it together with session.

            $last_notification_time_from_db = strtotime($new_notification[0]["time"]);

            // if notification content is same between session and db.
            if ($last_notification_time_from_session == $last_notification_time_from_db) {

                $packed_notification_status = $previous_notification;

                if ($previous_notification == NULL) {
                    $packed_notification_status = array();
                    $this->session->set_userdata("prev_notif", array());
                }

            } else {

                $new_notif_total = count($new_notification);

                if ($new_notif_total > 5) { // chop the new notification, fit it into session.

                    $new_notification = array_slice($new_notification, 0, 5);
                }

                foreach ($new_notification as $notification_element) {
                    $packed_notification_status[] = get_notification_status(
                        $notification_element["type"],
                        $notification_element["target"],
                        $notification_element["source"],
                        $notification_element["status"],
                        $notification_element["destination"]
                    );
                }

                if ($new_notif_total < 5) { // merge with previously saved notif

                    $empty_entry = 5 - $new_notif_total;
                    $prev_notif_total = count($previous_notification);

                    if ($prev_notif_total < $empty_entry) {
                        $empty_entry = $prev_notif_total;
                    }

                    for ($i = 0; $i < $empty_entry; $i++) {
                        $packed_notification_status[] = $previous_notification[$i];
                    }
                }

                $this->session->set_userdata("prev_notif", $packed_notification_status);
                $this->session->set_userdata("last_notification_time", $last_notification_time_from_db);
            }
        }

        $result["notifications"] = $packed_notification_status;



        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($result));
    }

    /**
     * Clear saved previous notification,
     * and update notification time
     * when user clicked "see all notification"
     */
    public function update_notification_time_ajax() {

        $this->generic->update(
            $this->_user_table,
            array("last_view_notif" => date("Y-m-d H:i:s")),
            array("id" => $this->session->userdata("id"))
        );

        $this->session->set_userdata("last_view_notif", date("Y-m-d H:i:s"));
        $this->session->unset_userdata("prev_notif");

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(true);
    }

    public function reject_request() {

        if ($this->session->userdata("role") == USER_SUPER_ADMIN) {

            $object_id = $this->input->post("id");
            $type = $this->input->post("type");
            $author = $this->input->post("author");

            $this->load->helper("notification");
            follow_up_request($object_id, $type, 0);

            $response["status"] = NOTIF_SUCCESS;
            $response["notification"] = "Request has been rejected";

            $this->output->set_content_type("application/json");
            $this->output->set_status_header(200);
            $this->output->set_output(json_encode($response));
        }
    }

}

/* End of file Log_seatizen.php */
/* Location: ./application/controllers/web/Log_seatizen.php */