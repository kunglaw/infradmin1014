<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Role
 * Handle role operation.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Role extends CI_Controller {

    private $_primary_table = "admin_role";
    private $_page_table = "admin_pages";

    private $_add_validation_rules = "add_role";
    private $_edit_validation_rules = "edit_role";

    private $_image_location = "";

    private $_menu = MENU_ROLE;

    private $_route = "role";
    private $_view_folder = "role";

    public function __construct() {

        parent::__construct();
        check_auth();
//        check_privileges($this->_menu);
    }


    /**
     * Show list page.
     */
    public function list_item() {

        set_page_title("Role Management");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] = base_url();
        $data["controller_name"] = $this->_route;
        $data["view_folder"] = $this->_view_folder;
        $data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list";
        $data["table_name"] = $this->_primary_table;
        $data["delete_table_name"] = $this->_primary_table;

        $data["create_popup_header"] = "Create New Role";
        $data["create_popup_submit"] = "Create";
        $data["edit_popup_header"] = "Edit Role";
        $data["edit_popup_submit"] = "Save";

        $data["popup_width"] = 400;

        $data["need_image_tools"] = false;

        // get list of role
        $this->load->helper("misc");
        $page_list = $this->generic->retrieve_many($this->_page_table);
        $data["page_list"] = convert_to_dropdown_conf($page_list);

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
            $this->_primary_table .".privileges AS privileges".
            $edit_button_area
        );

        $this->datatables->from($this->_primary_table);


        // modify first and last column for table bulk or individual operation.
        $this->load->helper("admin");

        $checkbox = form_checkbox("list_checkboxes[]", "$1");
        $this->datatables->edit_column("checkbox", $checkbox, "checkbox");

        $this->datatables->edit_column(
            "edit_link",
            '<a href="#create-edit-popup" class="edit-button open-popup">'.
            '<i class="fa fa-pencil"></i>' .
            '</a><input type="hidden" class="object-id" value="$1">'.
            '<a href="#create-edit-popup" class="edit-button-return-action"></a>',
            "edit_link");

        $this->datatables->edit_column(
            "delete_link",
            '<a href="#" class="delete-one-button" data-toggle="modal" data-target="#delete-one-confirmation">'.
            '<i class="fa fa-trash-o"></i>' .
            '</a><input type="hidden" class="object-id" value="$1">',
            "delete_link");

        $this->datatables->edit_column("privileges", "$1", "describe_privileges(privileges)");

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

            $chosen_privileges = $this->input->post("privileges[]");

            $chosen_page_list = $this->generic->retrieve_many_in_list(
                $this->_page_table, "id", $chosen_privileges);

            $privileges = 0;
            foreach ($chosen_page_list as $chosen_page) {
                $privileges += (int) $chosen_page["sign"];
            }

            $homepage = $chosen_page_list[0]["route"];

            $new_item = array(
                "name" => $this->input->post("name"),
                "privileges" => $privileges,
                "homepage" => $homepage
            );

            $this->generic->create($this->_primary_table, $new_item);

            $response["status"] = "success";
            $response["notification"] = "A new role has been created.";
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

                $chosen_privileges = $this->input->post("privileges[]");

                $chosen_page_list = $this->generic->retrieve_many_in_list(
                    $this->_page_table, "id", $chosen_privileges);

                $privileges = 0;
                foreach ($chosen_page_list as $chosen_page) {
                    $privileges += (int) $chosen_page["sign"];
                }

                $homepage = $chosen_page_list[0]["route"];

                $edited_item = array(
                    "name" => $this->input->post("name"),
                    "privileges" => $privileges,
                    "homepage" => $homepage
                );

                $this->generic->update(
                    $this->_primary_table,
                    $edited_item,
                    array("id" => $item["id"])
                );

                $response["status"] = "success";
                $response["notification"] = "Role has been saved.";
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
            "id, name, privileges"
        );

        // convert privileges to list of allowed pages
        $page_list = $this->generic->retrieve_many($this->_page_table);
        $privileges = $item["privileges"];
        $allowed_pages = array();

        foreach($page_list as $page) {

            if ($privileges & (int) $page["sign"]) {
                $allowed_pages[] = (int) $page["id"];
            }
        }

        $item["privileges"] = $allowed_pages;



        // pack them into json.
        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($item));
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/web/admin.php */