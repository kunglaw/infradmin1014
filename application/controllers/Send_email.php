<?php 

class Send_email extends CI_Controller{
	
	private $_primary_table 	  = "admin_send_email";
	
    private $_notification_table = "admin_message";

    private $_menu = MENU_SEND_EMAIL;

    private $_route = "send_email";
    private $_view_folder = "send_email";
	
	private $db2 ;
	//private $db;
	
	function __construct()
	{
		parent::__construct();
		check_auth();
        check_privileges($this->_menu);
        
		$this->db2 = $this->load->database(DB2_GROUP,TRUE);
		$this->load->model("send_email_model","sem");
		$this->load->model("seatizen_model","sm");
		$this->load->model("vessel_model","vm");
	}


		 /**
     * Show list page.
     */
    public function list_item() {
		
        set_page_title("Email Management");
        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] 			 = base_url();
        $data["controller_name"]	  = $this->_route;
        $data["view_folder"] 		  = $this->_view_folder;
        // $data["dt_list_source"] 	  = $data["base_url"] . $data["controller_name"] ."/list";
        $data["table_name"] 		   = $this->_primary_table;
        $data["need_image_tools"] 	 = false;
		
		if($_GET["tab"] == "send_email")
		{
			$data['list_email']           = $this->sem->get_email();
			$data["inc_active"]		   = "";
			$data["se_active"]			= "active";
		}
		else
		{
			$data["list_email"]		   = $this->sem->get_email_agentsea();
			$data["inc_active"]		   = "active";
			$data["se_active"]			= "";
		}

