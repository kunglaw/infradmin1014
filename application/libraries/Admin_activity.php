<?php

class Admin_activity{
	
	private $CI;
	
	
	function __construct()
	{
		$this->CI =& get_instance();	
		$CI = $this->CI;
		
		//$CI->db  = $this->CI->load->database(DB_GROUP,true);	
		//$CI->db2 = $this->CI->load->database(DB2_GROUP,true);
	}
	
	function insert_activity($arr)
	{	
		
		$CI = $this->CI;
		$DB1 = $CI->load->database(DB_GROUP,true);	
		
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$session_id = session_id();
		$location   = json_encode(file_get_contents("http://ipinfo.io/{$ip_address}/json"));
		//echo "test";
		
		$str  = "INSERT INTO admin_activity SET      ";
		$str .= "action 	  ='$arr[action]'		,";
		$str .= "menu		  ='$arr[menu]'			,";
		$str .= "ip_address	  ='$ip_address'		,";
		$str .= "browser_agent='$user_agent'		,";
		$str .= "username	  ='$arr[name]'		    ,"; //author 
		$str .= "session_id	  ='$session_id'		,";
		$str .= "id_object	  ='$arr[id_object]'	,";
		$str .= "location	  ='$location'			,";
		$str .= "form 		  ='$arr[form]'			 ";
		
		$q = $DB1->query($str);
		
	}
									// array
	function get_last_action($table,$arr_id)
	{		
		//echo $arr_id[0]['field'];
		$CI = $this->CI;
		$DB1  = $CI->load->database(DB_GROUP,true);
		
		$str  = "SELECT * FROM admin_activity where menu = '$table' ";
		
		for($i = 0; $i <= count($arr_id)-1; $i++)
		{
			$str .= " AND ".$arr_id[$i]['field'] ."='". $arr_id[$i]['val']."' " ;
		}
		
		//echo $str;
		
		$str .= " ORDER BY id DESC LIMIT 1";
		
		
		$q = $DB1->query($str);
		$f = $q->row_array();
		
		return $f;
	}

	
	
}