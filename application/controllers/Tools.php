<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Tools
 * Extra tools.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */
class Tools extends CI_Controller {

    private $_menu = MENU_TOOLS;

    private $_view_folder = "tools";

    public function __construct() {

        parent::__construct();
        check_auth();
        check_privileges($this->_menu);
    }

    /**
     * Show db usage, without free space.
     */
	 
    public function show_memory_usage() {

        set_page_title("Database Usage");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $db  = $this->generic->get_memory_info(DB);
		$db2 = $this->generic->get_memory_info(DB2);
		
		$data['db'] = array($db,$db2);
		
        $this->load->view($this->_view_folder ."/memory_usage",$data);
    }

    public function test() {

        $this->load->helper("tracker");
        track_new_seatizen(1);
		
		$this->db  = $this->load->database(DB_GROUP,true);
		$this->db2 = $this->load->database(DB2_GROUP,true);
		
		$this->db->select("*");
		$this->db->from("pelaut_ms");
		
		// $query = $this->db->get() or die('wiiiiiuuu wiiiiiiuuu');
		
		if(!$query = $this->db->get())
		{
			$this->db = $this->load->database(DB2_GROUP,true);
			$query = $this->db->get();
		}
		
		$f = $query->result_array();
		
		print_r($f);
		 
		/* $db = $this->load->database(DB_GROUP,true);
		if(!$db->table_exists($table) && $table != "")
		{
			$db = $this->load->database(DB2_GROUP,true);
			echo $table." exists in database "."<u>".DB2."</u>";
		}
		else if($db->table_exists($table))
		{
			echo $table." exists in database "."<u>".DB."</u>";	
		}
		else
		{
			echo "silahken isi table nya ...";	
		}*/
		
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/web/admin.php */