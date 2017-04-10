<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Vessel
 * Handle vessel operation.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Vessel extends CI_Controller {

    private $_primary_table = "ship";
    private $_ship_type_table = "ship_type";
    private $_agentsea_table = "perusahaan";
    private $_nationality_table = "nationality";

    private $_menu = MENU_VESSEL;

    private $_route = "vessel";
    private $_view_folder = "vessel";

    public function __construct() {

        parent::__construct();
        check_auth();
        check_privileges($this->_menu);

    }


    /**
     * Show list page.
     */
    public function list_item() {

        set_page_title("Vessel Management");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] = base_url();
        $data["controller_name"] = $this->_route;
        $data["view_folder"] = $this->_view_folder;
        $data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list";
        $data["table_name"] = $this->_primary_table;
        $data["delete_table_name"] = $this->_primary_table;

        $data["need_image_tools"] = false;

        $this->load->view($data["view_folder"] ."/item_list", $data);
    }


    /**
     * Return all item in specified table.
     */
    public function get_list_item_ajax($item_id = NULL) {

        $this->load->library("datatables");

        $company_column = "";
        if ($item_id == NULL) {
            $company_column = ", ".
                $this->_agentsea_table .".nama_perusahaan AS company";
        }

        $edit_button_area = ", ".
            $this->_primary_table .".ship_id AS delete_link";

        // specify columns for datatables
        $this->datatables->select(
            $this->_primary_table .".ship_id AS checkbox, ".
            $this->_primary_table .".ship_name AS name, ".
            $this->_ship_type_table .".ship_type AS type".
            $company_column .
            $edit_button_area
        );

        $this->datatables->from($this->_primary_table);

        $this->datatables->join(
            $this->_ship_type_table,
            $this->_ship_type_table .".type_id = ". $this->_primary_table .".id_ship_type",
            "left outer"
        );

        if ($item_id != NULL) {

            $this->datatables->where($this->_primary_table .".id_perusahaan", $item_id);

        } else {
            $this->datatables->join(
                $this->_agentsea_table,
                $this->_agentsea_table .".id_perusahaan = ". $this->_primary_table .".id_perusahaan",
                "left outer"
            );
        }


        // modify first and last column for table bulk or individual operation.

        $this->load->helper("vessel");
        $this->datatables->edit_column(
            "delete_link",
            '$2<input type="hidden" class="object-id" value="$1">',
            "delete_link, get_vessel_delete_action(checkbox)");

        $checkbox = form_checkbox("list_checkboxes[]", "$1");
        $this->datatables->edit_column("checkbox", $checkbox, "checkbox");

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output($this->datatables->generate());
    }

    /**
     * Show item detail
     * @param $item_id
     */
    public function show_item_detail($item_id) {
		
		
		
        set_page_title("Vessel Detail");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $item_detail = $this->generic->retrieve_one(
            $this->_primary_table, array("ship_id" => $item_id));

        if (empty($item_detail)) {
            set_notification("Detail is not available.", NOTIF_ERROR);
            redirect($this->_route);
        }

        $ship_type = $this->generic->retrieve_one(
            $this->_ship_type_table, array("type_id" => $item_detail["id_ship_type"]));

        if (! empty($ship_type)) {
            $item_detail["ship_type"] = $ship_type["ship_type"];
        } else {
            $item_detail["ship_type"] = "";
        }


        $nationality = $this->generic->retrieve_one(
            $this->_nationality_table, array("id" => $item_detail["flag"]));

        if (! empty($nationality)) {
            $item_detail["nationality"] = $nationality["name"];
        } else {
            $item_detail["nationality"] = "";
        }

        $item_detail["delete_table_name"] = $this->_primary_table;
        $item_detail["delete_parent_route"] = $this->_route;

        $this->load->view($this->_view_folder ."/item_detail", $item_detail);
    }

    /**
     * Import excel.
     */
    public function import() {

        $this->load->helper("excel");
        $response = import_excel_vessel();

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }

}

/* End of file admin.php */
/* Location: ./application/controllers/web/admin.php */