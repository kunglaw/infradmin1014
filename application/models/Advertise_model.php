<?php 

	class Advertise_model extends CI_Model{
		
		function __construct()
		{
			
			
		}
		
		function list_ad_area()
		{
			
			$str = "SELECT * FROM admin_ad_area";	
			$q   = $this->db->query($str);
			$f   = $q->result_array();
			$q->free_result();
			return $f; 
			
		}
		
		function list_ad_page()
		{
			$str = "SELECT * FROM admin_ad_page";
			$q = $this->db->query($str);
			$f = $q->result_array();
			$q->free_result();
			
			return $f;	
			
		}
		
		function list_ad_periode()
		{
			$str = "SELECT * FROM admin_ad_periode";
			$q = $this->db->query($str);
			$f = $q->result_array();
			$q->free_result();
			
			return $f;	
			
		}
		
		function detail_ad_page($id_page)
		{
			$str = "SELECT * FROM admin_ad_page WHERE id_page = '$id_page' ";
			$q = $this->db->query($str);
			$f = $q->row_array();
			$q->free_result();
			
			return $f;
			
		}

		function detail_ad_periode($id_periode)
		{
			$str = "SELECT * FROM admin_ad_periode WHERE id_periode = '$id_periode' ";
			$q   = $this->db->query($str);
			$f   = $q->row_array();
			$q->free_result();
			
			return $f; 	
			
			
		}
		
		function detail_ad_user($email)
		{
			$str = "SELECT * FROM admin_ad_user WHERE email = '$email' oR id_user_ad = '$email' ";
			$q = $this->db->query($str);
			$f = $q->row_array();
			$q->free_result();
			
			return $f;
		}
		
		function detail_ad_request($id_order)
		{
		   $str = "SELECT * FROM admin_advertise_list WHERE id_ad = '$id_order' ";
		   $q   = $this->db3->query($str);
		   $f   = $q->row_array(); 
			$q->free_result();
		   
		   return $f;
				
		}
		
		function detail_ad_area($id_area)
		{
			$str = "SELECT * FROM admin_ad_area WHERE id_area = '$id_area' OR area_name = '$id_area' ";
			$q = $this->db->query($str);
			$f = $q->row_array();
			$q->free_result();
			
			return $f;	
			
		}
		
		function list_advertise_req()
		{
			
			$str = "SELECT * FROM admin_advertise_list";
			$q = $this->db->query($str);
			$f = $q->result_array();
			$q->free_result();
			
			return $f;	
			
		}

		function detail_advertise($id) // no_order
		{
			$str = "SELECT * FROM admin_advertise_list WHERE id_ad = '$id'";
			$q = $this->db->query($str);
			$f = $q->row_array();
			$q->free_result();
			
			return $f;
		}

		function list_payment_req()
		{
			
			$str = "SELECT * FROM admin_ad_payconf";
			$q = $this->db->query($str);
			$f = $q->result_array();
			$q->free_result();
			
			return $f;	
			
		}
		
		// update activate
		function activate_ad($arr)
		{
			$id_ad = $arr["id_ad"];
			$status = $arr["status"];
			
			$str = "UPDATE admin_advertise_list SET status = '$status' WHERE id_ad = '$id_ad' ";
			return $q = $this->db->query($str);
			
			
		}
		
		function paid_status($arr)
		{
			$id_ad = $arr["id_ad"];
			$paid_status = $arr["paid_status"];
			
			$str = "UPDATE admin_advertise_list SET paid_status = '$paid_status' WHERE id_ad = '$id_ad' ";
			return $q = $this->db->query($str);
		}
		
		
	}