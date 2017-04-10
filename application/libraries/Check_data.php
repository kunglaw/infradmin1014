<?php

class Check_data{
	
	private $CI;
	private $db;
	
	function __construct()
	{
		$this->CI =& get_instance();
		$CI = $this->CI;
		
		$CI->db = $CI->load->database(DB2_GROUP,true);
	}
	
	
	function check_username_company($username)
	{
		$CI = $this->CI;
		
		$str = "SELECT * FROM perusahaan where username = '$username' ";
		$q   = $CI->db->query($str);
		$f   = $q->row_array();
		
		return $f;    
	}
	
	function check_username_agent($username)
	{
		$CI = $this->CI;
		
		$str = "SELECT * FROM agent_ms where username = '$username' ";
		$q   = $CI->db->query($str);
		$f   = $q->row_array();
		
		return $f;    
		
	}
	
	function check_username_seaman($username)
	{
		$CI = $this->CI;
		
		$str = "SELECT * FROM pelaut_ms where username = '$username' ";
		$q   = $CI->db->query($str);
		$f   = $q->row_array();
		
		return $f;    
	}
	
	function check_username($username)
	{
		$check_username_company  = $this->check_username_company($username); 
		$check_username_agent 	= $this->check_username_agent($username);
		$check_username_seaman   = $this->check_username_seaman($username);
		
		if(empty($check_username_agent) && empty($check_username_company) && empty($check_username_seaman))
		{
			
			$hasil = TRUE; // username bisa digunakan
		}
		else
		{
			$hasil = FALSE; // username tidak bisa digunakan 
		}
		return $hasil;
		
	}
	
	// email 
	function check_email_company($email)
	{
		$CI = $this->CI;
		
		$str = "SELECT * FROM perusahaan where email = '$email' ";
		$q   = $CI->db->query($str);
		$f   = $q->row_array();
		
		return $f;    
	}
	
	function check_email_agent($email)
	{
		$CI = $this->CI;
		
		$str = "SELECT * FROM agent_ms where email = '$email' ";
		$q   = $CI->db->query($str);
		$f   = $q->row_array();
		
		return $f;    
	}
	
	function check_email_seaman($email)
	{
		$CI = $this->CI;
		
		$str = "SELECT * FROM pelaut_ms where email = '$email' ";
		$q   = $CI->db->query($str);
		$f   = $q->row_array();
		
		return $f;    
		
	}
	
	function check_email($email)
	{
		$check_email_company = $this->check_email_company($email);
		$check_email_agent   = $this->check_email_agent($email);
		$check_email_seaman  = $this->check_email_seaman($email);
		
		if(empty($check_email_agent) && empty($check_email_company) && empty($check_email_seaman))
		{
			$hasil = TRUE ; // email available 
		}
		else
		{
			
			$hasil = FALSE;	
		}
		
		
		return $hasil;
	}
	
	function __destruct()
	{
		
	}

}