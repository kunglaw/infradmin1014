<?php

	class Seatizen_print extends CI_Controller{
		
		private $_primary_table 	  = "pelaut_ms";
		private $_prtr			   = "profile_resume_tr";
		private $_crew_table 	     = "crew_ms";
		private $_departement_table  = "department";
		private $_photo_table 	    = "photo_pelaut_tr";
		private $_rank_table 		 = "rank";
		private $_notification_table = "admin_message";
	
		private $_menu = MENU_SEATIZEN;
	
		private $_route = "seatizen";
		private $_view_folder = "seatizen";
		// private $db=null;
		
		function __construct()
		{
			parent::__construct();
        check_auth();
        check_privileges($this->_menu);
        $this->load->model("seatizen_model", "seatizen");
        $this->load->model("department_model","department");
		$this->load->model("rank_model");
        $this->load->model('resume_model');

			
		}
		
		function list_complete_seatizen()
		{
			error_reporting(E_ALL);
			
			$list_seatizen = $this->seatizen->get_allseatizen();
			//print_r($list_seatizen); exit;
			
			$complete_resume = array();
			$zz=0;
			$this->load->model('profile_resume_model');
			
			foreach ($list_seatizen as $row) {
				$crl = $this->profile_resume_model->cek_lengkap_resume($row['pelaut_id']);
				if($crl['result']){
					$complete_resume[$zz] =$row;
					//print_r($complete_resume[$zz++]);
					 //echo "<hr>";
				}
				
				$zz++;
				
			}
			
			set_page_title("Seatizen Management");
		
			$this->load->model("experience_model");
			$this->load->model("vessel_model");
	
			$this->session->set_userdata("sidebar_flag", $this->_menu);
	
			$data["base_url"] 			 = base_url();
			$data["controller_name"]	  = $this->_route;
			$data["view_folder"] 		  = $this->_view_folder;
			// $data["dt_list_source"] 	  = $data["base_url"] . $data["controller_name"] ."/list";
			$data['list_seatizen']        = $complete_resume;
			$data["table_name"] 		   = $this->_primary_table;
	
			$data["need_image_tools"] 	 = false;
			
			$this->load->view($data["view_folder"] ."/item_list", $data);
			
		
			
		}
		
		
		
	}