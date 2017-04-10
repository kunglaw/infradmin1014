<?php if(!defined('BASEPATH')) exit ('No Direct Script access allowed');
//saas
class User_model extends CI_Model{
		private $db = null;
		function __construct()
		{
			$this->db = $this->load->database(DB2_GROUP,TRUE);	
		}
		
	public function get_pelaut()
	{
		
		$sql = "select * from pelaut_ms";
		$q = $this->db->query($sql);
		$f = $q->result_array();
		
		return $f; 	
		
	}
	
	public function get_detail_pelaut($username = "")
	{
		// $this->db = $this->load->database('default',true);
		
		if($username == "")
		{
			$username = $this->uri->segment(2);
		}
		
		$str = "SELECT * FROM pelaut_ms a , profile_resume_tr b WHERE a.pelaut_id = b.pelaut_id AND a.username = '$username' ";
		
		
		$ab = $this->db->query($str);
		$f = $ab->row_array();
		
		
		return $f;
		
	}


	function get_detail_pelaut22($username = ""){
			// $this->db = $this->load->database('default',true);
		
		if($username == "")
		{
			$username = $this->uri->segment(2);
		}
		
		$str = "SELECT * FROM pelaut_ms WHERE username = '$username' ";
		
		
		$ab = $this->db->query($str);
		$f = $ab->row_array();
		
		
		return $f;
	}
	
	public function get_profile_resume($pelaut_id)
	{
		
		$str = "select * from profile_resume_tr where pelaut_id = '$pelaut_id' ";
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;
		
	}
	
	public function get_detail_pelaut_byid($id = "")
	{
		$str = "select * from pelaut_ms where pelaut_id = '$id' ";
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;		
	}
	
	public function get_detail_pelaut_byemail($email)
	{
		$str = "select * from pelaut_ms where email = '$email' ";
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;
			
	}
	
	public function get_last_user()
	{
		// Mengetahui user terakhir / baru daftar 
		echo $str = "select * from pelaut_ms order by pelaut_id desc limit 1 ";
		$q = $this->db->query($str);
		$f = $q->row_array();	
		
		return $f;
	}
	
	// pelaut
	public function check_activation()
	{
		/*$a = $this->input->get('a',true);
		$e = $this->input->get('e',true);
		$x = $this->input->get('x',true);
		$u = $this->input->get('u',true);
		$p = $this->input->get('p',true);*/
		
		$activate_url = $this->input->get("a");
		$email_url 	= $this->input->get("email");
		$username_url = $this->input->get("u");
		$password	 = $this->input->get("p");
		
		$str = "select * from pelaut_ms where username = '$username_url' and email = '$email_url' and password = '$password' and activation = '$activate_url' ";
		
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;	
		
	}
	
	// company
	public function check_activation_company()
	{
		$activate_url = $this->input->get("a");
		$email_url 	= $this->input->get("email");
		$username_url = $this->input->get("u");
		$password	 = $this->input->get("p");
		
		$str = "select * from perusahaan where username = '$username_url' and email = '$email_url' and password = '$password' and activation_code = '$activate_url' ";
		
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;	
		
	}
	
	function checkPassword($username, $old_pass)
    {
        $str = "select * from pelaut_ms where username = '$username' and password = md5('$old_pass') AND activation = 'ACTIVE' ";
        $q = $this->db->query($str);
        return array($n = $q->num_rows(), $str);
    }

    function changePassword($id_pelaut, $username = "", $email="", $password="")
    {

        $str = "update pelaut_ms set";
        $str.=" username = '$username', email = '$email', password = md5('$password')";
//        if(empty($username)) $str.=" email = '$email', password = md5('$password')";
//        if(empty($email)) $str.=" username = '$username', password = md5('$password')";
//        if(empty($password)) $str.=" email = '$email', username = '$username'";
//        if(empty($username) && empty($email)) $str.=" password = md5('$password')";
//        if(empty($username) && empty($password)) $str.=" email = '$email'";
//        if(empty($password) && empty($email)) $str.=" username = '$username'";

        $str.=" where pelaut_id = '$id_pelaut' AND activation = 'ACTIVE' ";
       /* echo "<script>alert('$str')</script>";*/
        return $q = $this->db->query($str);
    }
	
