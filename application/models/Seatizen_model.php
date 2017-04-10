<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Special model for seatizen operation.
 *
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_DB_active_record $_current_db
 *
 * @copyright PT. Badr Interactive (c) 2015
 * @author pulung
 */
class Seatizen_model extends CI_Model {

    // current database object used
    private $_current_db = NULL;
    private $_primary_table = "pelaut_ms";
	
	private $db2 = NULL;
    /**
     * Load database with database name options
     * @param string $database_name
     */
    public function __construct($database_name = DB2_GROUP) {

        $this->_current_db = $this->load->database($database_name, TRUE);
		$this->db2 		 = $this->load->database(DB2_GROUP,TRUE);
    }
	
	function delete_full_seatizen($id_seatizen)
	{
		/*
			- applicant_tr = id_pelaut
			- comment_timeline = username
			- competency_tr = pelaut_id
			- document_tr = pelaut_id
			- experiences = pelaut_id
			- experiences_appraisal = id_pelaut
			- log_login_seatizen = seatizen_id
			- pelaut_ms = pelaut_id
			- photo_pelaut_tr = id_pelaut
			- proficiency_tr = pelaut_id
			- profile_resume_tr = pelaut_id 
			- recommendation_tr = id_pelaut
		*/
		  	
		$pelaut = $this->get_detailseatizen($id_seatizen);
		
		$this->db2->delete('document_tr', 			array('pelaut_id' => $id_seatizen));
		$this->db2->delete('competency_tr', 		  array('pelaut_id' => $id_seatizen));
		$this->db2->delete('proficiency_tr', 		 array('pelaut_id' => $id_seatizen));
		$this->db2->delete('experiences', 			array('pelaut_id' => $id_seatizen));
		$this->db2->delete('experiences_appraisal', array('id_pelaut' => $id_seatizen));
		$this->db2->delete('applicant_tr', 		   array('id_pelaut' => $id_seatizen)); 
		$this->db2->delete('comment_timeline', 	   array('username' => $pelaut["username"])); 
		$this->db2->delete('photo_pelaut_tr', 		array('id_pelaut' => $id_seatizen)); 
		$this->db2->delete('recommendation_tr', 	  array('id_pelaut' => $id_seatizen)); 
		$this->db2->delete('log_login_seatizen', 	 array('seatizen_id' => $id_seatizen)); 
		
		$this->db2->delete('profile_resume_tr', 	  array('pelaut_id' => $id_seatizen)); 
		$this->db2->delete('pelaut_ms', 			  array('pelaut_id' => $id_seatizen));
		
		
		
	}

    public function ViewSeatizenCrew($value='')
    {
        # code...
        $q = "select * from crew_ms where id_seatizen = '$value'";
        $exec = $this->db2->query($q);
        return $exec->result_array();
    }
	
	function seatizen_active()
	{
		$str = "SELECT * FROM pelaut_ms WHERE `show` = 'TRUE' AND activation = 'ACTIVE' ";
		$q   = $this->db2->query($str);
		$f   = $q->result_array();
		
		return $f;	
		
	}
	
	function seatizen_hidden()
	{
		$str = "SELECT * FROM pelaut_ms WHERE `show` = 'FALSE' ";
		$q   = $this->db2->query($str);
		$f   = $q->result_array();
		
		return $f;	
		
	}

    public function CompanySeatizen($value='')
    {
        # code...
        $q = "select * from perusahaan where id_perusahaan = '$value'";
        $exec = $this->db2->query($q);
        return $exec->row_array();
    }

    public function get_allseatizen()
    {
        # code...
        /* $q = "select a.*,b.pelaut_id, b.department, b.rank from pelaut_ms a, profile_resume_tr b WHERE a.pelaut_id = b.pelaut_id ORDER BY create_date DESC"; */
		
		$q = "SELECT a.*,b.rank, b.department FROM pelaut_ms a LEFT JOIN profile_resume_tr b ON a.pelaut_id = b.pelaut_id ORDER BY create_date DESC ";
        $exec = $this->db2->query($q);
        return $exec->result_array();
    }
	
	public function get_seatizen_panel($limit = 6)
    {
        # code...
        $q = "select * from pelaut_ms WHERE activation = 'ACTIVE' ORDER BY create_date DESC LIMIT $limit";
        $exec = $this->db2->query($q);
        return $exec->result_array();
    }
	
	public function get_detailseatizen_a($id)
	{
		$q = "select * from pelaut_ms a, profile_resume_tr b  where a.pelaut_id = b.pelaut_id AND a.pelaut_id = '$id' ";
        $exec = $this->db2->query($q);
        return $exec->row_array();
	}
	