        $this->load->view($data["view_folder"] ."/list_item", $data);
    }
		
	function item_detail()
	{
		
	}
	
	function delete_few_email_agentsea()
	{
		//print_r($_POST);
		$email = $this->input->post("id");
		
		foreach($email as $row)
		{
			$str = "DELETE FROM admin_send_email_agentsea WHERE id = '$row'";
			$q = $this->db->query($str);	
		}
		
		echo "Email Successfully Delete";
	}
	
	function delete_few_email()
	{
		//print_r($_POST);
		$email = $this->input->post("id");
		
		foreach($email as $row)
		{
			$str = "DELETE FROM admin_send_email WHERE id = '$row'";
			$q = $this->db->query($str);	
		}
		
		echo "Email Successfully Delete";
	}
	
	function preview_email() // detail preview email di database table 
	{
		
		error_reporting(E_ALL);
		$id = $this->uri->segment(3);
		
		set_page_title("Email Management");
        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] 			 = base_url();
        $data["controller_name"]	  = $this->_route;
        $data["view_folder"] 		  = $this->_view_folder;
        // $data["dt_list_source"] 	  = $data["base_url"] . $data["controller_name"] ."/list";
        $data["table_name"] 		   = $this->_primary_table;
		
		$dt = $this->sem->get_email_detail($id);
		
		$ca = $this->sem->list_agentsea();
		$cs = $this->sem->list_seatizen();
		$cv = $this->sem->list_vacantsea();
		
		if($dt_email['template'] == "")
		{
			// dibagi berdasarkan type email 
			
			$type 	= $dt['type_email'];
			$name 	= $dt['name'];
			$email   = $dt['email_to'];
			$message = $dt['content'];
			
			if($type == "vacantsea_list" && !empty($cv) )
			{
				// data // template 
				$msg      = "template_email2016/new_email_template"; 
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-vacantsea-list",$aaa,true);

				if(!empty($message))
				{
					$list_template = $this->load->view("send_email/email/template_2016/list-template-vacantsea",$aaa,true);
					
					$button = ""; // button bisa disetting kalo mau 
					$content_email = array("list_template"=>$list_template,"button"=>$button,"content"=>$message,
					
					"email_to"=>$email,"is_info"=>$is_info);
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					$msg      = "template_email2016/new_email_template"; 
				}
				
				$check_result = TRUE;
				
			}
			else if($type == "seatizen_list" && !empty($cs))
			{
				// data 
				$dt_email = array("department"=>$department,"rank"=>$rank,"email_to"=>$email,"is_info"=>$is_info,
				"content_template"=>$this->load->view("send_email/email/template_2016/email-seatizen-list",$aaa,true));
				//$msg      = "send_email/email/email-seatizen-list"; 
				$msg 		= "template_email2016/new_email_template";
				//$msg 		= "send_email/template_2016/email-seatizen-list";
				// template 
				
				if(!empty($message))
				{
					$aaa["department"] = $department;
					$aaa["rank"]       = $rank;
					
					$list_template = $this->load->view("send_email/email/template_2016/list-template-seatizen",$aaa,true);
					
					$button = ""; // button bisa disetting kalo mau 
					$content_email = array("list_template"=>$list_template,
					
					"button"=>$button,"content"=>$message,"email_to"=>$email,
					"is_info"=>$is_info,"department"=>$department,"rank"=>$rank);
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					// lama
					//$msg 		= "send_email/email/email-universal-content";	
					//$alt_msg	= "send_email/email/email-universal-content-alt";
					$msg = "template_email2016/new_email_template";	
				}
				
				$check_result = TRUE;
			}
			else if($type == "view_resume")
			{
				// data 
				// $dt_email 			= array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info); //membutuhkan str_url
				$dt_email["str_url"] = infr_url("users/login/seaman"); // redirect ke login untuk masuk ke resume
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-view-resume",$aaa,true);
				
				//$msg      = "send_email/email/email-view-resume";
				// $msg 		= "send_email/email/template_2016";
					$msg		= "template_email2016/new_email_template";

				// template 
				
				if(!empty($message))
				{
					$content_email = array("list_template"=>$list_template, "content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
					
					$content_email["is_first_button"] = TRUE;
					$content_email["first_str_url"]   = infr_url("users/login/seaman"); // redirect ke login untuk masuk ke resume // link demo;
					$content_email["first_title_btn"] = "View Resume";
					
					$content_email["is_second_button"] = FALSE;
					$contentnya = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					$dt_email['content_template'] = $contentnya;
					//$msg  	= "send_email/email/email-universal-content";
					$msg		= "template_email2016/new_email_template";
					$alt_msg	= "send_email/email/email-universal-content-alt";	
				}
				
				$check_result = TRUE;
			}
			else if($type == "agentsea_list" && !empty($ca))
			{
				// data 
				// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-agentsea-list",$aaa,true);
				$msg      = "template_email2016/new_email_template";
				// template 
				
				if(!empty($message))
				{
					$list_template = $this->load->view("send_email/email/template_2016/list-template-agentsea",$aaa,true);
					$button = ""; // button bisa disetting kalo mau 
					$content_email = array("list_template"=>$list_template,"button"=>$button,"content"=>$message,
					
					"email_to"=>$email,"is_info"=>$is_info);
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					$msg 		= "template_email2016/new_email_template";
					$alt_msg	= "send_email/email/email-universal-content-alt";
						
				}
				
				$check_result = TRUE;
			}
			else if($type == "contract_offer")
			{
				// data 
				// echo "saya di sini";
				// $this->load->library("form_validation");
					$this->form_validation->set_rules("comp_name","Name","required");
					$this->form_validation->set_rules("comp_telp","Telp","required");
					$this->form_validation->set_rules("comp_address","Address","required");
					$this->form_validation->set_rules("title_pic","Title","required");
					if($this->form_validation->run())
					{
						$company_name = $this->input->post('comp_name');
						$company_address = $this->input->post('comp_address');
						$company_telp = $this->input->post('comp_telp');
						$title_pic = $this->input->post('title_pic');
						
						$conten_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info,"company_name" => $company_name, 
						"company_address" => $company_address, "company_telp" => $company_telp, "title_pic" => $title_pic
						
						);

						$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-contract-offer",$conten_email,true);
						$msg      = "template_email2016/new_email_template";
						
						$check_result = TRUE;
					}
					else{
						$err = validation_errors();
						$response["val"] 	   = "error";
			            $response["error"] = "<div class='alert alert-danger' role='alert' style='padding:20px;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> $err $err_email </div> ";

			            echo json_encode($response); exit;
					}
				
			}
			else if($type == "view_dashboard")
			{
				$this->load->model("agentsea_model");
				/* $code_invitation = random_string();
				$arr["company_name"] 	= $company_name;
				$arr["contact_person"]  = $name;
				$arr["email"]		   = $email_to;
				$arr["email_content"]   = $message;
				$arr["code_invitation"] = $code_invitation;
				$this->agentsea_model->send_email_add($arr);*/
				
				// data 
				// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
				$dt_email["str_url"] = "http://agent.informasea.com/user/login"; // redirect ke login untuk masuk ke resume
				//$dt_email['str_reg'] = infr_url("users/register/agentsea");
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-view-dashboard",$aaa,true);
				$msg      = "template_email2016/new_email_template"; 
				// template 
				
				if(!empty($message))
				{
					//$list_template = $this->load->view("list-template-vacantsea",true);
					
					$content_email = array("list_template"=>$list_template,"content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
					
					$content_email["is_first_button"] = TRUE;
					$content_email["first_str_url"]   = "http://agent.informasea.com/user/login"; // link demo;
					$content_email["first_title_btn"] = "View Dashboard"; 
					$dt_email["content_template"]= $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					/* $dt_email["is_second_button"] = TRUE;
					$dt_email["second_str_url"]   = infr_url("users/register/agentsea"); // link registrasi agentsea;
					$dt_email["second_title_btn"] = "Free Trial"; */
					
					$msg 	= "template_email2016/new_email_template";
					$alt_msg= "send_email/email/email-universal-content-alt";	
				}
				
				$check_result = TRUE;
				
			}
			else if($type == "demo")
			{
				// TIDAK BISA CLICK DARI SINI 
				/* $this->load->model("agentsea_model");
				$code_invitation = random_string();
				$arr["company_name"] 	= $company_name;
				$arr["contact_person"]  = $name;
				$arr["email"]		   = $email_to;
				$arr["email_content"]   = $message;
				$arr["code_invitation"] = $code_invitation;
				$this->agentsea_model->send_email_add($arr);*/
				
				// data 
				// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
				// http://dashboard.informasea.com/user/login_demo?t=$code_invitation
				$dt_email["str_url"] = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // redirect ke login untuk masuk ke resume			
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/demo-dashboard",$aaa,true);
				//$dt_email['str_reg'] = infr_url("users/register/agentsea");
				$msg      = "template_email2016/new_email_template"; 
				// template 
				
				if(!empty($message))
				{
					//$list_template = $this->load->view("list-template-vacantsea",true);
					
					// $dt_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
					
					$dt_email["is_first_button"] = TRUE;
					$dt_email["first_str_url"]   = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo;
					$dt_email["first_title_btn"] = "Demo"; 
					$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-universal-content",$aaa,true);
					
					/* $dt_email["is_second_button"] = TRUE;
					$dt_email["second_str_url"]   = infr_url("users/register/agentsea"); // link registrasi agentsea;
					$dt_email["second_title_btn"] = "Free Trial"; */
					
					$msg 	= "template_email2016/new_email_template";
					$alt_msg= "send_email/email/email-universal-content-alt";	
				}
				
				$check_result = TRUE;
			}
			else
			{
				// $dt_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
				$aaa['content'] = $message;
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-universal-content",$aaa,true);	
				$msg 		= "template_email2016/new_email_template";
				$alt_msg	= "send_email/email/email-universal-content-alt";
				
				$check_result = TRUE;	
			}
			// echo "<pre>";
			// print_r($dt_email);
			// echo "</pre>";
			// exit;
			$data["dt"]	   = $dt;
			
			$dt["content"] = $msg;
			$new_template = $this->load->view($msg,$dt_email,true);
			
			// untuk sementara di 
			//$data['template_email'] = $this->load->view($msg,$dt_email,true);
			$data['template_email'] = $new_template;
			
			$this->load->view("send_email/item_detail",$data);
		}
		else
		{
			$data["dt"]	   = $dt;
			$data["template_email"] = $dt_email["template"];
			$this->load->view("send_email/item_detail",$data);	
		}
		
		
	}
	
	function delete_modal()
	{
		$id = $this->input->post("id");

		$data["dt"] = $this->sem->get_email_detail($id);
		
		$this->load->view("send_email/modal-delete-email",$data);	
	}
	
	function delete_modal_agentsea()
	{
		
		$this->load->model("agentsea_model",agentsea);
		
		$id = $this->input->post("id");
		
		$data["dt"] = $this->agentsea->detail_email_agentsea($id);
		
		$this->load->view("send_email/modal-delete-email-agentsea",$data);	
	}
	
	function delete_process()
	{
		$id = $this->input->post("id");
		$this->sem->delete_email($id);	
	}
	
	function delete_email_agentsea_process()
	{
		$this->load->model("agentsea_model");
		
		$id = $this->input->post("id");
		$this->agentsea_model->delete_email_agentsea($id); 	
	}
	
	function test_preview()
	{
		
		//$dt_email 			= array("name"=>$name); //membutuhkan str_url
		$dt_email["name"]     = "Hatabomba";
		$dt_email["email_to"] = "hatabomba@gmail.com";
		$dt_email["config"]   = $this->config->item("info");
		
		
		// $dt_email["str_url"] = infr_url("users/login/seaman"); // redirect ke login untuk masuk ke resume
		$dt_email["str_url"] = "http://dashboard.informasea.com/user/login_demo?t=0d0df4";
		$dt_email["str_reg"] = infr_url("users/register/agentsea");
		
		//$this->load->view("send_email/email/email-agentsea-list",$dt_email); //done
		//$this->load->view("send_email/email/email-seatizen-list",$dt_email);	 // done 
	    //$this->load->view("send_email/email/email-vacantsea-list",$dt_email); //done 
		//$this->load->view("send_email/email/email-view-resume",$dt_email); // done
		//$this->load->view("send_email/email/email-view-dashboard",$dt_email);
		
		// vacantsea 
		// $list_template = $this->load->view("send_email/email/list-template-vacantsea",$aaa,true); (done ) 
		// $list_template = $this->load->view("send_email/email/list-template-agentsea",$aaa,true); (done)
		//$list_template = $this->load->view("send_email/email/list-template-seatizen",$aaa,true); (done)
		
		
		$dt_email["list_template"] 	= $list_template;
		
		$dt_email["content"]	   	  = "<h2>Performed suspicion in certainty so frankness by attention pretended</h2>

<p>Sitting mistake towards his few country ask. You delighted two rapturous six depending objection happiness something the. Off nay impossible dispatched partiality unaffected. Norland adapted put ham cordial. Ladies talked may shy basket narrow see. Him she distrusts questions sportsmen. Tolerably pretended neglected on my earnestly by. Sex scale sir style truth ought.</p>

<p>Way nor furnished sir procuring therefore but. Warmth far manner myself active are cannot called. Set her half end girl rich met. Me allowance departure an curiosity ye. In no talking address excited it conduct. Husbands debating replying overcame blessing he it me to domestic.</p>

<p>Warmly little before cousin sussex entire men set. Blessing it ladyship on sensible judgment settling outweigh. Worse linen an of civil jokes leave offer. Parties all clothes removal cheered calling prudent her. And residence for met the estimable disposing. Mean if he they been no hold mr. Is at much do made took held help. Latter person am secure of estate genius at.</p>";

		//$dt_email['is_first_button']  = FALSE;
		//$dt_email['is_second_button'] = FALSE;
		
		$dt_email["is_first_button"] = TRUE;
		$dt_email["first_str_url"]   = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo;
		$dt_email["first_title_btn"] = "Demo"; 
		
		$dt_email["is_second_button"] = TRUE;
		$dt_email["second_str_url"]   = infr_url("users/register/agentsea"); // link registrasi agentsea;
		$dt_email["second_title_btn"] = "Free Trial";
		
		$msg = "send_email/email/email-universal-content";	
		
		$a = $this->sem->list_agentsea();
		$s = $this->sem->list_seatizen();
		$v = $this->sem->list_vacantsea();
		
		var_dump($v);   
		
		//$this->load->view($msg,$dt_email);
		
		
	}
	
	function form_send_email()
	{
		// form send email
		// error_reporting(E_ALL);
		
		$data['department'] 	= $this->sm->call_department();
		$data['rank'] 	      = $this->sm->get_rank();
		$data["vessel"]		= $this->vm->get_ship_type();
		
		$this->load->view("send_email/send_email_form",$data);	
		
	}
	
	function form_edit_email()
	{
		// form send email
		$this->load->view("send_email/send_email_edit_form");	
		
	}
	// preview sebelum kirim email
	function preview_type()
	{
		// detail email 
		
		
		// error_reporting(E_ALL);
		$name 			= $this->input->post("name",true);
		$email		   = $this->input->post("email",true);
		$subject 		 = $this->input->post("subject",true);
		$type			= $this->input->post("type",true);
		
		$message		 = $this->input->post("message",true);
		$is_info		 = $this->input->post("is_info",true);
		$img_content 	= $_FILES["browse_img"];
		
		$department 	  = $this->input->post("department",true);
		$rank 			= $this->input->post("rank",true);
		$vessel_type	 = $this->input->post("vessel_type",true);
	
		$file_img = null;
		
		if(isset($img_content)){
			
			$this->load->helper("upload_file");
			$q = "select id from admin_send_email order by id desc limit 1";
			$exec = $this->db->query($q);
			$hasil = $exec->row_array();
			$id_terakhir = $hasil['id'];
			$id_terakhir+=1;
			$img_content['name'] = "img_compose_email_$id_terakhir.".strtolower(end(explode('.', $img_content['name'])));
			$upload_file = upload_file_email($img_content);
			$file_img = $upload_file['data']['file_name'];
			
		}
		// $dt['success'] = print_r($upload_file)." -> $img_content[name]";
		// 		$dt['val']	 = "success";
		// echo json_encode($dt); exit;
		// print_r($img_content); exit;
		//echo print_r($_POST); exit;
		$ca = $this->sem->list_agentsea();
		$cs = $this->sem->list_seatizen();
		$cv = $this->sem->list_vacantsea();
		$check_result = FALSE;
		
		$this->form_validation->set_rules("name","Name","required");
		$this->form_validation->set_rules("subject","Subject","required");
		$this->form_validation->set_rules("email","Email","valid_email|required");
		
		if($type == "seatizen_list")
		{
			//$this->form_validation->set_rules("department","Department","required");
			//$this->form_validation->set_rules("rank","Rank","required");
			//$this->form_validation->set_rules("type","Type","");
		}
		

		if(empty($type))
		{
			$this->form_validation->set_rules("message","Content","required");	
		}
		
		if($this->form_validation->run() == TRUE)
		{
			 
			$dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
			$dt_email["file_img"] = $file_img;
			$aaa['name'] = $name;
			$aaa["file_img"] = $file_img;
			$content_email["name"] = $name;
			$content_email["file_img"] = $file_img;
			
			$msg      = "template_email2016/new_email_template"; //GLOBAL
			
			if($type == "vacantsea_list" && !empty($cv) ) //user_type = seatizen
			{
				
				$aaa["user_type"] = "seatizen";
				
				// data 
				
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-vacantsea-list", $aaa,true);
				
				// template 
				
				if(!empty($message))
				{
					$aaa["content"] = $message;
					$list_template = $this->load->view("send_email/email/template_2016/list-template-vacantsea",$aaa,true);
					
					$button = ""; // button bisa disetting kalo mau 
					
					$content_email = array("list_template"=>$list_template,"button"=>$button,"content"=>$message,
					"email_to"=>$email,"is_info"=>$is_info);
					
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content", $content_email, true);
					
				}
				
				$check_result = TRUE;
				
			}
			else if($type == "seatizen_list" && !empty($cs)) //user_type = seatizen
			{
				// data 
				$aaa["department"] = $department;
				$aaa["rank"]       = $rank;
				$aaa["vessel_type"]= $vessel_type;
				$aaa["user_type"]  = "seatizen";
				
				$content_email = array("department"=>$department,"name" => $name,"rank"=>$rank,"email_to"=>$email,"is_info"=>$is_info,
				"user_type"=>"seatizen");
				
				$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-seatizen-list",$content_email,true); 
				
				if(!empty($message))
				{
					// $aaa["department"] = $department;
					// $aaa["rank"]       = $rank;
					
					$list_template = $this->load->view("send_email/email/template_2016/list-template-seatizen",$aaa,true);
					
					$button = ""; // button bisa disetting kalo mau 
					$content_email = array("list_template"=>$list_template,"name" => $name,
					"button"=>$button,"content"=>$message,"email_to"=>$email,
					"is_info"=>$is_info,"department"=>$department,"rank"=>$rank,"user_type"=>"seatizen");
					
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					// lama
					
				}
				
				$check_result = TRUE;
			}
			else if($type == "view_resume") //user_type = seatizen
			{
				$aaa["user_type"] = "seatizen";
				// data 
				// $dt_email 			= array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info); //membutuhkan str_url
				$dt_email["str_url"] = infr_url("users/login/seaman"); // redirect ke login untuk masuk ke resume
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-view-resume", $aaa, true);
				
				// template 
				
				if(!empty($message))
				{
					//$list_template = $this->load->view("list-template-vacantsea",true);
					$content_email = array("list_template"=>$list_template,
					
					"content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
					
					$content_email["is_first_button"] = TRUE;
					$content_email["first_str_url"]   = infr_url("users/login/seaman"); // redirect ke login untuk masuk ke resume // link demo;
					$content_email["first_title_btn"] = "View Resume";
					
					$content_email["is_second_button"] = FALSE;
					$content_email["user_type"]	   = "seatizen";
					
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					//$msg  	= "send_email/email/email-universal-content";
					
					
				}
				
				$check_result = TRUE;
			}
			else if($type == "agentsea_list" && !empty($ca)) //user_type = seatizen
			{
				// data 
				// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
				$content_email['name'] = $name;
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-agentsea-list", $content_email, true);
				
				// template 
				
				if(!empty($message))
				{
					$list_template = $this->load->view("send_email/email/template_2016/list-template-agentsea",$aaa,true);
					
					$button = ""; // button bisa disetting kalo mau 
					$content_email = array("list_template"=>$list_template,"button"=>$button,"content"=>$message,
					
					"email_to"=>$email,"is_info"=>$is_info);
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
						
				}
				
				$check_result = TRUE;
			}
			else if($type == "contract_offer")
			{
				
				
				
			
					$this->form_validation->set_rules("comp_name","Name","required");
					$this->form_validation->set_rules("comp_telp","Telp","required");
					$this->form_validation->set_rules("comp_address","Address","required");
					$this->form_validation->set_rules("title_pic","Title","required");
					if($this->form_validation->run())
					{
						$company_name = $this->input->post('comp_name');
						$company_address = $this->input->post('comp_address');
						$company_telp = $this->input->post('comp_telp');
						$title_pic = $this->input->post('title_pic');
						
						$content_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info,"company_name" => $company_name, "content" => $message,
						"company_address" => $company_address, "company_telp" => $company_telp, "title_pic" => $title_pic
						);
						
						$content_email["user_type"] = "agentsea";
						
						$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-contract-offer",$content_email,true);
						
						
						$check_result = TRUE;
					}
					else{
						$err = validation_errors();
						$response["val"] 	   = "error";
			            $response["error"] = "<div class='alert alert-danger' role='alert' style='padding:20px;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> $err $err_email </div> ";

			            echo json_encode($response); exit;
					}
				
			}
			else if($type == "view_dashboard")
			{
				$content_email["user_type"] = "agentsea";
				$content_email["name"]	  = $name;
				
				$this->load->model("agentsea_model");
				/* $code_invitation = random_string();
				$arr["company_name"] 	= $company_name;
				$arr["contact_person"]  = $name;
				$arr["email"]		   = $email_to;
				$arr["email_content"]   = $message;
				$arr["code_invitation"] = $code_invitation;
				$this->agentsea_model->send_email_add($arr);*/
				
				// data 
				// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
				$dt_email["str_url"] = "http://agent.informasea.com/user/login"; // redirect ke login untuk masuk ke resume
				//$dt_email['str_reg'] = infr_url("users/register/agentsea");
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-view-dashboard",$content_email, true);
				
				// template 
				
				if(!empty($message))
				{
					//$list_template = $this->load->view("list-template-vacantsea",true);
					
					$content_email = array("list_template"=>$list_template,"content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
					
					$content_email["is_first_button"] = TRUE;
					$content_email["first_str_url"]   = "http://agent.informasea.com/user/login"; // link demo;
					$content_email["first_title_btn"] = "View Dashboard"; 
					$dt_email['content_template'] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					/* $dt_email["is_second_button"] = TRUE;
					$dt_email["second_str_url"]   = infr_url("users/register/agentsea"); // link registrasi agentsea;
					$dt_email["second_title_btn"] = "Free Trial"; */
					
				}
				
				$check_result = TRUE;
				
			}
			else if($type == "demo")
			{
				$content_email["user_type"] = "agentsea";
				$content_email["name"]	  = $name;
				
				// TIDAK BISA CLICK DARI SINI 
				/* $this->load->model("agentsea_model");
				$code_invitation = random_string();
				$arr["company_name"] 	= $company_name;
				$arr["contact_person"]  = $name;
				$arr["email"]		   = $email_to;
				$arr["email_content"]   = $message;
				$arr["code_invitation"] = $code_invitation;
				$this->agentsea_model->send_email_add($arr);*/
				
				// data 
				// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
				// http://dashboard.informasea.com/user/login_demo?t=$code_invitation
				$dt_email["str_url"] = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // redirect ke login untuk masuk ke resume			
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/demo-dashboard",$content_email, true);
				//$dt_email['str_reg'] = infr_url("users/register/agentsea");
				// template 
				
				if(!empty($message))
				{
					//$list_template = $this->load->view("list-template-vacantsea",true);
					
					// $dt_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
					$content_email["content"]		 = $message;
					$content_email["is_first_button"] = TRUE;
					$content_email["first_str_url"]   = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo;
					$content_email["first_title_btn"] = "Demo"; 
					$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);
					
					/* $dt_email["is_second_button"] = TRUE;
					$dt_email["second_str_url"]   = infr_url("users/register/agentsea"); // link registrasi agentsea;
					$dt_email["second_title_btn"] = "Free Trial"; */
					
				}
				
				$check_result = TRUE;
				
			}
			else if(empty($type))
			{
				// $dt_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info);
				// echo "saya doi ";
				$content_email['content'] = $message;
				$dt_email["content_template"] = $this->load->view("send_email/email/template_2016/email-universal-content",$content_email,true);	
				
				$check_result = TRUE;	
			}

			
			
			if($check_result == TRUE)
			{
				$dt['success'] = $this->load->view($msg,$dt_email,true);
				$dt['val']	 = "success";
			}
			else
			{
				$dt['error'] =  "<div class='alert alert-danger' > Your data is empty </div>";
				$dt["val"]   = "error";	
			}
			
		}
		else
		{
			$dt['error'] =  "<div class='alert alert-danger' >".validation_errors()."</div>";
		 	$dt["val"]   = "error";
		}
	
		
		echo json_encode($dt);
	}
	
	function send_process()
	{
		// ({email:"", name:"", subject:"", type:"view_dashboard", email_content:"", message:""})
		
		$this->load->library("form_validation");
		
		$name 			= $this->input->post("name",true);
		$email		   = $this->input->post("email",true);
		$email_from	  = $this->input->post("email_from",true);
		$password_email  = $this->input->post("password_email",true);
		$subject 		 = $this->input->post("subject",true);
		$type			= $this->input->post("type",true);
		$is_info 		 = $this->input->post("is_info",true); // FOOTER setting
		//$email_content   = $this->input->post("email_content",true);
		$message		 = $this->input->post("message",true);
		$attachment	  = $_FILES['attachment'];
		$nama_file_gambar = $this->input->post("file_imgnya");
		
		$department 	  = $this->input->post("department",true);
		$rank 			= $this->input->post("rank",true);
		$vessel_type	 = $this->input->post("vessel_type",true);
		
		$ca = $this->sem->list_agentsea();
		$cs = $this->sem->list_seatizen();
		$cv = $this->sem->list_vacantsea();
		
		$this->form_validation->set_rules("name","Name","required");
		$this->form_validation->set_rules("subject","Subject","required");
		$this->form_validation->set_rules("email","Email","valid_email|required");
		
		if($type == "seatizen_list")
		{
			//$this->form_validation->set_rules("department","Department","required");
			//$this->form_validation->set_rules("rank","Rank","required");
			//$this->form_validation->set_rules("type","Type","");
		}
		
		$path = infrasset_path()."img/email/$nama_file_gambar";
		if(!is_file($path)) $path = null;
		//$this->form_validation->set_rules("type","Type","");
		
		if(empty($type))
		{
			$this->form_validation->set_rules("message","Content","required");	
		}
		
		if($this->form_validation->run() == TRUE)
		{
			$this->load->library("email");
			
			// GLOBAL
			$msg      = "template_email2016/new_email_template";
			$dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
			$aaa["name"] = $name;
			
			$dt_email['user_type'] = "seatizen";
			// set content tambahan email berdasarkan type 
				// vacantsea_list 
				// seatizen_list 
				// view_resume 
				// agentsea_list
				// view dashboard 
				$content_email = "";
				
				// TESTED
				if($type == "vacantsea_list")
				{
					
					$dt_email["user_type"] = "seatizen";
					// data 
					// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
					$content_email = array("name" => $name,"button"=>$button,"content"=>$message,"email_to"=>$email,
					"is_info"=>$is_info,"file_img" => $nama_file_gambar);
					
					$content_email["user_type"] = "seatizen";
					
					$emailnya      = "send_email/email/template_2016/email-vacantsea-list"; 
					// template 
					
					if(!empty($message))
					{
						
						$list_template = $this->load->view("send_email/email/template_2016/list-template-vacantsea",$content_email,true);
						$content_email['list_template'] = $list_template;
						$button = ""; // button bisa disetting kalo mau 
						
						$emailnya = "send_email/email/template_2016/email-universal-content";	
					}
					$dt_email['content_template'] = $this->load->view($emailnya, $content_email, true);
				}
				else if($type == "seatizen_list")
				{
					// data 
					$dt_email["user_type"] = "seatizen";
					
					$content_email = array("department"=>$department,"name" => $name,"rank"=>$rank,"vessel_type"=>$vessel_type,"email_to"=>$email,"is_info"=>$is_info);
					$content_email["user_type"] = "seatizen";
					
					$emailnya      = "send_email/email/template_2016/email-seatizen-list"; 
					
					// template 
					
					if(!empty($message))
					{
						
						
						$aaa["department"] = $department;
						$aaa["rank"]       = $rank;
					
						$list_template = $this->load->view("send_email/email/template_2016/list-template-seatizen",$aaa,true);
						$button = ""; // button bisa disetting kalo mau 
						
						$content_email = array("list_template"=>$list_template,"button"=>$button,"content"=>$message,"email_to"=>$email,
						"department"=>$department,"rank"=>$rank,"name" => $name,
						"is_info"=>$is_info,"file_img" => $nama_file_gambar);
						
						$emailnya 		= "send_email/email/template_2016/email-universal-content";	
						
					}

					$dt_email['content_template'] = $this->load->view($emailnya, $content_email, true);
				}
				else if($type == "contract_offer")
				{
					$dt_email['user_type'] = "agentsea";

					$company_name = $this->input->post('comp_name');
					
					$this->load->library("token");
					$token = $this->token->generate(128);
					$company_name = $this->input->post('comp_name');
					$company_address = $this->input->post('comp_address');
					$company_telp = $this->input->post('comp_telp');
					$title_pic = $this->input->post('title_pic');
					
					$dt = array(
							'nama_perusahaan' 	=> $this->input->post("comp_name", true),
							'alamat_perusahaan'	=> $this->input->post("comp_address", true),
							'telp_perusahaan'	=> $this->input->post("comp_telp", true),
							'pic'				=> $this->input->post("name", true),
							'jabatan_pic'		=> $this->input->post("title_pic", true),
							'content'			=> "<ol><li>informasea.com membantu $company_name dengan cara mem-posting lowongan di informasea.com atas nama $company_name.</li><li>Lowongan yang di-posting di informasea.com hanya lowongan yang telah $company_name buat di gotoseajobs ataupun job portal crewing lainnya.</li><li>informasea.com akan melakukan marketing untuk lowongan tersebut melalui social media yang ada (facebook, twitter, linkedin, g+)</li><li>$company_name dapat memantau applicant yang telah melamar lowongan tersebut dengan mengakses informasea.com ataupun melalui email.</li><li>$company_name dapat langsung melihat CV dan resume pelamar melalui informasea.com dan dapat dengan mudah melakukan validasi sertifikat.</li><li>Penawaran ini tidak dipungut biaya demi meningkatkan kebermanfaatan informasea.com sebagai komunitas pelaut dan job portal</li></ol>",
							'token'				=> $token
					);

					$id_kontrak_baru = $this->sem->insert_data_contract($dt);
					
					$dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>0,"company_name" => $company_name, 
					"id_contract" => $id_kontrak_baru, "token" =>$token);
					
					$check_result = TRUE;
					
				}
				else if($type == "view_resume") //benar
				{
					$dt_email["user_type"] = "seatizen";
					// data 
					// $dt_email 			= array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info); //membutuhkan str_url
					$content_email["str_url"] = infr_url("users/login/seaman"); // redirect ke login untuk masuk ke resume
					$content_email["name"]	= $name;
					$emailnya = "send_email/email/template_2016/email-view-resume";
					// template 
					
					if(!empty($message))
					{
						
						$content_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info,
						"file_img" => $nama_file_gambar);
						
						$content_email["is_first_button"] = TRUE;
						$content_email["first_str_url"]   = infr_url("users/login/seaman"); // redirect ke login untuk masuk ke resume // link demo;
						$content_email["first_title_btn"] = "View Resume";
						
						$content_email["is_second_button"] = FALSE;
						
						$emailnya 		= "send_email/email/template_2016/email-universal-content";	
						
					}
					
					$dt_email['content_template'] = $this->load->view($emailnya, $content_email, true);
				}
				else if($type == "agentsea_list")
				{
					$dt_email["user_type"] = "seatizen";
					$content_email['name'] = $name;
					$emailnya      = "send_email/email/template_2016/email-agentsea-list";
					
					
					if(!empty($message))
					{
						$list_template = $this->load->view("send_email/email/template_2016/list-template-agentsea",$aaa,true);
						$button = ""; // button bisa disetting kalo mau 
						$content_email = array("list_template"=>$list_template,"button"=>$button,"content"=>$message,"email_to"=>$email,
						"is_info"=>$is_info,"file_img" => $nama_file_gambar);
						
						$emailnya 		= "send_email/email/template_2016/email-universal-content";
							
					}

					$dt_email['content_template'] = $this->load->view($emailnya, $content_email, true);
				}
				else if($type == "view_dashboard")
				{
					$dt_email['user_type'] = "agentsea";
					$this->load->model("agentsea_model");
					
					// data 
					$content_email["name"] = $name;
					
					// $dt_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
					$content_email["str_url"] = "http://agent.informasea.com/user/login"; // redirect ke login untuk masuk ke resume
					//$dt_email['str_reg'] = infr_url("users/register/agentsea");
					$emailnya 		= "send_email/email/template_2016/email-view-dashboard"; 
					// template 
					
					if(!empty($message))
					{
						//$list_template = $this->load->view("list-template-vacantsea",true);
						
						$content_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info,
						"file_img" => $nama_file_gambar);
						
						$content_email["is_first_button"] = TRUE;
						$content_email["first_str_url"]   = "http://agent.informasea.com/user/login"; // link demo;
						$content_email["first_title_btn"] = "View Dashboard"; 
						
						/* $dt_email["is_second_button"] = TRUE;
						$dt_email["second_str_url"]   = infr_url("users/register/agentsea"); // link registrasi agentsea;
						$dt_email["second_title_btn"] = "Free Trial"; */
						
						$emailnya 		= "send_email/email/template_2016/email-universal-content";
					}
					
					$dt_email['content_template'] = $this->load->view($emailnya, $content_email, true);
					$check_result = TRUE;
					
				}
				else if($type == "demo")
				{
					$dt_email['user_type'] = "agentsea";
					$content_email["name"] = $name;
					
					$this->load->model("agentsea_model");
					$code_invitation = random_string();
					$arr["company_name"] 	= $company_name;
					$arr["contact_person"]  = $name;
					$arr["email"]		   = $email_to;
					$arr["email_content"]   = $message;
					$arr["code_invitation"] = $code_invitation;
					$this->agentsea_model->send_email_add($arr);
					
					
					$dt_email["str_url"] = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; 
					// redirect ke login untuk masuk ke resume
					
					//$dt_email['str_reg'] = infr_url("users/register/agentsea");
					$emailnya 		= "send_email/email/template_2016/demo-dashboard"; 

					// template 
					
					if(!empty($message))
					{
						//$list_template = $this->load->view("list-template-vacantsea",true);
						
						$content_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info,"file_img" => $nama_file_gambar);
						
						$content_email["is_first_button"] = TRUE;
						$content_email["first_str_url"]   = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo;
						$content_email["first_title_btn"] = "Demo"; 
						
						$emailnya 		= "send_email/email/template_2016/email-universal-content";

					}
					
					$dt_email['content_template'] = $this->load->view($emailnya, $content_email, true);
					$check_result = TRUE;
					
				}
				else if(empty($type))
				{
					$dt_email["user_type"] = "seatizen";
					
					$content_email = array("content"=>$message,"email_to"=>$email,"is_info"=>$is_info, "file_img" => $nama_file_gambar);
					$emailnya 		= "send_email/email/template_2016/email-universal-content";
					$dt_email['content_template'] = $this->load->view($emailnya, $content_email, true);
					
				}
				
			// upload attachment jika ada ke server
			//var_dump($attachment); exit;
			if(!empty($attachment["name"]))
			{
				$this->load->library("upload");
				$this->upload->initialize(array(
					"upload_path"   => infr_img_path("attachment_email"),
					"allowed_types" => "*"
			   ));
		
				//Perform upload.
				$lamp = array();
				if($this->upload->do_upload("attachment"))
				{
					$lamp = $this->upload->data();
					// foreach ($lamp as $key=>$value)
					// {
					// 	$this->email->attach($value['full_path']); //mengambil path dari attachmen yang di uplad
					// }
				}else
				{
					echo $this->upload->display_errors(); 
				}
			}

			// send email
			$this->load->library("my_email"); 
			
			if($password_email != ""){

				$user['smtp_user'] = $email_from;
				$user['smtp_pass'] = $password_email;
			}
			else
			{ 
				$user = "info";
			}
			
			$content = array(
				
				  "subject" 		=> $subject,
				  "subject_title"  => WEBSITE,
				  "to" 			 => $email, 
				  "data" 		   => $dt_email,
				  "attachment"	 => $lamp['full_path'],
				  "message" 		=> $msg, // harus ada template nya 
				  "mv" 			 => TRUE, //model view, jika true
				  "alt_message" 	=> $alt_msg, // harus ada template nya 
				  "amv" 		    => FALSE // untuk sementara ditiadakan
			
			);
			
			$this->my_email->send_email($user,$content);
			
			// simpen di database
			$ip_address = $this->input->ip_address();
			$user_agent = $this->input->user_agent();
			
			$dt['name']  	   = $name;
			$dt['email_to']   = $email;
			$dt['subject']  	= $subject;
			$dt['content']  	= $message;
			$dt['type_email'] = $type;
			$dt["template"]   = $this->load->view($msg,$dt_email,true);
			$dt['ip_address'] = $ip_address;
			$dt['pic']		= $this->session->userdata("name");
			$dt['user_agent'] = $user_agent;
			$dt['is_info']	= $is_info;
			
			$this->sem->insert_data_email($dt);
			
			// add tracker 
			// insert admin activity
			// untuk keperluan admin_activity
			$table			 = $this->_primary_table;
			$arr['menu']	   = $this->_route;
			$arr['name']   	   = $this->session->userdata("name");
			$arr['form']	   = "send_email";
			$arr['id_object']  = "";
			$arr['action']     = "admin $arr[name] send email to $email store at table $table ";
				
			//print_r($this->session->all_userdata());
			$this->admin_activity->insert_activity($arr); 
			
			$response["status"] 	   = "success";
            $response["notification"] = "<div class='alert alert-success' role='alert' style='padding:20px;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> you successfully send an email to $name with $email. </div> ";
			
		}
		else
		{
			// form salah isi 
			// redirect	
			$err = validation_errors();
			$response["status"] 	   = "error";
            $response["notification"] = "<div class='alert alert-danger' role='alert' style='padding:20px;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> $err $err_email </div> ";
			
		}
		
		echo json_encode($response);
	}
	
	// send_email_agentsea 
	function detail_email_agentsea()
	{
		
		set_page_title("Email Management");
        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] 			 = base_url();
        $data["controller_name"]	  = $this->_route;
        $data["view_folder"] 		  = $this->_view_folder;
        // $data["dt_list_source"] 	  = $data["base_url"] . $data["controller_name"] ."/list";
        $data["table_name"] 		   = $this->_primary_table;
		
		$this->load->model("agentsea_model");
		
		$id = $this->uri->segment(3);
		
		$dt = $this->agentsea_model->detail_email_agentsea($id);
		// print_r($dt);
		 $type 		  = $dt["type_email"];
		$email_content  = $dt['content'];
		$contact_person = $dt['contact_person'];
		$company_name   = $dt["company_name"];
		$email 		  = $dt["email"];		
		
		// GLOBAL EMAIL
		$msg      		   = "template_email2016/new_email_template";
		$data["user_type"] = "agentsea";
		
		if($type == 1) // create vacantsea for free 
		{
			
			// kalau content kosong maka ada template nya dari 
			
			$is_reg  = FALSE;
			//$str_url = infr_url("users/create_vacantsea/?t=$code_invitation");
			$content_email = array('is_reg'=>$is_reg,"email_to"=>$email,'company_name' => $company_name,"contact_person"=>$contact_person);
			
			$content_template 	 = $this->load->view("email_agentsea/template_2016/create-vacantsea",$content_email,true);
			//$str_reg = "";
			
			if(!empty($email_content))
			{
				//$str_reg = "";
				//$str_url = "";
				$title_btn = "Create Vacantsea for Free";
				
				
				$content_email    = array('is_reg'=>$is_reg,"email_to"=>$email,"title_btn"=>$title_btn,'content'=>$email_content,"str_url"=>"#"
				,"contact_person"=>$dt["contact_person"]);
				
				$content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
			}
			
			$data["content_template"] = $email_content;
		
		}
		else if($type == 2) // demo dashboard
		{
			
			// kalau content kosong maka ada template nya dari 
			
			$is_reg  = TRUE;
			$content_email = array('is_reg'=>$is_reg,"email_to"=>$email,'company_name' => $company_name,"contact_person"=>$contact_person);
			//$str_url = "http://dashboard.informasea.com/user/login_demo?t=$code_invitation"; // link demo			
			$content_template 	 = $this->load->view("email_agentsea/template_2016/demo-dashboard",$content_email,true);
			
			$str_reg = infr_url("users/register"); // link registrasi agentsea 
			
			if(!empty($email_content))
			{
				//$str_url = ""; // demo 
				//$str_reg = ""; // str register
				$title_btn = "Demo";
				$title_btn_reg = "Free Trial";
				
				$content_email = array('is_reg'=>$is_reg,"email_to"=>$email,'company_name' => $company_name,"contact_person"=>$contact_person,
				"content"=>$dt["content"],"title_btn"=>$title_btn,"title_btn_reg"=>$title_btn_reg,"str_url"=>"#");
				
				$content_template = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);
			}
			
			$data["content_template"] = $email_content;
			
		}
		else if($type == 3) // alpha 
		{
			
			// kalau content kosong maka ada template nya dari 
			
			
			$is_reg  = TRUE;
			$content_email = array('is_reg'=>$is_reg,"email_to"=>$email,'company_name' => $company_name,"contact_person"=>$contact_person);
			//$str_url = "http://devalpha.informasea.com/user/login_demo?t=$code_invitation"; // demo alpha
			
			$content_template = $this->load->view("email_agentsea/template_2016/demo-alpha",$content_email,true);
			$str_reg = "http://alpha.informasea.com/user/register"; // register alpha
			
			if(!empty($email_content))
			{
				//$str_url = ""; // demo 
				//$str_reg = ""; // str register
				$title_btn = "Register";
				$title_btn_reg = "Free Trial";
				
				$data = array('is_reg'=>$is_reg,"email_to"=>$email,'company_name' => $company_name,"contact_person"=>$contact_person,
				"content"=>$dt["content"],"title_btn"=>$title_btn,"title_btn_reg"=>$title_btn_reg,"str_url"=>"#");
				
				$content_template 	 = "email_agentsea/template_2016/new-content-email-template";
			}
			
			$data["content_template"] = $email_content;
			
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

			$data["content_template"] = $email_content;
		}
		else if($type == 5) // Seatizen List
		{

			$title = "Register";
			// kalau content kosong maka ada template nya dari 
			
			//$alt_msg = "email_agentsea/template_2016/demo-alpha-alt"; 
			$is_reg  = TRUE;
			//$str_url = "https://devalpha.informasea.com/user/login_demo?t=$code_invitation"; // demo alpha
			$str_reg = "https://www.informasea.com/users/register"; // register alpha
			
			$content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],"is_info"=>$is_info);
			
			// $content_template 	 = $this->load->view("email_agentsea/template_2016/email-seatizen-list",$content_email,true);
			
			if(!empty($email_content))
			{
			// 	$title_btn     = "Register";
				// $title_btn_reg = "Activate";
				
				$content_email = array('is_reg'=>$is_reg,"email_to"=>$value['email'],'company_name' => $value['company_name'],"contact_person"=>$value['contact_person'],
				"content"=>$email_content,"title_btn"=>$title_btn,/*"title_btn_reg"=>$title_btn_reg,*/"str_reg"=>$str_reg,"is_info"=>$is_info);
				// $content_template  = $this->load->view("email_agentsea/template_2016/new-content-email-template",$content_email,true);

			}

			$data["content_template"] = $email_content;
		}
		else
		{
		  $response['result']	= "Saya tidak ada tipenya<br>";
		  
		  $check_result = TRUE;	
		  $content_email = array("name"=>$name,"email_to"=>$email,"is_info"=>$is_info);
		  
		  $data["content_template"] = $this->load->view("send_email/email/email-universal-content",$content_email,true);
		}
		
		$data["config"] = $this->config->item("info");
		$data["dt"] = $dt;
		
		if(!empty($dt["type_email"]))
		{
			// echo "<pre>";
			// print_r($data);
			// echo "</pre>";

			$dt_final["template_email"] = $this->load->view($msg,$data,true);
		}
		else
		{
			$dt_final["template_email"] = "";	
		}
		
		// print_r($dt_final);
		
		$this->load->view("agentsea/detail-email-agentsea",$dt_final);
		
			
		
	}
	
	
	function __destruct()
	{
		
	}
	
	
}