<?php if(!defined("BASEPATH")) exit ("No direct script access allowed");

class agentsea_model extends CI_Model{
	
	private $db;
	
	public function __construct()
	{
		parent::__construct();
		
		// load database				   //check constants
		$this->db = $this->load->database(DB_GROUP,TRUE);
		$this->db2 = $this->load->database(DB2_GROUP,TRUE);	
	}
	
	// a.username <> 'informasea_test' OR a.username <> 'hidden' OR a.username <> 'informasea_test1'
	public function list_agentsea()
	{
		$str = "SELECT a.*,b.status FROM perusahaan a LEFT JOIN perusahaan_setting b ON a.id_perusahaan = b.id_perusahaan 
		
		WHERE a.username NOT IN ('informasea_test1','hidden')
		
		ORDER BY a.create_date DESC";
		
		$q   = $this->db2->query($str);
		$f   = $q->result_array();
		
		return $f;
	}

	function update_tampil($id_perusahaan,$tampil){
		$str = "UPDATE perusahaan SET tampil = '$tampil' WHERE id_perusahaan = '$id_perusahaan'";
		$qq = $this->db2->query($str);
		return $qq;
	}

	function history_pic($id){
		$str = "SELECT * FROM admin_activity WHERE id_object ='$id' ORDER by datetime desc";
		$q = $this->db->query($str);
		$f = $q->result_array();
		return $f;
	}

	function last_login($id){
		
		$str = "SELECT * FROM log_agentsea WHERE agentsea_id = '$id' ORDER BY action_time DESC LIMIT 1";
		$q = $this->db2->query($str);
		$f = $q->row_array();
		return $f;
	}

		
	function detail_agentsea($id_perusahaan)
	{
		$str = "SELECT a.*,b.* FROM perusahaan a LEFT JOIN perusahaan_setting b ON a.id_perusahaan = b.id_perusahaan WHERE a.id_perusahaan = '$id_perusahaan' OR username = '$id_perusahaan' OR email = '$id_perusahaan' ";	
		$q = $this->db2->query($str);
		$f = $q->row_array();
		return $f;
		
	}
	
	function send_email_add($arr)
	{
		//$this->load->library("user_agent");
		$ip_address = $this->input->ip_address();
		$user_agent = $this->input->user_agent();
		
		$str  = "INSERT INTO admin_send_email_agentsea SET  		 	 ";
		$str .= "company_name 	 = '$arr[company_name]'					,";
		$str .= "contact_person	 = '$arr[contact_person]'				,";
		$str .= "email			 = '$arr[email]'						,";
		$str .= "username		 = '$arr[username]'						,";
		$str .= "content		 = '$arr[email_content]'				,";
		$str .= "PIC			 = '$arr[PIC]'							,";
		$str .= "type_email		 = '$arr[type]'							,";
		$str .= "code_invitation = '$arr[code_invitation]'				,";
		$str .= "datetime		 = now()								,";
		$str .= "ip_address		 = '$ip_address'						,";
		$str .= "user_agent		 = '$user_agent'						 ";
		
		$q = $this->db->query($str);
	}
	
	function insert_agent($arr)
	{
		
		$str  = "INSERT INTO agent_ms SET      		      ";
		$str .= "nama 	   	  	  ='$arr[nama]'			 ,";
		$str .= "alamat		  	  ='$arr[alamat]'		 ,";
		$str .= "no_telp	  	  ='$arr[no_telp]'		 ,";
		$str .= "email		  	  ='$arr[email]'		 ,";
		$str .= "username		  ='$arr[username]'		 ,";
		$str .= "perusahaan_id	  ='$arr[id_perusahaan]' ,"; //author 
		$str .= "lokasi		  	  ='$arr[lokasi]'		 ,";
		$str .= "password		  ='$arr[password]'		 ,";
		$str .= "activation_code  ='$arr[ac]'			 ,";
		$str .= "nationality	  ='$arr[nationality]'	 ,";
		$str .= "id_nationality	  ='$arr[id_nationality]',";
		$str .= "photo_agent	  ='$arr[photo_agent]'    ";
		
		//echo $str;
		
		$q = $this->db2->query($str);
		
	}
	
	function insert_agentsea($arr)
	{
		
		$str  = "INSERT INTO perusahaan SET 					 ";
		$str .= "nama_perusahaan	= '$arr[nama_perusahaan]'	,";
		$str .= "id_nationality 	= '$arr[id_nationality]' 	,";
		$str .= "nationality 		= '$arr[nationality]'		,";
		$str .= "description		= '$arr[description]'		,";
		$str .= "website			= '$arr[website]'			,";	
		$str .= "no_telp			= '$arr[no_telp]'			,";
		$str .= "fax 				= '$arr[fax]' 				,";
		$str .= "email		 		= '$arr[email]'				,";
		$str .= "address			= '$arr[address]'			,";
		$str .= "username			= '$arr[username]'			,";
		$str .= "password			= '$arr[nama_perusahaan]'	,";
		$str .= "create_date	 	= now() 					,";
		$str .= "expired_date 		= '$arr[expired_date]'		,"; // dihitung dari tanggal create_date
		$str .= "contact_person		= '$arr[contact_person]'	,";
		$str .= "visi				= '$arr[visi]'				,";
		$str .= "misi				= '$arr[misi]'				,";
		$str .= "activation_code 	= '$arr[activation_code]' 	,";
		$str .= "account_type 		= '$arr[account_type]'		,";
		$str .= "role				= '$arr[role]'				,";
		$str .= "tampil				= '$arr[tampil]'			,";
		$str .= "official			= '$arr[official]'			 ";
		
		$this->db->query($str);
		
		$id = mysql_insert_id();
		
		$str1 = "INSERT INTO perusahaan_setting SET id_perusahaan = '$id' , status = 'VERIFIED' ";
		
		$this->db->query($str1);
		
	}
	