    public function get_detailseatizen($id)
    {
        # code...
        $q = "select * from pelaut_ms where pelaut_id = '$id'";
        $exec = $this->db2->query($q);
        return $exec->row_array();
    }
	
	
	function change_activate($id)
	{
		$str  = "UPDATE pelaut_ms SET ";
		$str .= "activation = 'ACTIVE' WHERE pelaut_id = '$id'";
		
		$q = $this->db2->query($str);
		
		
	}
	
	function test()
	{
		return "test test";	
	}
	
	function applied_vacantsea($username)
	{
		$str = "SELECT * FROM applicant_tr WHERE username = '$username' ";
		$q   = $this->db2->query($str);
		$f   = $q->result_array();
		
		return $f;
		
	}
	
	function get_log_hired($val)
	{
		// untuk melihat yang hired atau enggak harus melihat dari table log_agentsea
		// $val = 'username=$username&page=hire_crew&action=hire_applicant&id_vacantsea=$id_vacantsea' 
		
		$str = "SELECT * FROM log_agentsea WHERE action LIKE '%$val%' ";
		$q   = $this->db2->query($str); 
		$f   = $q->row_array();
		
		if(!empty($f))
		{
			$hasil = date_format_db($f['action_time']);	
		}
		else
		{
			$hasil = " - ";	
		}
		
		return $hasil; 		
	}
	
	function get_log_approved($val)
	{
		// untuk melihat yang hired atau enggak harus melihat dari table log_agentsea
		// $val = 'username=$username&page=hire_crew&action=approved&id_vacantsea=$id_vacantsea' 
		
		$str = "SELECT * FROM log_agentsea WHERE action LIKE '%$val%' ";
		$q   = $this->db2->query($str); 
		$f   = $q->row_array();
		
		if(!empty($f))
		{
			$hasil = date_format_db($f['action_time']);	
		}
		else
		{
			$hasil = " - ";	
		}
		
		return $hasil;
	}
	
	public function jumlah_view($username){
		$q = "select * from log_seatizen WHERE action LIKE '%username=$username%'";
		$f = $this->db2->query($q);
		 //   echo $q;
		$c = $f->num_rows();
		
		// =========================================================================
		
		$stra = "select * from user_history WHERE action LIKE '%username=$username%'";
		$qa = $this->db2->query($stra);
		$fa = $qa->num_rows();
		
		return $c + $fa;
    }
	
	public function register_from($value)
	{
		
		$strss = "SELECT * FROM pelaut_ms WHERE username = '$value' ";
		$qss =  $this->db2->query($strss);
		$fss = $qss->row_array();
		
		//
		$str  = "SELECT * FROM log_seatizen WHERE ( ";
		
		$str .= "action = 'register' OR ";
		$str .= "action = 'register_all' OR ";
		$str .= "action = 'fb_register_noemail' OR ";
		$str .= "action = 'fb_register_email' OR ";
		//$str .= "action = 'google_register' OR ";
		$str .= "action = 'register_agentsea' )";
		
		$str .= "AND (username = '$value' OR seatizen_id = '$fss[pelaut_id]') order by no_urut desc ";
		$str .= "LIMIT 1";
		
		//echo $str;
		
		$q = $this->db2->query($str);
		$f = $q->row_array();
		
		//print_r($f); exit;
		
		if(!empty($f))
		{
			$hasil = $f["action"];	
			if($fss["google_id"] != "")
			{
				$hasil = "google_register";	
			}
		}
		else
		{
			$stra = "SELECT * FROM admin_activity WHERE id_object = '$fss[pelaut_id]' ";
			$qa = $this->db->query($stra);
			$fa = $qa->row_array();
			
			$hasil = "<a href='#'><span title='$fa[action]'> ".$fa["form"]." by ".$fa["username"]."</span></a>"; 
			if($fss["google_id"] != "")
			{
				$hasil .= "<div> google_register </div>";	
			}
			else if(empty($fa))
			{
				$hasil = "not tracked";
			}
		}
		
		return $hasil;
		
	}
	