	// check activation code
	// digunakan di forgot_pass
	function check_activation_code($value) // email, username, id
	{
		$str = "SELECT * FROM pelaut_ms WHERE ( username = '$value' OR email = '$value' OR pelaut_id = '$value' ) AND activation = 'ACTIVE'  ";	
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;
	}
	
	function forgot_pass($password,$username)
	{
		$password = md5($password);
		$str = "UPDATE pelaut_ms SET password = '$password' where ( username = '$username' OR email = '$username' ) AND activation = 'ACTIVE' ";
		
		return $q = $this->db->query($str);
		
	}
	
	public function update_activation($email)
	{
		$str = "update pelaut_ms set activation = 'ACTIVE' , create_date = now() where email = '$email' ";
		$q = $this->db->query($str);
		
		return $q;
	}
	
	public function update_activation_company($email)
	{
		$str = "update perusahaan set activation_code = 'ACTIVE' where email = '$email' ";
		$q = $this->db->query($str);
		
		return $q;
	}
	
	public function logout()
	{
		$session = $this->session->all_userdata(); 
		
		$session_id 	= $session['session_id'];
		$ip_address	= $session['ip_address'];
		$user_agent 	= $session['user_agent'];
		$last_activity = 'now()';
		$username	  = $this->session->userdata("username");
		$user_type  	 = $this->session->userdata("user");
		$nama		  = $this->session->userdata("nama");
	
		$str  = "insert into user_history set			 ";
		$str .= "session_id 		= '$session_id' 	,";
		$str .= "ip_address 		= '$ip_address' 	,";
		$str .= "user_agent			= '$user_agent' 	,";
		$str .= "last_activity		= '$last_activity'	,";
		$str .= "username			= '$username'		,";
		$str .= "user_type			= '$user_type'		,";
		$str .= "nama				= '$nama'			 ";
		
		$q = $this->db->query($str);
		
		return $q;
		
	}
	
	public function get_profile_pic($id_pelaut)
	{
		$this->db = $this->load->database('default',true);
		
		$str = "select nama_gambar from photo_pelaut_tr where (id_pelaut = '$id_pelaut' or `username` = '$id_pelaut') and profile_pic = 1 ";
		
		$b = $this->db->query($str);
		
		$profile_pic = $b->row_array();
		
		if(empty($profile_pic))
		{
			$gambar = "";	
		}
		else
		{
			$gambar = $profile_pic['nama_gambar'];	
		}

		
		return $gambar; 
		
	}
	
	public function login($username,$password)
	{
		// pelaut , agent , company		
		
		$sql = "select * from pelaut_ms where (username = '$username' OR email = '$username') and password = '$password' and activation = 'ACTIVE' ";
		
		$q = $this->db->query($sql);
		$fpelaut = $q->row_array();
		
		$user = "";
		$f = array('user' => $user,$fpelaut);
		
		/*if(empty($fpelaut))
		{
			$sql = "select * from agent_ms where username = '$username' and password = '$password' and activation = 'ACTIVE' ";
			$q = $this->db->query($sql);
			$fagent = $q->row_array();
			
			if(!empty($fagent))
			{
				$user = "agent";
				$f = array('user' => $user,$fagent);
			}
		}
		else
		{*/
		$user = "pelaut";
		$f = array('user' => $user,$fpelaut);	
		//}
		
		/*if(empty($fagent) && empty($fpelaut))
		{
			$sql = "select * from perusahaan where username = '$username' and password = '$password' ";
			$q = $this->db->query($sql);
			$fperusahaan = $q->row_array();
			
			$user = "agent";
			$f = array('user' => $user,$fperusahaan);
			
		}*/
		
		return $f;
			
	}
	
	// username tidak active dan password benar 
	public function check_user($username) {
		
		//cek username ada atw ga di db		
		if(empty($username))
		{		
			$username	  = $this->input->post('username_lg');
		}
		
		//echo $username;
		$sql = "SELECT * FROM pelaut_ms WHERE ( username = '$username' OR email = '$username' ) and activation = 'ACTIVE' ";
		//echo $sql;
		$q = $this->db->query($sql);
		$r=$q->row_array();
		return $r; 
	}
	
	public function just_username($username)
	{
		//cek username ada atw ga di db		
		if(empty($username))
		{		
			$username	  = $this->input->post('username_reg');
		}
		
		//echo $username;
		$sql = "SELECT * FROM pelaut_ms WHERE username = '$username' ";
		//echo $sql;
		$q = $this->db->query($sql);
		$r=$q->row_array();
		return $r; 
			
	}
	
