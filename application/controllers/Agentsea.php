<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Agentsea
 * Handle agentsea operation.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Agentsea extends CI_Controller {

    private $_primary_table = "perusahaan";
    private $_nation_table = "nationality";
    private $_vessel_table = "ship";

    private $_menu = MENU_AGENTSEA;

    private $_route = "agentsea";
    private $_vessel_route = "vessel";
    private $_view_folder = "agentsea";
    private $db2;
    public function __construct() {

        parent::__construct();
		
        check_auth();
        check_privileges($this->_menu);
		
        $this->db2 = $this->load->database(DB_GROUP, TRUE);
		// k-edit
		$this->load->model("agentsea_model");
		$this->load->library("Admin_activity");
		$this->load->model("seatizen_model","sm");
		$this->load->model("vessel_model","vm");

    }
	
	// kunglaw
	// untuk include didalam editable datatable
	private function load_view($page,$arr)
	{
		return $this->load->view($page,$arr,true);
		//return include_once "../views/agentsea/button_role.php";
	}


    /**
     * Show list page.
     */
    public function list_item() {

        set_page_title("Agentsea Management");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] 		 = base_url();
        $data["controller_name"]  = $this->_route;
        $data["view_folder"] 	  = $this->_view_folder;
        //$data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list";
		$data["list_agentsea"]    = $this->agentsea_model->list_agentsea();
        $data["table_name"] 	   = $this->_primary_table;

        $data["need_image_tools"] = false;

        $this->load->view($data["view_folder"] ."/item_list", $data);
    }

    /**
     * Return all item in specified table.
     */
    public function get_list_item_ajax() {

        $this->load->library("datatables");

        $edit_button_area  = ", ".$this->_primary_table .".id_perusahaan AS log_link";
		$edit_button_area .= ", ".$this->_primary_table .".id_perusahaan AS edit_form";
		//$edit_button_area .= ", ".$this->_primary_table .".id_perusahaan AS edit_role";

        // specify columns for datatables
        $this->datatables->select(
            $this->_primary_table .".id_perusahaan AS checkbox, ".
            $this->_primary_table .".nama_perusahaan AS name, ".
            $this->_primary_table .".contact_person AS cp, ".
            $this->_primary_table .".no_telp AS phone, ".
            $this->_primary_table .".email AS email,".
			$this->_primary_table .".activation_code AS ac,".
			$this->_primary_table .".account_type AS Account Type,".
			$this->_primary_table .".role AS Role".
            $edit_button_area
        );

        $this->datatables->from($this->_primary_table);
		
        // modify first and last column for table bulk or individual operation.
        $checkbox = form_checkbox("list_checkboxes[]", "$1");
        $this->datatables->edit_column("checkbox", $checkbox, "checkbox");
		
		// ubah field 
		$this->datatables->edit_column("nama_perusahaan"," ","nama_perusahaan,edit_form");
		                             		
        // link to log list
        $this->datatables->edit_column(
            "log_link",
            '<a href="'. base_url() .'agentsea/log/$1">'.
            '<i class="fa fa-bars"></i>' .
            '</a>',
            "log_link");
			
	    // edit role					// nama kolom yg mau diubah
		$this->datatables->edit_column("Role",$this->load_view("agentsea/button_role",
		array("role" => "$1","edit_form" => "$2","ac" => "$3")),
		"Role,edit_form,ac");
		// nilai $1
		
		// edit form
		$this->datatables->edit_column("edit_form","<a href='#' onclick='edit_agentsea($1)'>".
            '<i class="fa fa-edit"></i>' .
            '</a>',
            "edit_form");

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output($this->datatables->generate());
    }

    /**
     * Show item detail
     * @param $item_id
     */
    public function show_item_detail($item_id) {

        set_page_title("Agentsea Detail");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $item_detail = $this->generic->retrieve_one(
            $this->_primary_table, array("id_perusahaan" => $item_id));

        if (empty($item_detail)) {
            set_notification("Detail is not available.", NOTIF_ERROR);
            redirect($this->_route);
        }

        $nationality = $this->generic->retrieve_one(
            $this->_nation_table, array("id" => $item_detail["id_nationality"]));

        $item_detail["nationality"] = "";
        if (! empty($nationality)) {
            $item_detail["nationality"] = $nationality["name"];
        }

        $item_detail["item_id"] = $item_id;

        $item_detail["base_url"] = base_url();
        $item_detail["controller_name"] = $this->_vessel_route;
        $item_detail["view_folder"] = $this->_view_folder;
        $item_detail["dt_list_source"] = $item_detail["base_url"] . $this->_vessel_route ."/list/". $item_id;
        $item_detail["table_name"] = $this->_vessel_table;
        $item_detail["delete_table_name"] = $this->_vessel_table;

        $item_detail['pic'] = $this->agentsea_model->history_pic($item_id);
		$item_detail["register_from"] = $this->agentsea_model->register_from($item_id); 

        $this->load->view($this->_view_folder ."/item_detail", $item_detail);
    }
	
	
	
	// function ajax
	function form_edit_agentsea()
	{
		$this->load->model("nation_model");
	    $id_perusahaan = $this->input->post("id_perusahaan");
		// load data 
		$data['agentsea'] = $this->agentsea_model->detail_agentsea($id_perusahaan);
		
		$this->load->view("modal/form_edit_agentsea_modal1",$data);
	}
	
	function send_email_form()
	{
		
		$this->load->view("agentsea/send_email_form");	
	}
	
	function send_email_page()
	{
		$data['department'] 	= $this->sm->call_department();
		$data['rank'] 	      = $this->sm->get_rank();
		$data['ship_type'] 	      = $this->sm->get_vessel_type();
		// echo base_url();
		$data['extra_css_str'] = "<link href='".plugin_url()."tags_input/bootstrap-tagsinputs.css' rel='stylesheet' type='text/css' media='all'>"; 

		
		$this->load->view("agentsea/send_email_page", $data);	
	}
	
	function preview_email()
	{
		// error_reporting(E_ALL);
		//print_r($_POST); exit;
		$this->load->library("form_validation");
		$this->load->library("check_data");
		
		$company_name   = $this->input->post("company_name",true);
		$contact_person = $this->input->post("contact_person",true);
		$email		  = $this->input->post("email",true);
		$email_content  = $this->input->post("message",true);
		$type		   = $this->input->post("type",true);
		$is_info 		= $this->input->post("is_info",true);
		/*
			 1. create vacantsea for free 
			 2. demo for company 
			 3. alpha 
		*/ 
		
		$this->form_validation->set_rules("company_name","Company Name","required");
		$this->form_validation->set_rules("contact_person","Contact Person","required");
		$this->form_validation->set_rules("email","Email","required|valid_email");
		$this->form_validation->set_rules("type","Type","required");
		 
		
		if($type == 4)
		{
			$this->form_validation->set_rules("username","Username","required"); 
			$this->form_validation->set_rules("message","Content","required");
		}
		//$this->form_validation->set_rules("message","Content","");
		$check_email = $this->check_data->check_email($email); 
		

		if($this->form_validation->run() == true && $check_email == true)
		{
			// kirim email kalau validasinya benar
			$this->load->library("my_email");
			
			//GLOBAL EMAIL
			$msg = "template_email2016/new_email_template";
			$data["user_type"] = "agentsea";
			
			$user = "user"; // harus select
			$code_invitation = random_string();
			$response["status"] 	   = "success";
			
			if($type == 1) // create vacantsea for free 
			{
				$title_btn = "<b><i style='font-size:14px'> Post Vacantsea and Get Qualified Crew for Free </i></b> ";
				// kalau content kosong maka ada template nya dari 
				
				
				$is_reg  = FALSE;
				$str_url = infr_url("users/create_vacantsea/?t=$code_invitation");
				$content_email	= array('is_reg'=>$is_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,"contact_person"=>$contact_person,"is_info"=>$is_info);
				$data["content_template"] 	 = $this->load->view("email_agentsea/template_2016/create-vacantsea",$content_email,true);
				//$str_reg = "";
				
				if(!empty($email_content))
				{
					//$str_reg = "";
					//$str_url = "";
					$title_btn = "<b><i style='font-size:14px'> Post Vacantsea and Get Qualified Crew for Free </i></b> ";
					
					$content_email = array('is_reg'=>$is_reg,"str_url"=>$str_url,"email_to"=>$email,"title_btn"=>$title_btn,'content'=>$email_content,"is_info"=>$is_info);
					$data["content_template"] = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
				}
				
				$template_email = $this->load->view($msg,$data,true);
			}
			else if($type == 2) // demo 
			{
				$title = "Demo";
				$title_btn_reg = "Free Trial";
				// kalau content kosong maka ada template nya dari 
				
				$is_reg  = TRUE;
				$str_url = "https://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo
				$str_reg = infr_url("users/register/agentsea"); // link registrasi agentsea 
				
				$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
				 "contact_person"=>$contact_person);
				  
				$content_template = $this->load->view("email_agentsea/template_2016/demo-dashboard",$content_email,true);
				
				if(!empty($email_content))
				{
					//$str_url = ""; // demo 
					//$str_reg = ""; // str register
					$title_btn = "Demo";
					$title_btn_reg = "Free Trial";
					
					$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
				  "content"=>$email_content,"contact_person"=>$contact_person,"is_info"=>$is_info);
					
					$content_template 	 = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
		
				}
				
				$data["content_template"] = $content_template;
				  
				$template_email = $this->load->view($msg,$data,true);
				
					
			}
			else if($type == 3) // alpha 
			{
				$title = "Demo";
				// kalau content kosong maka ada template nya dari 
				
				$is_reg  = TRUE;
				$str_url = "https://devalpha.informasea.com/user/login_demo?t=$code_invitation"; // demo alpha
				$str_reg = "https://alpha.informasea.com/user/register"; // register alpha
				
				$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
				  "contact_person"=>$contact_person);
				
				$content_template = $this->load->view("email_agentsea/template_2016/demo-alpha",$content_email,true);
				
				
				if(!empty($email_content))
				{
					//$str_url = ""; // demo 
					//$str_reg = ""; // str register
					$title_btn = "Demo";
					$title_btn_reg = "Free Trial";
					
					$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
				  "content"=>$email_content,"contact_person"=>$contact_person);	
					
					$content_template 	 = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
					
				}
				
				$data["content_template"] = $content_template;
				  
				$template_email = $this->load->view($msg,$data,true);
			}
			else if($type == 4) // Demo and Activate
			{
				$title = "Demo";
				
				$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,
				"email_to"=>$email,'company_name' => $company_name,
				 "content"=>$email_content,"contact_person"=>$contact_person,"is_info"=>$is_info);	
				
				// kalau content kosong maka ada template nya dari 
				$content_template 	 = $this->load->view("email_agentsea/template_2016/demo-activate",$content_email,true);
				//$alt_msg = "email_agentsea/template_2016/demo-alpha-alt"; 
				//$is_reg  = TRUE;
				//$str_url = "https://devalpha.informasea.com/user/login_demo?t=$code_invitation"; // demo alpha
				//$str_reg = "https://alpha.informasea.com/user/register"; // register alpha
				
				if(!empty($email_content))
				{
					//$str_url = ""; // demo 
					//$str_reg = ""; // str register
					$title_btn 	 = "Demo";
					$title_btn_reg = "Activate";
					
					$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,
				"email_to"=>$email,'company_name' => $company_name,
				 "content"=>$email_content,"contact_person"=>$contact_person);	
				 
					$content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
					
				}
				
				$data["content_template"] = $content_template;
				
				$template_email = $this->load->view($msg,$data,true);
			}
			
			
			$dt_p['title'] 		  = $title;
			$dt_p['template_email'] = $template_email;
			
			$response["result"] 	 = $template_email;//$this->load->view("agentsea/preview-email",$dt_p,true);
			
			echo json_encode($response);
			
		}
		else
		{
			if($check_email == false)
			{
				$err_email = "<p> Email has been Registered loohh </p>";	
			}
			
			$err = validation_errors();
			$response["status"] 	   = "error";
            $response["notification"] = " $err $err_email  ";
			
			echo json_encode($response);	
		}
		
		
		
	}

	function validate_email()
	{
		# code...
		$email = $this->input->post("email");
		$pass = base64_decode($this->input->post("pass"));
		echo "$email dan $pass";
	}
	
	// sudah benar
	function send_email_process()
	{
		error_reporting(E_ALL);
		//print_r($_POST); exit;
		$this->load->library("form_validation");
		$this->load->library("check_data");
		
		$company_name   = $this->input->post("company_name",true);
		$email_sender   = $this->input->post("email_from",true);
		$contact_person = $this->input->post("contact_person",true);
		
		$email_from     = $this->input->post("email_from",true);
		$password_email = $this->input->post("password_email",true);
		
		$list_email	 = json_decode($this->input->post("list_email",true), true); 
		$email_content  = $this->input->post("message",true);
		$type		   = $this->input->post("type",true);
		
		$department 	 = $this->input->post("department",true);
		$rank		   = $this->input->post("rank",true);
		$vessel		 = $this->input->post("vessel_type",true);
	
		$nama_file_gambar		= $this->input->post("file_imgnya",true);

		/*
			 1. create vacantsea for free 
			 2. demo for company 
			 3. alpha 
		*/ 
		
		$this->form_validation->set_rules("company_name"  ,"Company Name","required");
		$this->form_validation->set_rules("contact_person","Contact Person","required");
		// $this->form_validation->set_rules("email"		 ,"Email","required|valid_email");
		$this->form_validation->set_rules("type"		  ,"Type","required"); 
		
		// jika username atau email yang dimasukkan sudah ada di database , 
		// maka hanya send email saja tidak usah dimasukkan data nya ke database 
		$email_terdaftar  = $email_tidak_terdaftar = 0;
		$registered_email = $unregistered_email = "";
		// kirim email kalau validasinya benar
				$this->load->library("email");
				$this->load->library("my_email");
		foreach ($list_email as $each_email) {
			
			# code...
			$email = $each_email['email'];
			$stat_email = $each_email['status'];
			$company_name = $each_email['company_name'];
			$contact_person = $each_email['contact_person'];
			$username = $each_email['username'];
			
			$str = "SELECT * FROM perusahaan WHERE  username = '$username' OR email = '$email' ";
			$q   = $this->db->query($str);
			$check_perusahaan   = $q->row_array();
			
			/* if($type == 4 )
			{
				$this->form_validation->set_rules("username","Username","required"); 
				$this->form_validation->set_rules("message","Content","required"); 
				$check_email = TRUE;
			}
			else
			{
				$check_email = $this->check_data->check_email($email); // sementara 	
			}*/
			$check_email = TRUE;
			
			//$this->form_validation->set_rules("message","Content","");
			
			if($this->form_validation->run()== TRUE)
			{
				// GLOBAL EMAIL
				$msg = "template_email2016/new_email_template";
				$data["user_type"] = "agentsea";
				
				if($stat_email){

				
				
				//$user = "info"; // harus select
				if($password_email != ""){
				
					$user['smtp_user'] = $email_from;
					$user['smtp_pass'] = $password_email;
				}
				else
				{ 
					$user = "info";
				}
				
				$code_invitation = random_string();
				$msg = "template_email2016/new_email_template";
				
				if($type == 1) // create vacantsea for free 
				{
					
					// kalau content kosong maka ada template nya dari 
					
					
					$is_reg  = FALSE;
					$str_url = infr_url("users/create_vacantsea/?t=$code_invitation");
					$content_email	= array('is_reg'=>$is_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,"contact_person"=>$contact_person,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
					
					$content_template = $this->load->view("email_agentsea/template_2016/create-vacantsea",$content_email,true);
					//$str_reg = "";
					
					if(!empty($email_content))
					{
						//$str_reg = "";
						//$str_url = "";
						$title_btn = "<b> <i style='font-size:14px'> Post Vacantsea and Get Qualified Crew for Free </i> </b> ";
						
						$content_email	= array('is_reg'=>$is_reg,"str_url"=>$str_url,"email_to"=>$email,"title_btn"=>$title_btn,'content'=>$email_content,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
						
						$content_template 	 = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
					}
					
					$data["content_template"] = $content_template;
					
					$content = array(
					
					  "subject" 		=> "Informasea - Post Vacantsea and Get Qualified Crew for Free",
					  "subject_title"  => WEBSITE,
					  "to" 			 => $email, 
					  "data" 		   => $data,
					  
					  "message" 		=> $msg,
					  "mv" 			 => TRUE,
					 
				
					);
				}
				else if($type == 2) // demo dashboard
				{
					
					// kalau content kosong maka ada template nya dari 
					
					$is_reg  = TRUE;
					$str_url = "https://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo
					$str_reg = infr_url("users/register/agentsea"); // link registrasi agentsea 
					$content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],"is_info"=>$is_info);
					$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,
					  "str_url"=>$str_url,"email_to"=>$email);
					
					$content_template = $this->load->view("email_agentsea/template_2016/demo-dashboard",$content_email,true);
					
					if(!empty($email_content))
					{
						//$str_url = ""; // demo 
						//$str_reg = ""; // str register
						$title_btn = "Demo";
						$title_btn_reg = "Free Trial";
						
						$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg, "content" => $email_content,
					  "str_url"=>$str_url,"email_to"=>$email);
					  
					  	$content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
					}
					
					$data["content_template"] = $content_template;
					
					$content = array(
					
					  "subject" 		=> "INFORMASEA - Crew Management System",
					  "subject_title"  => WEBSITE,
					  "to" 			 => $email, 
					  /* "data" 		   => array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,
					  					   "str_url"=>$str_url,"email_to"=>$email,
										  'company_name' => $company_name, 
										  "content"=>$email_content,
										  "contact_person"=>$contact_person,"is_info"=>$is_info, "file_img" => $nama_file_gambar),*/
					  "data"		   => $data,
					  "message" 		=> $msg,
					  "mv" 			 => TRUE
					  
				
					);	
				}
				else if($type == 3) // alpha 
				{
					
					// kalau content kosong maka ada template nya dari 
					$is_reg  = TRUE;
					$str_url = "https://devalpha.informasea.com/user/login_demo?t=$code_invitation"; // demo alpha
					$str_reg = "https://alpha.informasea.com/user/register"; // register alpha
					
					$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
					  "content"=>$email_content,"contact_person"=>$contact_person,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
					
					$content_template = $this->load->view("email_agentsea/template_2016/demo-alpha",$content_email,true);
					
					if(!empty($email_content))
					{
						//$str_url = ""; // demo 
						//$str_reg = ""; // str register
						$title_btn = "Demo";
						$title_btn_reg = "Free Trial";
						
						$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
					  "content"=>$email_content,"contact_person"=>$contact_person,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
						
						$content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
						
					}
					
					$data["content_template"] = $content_template;
					
					$content = array(
					
					  "subject" 		=> "INFORMASEA - Crew Management System",
					  "subject_title"  => WEBSITE,
					  "to" 			 => $email, 
					  "data"		   => $data,
					  
					  "message" 		=> $msg,
					  "mv" 			 => TRUE
				
					);	
				}
				else if($type == 4) // send activation and demo 
				{
					// set password buat new company
					//$set_pass 		= mt_rand(100000,999999);
					//$pass	 		= md5($set_pass);
					//$activation 	  = md5(uniqid(rand(), true)); // kode untuk diaktivasi 
					
					/* if(empty($check_perusahaan))
					{
						$arr["nama_perusahaan"] = $company_name;
						$arr["contact_person"]  = $contact_person;
						$arr["username"] 		= $username;
						$arr["password"]		= $pass; 
						$arr["activation_code"] = $activation;
						$arr["email"]		   = $email;
						$arr["role"]			= "Manager";
						$arr["account_type"] 	= "Free_trial";
						$arr["official"]		= "Agent"; 
						
						$this->agentsea_model->insert_agentsea($arr);	
						
					}*/
					if(!empty($check_perusahaan))
					{
						// set buat kirim email
						$username 			= $check_perusahaan['username'];
						$activation_code 	 = $check_perusahaan["activation_code"];
							
					}
					
					// kalau content kosong maka ada template nya dari 
					
					
					$is_reg  = TRUE;
					$str_url = "https://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // demo dashboard
					
					$str_reg  = "https://agent.informasea.com/user/user_process/";
					$str_reg .= "activate_company/?a=$check_perusahaan[activation_code]&x=1&u=$username&email=$email"; //infradmin
					
					$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
					  "content"=>$email_content,"contact_person"=>$contact_person,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
					
					$content_template = $this->load->view("email_agentsea/template_2016/demo-activate",$content_email,true);
					// activate
					
					if(!empty($email_content))
					{
						//$str_url = ""; // demo 
						//$str_reg = ""; // str register
						$title_btn 	 = "Demo";
						$title_btn_reg = "Activate";
						
						$content_email = array("title_btn_reg"=>$title_btn_reg,"title_btn"=>$title_btn,"is_reg"=>$is_reg,"str_reg"=>$str_reg,"str_url"=>$str_url,"email_to"=>$email,'company_name' => $company_name,
					  "content"=>$email_content,"contact_person"=>$contact_person,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
						
						$content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
						
					}
					
					$data["content_template"] = $content_template;
					
					$content = array(
					
					  "subject" 		=> "INFORMASEA - Activate Account",
					  "subject_title"  => WEBSITE,
					  "to" 			 => $email, 
					  "data" 		   => $data,
					  
					  "message" 		=> $msg,
					  "mv" 			 => TRUE,
					  //"alt_message" 	=> $alt_msg,
					  //"amv" 		    => TRUE
				
					);
					
				}
				else if($type == 5)
				{
					
					// data 
						  
					$data["user_type"] = "agentsea";
					
					 $title_btn_reg = "Create Vacantsea for Free";
					 $is_reg  = TRUE;
					 $first_str_url = infr_url("users/create_vacantsea");
					
					$content_email = array("is_reg"=>$is_reg,"title_btn_reg"=>$title_btn_reg,"department"=>$department,
					"name" => $each_email['contact_person'],"rank"=>$rank, "vessel_type" => $vessel,"email_to"=>$email,
					"user_type"=>"agentsea");
					
					$content_email["department"] = $department;
					$content_email["rank"]       = $rank;
					
					$data['content_template'] = $this->load->view("email_agentsea/template_2016/email-seatizen-list",$content_email,true); 
					
					if(!empty($email_content))
					{
						// $aaa["department"] = $department;
						// $aaa["rank"]       = $rank;
						
						$list_template = $this->load->view("email_agentsea/template_2016/list-template-seatizen",$aaa,true);
						
						$button = ""; // button bisa disetting kalo mau 
						$content_email = array("is_first_button"=>$is_reg,
						"first_title_btn"=>$title_btn_reg,
						"str_url"=>$first_str_url,
						"list_template"=>$list_template,"name" => $each_email['contact_person'],
						"button"=>$button,"content"=>$email_content,"email_to"=>$email,
						"department"=>$department,"rank"=>$rank,"user_type"=>"agentsea");
						
						$data['content_template'] = $this->load->view("email_agentsea/template_2016/email-universal-content",$content_email,true);
						// lama
						
					}
	
					$content = array(
					
					  "subject" 		=> "INFORMASEA - We Have Any Crews You Need",
					  "subject_title"  => WEBSITE,
					  "to" 			 => $email, 
					  "data" 		   => $data,
					  
					  "message" 		=> $msg,
					  "mv" 			 => TRUE,
					  //"alt_message" 	=> $alt_msg,
					  //"amv" 		    => TRUE
				
					);
				}

				$isi_pesan_terkirim = str_replace("'", "\'", $data['content_template']);
				
				$this->my_email->send_email($user,$content);
				
				// catat kedalam table 
				$arr["company_name"] 	= $company_name;
				$arr["contact_person"]  = $contact_person;
				$arr["email"]		   = $email;
				$arr["email_content"]   = $isi_pesan_terkirim;
				$arr["code_invitation"] = $code_invitation;
				$arr["PIC"]			 = $this->session->userdata("name");
				$arr["type"]			= $type;
				$arr["username"]	    = $username;
				
				$this->agentsea_model->send_email_add($arr);
				
				// catat yang bertanggung jawab 
				// insert admin activity
				// untuk keperluan admin_activity
				$table			 = $this->_primary_table;
				$arr['menu']	   = $this->_route;
				$arr['name']   	   = $this->session->userdata("name");
				$arr['form']	   = "send_email_agentsea";
				$arr['id_object']  = "";
				$arr['action']     = "admin $arr[name] send email agentsea for data store at table $table ";
				if($email_terdaftar != 0) $registered_email .= ", ";
				$registered_email .= $email;
					$email_terdaftar++;
				//print_r($this->session->all_userdata());
				$this->admin_activity->insert_activity($arr); 
				
				$response["status"] 	   = "success";
	            
	            }
	            else{
	            	if($email_tidak_terdaftar != 0) $unregistered_email .= ", ";
					$unregistered_email .= $email;
	            	$email_tidak_terdaftar++;
	            }	
				
			}
			else
			{
				
				$err = validation_errors();
				$response["status"] 	   = "error";
	            $response["notification"] = "<div class='alert alert-danger' role='alert' style='padding:20px;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> $err $err_email </div> ";
			}
		
		}
		
		$response["post"]		   = json_encode($_POST);
		$response["email_debugger"] = $this->my_email->printDebugger();
		
		$response["notification"] = "<div class='alert alert-success' role='alert' style='padding:20px;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>you successfully send an email <b style='color: green'>($registered_email)</b> ";
		$response['notification'] .= $unregistered_email != "" ? "and unsuccessful send an email because of already registered <b style='color: red'>($unregistered_email)</b> " : "";
		$response['notification'] .= "to $company_name </div> ";	
		
		echo json_encode($response);
		
	}
	
	function form_edit_data(){
		
		$this->load->model('nation_model');
		 $id_perusahaan = $this->input->post("id_perusahaan");
		// load data 
		$data['agentsea'] = $this->agentsea_model->detail_agentsea($id_perusahaan);
		
		$this->load->view("modal/form_edit_data_agentsea",$data);
	}
	
	
	function form_edit_role()
	{
		 $id_perusahaan = $this->input->post("id_perusahaan");
		 $data['agentsea'] = $this->generic_model->retrieve_one($this->_primary_table,array("id_perusahaan" => $id_perusahaan ));
		 
		 $this->load->view("modal/form_edit_role",$data);	
		 
		 //$this->output->set_content_type("application/html");
         //$this->output->set_status_header(200);
	}

	function edit_tampil(){
		$id_perusahaan = $this->input->post('id_perusahaan');

		$data['agentsea'] = $this->agentsea_model->detail_agentsea($id_perusahaan);

		$this->load->view("modal/form_edit_tampil",$data);
	}
	
	private function check_sum_item($item)
	{
		//arrange item
		
		$email 			= $item["email"];
		$company_name	 = $item["company_name"];
		$contact_person   = $item["contact_person"];
		$username   = $item["username"];
		
		if(count($email) > 1)
		{
			$jml_email 		= count($email);
			$jml_cn			= count($company_name);
			$jml_cp			= count($contact_person);
			$jml_uname		= count($username);
		}
		else
		{
			$jml_email 		= 1;
			$jml_cn		   = 1;
			$jml_cp		   = 1;
			$jml_uname		   = 1;
		}
		
		if(($jml_email != $jml_cn ) && ($jml_email != $jml_cp) && ($jml_email != $jml_uname))
		{
			$result['status'] = false;
		}
		else
		{
			$pair = array();
			
			for($i=0; $i < $jml_email; $i++)
			{
			
				$pair[] = array("email"=>$email[$i],"company_name"=>$company_name[$i],"contact_person"=>$contact_person[$i], "username" => $username[$i]);
			
			}
			
			
			$result["data"]   = $pair; 
			$result['status'] = TRUE;
 		}
		
		return $result;
			
	}
	
	function preview_email_agentsea()
	{	
		error_reporting(E_ALL);
		$this->load->library("form_validation");
		$this->load->library("check_data");
		
		$company_name   = explode(",",$this->input->post("company_name",true));
		$contact_person = explode(",",$this->input->post("contact_person",true));
		$email		  	= explode(',', $this->input->post("email",true));
		$username		= explode(',', $this->input->post("username",true));
		$email_content  = $this->input->post("message",true);
		$type		   	= $this->input->post("type",true);
		$is_info		= $this->input->post("is_info",true);
		$img_content 	= $_FILES["browse_img"];
		
		$department 	= $this->input->post("department",true);
		$rank 			= $this->input->post("rank",true);
		$vessel 			= $this->input->post("vessel_type",true);
		// echo "$vessel -> $department -> $rank";exit;
		// print_r($img_content);
		// echo "\n";
		$file_img = "";
		
		if(isset($img_content)){
			
			$this->load->helper("upload_file");
			$q = "select id from admin_send_email_agentsea order by id desc limit 1";
			$exec = $this->db2->query($q);
			$hasil = $exec->row_array();
			$id_terakhir = $hasil['id'];
			$id_terakhir+=1;
			$img_content['name'] = "img_invite_email_$id_terakhir.".end(explode('.', $img_content['name']));
			$upload_file = upload_file_email($img_content);
			$file_img = $upload_file['data']['file_name'];
// print_r($upload_file);
// echo "\n";
		}

		/*
			 1. create vacantsea for free 
			 2. demo for company 
			 3. alpha 
		*/
		
		$this->form_validation->set_rules("company_name","Company Name","required");
		$this->form_validation->set_rules("contact_person","Contact Person","required");
		$this->form_validation->set_rules("email","Email","required");
		$this->form_validation->set_rules("type","Type","required"); 
		//$this->form_validation->set_rules("message","Content","");
		
		$list_email = array();
		
		$e=0;
		
		// check apakah jumlah contact person sama dengan jumlah 
		// generate pair
		// if($email == TRUE)
		// {
			$item["email"] 		 = $email;
			$item["company_name"]  = $company_name;
			$item["contact_person"]= $contact_person;
			$item["username"]= $username;
		// }
		// else
		// {
		// 	$company_name   = $this->input->post("company_name",true);
		// 	$email 		  = $this->input->post("email",true);
		// 	$contact_person = $this->input->post("contact_person",true);
			
		// 	$item["email"] 		 = $email;
		// 	$item["company_name"]  = $company_name;
		// 	$item["contact_person"]= $contact_person;
		// }
	
		$pair = $this->check_sum_item($item);
		
		
		if($pair["status"] == FALSE)
		{
			$response["status"] = "error";
			$response["result"]	= "<div class='alert alert-danger' role='alert' id='error-message'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						the ammount of the item must match each other </div>";
			echo json_encode($response);
			exit;
		} // Berhenti 
		
		foreach ($email as $value) {
			
			# code...
			$list_email[$e++] = array();
		}
	
		$e=0; 
		$check_email = true;
		$response['result'] = "";
		
		if($type == 4)
		{
			$this->form_validation->set_rules("username","Username","required"); 
			// $this->form_validation->set_rules("message","Content","required");
		}
			
			// GLOBAL EMAIL
			$msg = "template_email2016/new_email_template";
			$data["user_type"] = "agentsea";
			
			foreach ($pair["data"] as $value) {
				// echo $value['email']; exit;
				# code...	// disable sementara
				if(true /* $this->check_data->check_email($value['email'])*/){
					
					$list_email[$e] = array_merge($list_email[$e], array('email' => $value['email'], 'company_name' => $value['company_name'], 'contact_person' => $value['contact_person'], 'username' => $value['username'], 'status' => true));
					
					if($this->form_validation->run() == true && $check_email == true)
					{
					  if($type == 1) // create vacantsea for free 
					  {
						  
						  // kalau content kosong maka ada template nya dari 

						  $is_reg  = FALSE;
						 
						  //$str_url = infr_url("users/create_vacantsea/?t=$code_invitation");
						  $content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],"is_info"=>$is_info);
						  
						  $content_template 	 = $this->load->view("email_agentsea/template_2016/create-vacantsea",$content_email,true);
						  
						  if(!empty($email_content))
						  {
							  //$str_reg = "";
							  //$str_url = "";
							  $title_btn = "<b><i style='font-size:14px'> Post Vacantsea and Get Qualified Crew for Free </i></b> ";
							 
							  $content_email    = array('is_reg'=>$is_reg,"email_to"=>$value['email'],"title_btn"=>$title_btn,'content'=>$email_content,"str_reg"=>"#"
							  ,"contact_person"=>$value['contact_person'],"is_info"=>$is_info);
							  
							  $content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
						  }
						  
						  $data["content_template"] = $content_template;
					  
					  }
					  else if($type == 2) // demo dashboard
					  {
						  
						  // kalau content kosong maka ada template nya dari 
						  
						  $is_reg  = TRUE;
						  $str_url = "https://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo
						  $str_reg = infr_url("users/register"); // link registrasi agentsea 
						  $content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],"str_reg"=>$str_reg,"is_info"=>$is_info, "str_url" => $str_url);
						  
						  $content_template 	 = $this->load->view("email_agentsea/template_2016/demo-dashboard",$content_email,true);
						  
						  
						  if(!empty($email_content))
						  {
							  //$str_url = ""; // demo 
							  //$str_reg = ""; // str register
							  $title_btn = "Demo";
							  $title_btn_reg = "Free Trial";
							  // $str_url = "https://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo
							
							  $content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],
							  "content"=>$email_content,"title_btn"=>$title_btn,"title_btn_reg"=>$title_btn_reg,"str_reg"=>$str_reg,"is_info"=>$is_info, "str_url" => $str_url);
							  $content_template 	 = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
						  }
						  $data["content_template"] = $content_template;
						  
					  }
					  else if($type == 3) // alpha 
					  {
						  
						  // kalau content kosong maka ada template nya dari 
						  
						  
						  $is_reg  = TRUE;
						  $content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],"is_info"=>$is_info);
						  //$str_url = "https://devalpha.informasea.com/user/login_demo?t=$code_invitation"; // demo alpha
						  
						  $content_template = $this->load->view("email_agentsea/template_2016/demo-alpha",$content_email,true);
						  
						  $str_reg = "https://alpha.informasea.com/user/register"; // register alpha
						  
						  if(!empty($email_content))
						  {
							  //$str_url = ""; // demo 
							  //$str_reg = ""; // str register
							  $title_btn = "Demo";
							  $title_btn_reg = "Free Trial";
							  
							  
							  $content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],
							  "content"=>$email_content,"title_btn"=>$title_btn,"title_btn_reg"=>$title_btn_reg,"str_reg"=>$str_reg,"is_info"=>$is_info);
							  $content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
						  }
						  
						  $data["content_template"] = $content_template;
						  
						  
					  }
					  else if($type == 4) // Demo and Activate
					  {

						  $title = "Demo";
						  // kalau content kosong maka ada template nya dari 
						  
						  //$alt_msg = "email_agentsea/template_2016/demo-alpha-alt"; 
						  $is_reg  = TRUE;
						  //$str_url = "https://devalpha.informasea.com/user/login_demo?t=$code_invitation"; // demo alpha
						  //$str_reg = "https://alpha.informasea.com/user/register"; // register alpha
						  
						  $content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],"is_info"=>$is_info);
						  
						  $content_template 	 = $this->load->view("email_agentsea/template_2016/demo-activate",$content_email,true);
						  
						  if(!empty($email_content))
						  {
							  $title_btn     = "Demo";
							  $title_btn_reg = "Activate";
							  
							  $content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],
							  "content"=>$email_content,"title_btn"=>$title_btn,"title_btn_reg"=>$title_btn_reg,"str_reg"=>$str_reg,"is_info"=>$is_info);
							  $content_template  = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
						  }

						  $data["content_template"] = $content_template;
					  }
					  else if($type == 5)
					  {
						  // data 
						  
						   $title_btn_reg = "Create Vacantsea for Free";
						   $is_reg  = TRUE;
						   $first_str_url = infr_url("users/create_vacantsea");
						   
						  $data["user_type"] = "agentsea";
						  
						  $content_email = array('is_reg'=>$is_reg,"department"=>$department,"name" => $value['contact_person'],"rank"=>$rank,"email_to"=>$email,"is_info"=>$is_info, "vessel_type" => $vessel,
						  "user_type"=>"agentsea");
						  
						  
						  $data['content_template'] = $this->load->view("email_agentsea/template_2016/email-seatizen-list",$content_email,true); /*exit;*/
						  
						  if(!empty($email_content))
						  {
							  $aaa["department"] = $department;
							  $aaa["rank"]       = $rank;
							  $aaa["vessel_type"]       = $vessel;
							  
							  $list_template = $this->load->view("email_agentsea/template_2016/list-template-seatizen",$aaa,true);
							  
							  $button = ""; // button bisa disetting kalo mau 
							  $content_email = array('is_first_button'=>$is_reg,
							  "first_title_btn"=>$title_btn_reg,
							  "str_url"=>$first_str_url,
							  "list_template"=>$list_template,"name" => $value['contact_person'],
							  "button"=>$button,"content"=>$email_content,"email_to"=>$email,
							  "department"=>$department,"vessel_type" => $vessel,"rank"=>$rank,"user_type"=>"agentsea");
							  
							  $data['content_template'] = $this->load->view("email_agentsea/template_2016/email-universal-content",$content_email,true);
							  // lama
							  
						  }
						  
						  $check_result = TRUE;
					  }
					  else
					  {
					  	$response['result']	= "Saya tidak ada tipenya<br>";
						
						$check_result = TRUE;	
						$content_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
						
						$data["conetent_template"] = $this->load->view("send_email/email/email-universal-content",$content_email,true);
					  }

					  $data = array_merge($data, array('file_img' => $file_img));
						// echo $type;
					  $data["config"] = $this->config->item("info");
					  
					  //$response["result"] 	   = "tetap benar";
					  // print_r($data); exit;
					  $response["result"] 	   .= $this->load->view($msg,$data,true)."<br><br>";
					  $response["status"]	   = "success";
					  
					}
					else
					{
						if($check_email == false)
						{
							$err_email = "<p> Email has been Registered </p>";	
						}
						
						$err = validation_errors();
						$response["status"] 	   = "error";
			            $response["result"] 	   = " <div class='alert alert-danger' role='alert' id='error-message'>
						<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
						 $err $err_email </div> ";
					}
				}
				
				else $list_email[$e] = array_merge($list_email[$e], array('email' => $value, 'status' => false));
				$e++;
			}
		
		//$check_email = TRUE;
		$response['list_email'] = $list_email;
		

		
		echo json_encode($response);
		
	}

	function proses_edit_tampil(){

		$tampil = $this->input->post('tampil');
		$id_perusahaan = $this->input->post('id_perusahaan');
		//echo $tampil;
		$str = $this->agentsea_model->update_tampil($id_perusahaan,$tampil);

		if($str){

			echo "<div class='alert alert-success'> Success Edited </div>";
			echo "<script>setTimeout(function(){location.reload();
			},2000);</script>";


		$arr['menu']	   = $this->_route;
		$arr['name']       = $this->session->userdata("name");
		$arr['form']       = "edit_tampil";
		$arr['id_object']  = $this->input->post("id_perusahaan");
		$table			 = $this->_primary_table;
		
		if($tampil == 1){
			$tampil = "Tampil";
		}else{
			$tampil = "Tidak Tampil";
		}

		$arr['action'] = "admin $arr[name] edit tampil set tampil = <b> $tampil </b> for data id_object = $arr[id_object] from table $table ";
			$this->admin_activity->insert_activity($arr);

		}else{
			echo "<div class='alert alert-danger'> Gagal </div>";
		}


	}
	
	function edit_account_setting()
	{
		$id_perusahaan = $this->input->post('id_perusahaan');

		$data['agentsea'] = $this->agentsea_model->detail_agentsea($id_perusahaan);

		$this->load->view("agentsea/account_setting",$data);
	}
	
	function edit_account_type() // account type, 
	{
		 $id_perusahaan = $this->input->post("id_perusahaan");
		 $data['agentsea'] = $this->agentsea_model->detail_agentsea($id_perusahaan);
		 
		 $this->load->view("agentsea/edit_account_type",$data);	
		 
	}
	
	function edit_official()
	{
		 //error_reporting(E_ALL);
		 $id_perusahaan = $this->input->post("id_perusahaan");
		 $data['agentsea'] = $this->agentsea_model->detail_agentsea($id_perusahaan);
		 
		 $this->load->view("agentsea/edit_official",$data);	
		 
	}
	
	function account_setting_process()
	{
		error_reporting(E_ALL);
		
		$au 				= $this->input->post("authorized");
		$unau			  = $this->input->post("unauthorized");
		$invalid_phone	 = $this->input->post("invalid_phone");
		//$invalid_email	 = $this->input->post("invalid_email");
		
		$valid_email	   = $this->input->post("valid_email");
		$activation		= $this->input->post("activation");
		$send_email		= $this->input->post("send_email");
		
		$id_perusahaan	 = $this->input->post("id_perusahaan",TRUE);
		
		//fetch data perusahaan
		$dt_perusahaan  = $this->agentsea_model->detail_agentsea($id_perusahaan);
		
		// cek apakah authorisasi nya 
		if($au == "on")
		{
			
			//change status
			$status[] = "VERIFIED";

			// ubah status
		    $this->agentsea_model->change_status($id_perusahaan,$status);
			
			// insert admin activity 
			$arr['action'] = "admin $arr[name] set VERIFIED for data id_object = $arr[id_object] from table $table ";
			$this->admin_activity->insert_activity($arr);
			 
		}
		else
		{
			if($unau == "on")
			{
				
				// for change content email
				//$this->load->view('email_agentsea/template_2016/unauthorize-person');
				$message_text[] = "<div> you are unauthorized person half $dt_perusahaan[company_name] its our pleasure for having your manager contact to continue this verification process by reply this message </div>"; // Isi Pesan yang hendak di tampilkan 
				$dt_email["user_type"] = "agentsea";
				// change status
				$status[] = "unauthorized";
			}
			
			/* if($invalid_email == "on")
			{
				
				// for change content email
				//$this->load->view("email_agentsea/template_2016/");
				$message_text[] = "<div> Invalid Email </div>";
				
				//change status
				$status[] = "invalid_email";

			}*/
			
			if($invalid_phone == "on")
			{
				
				// for change content email
				//$this->load->view("email_agentsea/template_2016/phone-not-valid");
				
				$message_text[] = "<div> the phone number is not valid. please send us the valid phone number to continue verification process by reply this message </div>
				<div> If you are an agent from this company, please kindly ask the manager to add yourself as an agent from your company dashboard web </div>";
				
				//change status
				$status[] = "invalid_phone";
				
			}		
			if( !empty($invalid_phone) || !empty($unau) ){ 
				
				// ubah status
				$this->agentsea_model->change_status($id_perusahaan,$status);
			
			}
			
			// insert admin activity 
			$status_str = implode("|",$status);
			$arr['action'] = "admin $arr[name] set status $status_str for data id_object = $arr[id_object] from table $table ";
			
			//print_r($this->session->all_userdata());
			$this->admin_activity->insert_activity($arr);	
			
		}// END OF AUTHORIZE 
		
		//ubah semua vacantsea nya menjadi "open" atau "hold"
		$this->agentsea_model->change_vacantsea_stat($id_perusahaan);
		
		// change activation
		if(!empty($activation))
		{
			$this->agentsea_model->change_activation();
		}
		
		//change valid_email
		if(!empty($valid_email))
		{
			$this->agentsea_model->change_valid_email();	
		}
		
		
		
		// SEND EMAIL  
		if($send_email == "yes")
		{
			$this->load->helper("email");
			$msg = "template_email2016/new_email_template";
			
			$dt_email['data'] 	  	    = $dt_perusahaan;
			$dt_email["email_to"] 	 	= $dt_perusahaan['email'];
			$dt_email['contact_person']  = $dt_perusahaan["contact_person"];
			$dt_email["user_type"] 	   = "agentsea";
			$dt_email['config'] 	   	  = $this->config->item("info");
			$dt_email["title_text"]   	  = "Data not valid";
			
			if($au != "on")
			{
				$dt_email["message_text"] = $message_text;
				
				$dt["content_template"] = $this->load->view("email_agentsea/template_2016/data-not-valid",$dt_email,true);
				$message				= $this->load->view($msg,$dt,true);
				
				$email_result = @send_email(array($dt_perusahaan['email'],"info@informasea.com"), "Data not Valid", $message);
				
				if ($email_result)  {
					set_notification("an Activation Code has been send to corporate webmail .", NOTIF_SUCCESS);
					$response["status"] = "success";
					$response["notification"] = "an Activation Code has been send to corporate webmail";
					$alert_type = "alert-success";
				} else {
					$response["status"] = "error";
					$response["notification"] = "Unable to send activation code .";
					$alert_type = "alert-danger";
				}
					
			}
			else
			{
				
				$this->load->library("my_email");
				$dt_email["str_url"] 	 = infr_url("login");
				
				$dt_email["authorized"]  = $au;
				$dt_email["activation"]  = $activation;
				$dt_email["valid_email"] = $valid_email;
				
				$dt["content_template"] = $this->load->view("email_agentsea/template_2016/authorized",$dt_email,true);
				$message		  		= $this->load->view($msg,$dt,true);
				
				$email_result = @send_email(array($dt_perusahaan['email'],"info@informasea.com","alhusna901@gmail.com"), "Authorized Account", $message);
				
				if ($email_result)  {
					set_notification("an Verified Acoount has been send to corporate webmail .", NOTIF_SUCCESS);
					$response["status"] = "success";
					$response["notification"] = "an Activation Code has been send to corporate webmail";
					$alert_type = "alert-success";
				} else {
					$response["status"] = "error";
					$response["notification"] = "Unable to send activation code .";
					$alert_type = "alert-danger";
				}
				
			}
			
		}
		
		echo $response["notification"] = "you successfully save the update account setting";
		set_notification("you successfully save the update account setting", NOTIF_SUCCESS);
		
		
		
	}
	
	function official_process()
	{
		// update account type 
		$official = $this->input->post("official");
		$this->agentsea_model->change_official();
		
		// insert admin activity
		// untuk keperluan admin_activity
		$table			 = $this->_primary_table;
		$arr['menu']	   = $this->_route;
		$arr['name']   	   = $this->session->userdata("name");
		$arr['form']	   = "official";
		$arr['id_object']  = $this->input->post("id_perusahaan");
		$arr['action']     = "admin $arr[name] set official $official for data id_object = $arr[id_object] from table $table ";
			
		//print_r($this->session->all_userdata());
		$this->admin_activity->insert_activity($arr); 
		
		echo "<div class='alert alert-success'> Official for this Agentsea successfully Change </div>";
		echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
		
		
	}
	
	function account_type_process()
	{
		// update account type
			
		$account_type  = $this->input->post("account_type");
		$id_perusahaan = $this->input->post("id_perusahaan"); 
		
		$dt_agentsea = $this->agentsea_model->detail_agentsea($id_perusahaan);
		
		// GLOBAL EMAIL
		$msg = "template_email2016/new_email_template";
		$dt["user_type"] = "agentsea";
		
		$this->agentsea_model->change_account_type();
		
		$this->load->library("my_email");
		// send email , pemberitahuan ke perusahaan bahwa account type nya di ganti 
		$content_email = array("email_to"=>$dt_agentsea["email"],'name' => $dt["company_name"],"contact_person"=>$dt['contact_person']);
		$content_template = $this->load->view("email_agentsea/template_2016/change-account-type",$content_email,true);
		
		$content = array(
			
			"subject" 		=> "Informasea Agentsea Account",
			"subject_title"  => WEBSITE,
			"to" 			 => "alhusna901@gmail.com",//$dt_agentsea['email'], 
			"data" 		   => $data,
			
			/* "message" 		=> "seatizen/email/email-activation-seatizen",
			"mv" 			 => TRUE,
			"alt_message" 	=> "seatizen/email/email-activation-seatizen-alt",
			"amv" 		    => TRUE */
			
			"message" 		=> $msg,
			"mv" 			 => TRUE,
			"alt_message" 	=> "email_agentsea/template_2016/change-account-type-alt",
			"amv" 		    => FALSE
		
		);
		//$user = "info";
		$this->my_email->send_email($user,$content);
		
		// insert admin activity
		// untuk keperluan admin_activity
		$table			 = $this->_primary_table;
		$arr['menu']	   = $this->_route;
		$arr['name']   	   = $this->session->userdata("name");
		$arr['form']	   = "account_type";
		$arr['id_object']  = $this->input->post("id_perusahaan");
		$arr['action']     = "admin $arr[name] set account_type $account_type for data id_object = $arr[id_object] from table $table ";
			
		//print_r($this->session->all_userdata());
		$this->admin_activity->insert_activity($arr);
		
	
		echo "<div class='alert alert-success'> Account Type for this Agentsea successfully Change </div>";
		echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
		
		
	}
	
	function edit_agentsea_process()
	{
		
		$this->load->helper("email");
		/*
			Array
			(
				[id_perusahaan] => 47
				[username] => primetech
				[nama_perusahaan] => PT. Primetech Multinovative
				[nationality] => 99
				[contact_person] => 
				[website_perusahaan] => 
				[no_telp] => 
				[fax] => 
				[email] => radityapratama@informasea.com
				[address] => 
				[visi] => 
				[misi] => 
				[description] => 
			)

		*/
		
		//global email template
		$msg = "template_email2016/new_email_template";
		
		$id_perusahaan	 = $this->input->post("id_perusahaan",TRUE);
		$username 		  = $this->input->post("username",TRUE);
		$nama_perusahaan   = $this->input->post("nama_perusahaan",TRUE);
		$nationality	   = $this->input->post("nationality",TRUE);
		$contact_person	= $this->input->post("contact_person",TRUE);
		$website_perusahaan= $this->input->post("website_perusahaan",TRUE);
		$no_telp		   = $this->input->post("no_telp",TRUE);
		$fax			   = $this->input->post("fax",TRUE);
		$email			 = $this->input->post("email",TRUE);
		$address		   = $this->input->post("address",TRUE);
		$visi			  = $this->input->post("visi",TRUE);
		$misi			  = $this->input->post("misi",TRUE);
		$description	   = $this->input->post("description",TRUE);
		
		$table			 = $this->_primary_table;
	
		$this->load->library("form_validation");
		
		$this->form_validation->set_rules("username","Username","required");
		$this->form_validation->set_rules("nama_perusahaan","Company name","required");
		$this->form_validation->set_rules("email","Email","required|valid_email");
		//$this->form_validation->set_rules("contact_person","Contact person","required");
		
		if($this->form_validation->run() == TRUE)
		{
			$this->db2 = $this->load->database(DB2_GROUP,TRUE);	
			
			$data = array(
			
			  'username' 		=> $username,
			  'nationality' 	 => $nationality,
			  'contact_person'  => $contact_person,
			  'website' 		 => $website,
			  'no_telp' 		 => $no_telp,
			  'fax' 			 => $fax,
			  'email' 		   => $email,
			  'visi' 			=> $visi,
			  'address' 		 => $address,
			  'misi' 			=> $misi,
			  'description' 	 => $description,
			  'nama_perusahaan' => $nama_perusahaan,
			  "activation"	  => $activation
			
			);

			$a = $this->db2->update('perusahaan',$data,array('id_perusahaan' => $id_perusahaan));
			
			$response["notification"] = "Update Agentsea Success";
			$alert_type   = "alert-success";
			
			// untuk keperluan admin_activity
			$arr['menu']	   = $this->_route;
			$arr['name']   	   = $this->session->userdata("name");
			$arr['form']	   = "edit_agentsea";
			$arr['id_object']  = $this->input->post("id_perusahaan");
			
			$arr['action'] = "admin $arr[name] edit definition for data id_object = $arr[id_object] from table $table ";
			$this->admin_activity->insert_activity($arr);
			
		}
		else
		{	
			$response["notification"] = validation_errors();
			$alert_type   = "alert-danger";
		}
		
		//echo "<div class='alert alert-success'> Data Agentsea successfully Edited </div>";
		echo "<div class='alert $alert_type'> $response[notification] </div>";
		/* echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";*/
			
	}

	function proses_edit_agentsea(){
		
		$this->db2 = $this->load->database(DB2_GROUP,TRUE);	

		$username = $this->input->post('username');
		$nationality = $this->input->post('nationality');
		$contact_person = $this->input->post('contact_person');
		$website = $this->input->post('website');
		$no_telp = $this->input->post('no_telp');
		$fax = $this->input->post('fax');
		$email = $this->input->post('email');
		$visi = $this->input->post('visi');
		$address = $this->input->post('address');
		$misi = $this->input->post('misi');
		$description = $this->input->post('description');
		$nama_perusahaan = $this->input->post('nama_perusahaan');

		$id_perusahaan = $this->input->post('id_perusahaan');

		$data = array(
			'username' => $username,
			'nationality' => $nationality,
			'contact_person' => $contact_person,
			'website' => $website,
			'no_telp' => $no_telp,
			'fax' => $fax,
			'email' => $email,
			'visi' => $visi,
			'address' => $address,
			'misi' => $misi,
			'description' => $description,
			'nama_perusahaan' => $nama_perusahaan);

		$a = $this->db2->update('perusahaan',$data,array('id_perusahaan' => $id_perusahaan));
		if($a){
			echo "<div class='alert alert-success'> Success Edited </div>";
			echo "<script>setTimeout(function(){location.reload();
			},2000);</script>";


		$arr['menu']	   = $this->_route;
		$arr['name']       = $this->session->userdata("name");
		$arr['form']       = "edit_agentsea";
		$arr['id_object']  = $this->input->post("id_perusahaan");
		$table			 = $this->_primary_table;
		
		$arr['action'] = "admin $arr[name] edit definition for data id_object = $arr[id_object] from table $table ";
			$this->admin_activity->insert_activity($arr);

		}else{
			echo "<div class='alert alert-danger'> gagal </div>";
		}
	}

	
	function ajax_manager()
	{
		$id_perusahaan = $this->input->post("id_perusahaan");
		
		$list_manager = $this->agentsea_model->list_manager($id_perusahaan); 	
		
		//echo "test";
		echo json_encode($list_manager);
	}
	
	function edit_role_process()
	{
		$id_perusahaan = $this->input->post("id_perusahaan"); // id_perusahaan saat di table perusahaan
		$manager 	   = $this->input->post("manager"); // dinyatakan bahwa sebenernya dia agent dari manager tersebut 
		
		$role = $this->input->post("role");
		
		// untuk keperluan admin_activity
		$arr['menu']	   = $this->_route;
		$arr['name']       = $this->session->userdata("name");
		$arr['form']       = "role";
		$arr['id_object']  = $this->input->post("id_perusahaan");
		$table			 = $this->_primary_table;
		
		if($role == "manager")
		{   
			// jika manager tetap di table agentsea 
			//NOTHING TO DO 
			
			// insert admin_activity 
			$arr['action'] = "admin $arr[name] set role = $role for data id_object = $arr[id_object] from table $table ";
			$this->admin_activity->insert_activity($arr);
			
			echo "<div class='alert alert-success'> Change Role successfully Edited </div>";
			echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
			
		}	
		else if($role == "agent")
		{
			// jika agent maka pindahkan datanya ke table agent 
			
			// ambil data 
			$dt_perusahaan  = $this->agentsea_model->detail_agentsea($id_perusahaan);
			
			// insert ke table agent 
			$arrp['nama']    	   = $dt_perusahaan["contact_person"];
			$arrp['username'] 	   = $dt_perusahaan["username"];
			$arrp["no_telp"]	    = $dt_perusahaan["no_telp"];
			$arrp["email"]	   	  = $dt_perusahaan["email"];
			$arrp["password"]	   = $dt_perusahaan["password"];
			$arrp["nationality"] 	= $dt_perusahaan["nationality"];
			$arrp["id_nationality"] = $dt_perusahaan["id_nationality"];
			$arrp["id_perusahaan"]  = $manager; // masukkan disini 
			$arrp["alamat"]		 = $dt_perusahaan["address"];
			
			$this->agentsea_model->insert_agent($arrp);
			
			// hapus data 
			$this->agentsea_model->delete_agentsea($id_perusahaan);
			
			// insert admin_activity// insert admin_activity 
			$arr['action'] = "admin $arr[name] set role = $role for data id_object = $arr[id_object] from table $table ";
			$this->admin_activity->insert_activity($arr);
			
			echo "<div class='alert alert-success'> Change Role successfully Edited </div>";
			echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
		
		}
	}


}

/* End of file admin.php */
/* Location: ./application/controllers/web/admin.php */