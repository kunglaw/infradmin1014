<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Log_seatizen
 * Handle logging of seatizen.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Log_seatizen extends CI_Controller {

    private $_primary_table = "log_seatizen";
    private $_seatizen_table = "pelaut_ms";

    private $_menu = MENU_SEATIZEN;

    private $_route = "seatizen/log";
    private $_parent_route = "seatizen";
    private $_view_folder = "log_seatizen";

    public function __construct() {

        parent::__construct();
        check_auth();
        check_privileges($this->_menu);

    }


    /**
     * Show list page.
     */
    public function list_item($item_id) {

        set_page_title("Seatizen Log");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] = base_url();
        $data["controller_name"] = $this->_route;
        $data["view_folder"] = $this->_view_folder;
        $data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list/". $item_id;
        $data["table_name"] = $this->_primary_table;

        $data["need_image_tools"] = false;

        $item = $this->generic->retrieve_one(
            $this->_seatizen_table,
            array("pelaut_id" => $item_id)
        );

        if (empty($item)) {
            set_notification("Seatizen does not exist", NOTIF_ERROR);
            redirect($this->_parent_route);
        }

        $data["item_name"] = $item["nama_depan"] ." ". $item["nama_belakang"];

        $this->load->view($data["view_folder"] ."/item_list", $data);
    }

    /**
     * Return all item in specified table.
     * @param $item_id
     */
    public function get_list_item_ajax($item_id) {

        $this->load->library("datatables");

        $edit_button_area = "";

        // specify columns for datatables
        $this->datatables->select(
			$this->_primary_table .".username AS username, ".
			$this->_primary_table .".nama AS nama, ".
			$this->_primary_table .".action AS action, ".
            $this->_primary_table .".ip_address AS ip_address, ".
			$this->_primary_table .".user_agent AS user_agent, ".
			$this->_primary_table .".session_id AS session_id, ".
			$this->_primary_table .".url AS url, ".
            $this->_primary_table .".action_time AS action_time_shown, ".
            $this->_primary_table .".action_time AS action_time_hidden".
            $edit_button_area
        );

        $this->datatables->from($this->_primary_table);

        $this->datatables->where($this->_primary_table .".seatizen_id", $item_id);

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output($this->datatables->generate());
    }

}

/* End of file Log_seatizen.php */
/* Location: ./application/controllers/web/Log_seatizen.php */