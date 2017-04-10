<?php 

	class Request_upgrade extends CI_Controller{
		
		private $_primary_table = "request_upgrade";
		private $_nation_table  = "nationality";
		private $_vessel_table  = "ship";
	
		private $_menu = MENU_REQUEST_UP;
	
		private $_route = "request_upgrade";
		private $_vessel_route = "vessel";
		private $_view_folder = "request_upgrade";
		
		function __construct()
		{
			parent::__construct();
			
			check_auth();
        	check_privileges($this->_menu);
			
			$this->load->model("request_upgrade_model","rum");
			$this->db2 = $this->load->database(DB2_GROUP,TRUE);
			
		}
		
		
		function index()
		{
			
			
    
		}
		
		function list_item()
		{
				
			set_page_title("Request Upgrade");

			$this->session->set_userdata("sidebar_flag", $this->_menu);
	
			$data["base_url"] 		 = base_url();
			$data["controller_name"]  = $this->_route;
			$data["view_folder"] 	  = $this->_view_folder;
			//$data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list";
			//$data["list_rum"]    	 = $this->rum->list_request_upgrade();
			$data["list_rum"]    	 = $this->rum->list_order_confirm();
			$data["table_name"] 	   = $this->_primary_table;
	
			$data["need_image_tools"] = false;
	
			
			
			$this->load->view($data["view_folder"] ."/item_list", $data);
			
		}
		
		// mengubah data sesuai pesanan
		function change_account_process()
		{			
			error_reporting(E_ALL);
			$this->load->model("agentsea_model");
			
			$no_invoice = $this->input->post("no_invoice");
			
			$detail_order = $this->rum->detail_request($no_invoice);
			$perusahaan = $this->agentsea_model->detail_agentsea($detail_order['email']);
			
			$perusahaan_id 	= $perusahaan['id_perusahaan'];
			$username_company = $perusahaan['username'];
			$status_pilihan   = $detail_order['account_pilihan'];
			
			$this->rum->change_account($detail_order,$perusahaan);
			
			echo "<div class='label label-success'> this Company status has changed </div>";
			
			
		}
		
		// change status order yang hanya punya admin
		function change_status_order()
		{
			
			//echo "asdasd";
			$is_ajax = $this->input->is_ajax_request();
			
			//print_r($_POST); exit;
			if($is_ajax == TRUE)
			{
				$no_invoice = $this->input->post("no_invoice",TRUE);
				$str = "UPDATE request_upgrade SET status = 'PAID' where no_invoice = '$no_invoice' "; //exit;
				$q = $this->db2->query($str);
				
				echo "<div class='label label-success'> This Invoice status is changed to PAID </div>";
			}
			else
			{
				echo "aasdasdasdasdasdas";
				show_404();	
			}
			
		}
		
		function modal()
		{
			$is_ajax = $this->input->is_ajax_request();
			
			if($is_ajax == TRUE)
			{
				$no_invoice = $this->input->post("no_invoice");
				$modal 	  = $this->input->post("modal");
				
				$data['order'] = $this->rum->detail_request($no_invoice);
			
				if($modal == "change_status")
				{
					$this->load->view("request_upgrade/modal/change_status_modal",$data);
				}
				else if($modal == "change_account")
				{
					$this->load->view("request_upgrade/modal/change_account_modal",$data);
				}
			}
			else
			{
				show_404();	
			}
			
		}
		
		function __destruct()
		{
			
		}
		
	}