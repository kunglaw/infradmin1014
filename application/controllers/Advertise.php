<?php

	class Advertise extends CI_Controller{
		
		
		private $_primary_table 	  = "admin_advertise_list";

		private $_notification_table = "admin_message";
	
		private $_menu = MENU_ADVERTISE;
	
		private $_route	   = "advertise";
		private $_view_folder = "advertise";
		
		function __construct()
		{
			parent::__construct();
			check_auth();
			check_privileges($this->_menu);
			$this->db2 = $this->load->database(DB2_GROUP,TRUE);
			$this->load->model("advertise_model");
		}

		function show_modal_detail()
		{
			$ajax = $this->input->post("x");
			if($ajax){
				$id_iklan = $this->input->post("id_iklan");
				$data['detail_iklan'] = $this->advertise_model->detail_advertise($id_iklan);
				$this->load->view("modal/detail_advertise", $data);
			}
		}

		function process_edit_area()
		{
			$ajax = $this->input->post("x");
			if($ajax){
				$id_area = $this->input->post("id_area");
				$title = $this->input->post("ad_title");
				$size = $this->input->post("ad_size");
				$currency = $this->input->post("ad_currency");
				$price = $this->input->post("ad_price");
				$status = $this->input->post("status");
				$active = "FALSE";
				if($status == "on") $active = "TRUE";

				$q = "update admin_ad_area set title = '$title', size = '$size', currency = '$currency', price = '$price', active = '$active' where id_area = '$id_area'";
				$this->db->query($q);
			}
		}

		function show_modal()
		{
			$ajax = $this->input->post("x");
			if($ajax){
				$id_area = $this->input->post("id");
				$data['detail_area'] = $this->advertise_model->detail_ad_area($id_area);
				$this->load->view("advertise/modal_edit_price", $data);
			}
		}
		
		function list_item()
		{
			set_page_title("Advertise Management");

        	$this->session->set_userdata("sidebar_flag", $this->_menu);
			
			$data["controller_name"]  = $this->_route;
        	$data["view_folder"] 	  = $this->_view_folder;
			$data["table_name"] 	   = $this->_primary_table;
			$data["base_url"] 	     = base_url();
			
				$data["dt_ad_req"] = $this->advertise_model->list_advertise_req(); 
			
		
			if($_GET["tab"] == "list_price")
			{
				$data["lp_active"] = "active";
				$data["dt_ad_req"] = $this->advertise_model->list_ad_area(); 

			}
			else if($_GET["tab"] == "list_payment")
			{
				$data["lpy_active"] = "active";
				$data["dt_ad_req"] = $this->advertise_model->list_payment_req(); 
				
			}
			else
			{
				$data["al_active"] = "active";
				
			}
			
			$this->load->view($data["view_folder"]."/list_item",$data);
		}
		
		function modal_activate()
		{
			error_reporting(E_ALL);
			
			$is_ajax = $this->input->is_ajax_request();
			
			
			
			if($is_ajax == TRUE)
			{
				$id_ad   = $this->input->post("id_ad",TRUE);
				// detail request / order
				$data["order"] = $this->advertise_model->detail_advertise($id_ad);
				
				$this->load->view("advertise/modal_activate_ad",$data);
			}
		}
		
		function paid_status_modal()
		{
			error_reporting(E_ALL);
			
			$is_ajax = $this->input->is_ajax_request();
			
			
			
			if($is_ajax == TRUE)
			{
				$id_ad   = $this->input->post("id_ad",TRUE);
				// detail request / order
				$data["order"] = $this->advertise_model->detail_advertise($id_ad);
				
				$this->load->view("advertise/modal_paid_status",$data);
			}
			
		}
		
		function paid_status_process()
		{
			
			$this->load->library("form_validation");
			
			$id_ad  = $this->input->post("id_ad",TRUE);
			$paid_status = $this->input->post("paid_status",TRUE);
			
			$this->form_validation->set_rules("id_ad","No Order","required");
			$this->form_validation->set_rules("paid_status","Paid Status","required");
			
			if($this->form_validation->run() == TRUE)
			{
				
				$arr = array(
					
					"id_ad" => $id_ad,
					"paid_status"=> $paid_status
				
				);
				
				$this->advertise_model->paid_status($arr);
				
				
				$result["message"] = "<div class='alert alert-success'> You success </div>";
				$result["status"]  = "success";
			}
			else
			{
				$result["err"] =  validation_errors();
				$result["message"] = "<div class='alert alert-danger'> error ".validation_errors()."</div>"; 
				$result["status"]  = "error";
				
			}
			
			echo json_encode($result);
			
		}
		
		function activate_process()
		{
			$this->load->library("form_validation");
			
			$id_ad  = $this->input->post("id_ad",TRUE);
			$status = $this->input->post("status",TRUE);
			
			$this->form_validation->set_rules("id_ad","No Order","required");
			$this->form_validation->set_rules("status","Status","required");
			
			if($this->form_validation->run() == TRUE)
			{
				
				$arr = array(
					
					"id_ad" => $id_ad,
					"status"=> $status
				
				);
				
				$this->advertise_model->activate_ad($arr);
				
				
				$result["message"] = "<div class='alert alert-success'> You success </div>";
				$result["status"]  = "success";
			}
			else
			{
				$result["message"] = "<div class='alert alert-danger'>".validation_errors()."</div>"; 
				$result["status"]  = "error";
				
			}
			
			echo json_encode($result);
			
		}
		
		function __destruct()
		{
			
			
		}
		
	}