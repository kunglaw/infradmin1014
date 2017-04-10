<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for tracking purposes
 *
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_DB_active_record $_current_db
 *
 * @copyright PT. Badr Interactive (c) 2015
 * @author pulung
 */
class Tracker_model extends CI_Model {
    // current database object used
    private $_current_db 			= NULL;
    private $_seatizen_table 		= "log_seatizen";
    private $_agentsea_table 		= "log_agentsea";
    private $_vacantsea_table 	   = "log_vacantsea";
    private $_login_seatizen_table  = "log_login_seatizen";
    private $_login_agentsea_table  = "log_login_agentsea";
	private $_user_history_table    = "user_history";

    /**
     * Load database with database name options
     * @param string $database_name
     */
    public function __construct($database_name = "") {

        $this->_current_db = $this->load->database(DB2_GROUP, TRUE);
		
		//$this->load->model("users/user_model");
		//$this->load->model("company/company_model");
		//$this->load->model("vacantsea/vacantsea_model");
		
        // set timezone for further db query.
        $this->_current_db->query("SET time_zone = '+7:00'");
        $this->load->library('user_agent');
		
    }
	
	function get_pelaut($pelaut_id)
	{
		$str = "SELECT * FROM pelaut_ms WHERE pelaut_id = '$pelaut_id' ";
		$q   = $this->db->query($str);
		$f   = $q->row_array();
		
		return $f; 	
	}
	
	function get_vacantsea($vacantsea_id)
	{
		$str = "SELECT * FROM vacantsea WHERE vacantsea_id = '$vacantsea_id' ";
		$q   = $this->db->query($str);
		$f   = $q->row_array();
		
		return $f;   	
		
	}
	
    /**
     * Save seatizen action in text
     *
     * @param $seatizen_id
     * @param $action
     */
    public function save_seatizen_action($seatizen_id, $action) {
		
		$pelaut = $this->get_pelaut($seatizen_id);
		
        $log = array(
		
            "seatizen_id"   => $seatizen_id,
            "action" 		=> $action,
			"url"		   => current_url(),
            "username" 	  => $pelaut["username"],
            "nama" 		  => $pelaut["nama_depan"]." ".$pelaut["nama_belakang"],
            "ip_address" 	=> $_SERVER['REMOTE_ADDR'],
            "user_agent" 	=> $this->agent->agent_string(),
            "session_id" 	=> $this->session->userdata("session_id")
        );
		
		

        $this->db->insert($this->_seatizen_table, $log);

    }

    /**
     * Save agentsea action in text
     *
     * @param $agentsea_id
     * @param $action
     */
	//  private $_agentsea_table = "log_agentsea";
    public function save_agentsea_action($agentsea_id, $action) {
		
		$str       = "SELECT * FROM perusahaan where id_perusahaan = '$agentsea_id'";
		$q         = $this->db->query($str);
		$company   = $q->row_array();
		
        $log = array(
		
            "agentsea_id" 	=> $agentsea_id,
            "action" 		 => $action,
			"username" 	   => $company["username"],
			"url"			=> current_url(),
			"nama" 		   => $company["nama_perusahaan"],
			"ip_address" 	 => $_SERVER['REMOTE_ADDR'],
			"user_agent" 	 => $this->agent->agent_string(),
			"session_id" 	 => $this->session->userdata("session_id")
        );

        $this->db->insert($this->_agentsea_table, $log);

    }

    /**
     * Save vacantsea visitor
     *
     * @param $seatizen_id
     * @param $vacantsea_id
     */  
	 //private $_vacantsea_table = "log_vacantsea";
    public function save_vacantsea_visitor($seatizen_id, $vacantsea_id) {
		
		$vacant = $this->get_vacantsea($vacantsea_id);
		$pelaut = $this->get_pelaut($seatizen_id); 
		
        $log = array(
		
            "seatizen_id" 	 => $seatizen_id,
            "vacantsea_id" 	=> $vacantsea_id,
			"username" 		=> $pelaut["username"],
			"url"			 => current_url(),
			"nama" 			=> $pelaut["nama_depan"]." ".$pelaut["nama_belakang"],
			"ip_address" 	  => $_SERVER['REMOTE_ADDR'],
			"user_agent" 	  => $this->agent->agent_string(),
			"session_id" 	  => $this->session->userdata("session_id")
        );

        $query = $this->db->get_where($this->_vacantsea_table, $log);
        $result = $query->row_array();

        if (empty($result)) {
			
            $this->db->insert($this->_vacantsea_table, $log);
			
        }

    }

    /**
     * Save login action
     *
     * @param $seatizen_id
     */
	// private $_login_seatizen_table = "log_login_seatizen";
    public function save_login_seatizen_action($seatizen_id) {
		
        $log = array(
		
            "seatizen_id" => $seatizen_id,
			"url"		 => current_url(),
			"nama" 		=> $this->session->userdata("nama"),
			"username" 	=> $this->session->userdata("username"),
			"ip_address"  => $_SERVER['REMOTE_ADDR'],
			"user_agent"  => $this->agent->agent_string(),
			"session_id"  => $this->session->userdata("session_id")
        );

        $this->db->insert($this->_login_seatizen_table, $log);
    }
	
	public function delete_login_seatizen($seatizen_id)
	{
		
		$this->db->delete($this->_login_seatizen_table,array("seatizen_id"=>$seatizen_id));
	}

    /**
     * Save login action
     *
     * @param $agentsea_id
     */
	//private $_login_agentsea_table = "log_login_agentsea";
    public function save_login_agentsea_action($agentsea_id) {
		
		
		
        $log = array(
            "agentsea_id" 	=> $agentsea_id,
			
			"url"			=> current_url(),
			"nama" 		   => $this->session->userdata("nama_perusahaan"),
			"username" 	   => $this->session->userdata("username_company"),
			"ip_address" 	 => $_SERVER['REMOTE_ADDR'],
			"user_agent" 	 => $this->agent->agent_string(),
			"session_id"     => $this->session->userdata("session_id")
        );

        $this->db->insert($this->_login_agentsea_table, $log);

    }
	
	public function delete_login_agentsea($agentsea_id)
	{
		
		$str = "DELETE FROM log_login_agentsea WHERE agentsea_id = '$agentsea_id' ";
		$q = $this->db->query($str);
		
		//$this->db->delete($this->_login_agentsea_table,array("agentsea_id"=>$agentsea_id));
	}
	
	public function save_user_history($action)
	{
		
		$log = array(
           
			"url"			 => current_url(),
			"action"		  => $action, // ?? 
			"ip_address" 	  => $_SERVER['REMOTE_ADDR'],
			"user_agent" 	  => $this->agent->agent_string(),
			"location"	    => "", // get location
			"cookies"		 => "",
        );	
		
		$this->db->insert($this->_user_history_table, $log);
		
	}
	
}