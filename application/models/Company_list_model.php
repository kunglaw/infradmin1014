<?php 
	
	class Company_list_model extends CI_Model{
		
		function __construct()
		{
			parent::__construct();
			$this->db = $this->load->database("infr6975_2015",TRUE);	
			
		}
		
		function get_company_list()
		{
			$str = "SELECT * FROM company_list";
			$q   = $this->db->query($str);
			$f   = $q->result_array();
			
			return $f;  
		}
		
		function get_detail_company($id_company)
		{
			$str = "SELECT * FROM company_list = '$id_company' ";
			$q   = $this->db->query($str);
			$f   = $q->row_array();
			
			return $f; 
		}
		
		function insert_company_list($arr)
		{
	
			$str  = "INSERT INTO company_list SET			 ";
			$str .= "company 		= '$arr[company]' 		,";
			$str .= "description	= '$arr[description]'	,";
			$str .= "contact_person = '$arr[contact_person]',";
			$str .= "email			= '$arr[email]'			,";
			$str .= "create_date	= now()					,";
			$str .= "ip_address		= '$arr[ip_address]'	,";
			$str .= "user_agent		= '$arr[user_agent]'	 ";
			
			$q = $this->db->query($str);
			
			$id_company = $this->db->insert_id();
			
			$o = array($q,"id_company"=>$id_company);
			
			return $o;
		}
		
		function update_company_list($id_company,$arr)
		{
			$str  = "UPDATE company_list SET			 	 ";
			$str .= "company 		= '$arr[company]' 		,";
			$str .= "description	= '$arr[description]'	,";
			$str .= "contact_person = '$arr[contact_person]',";
			$str .= "email			= '$arr[email]'			,";
			$str .= "create_date	= now()					,";
			$str .= "ip_address		= '$arr[ip_address]'	,";
			$str .= "user_agent		= '$arr[user_agent]'	 ";
			$str .= "WHERE id_company = '$id_company'		 ";
			
			$q = $this->db->query($str);
			
			return $q;
			
		}
		
		function delete_company_list($id_company)
		{
			$str = "DELETE FROM company_list WHERE id_company = '$id_company' ";
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