	function seatizen_add($arr)
	{
		
		$first_name = filter($this->input->post("first_name",true));
		$last_name  = filter($this->input->post("last_name",true));
		$email 	  = filter($this->input->post("email",true));
		$department = filter($this->input->post("department",true)); // id -> profile_resume_tr
		$coc_class  = filter($this->input->post("coc_class",true));  // id -> profile_resume_tr
		$rank 	   = filter($this->input->post("rank",true));	    // id -> profile_resume_tr
		
		
		$username	= $arr['username'];
		$pass 		= md5($arr['pass']);
		
		/* $str  = "INSERT INTO pelaut_ms SET		 			 ";
		$str .= "nama_depan 		= '$first_name' 		,";
		$str .= "nama_belakang		= '$last_name'			,";
		$str .= "email				= '$email'				,";
		$str .= "username			= '$username'			,";
		$str .= "password			= '$pass'				,";
		$str .= "create_date		= now()					,";
		$str .= "last_update		= now()					,";
		$str .= "activation			= 'ACTIVE'				 ";
		
		$this->db2->query($str); */
		
		$arr_insert['nama_depan']    = $first_name;
		$arr_insert['nama_belakang'] = $last_name;
		$arr_insert['email']		 = $email;
		$arr_insert['username']	  = $username;
		$arr_insert['password']	  = $pass;
		//$arr_insert['create_date']   = 'now()';
		//$arr_insert['last_update']   = 'now()';
		//$arr_insert['activation']   = 'ACTIVE'; // diganti jadi activation code
		$arr_insert['activation'] 	  = md5(uniqid(rand(), true));
		
		$this->db2->set('create_date', 'NOW()', FALSE);
		$this->db2->set('last_update', 'NOW()', FALSE);
		
		$this->db2->insert('pelaut_ms',$arr_insert);
		
		$stro = "SELECT * FROM pelaut_ms WHERE username = '$username' AND email = '$email' ";
		$o = $this->db2->query($stro);
		$fo = $o->row_array();
		
		$id_pelaut = $fo['pelaut_id'];
		//$id_pelaut = mysql_insert_id();
		
		$str_p  = "INSERT INTO profile_resume_tr SET 		";
		$str_p .= "department 	   = '$department' 	   ,";
		$str_p .= "rank			   = '$rank'		   ,";
		$str_p .= "coc_class		   = '$coc_class'	   ,";
		$str_p .= "last_update	   = now()			   ,"; 
		$str_p .= "pelaut_id		   = '$id_pelaut'	    ";
		
		$this->db2->query($str_p);
		
		// hasil input
		$s = "SELECT * FROM pelaut_ms WHERE pelaut_id = '$id_pelaut' ";
		$q = $this->db2->query($s);
		$f = $q->row_array();
		
		return array("pelaut_id"=>$id_pelaut,'username'=>$username,'password'=>$arr['pass'],"dt"=>$fo);	
		
	}
	
	function get_rank() // punya Model sendiri bernama rank_model
	{
		// harus berdasarkan
		$str = "select * from rank";	
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;
	}

	function get_vessel_type() // punya Model sendiri bernama rank_model
	{
		// harus berdasarkan
		$str = "select * from ship_type";	
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;
	}
	
	function get_coc_class() // punya model sendiri coc_model
	{
		$str 	= "select * from coc_class ";
		$q 	  = $this->db2->query($str);
		$f 	  = $q->result_array();
		
		return $f;  	
	}
	
	function call_department()
    {
        $str  	  = "select * from department ";
        $q 		= $this->db2->query($str);
        return $f = $q->result_array();
    }

    public function lastLoginSeatizen($value='')
    {
        # code...
        $q = "select * from log_login_seatizen where username = '$value' order by action_time desc limit 1";
        $exec = $this->db2->query($q);
        return $exec->row_array();
    }

    public function BlockSeatizen($id_seatizen='')
    {
		$this->load->helper("notification");
		
        $q = "select * from pelaut_ms where pelaut_id = '$id_seatizen'";
        $exec = $this->db2->query($q);
        $result = $exec->row_array();
        # code...\
        if ($result['activation'] == "ACTIVE" || $result['activation'] == "BLOCKED") {
            # code...
            $state="";
            if($result['activation'] == "ACTIVE")
            {
                $state = "BLOCKED";
                $state_notif = NOTIF_BLOCK_SEATIZEN;
            }
            else
            {
                $state = "ACTIVE";
                $state_notif = NOTIF_UNBLOCK_SEATIZEN;
            }

            $q = "update pelaut_ms set activation = '$state' WHERE pelaut_id = '$id_seatizen'";
            $this->db2->query($q);

            $this->load->helper("notification");
            follow_up_request($id_seatizen, $state_notif);
			
			
        }
        
    }

    /**
     * Get total seatizen in a month, per day grouping.
     *
     * @param null $year
     * @param null $month
     * @return int
     */
    public function get_total_seatizen_in_a_month($year = NULL, $month = NULL) {

        if ($year == NULL || $month == NULL) {
            $year = date("Y");
            $month = date("m");
        }

        // check if table exist in db.
        if (!$this->_current_db->table_exists($this->_primary_table)) {
            return NULL;
        }

        $this->_current_db->select(
            "DAY(". $this->_primary_table .".create_date) AS day, ".
            "COUNT(". $this->_primary_table .".create_date) AS total"
        );

        $this->_current_db->where("YEAR(". $this->_primary_table .".create_date)", $year);
        $this->_current_db->where("MONTH(". $this->_primary_table .".create_date)", $month);
        $this->_current_db->where($this->_primary_table .".activation", "ACTIVE");

        $this->_current_db->group_by("DATE(". $this->_primary_table .".create_date)");
        $this->_current_db->order_by("day", "ASC");

        $query = $this->_current_db->get($this->_primary_table);

        return $query->result_array();
    }
}