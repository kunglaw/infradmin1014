<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * Class Log_vacantsea

 * Handle logging of vacantsea.

 *

 * @author pulung

 * @copyright 2015 PT. Badr Interactive

 */



class Log_vacantsea extends CI_Controller {



    private $_primary_table = "log_vacantsea";

    private $_seatizen_table = "pelaut_ms";

    private $_vacantsea_table = "vacantsea";



    private $_menu = MENU_VACANTSEA;



    private $_route = "vacantsea/viewer";

    private $_parent_route = "vacantsea";

    private $_view_folder = "log_vacantsea";



    public function __construct() {



        parent::__construct();

        check_auth();

        check_privileges($this->_menu);
		
		$this->load->model("vacantsea_model");
		$this->load->model("seatizen_model");


    }
	
	function geocite()
	{
		$ip_address = $this->input->post("ip_address");
		
		$geo = json_decode(file_get_contents("https://freegeoip.net/json/$ip_address"),TRUE);
		
		return $location = $geo["city"].", ".$geo["region_name"].", ".$geo["country_name"];
	}
	
    /**
     * Show list page.
     */

    public function list_item($item_id) {



        set_page_title("Vacantsea Viewer");



        $this->session->set_userdata("sidebar_flag", $this->_menu);



        $data["base_url"] = base_url();

        $data["controller_name"] = $this->_route;

        $data["view_folder"] = $this->_view_folder;

        $data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list/". $item_id;
		
		$data["list_log"]   = $this->vacantsea_model->log_vacantsea($item_id);
        $data["table_name"] = $this->_primary_table;



        $data["need_image_tools"] = false;



       /*  $item = $this->generic->retrieve_one(

            $this->_vacantsea_table,

            array("vacantsea_id" => $item_id)

        );



        if (empty($item)) {

            set_notification("Vacantsea does not exist", NOTIF_ERROR);

            redirect($this->_parent_route);

        }*/



        $data["item_name"] = $item["vacantsea"];



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

            "CONCAT_WS(' ', ". $this->_seatizen_table .".nama_depan, ". $this->_seatizen_table .".nama_belakang) AS name, ".
			
			$this->_primary_table.".ip_address, ".
			
            $this->_primary_table .".action_time AS action_time".

            $edit_button_area,



            false

        );



        $this->datatables->from($this->_primary_table);



        $this->datatables->join(

            $this->_seatizen_table,

            $this->_seatizen_table .".pelaut_id = ". $this->_primary_table .".seatizen_id",

            "left"

        );



        $this->datatables->where($this->_primary_table .".vacantsea_id", $item_id);



        $this->output->set_content_type("application/json");

        $this->output->set_status_header(200);

        $this->output->set_output($this->datatables->generate());

    }



}



/* End of file Log_seatizen.php */

/* Location: ./application/controllers/web/Log_seatizen.php */