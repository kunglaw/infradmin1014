<?php 

	class Company_model extends CI_Model{
		
		function __construct()
		{
			parent::__construct();	
			
			$this->db = $this->load->database("infr6975_2015",TRUE);
			
		}
		
		function get_company()
		{
			$str = "SELECT * FROM perusahaan";
			$q   = $this->db->query($str);
			$f   = $q->result_array();
			
			return $f;  
		}
		
		function get_company_byemail($email)
		{
			
			$str = "SELECT * FROM perusahaan WHERE email LIKE '%$email%'  "; // admin_post = 1
			$q   = $this->db->query($str);
			$f   = $q->result_array();
			
			return $f; 
			
		}
		
		function get_company_byname($nama_perusahaan)
		{
			
			$str = "SELECT * FROM perusahaan WHERE nama_perusahaan LIKE '%$nama_perusahaan%'  "; // admin_post = 1
			$q   = $this->db->query($str);
			$f   = $q->result_array();
			
			return $f; 
			
		}
		
		function get_company_byusername($username)
		{
			$str = "SELECT * FROM perusahaan WHERE username LIKE '%$username%'  "; // admin_post = 1
			$q   = $this->db->query($str);
			$f   = $q->result_array();
			
			return $f; 
			
		}
		
		
		function get_detail_company($id_perusahaan)
		{
			$str = "SELECT * FROM perusahaan WHERE id_perusahaan = '$id_perusahaan' ";
			$q   = $this->db->query($str);
			$f   = $q->row_array();
			
			return $f; 
		}
		
		
		
		function insert_company($arr)
		{
			
			$real_password = mt_rand(111111,999999);
			$password = md5($real_password);
			
			/* $a = explode("@",$arr["email"]);
			$aa = explode(".",$a[1]);
			$username = */ 
			
			$str  = "INSERT INTO perusahaan SET			 	 ";
			$str .= "nama_perusahaan= '$arr[company]' 		,";
			
			$str .= "contact_person = '$arr[contact_person]',";
			$str .= "email			= '$arr[email]'			,";
			$str .= "username		= '$arr[username]'		,";
			$str .= "password		= '$password'			,";
			
			// detail account
			$str .= "activation_code = 'ACTIVE'				,";
			$str .= "account_type	= 'Free'			,";
			$str .= "role			= 'manager'			,";
			$str .= "tampil			= 1					,";
			$str .= "official		= 'Agent'			,";
			$str .= "active_until	= now()				,";
			
			$str .= "create_date	= now()				 ";
			//$str .= "ip_address		= '$arr[ip_address]'	,";
			//$str .= "user_agent		= '$arr[user_agent]'	 ";
			
			$q = $this->db->query($str);
			
			$id_perusahaan = $this->db->insert_id();
																													// perusahaan yang didaftarkan
			$sql2 = "INSERT INTO perusahaan_setting set id_perusahaan = '$id_perusahaan', max_crew = '$max_crew', admin_post = 1 ";
		
			$q2 = $this->db->query($sql2);
			
			$o = array($q,"id_perusahaan"=>$id_perusahaan,"real_password"=>$real_password);
			
			return $o;
		}
		
		function update_company($id_company,$arr)
		{
			$str  = "UPDATE perusahaan SET			 	 		 ";
			$str .= "nama_perusahaan = '$arr[company]' 			,";
			$str .= "description	 = '$arr[description]'		,";
			$str .= "contact_person  = '$arr[contact_person]'	,";
			$str .= "email			 = '$arr[email]'			,";
			$str .= "create_date	 = now()					 ";
			//$str .= "ip_address		 = '$arr[ip_address]'		,";
			//$str .= "user_agent		 = '$arr[user_agent]'	 	 ";
			$str .= "WHERE id_company = '$id_company'		 	 ";
			
			$q = $this->db->query($str);
			
			return $q;
			
		}
		
		function delete_company_list($id_perusahaan)
		{
			$str = "DELETE FROM perusahaan WHERE id_perusahaan = '$id_perusahaan' ";
			$q   = $this->db->query($str);
			
			return $q;
			
		}
		
		function delete_few_company($arr_id_company)
		{
			if($arr_id_company)
			{
				foreach($arr_id_company as $row)
				{
					$this->delete_company_list($row);
				}
			}
			
		} 
		
		
		
	}