	//cek username ACTIVE ada atw ga di db
	public function check_auser($username) {
				
		if(empty($username))
		{		
			$username	  = $this->input->post('username_lg');
		}
		
		$password = md5($this->input->post("username"));
		
		//echo $username;
		$sql = "SELECT * FROM pelaut_ms WHERE username = '$username' and password = '$password' and activation != 'ACTIVE' "; // harus user yg active
		//echo $sql;
		$q = $this->db->query($sql);
		$r=$q->row_array();
		return $r; 
	}
	
	// USERNAME yang tidak ACTIVE dan password benar
	public function check_nauser($username)
	{
		//cek username ada atw ga di db		
		if(empty($username))	
		{	
			$username	  = $this->input->post('username_lg');
		}
		
		$password = $this->input->post('password_lg');
		if(empty($password))
		{
			
			$password	  = md5($this->input->post('password_reg'));
		}
		else
		{
			$password	  = md5($password);	
		}
		
		//echo $username;
		$sql = "SELECT * FROM pelaut_ms WHERE ( username = '$username' or email = '$username' ) and password = '$password' and activation != 'ACTIVE' ";
		//echo $sql;
		$q = $this->db->query($sql);
		$r=$q->row_array();
		return $r; 	
	}
	
	public function cajax_username($username)
	{
		// all data pelaut
		$str = "select * from pelaut_ms where username = '$username' ";
		$q = $this->db->query($str);
		$f = $q->num_rows();
		
		return $f;	
	}
	
	public function cajax_email($email)
	{
		// all data pelaut
		$str = "select * from pelaut_ms where email = '$email' ";
		$q = $this->db->query($str);
		$f = $q->num_rows();
		
		return $f;	
	}
	
	public function check_email() {
		
		// all data pelaut
		//cek email ada atw ga di db				
		$email	  = $this->input->post('email');
		//echo $email;
		$sql = "SELECT * FROM pelaut_ms WHERE email = '$email'";
		//echo $sql;
		$q = $this->db->query($sql);
		$r=$q->row_array();
		return $r; 
	}
	
	public function register_all()
	{
		
		// 2. input hasil masukan form
		$username  		= $this->input->post('username_seaman',true);
		$email		   = $this->input->post('email_seaman',true);
		
		$password        = $this->input->post('password_reg_seaman',true);
		
		$password		= md5($password);
		$activation 	  = md5(uniqid(rand(), true)); // kode untuk diaktivasi 
		
		//3. query proses input form dr controler
		$sql = "INSERT INTO pelaut_ms (username,email,password,activation,create_date) 
		VALUEs ('$username','$email','$password','$activation',now()) ";
		
		$q = $this->db->query($sql); 
		
		return $q;
	}

	public function register()
	{
		
		// 2. input hasil masukan form
		$username  		= $this->input->post('username_reg',true);
		$first_name	  = $this->input->post('first_name',true);
		$last_name	   = $this->input->post('last_name',true);
		$email		   = $this->input->post('email',true);
		$re_email		= $this->input->post('re_email',true);
		$password        = $this->input->post('password_reg',true);
		
		$password		= md5($password);
		
		$re_password     = $this->input->post('re_password',true);
		$activation 	  = md5(uniqid(rand(), true)); // kode untuk diaktivasi 

		
		//3. query proses input form dr controler
		$sql = "INSERT INTO pelaut_ms (username,nama_depan,nama_belakang,email,password,activation,create_date) 
		VALUEs ('$username','$first_name','$last_name','$email','$password','$activation',now()) ";
		
		$q = $this->db->query($sql); 
		
		return $q;
	}
	public function GetProfilPic($where=''){
		$sql 	= "select nama_gambar from photo_perusahaan_tr ".$where;
		$query 	= $this->db->query($sql);
		return $query;
	}
	
	function check_invitation()
	{
		$db3 = $this->load->database(DB_SETTING3,true);
		
		$cinvit = filter($_GET['t']);
		
		$str = "SELECT * FROM admin_send_email_agentsea WHERE code_invitation = '$cinvit' ";
		$q = $db3->query($str);
		$f = $q->row_array();
		
		if(!empty($f))
		{
			return array("val" => true, "dt" => $f);	
		}
		else
		{
			return array("val" => false) ;	
		}
		
		
	}
	
	
	
	
}