	function jumlah_view($username)
	{
		$q = "select * from log_agentsea WHERE action LIKE '%username_company=$username%' GROUP BY username";
		$f = $this->db2->query($q);
		 //   echo $q;
		$c = $f->num_rows();
		
		$qi = "select * from user_history WHERE action LIKE '%username_company=$username%' GROUP BY ip_address";
		$fi = $this->db2->query($qi);
		 //   echo $q;
		$d = $fi->num_rows();
		
		$h = $c+$d;
		
		return $h;	
		
	}
	
	function register_from($value)
	{
		// register , pemasangan tracker ada di moduler, user, controller company_process, funct register_process, informasea.com  
		// register_alpha, pemasangan tracker ada di module user, controller user, funct register_process, alpha informasea 
		// register_create_vacantsea, pemasangan tracker ada di module home, controller home_process, funct create_vacantsea, informasea.com
		
		$str  = "SELECT * FROM log_agentsea WHERE ( ";
		$str .= "action = 'register' OR ";
		$str .= "action = 'register_alpha' OR ";
		$str .= "action = 'register_create_vacantsea' OR ";
		$str .= "action = 'register_all' )";
		
		$str .= "AND ( username = 'value' OR agentsea_id = '$value' )  ";
		$str .= "LIMIT 1";
		
		$q = $this->db2->query($str);
		$f = $q->row_array();

		if(!empty($f))
		{
			$hasil = $f["action"];	
		}
		else
		{
			$stra = "SELECT * FROM perusahaan WHERE (username = '$value' OR id_perusahaan = '$value') AND account_type = 'Alpha' ";
			$qa = $this->db2->query($stra);
			$fa = $qa->row_array();
			
			if(!empty($fa))
			{
				$hasil = $fa["account_type"];
			}
			else
			{
				$hasil = "not tracked";
			}
		}
				 
		return $hasil;
		
	}
	
	function track_agentsea($val)
	{
		$str = "SELECT * FROM log_agentsea WHERE username = '$val' OR agentsea_id = '$val' ";
		$q   = $this->db2->query($str);
		$f   = $q->result_array();
		
		return $f; 	
	}
	
	function delete_agentsea($id_perusahaan)
	{
		$str = "DELETE from perusahaan where id_perusahaan = '$id_perusahaan' ";
		$q = $this->db2->query($str);	
	}
	
	public function change_valid_email()
	{
		// VALID 
		// INVALID	
		$valid_email = $this->input->post("valid_email");
		$id_perusahaan = $this->input->post("id_perusahaan");
		
		$str = "UPDATE perusahaan_setting SET valid_email = '$valid_email' where id_perusahaan = '$id_perusahaan' "; 
		$q = $this->db2->query($str);
	}
	
	public function change_activation()
	{
		// ACTIVE 
		// BLOCKED	
		$activation 	= $this->input->post("activation");
		$id_perusahaan = $this->input->post("id_perusahaan");
		
		$str = "UPDATE perusahaan SET activation_code = '$activation' where id_perusahaan = '$id_perusahaan' "; 
		$q = $this->db2->query($str);
	}
	
	public function change_account_type()
	{
		// FREE
		// PREMIUM
		// ALPHA
		$account_type  = $this->input->post("account_type");
		$id_perusahaan = $this->input->post("id_perusahaan");
		
		$str = "UPDATE perusahaan SET account_type = '$account_type' where id_perusahaan = '$id_perusahaan' "; 
		$q = $this->db2->query($str);	
		
	}
	
	public function change_official()
	{
		// FREE
		// PREMIUM
		// ALPHA
		$official  = $this->input->post("official");
		$id_perusahaan = $this->input->post("id_perusahaan");
		
		$str = "UPDATE perusahaan SET official = '$official' where id_perusahaan = '$id_perusahaan' "; 
		$q = $this->db2->query($str);	
		
	}
		
	public function change_status($id,$status = array())
	{
		// VERIFIED
		// INVALID PHONE
		// INVALID EMAIL
		// UNAUTHORIZED
		
		$status_str = implode("|",$status);
		
		$str = "UPDATE perusahaan_setting SET status = '$status_str' where id_perusahaan = '$id' ";
		$q   = $this->db2->query($str);
		
	}
	
	// email //username //id
	public function change_vacantsea_stat($key)
	{
		$au = $this->input->post("authorized");
		
		if($au == "on")
		{
			$stat = "open";
		}
		else
		{
			$stat = "hold";
		}
		
		$str = "SELECT * FROM vacantsea WHERE id_perusahaan = '$key' ";
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		if(!empty($f))
		{
			foreach($f as $row)
			{
				$str2 = "UPDATE vacantsea SET stat = '$stat' WHERE id_perusahaan = '$key' ";
				$q2 = $this->db2->query($str2);	
			}
		}
		
	}
	
	public function list_manager($id_perusahaan)
	{
		$str = "SELECT * FROM perusahaan a LEFT JOIN perusahaan_setting b ON  a.id_perusahaan = b.id_perusahaan WHERE role = 'manager' AND a.id_perusahaan <> '$id_perusahaan' AND activation_code = 'ACTIVE' AND status = 'VERIFIED' ";
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;
			
	}
	
	// email 
	
	function delete_email_agentsea($id)
	{	
		$str = "DELETE from admin_send_email_agentsea WHERE id = '$id' ";
		$q = $this->db->query($str);
		
		return $q;
	}
	
	function detail_email_agentsea($id)
	{
		$str = "SELECT * FROM admin_send_email_agentsea WHERE id = '$id' ";	
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;
		
		
	}
	
}