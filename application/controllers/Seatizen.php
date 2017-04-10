<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Seatizen
 * Handle seatizen operation.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Seatizen extends CI_Controller {

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
    public function __construct() {

        parent::__construct();
        check_auth();
        check_privileges($this->_menu);
        $this->load->model("seatizen_model", "seatizen");
        $this->load->model("department_model","department");
		$this->load->model("rank_model");
        $this->load->model('resume_model');
		
    }

    public function FormBlockSeatizen()
    {
        # code...
        $idnya = $this->input->post("pelaut_id");
        $data['data_seatizen'] = $this->seatizen->get_detailseatizen($idnya);

        $this->load->view("modal/block_seatizen", $data);
    }

    public function block_seatizen()
    {
        # code...
        $id_seatizen = $this->input->post("id_seatizen");
        return $this->seatizen->BlockSeatizen($id_seatizen);
    }
	
	function change_activation()
	{
		$is_ajax = $this->input->is_ajax_request();
		if(!$is_ajax)
		{
			
			show_404();
			exit;
		}
		
		$id_seatizen = $this->input->post("pelaut_id");
		
		$data["seatizen"] = $this->seatizen->get_detailseatizen($id_seatizen);
		
		$this->load->view("seatizen/change-activation",$data);	
	}
	
	function change_activation_process()
	{
		$is_ajax = $this->input->is_ajax_request();
		if(!$is_ajax)
		{
			
			show_404();
			exit;
		}
		
		$pelaut_id = $this->input->post("pelaut_id",TRUE);
		
		$this->seatizen->change_activate($pelaut_id);
		
		// untuk keperluan admin_activity
		$arr['menu']	   = $this->_route;
		$arr['name']   	   = $this->session->userdata("name");
		$arr['form']	   = "form_activate_seaman";
		$arr['id_object']  = $pelaut_id;
		
		$arr['action'] = "admin $arr[name] activated account seaman for data id_object = $arr[id_object] from table $table ";
		$this->admin_activity->insert_activity($arr);
		
		$result["status"]   = "success";
		$result["message"]  = "<div class='alert alert-success'> You successfully Activated this seaman </div>";
		$result["message"] .= "<script> setTimeout(function() { location.reload(); }, 3000); </script>";		
		
		echo json_encode($result);
	}

    /**
     * Show list page.
     */
    public function list_item() {

        set_page_title("Seatizen Management");
		
		$this->load->model("experience_model");
		$this->load->model("vessel_model");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data["base_url"] 			 = base_url();
        $data["controller_name"]	  = $this->_route;
        $data["view_folder"] 		  = $this->_view_folder;
        // $data["dt_list_source"] 	  = $data["base_url"] . $data["controller_name"] ."/list";
        $data['list_seatizen']        = $this->seatizen->get_allseatizen();
        $data["table_name"] 		   = $this->_primary_table;

        $data["need_image_tools"] 	 = false;

        $this->load->view($data["view_folder"] ."/item_list", $data);
    }
	
	function download_excel_template()
	{
		// helper appdata_helper
		download_seatizen_exctmpl();	
		
	}
	
	function form_seatizen_add()
	{
		
		$department			= $this->input->post("department",true);
		$coc_class		 	 = $this->input->post("coc_class",true);
		$rank			  	  = $this->input->post("rank",true);
		
		$data['coc_class'] 	 = $this->seatizen->get_coc_class();
		$data['department'] 	= $this->seatizen->call_department();
		$data['rank'] 	      = $this->seatizen->get_rank();
		
		$this->load->view("seatizen/form_seatizen_add",$data);	
	}
	
	function get_coc_class()
	{
		
		$this->load->model("coc_model");
		
		$id 		   = $this->input->post("department_id");
		$id_coc_class = $this->input->post("id_coc_class"); 
		
		$coc = $this->coc_model->get_coc_bydept($id);
		
		if(!empty($coc))
		{
			  if(empty($id_coc_class)){ $se = 'selected=selected'; }else{ $se = ''; }
			  echo "<option value='' $se  >- Select Coc Class -</option>";
		  foreach($coc as $row)
		  {
			  $scc = "";
			  
			  if($id_coc_class == $row['id_coc_class'])
			  {
				  $scc = "selected='selected'";	
			  }
			  
			  echo "<option value='$row[id_coc_class]' $scc >$row[coc_class]</option>";
		  }
		}
		else
		{
			echo "<option value='0' > none </option>";
			
		}
	}

    function edit_kepelautan_process()
    {
        if($this->input->is_ajax_request()){
			
            return $this->resume_model->kepelautan_edit_process();  

        } else{
            header('location:'.base_url('custom404'));
        }
    }
	
	function get_rank()
	{
		$this->load->model("rank_model");
		
		$id 	  = $this->input->post("department_id");
		$id_rank = $this->input->post("id_rank"); 
		
		$rank = $this->rank_model->get_rank_bydept($id);

		
		if(!empty($rank))
		{
			  if(empty($id_rank)){ $se = 'selected=selected'; }else{ $se = ''; }
			  echo "<option value='' $se  >- Select Rank -</option>";
		  foreach($rank as $row)
		  {
			  $sr = "";
			  if($row['rank_id'] == $id_rank ){
				$sr = "selected='selected'";  
			  }
			  echo "<option value='$row[rank_id]' $sr >$row[rank]</option>";
		  }
		}
		else
		{
			echo "<option value='0' selected >- Other -</option>";
			
		}
	}
	
	function edit_profile_process()
	{
		
		if($this->input->is_ajax_request()){
		$this->load->model("Profile_resume_model","prm");
		return $this->prm->profile_edit_process();
		
		} else{
			header('location:'.base_url('custom404'));
		}
	}
	
	function seatizen_delete()
	{
		$id_seatizen = $this->input->post("id_seatizen");
		$data["seatizen"] = $this->seatizen->get_detailseatizen($id_seatizen);
		$data["fullname"] = $data["seatizen"]["nama_depan"]." ".$data["seatizen"]["nama_belakang"];
		
		$this->load->view("seatizen/seatizen_delete_modal",$data);
	}
	
	function seatizen_delete_process()
	{
		$this->load->library("form_validation");
		
		$id_seatizen = $this->input->post("id_seatizen",TRUE);
		
		$this->form_validation->set_rules("id_seatizen","id seatizen","required");
		
		if($this->form_validation->run() == TRUE)
		{
			$this->seatizen->delete_full_seatizen($id_seatizen);	
			
			$response["status"]   = "success";
            $response["message"]  = "<div class='alert alert-success' role='alert'> seatizen $first_name $last_name has been deleted. </div> ";
			$response["message"] .= "<script>setTimeout(function(){ location.reload(); }, 3000);</script>";
		}
		else
		{
			
			$response["status"]  =  "error";
            $response["message"] =  "<div class='alert alert-danger'>".validation_errors()."</div>";
		}
		
		echo json_encode($response);
		
	}
	
	function seatizen_add_process()
	{
		$this->load->helper("tracker");
		/* Array
		(
			[first_name] => 
			[last_name] => 
			[email] => 
			[department] => 
			[coc_class] => 
			[rank] => 
		) */
		
		$this->load->library("form_validation");
		$this->load->library("check_data");
		$this->load->model("seatizen_model");
				
		$first_name = $this->input->post("first_name",true);
		$last_name  = $this->input->post("last_name",true);
		$email 	  = $this->input->post("email",true);
		$department = $this->input->post("department",true); // id -> profile_resume_tr
		$coc_class  = $this->input->post("coc_class",true);  // id -> profile_resume_tr
		$rank 	   = $this->input->post("rank",true);	    // id -> profile_resume_tr
		
		$first_name = filter($first_name);
		$last_name  = filter($last_name);
		$email 	  = filter($email);
		$department = filter($department);
		$coc_class  = filter($coc_class);
		$rank 	   = filter($rank);
		
		// check_email
		$check_email = $this->check_data->check_email($email);
	
		$this->form_validation->set_rules("first_name","First Name","required");
		//$this->form_validation->set_rules("last_name","Last Name","required");
		$this->form_validation->set_rules("email","Email","required");
		$this->form_validation->set_rules("department","Department","numeric|required");
		$this->form_validation->set_rules("coc_class","COC Class","numeric|required");
		$this->form_validation->set_rules("rank","Rank","numeric|required");
		
		if($this->form_validation->run() == TRUE && $check_email == TRUE)
		{
			// insert 
			$u		= explode("@",$email);
			$username = $u[0];
			
			$arr['pass']      = mt_rand(100000,999999);
			$arr['username']  = $username;
			$seatizen 		 = $this->seatizen->seatizen_add($arr);
			$dt 	   		   = $seatizen['dt']; 
			$
			// insert ke admin yang bertanggung jawab insert
			$table			 = $this->_primary_table; // pelaut_ms
			$arr['menu']	   = $this->_route; // seatizen
			$arr['name']   	   = $this->session->userdata("name"); // username
			$arr['form']	   = "form_add_seatizen";
			$arr['id_object']  = $seatizen['pelaut_id'];
			$arr['action']     = "admin $arr[name] add seatizen $dt[nama_depan] $dt[nama_belakang] for data id_object = $arr[id_object] into table $table ";
				
			//print_r($this->session->all_userdata());
			$this->admin_activity->insert_activity($arr);
			
			// insert ke tracker kunglaw 2016
			track_seatizen($seatizen["pelaut_id"],"infradmin");
			
			// send email 
			//kirim email, data username dan password
			$this->load->library("my_email");
			$user = "info";
			
			$name		   = $dt['nama_depan']." ".$dt['nama_belakang'];
			$dt_seatizen	= $this->seatizen_model->get_seatizen_panel();
			$str_url 		= infr_url("users/users_process/activate/?a=$dt[activation]&x=1&u=$dt[username]&p=$dt[password]&email=$dt[email]");
			
			$content = array(
				
				"subject" 		=> "Informasea Account",
				"subject_title"  => WEBSITE,
				"to" 			 => $email, 
				"data" 		   => array("username"=>$username,"password"=>$arr['pass'],"str_url"=>$str_url,"email_to"=>$dt['email'],
				"dt_seatizen" => $dt_seatizen, 'name' => $name,"user_type"=>"seatizen"),
				
				"message" 		=> "seatizen/email/email-activation-seatizen",
				"mv" 			 => TRUE,
				"alt_message" 	=> "seatizen/email/email-activation-seatizen-alt",
				"amv" 		    => TRUE
			
			);
			
			$this->my_email->send_email($user,$content);
			 
			
			$response["status"] 	   = "success";
            $response["message"] = "<div class='alert alert-success' role='alert'> seatizen $first_name $last_name has been added. </div> ";
		}
		else
		{
			if($check_email == false)
			{
				$str_ce = "<p> Email has been used </p>";	
			}
			
			$response["status"] 	   =  "error";
            $response["message"] =  "<div class='alert alert-danger'>".validation_errors()." ".$str_ce."</div>";
		}
		
		$this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
       	$this->output->set_output(json_encode($response));
		//echo json_encode($response);
	}
	
	function import()
	{
		$this->load->library("Excel_management");
		//$this->excel_management->test();
		
		// set seatizen
		$setting["upload_location"] = $this->config->item("server_url")."/upload/seatizen/excel_data";
		$setting["table"]		   = "pelaut_ms";
		
		// set test
		/* $setting["upload_location"] = $this->config->item("server_url")."upload/test/excel_data";
		$setting["table"]		   = "test";*/
				
		$response = $this->excel_management->import_excel($setting);
		
		$this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
		
		/* $this->load->helper("excel");
        $response = import_excel_vessel();

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));*/
		
	}


    /**
     * Return all item in specified table.
     */
    public function get_list_item_ajax() {

        $this->load->library("datatables");

        $edit_button_area = ", ".
            $this->_primary_table .".pelaut_id AS log_link, ".
            $this->_primary_table .".pelaut_id AS block_link";

        // specify columns for datatables
        $this->datatables->select(
		
            $this->_primary_table .".pelaut_id AS checkbox, ".
            "CONCAT_WS(' ', ". $this->_primary_table .".nama_depan, ". $this->_primary_table .".nama_belakang) AS name, ".
            $this->_primary_table .".email AS email, ".
            $this->_departement_table .".department AS department, ".
            $this->_primary_table .".gender AS gender, ".
            $this->_primary_table .".activation AS status".
            $edit_button_area,

            false
        );

        $this->datatables->from($this->_primary_table);

        $this->datatables->join(
            $this->_crew_table,
            $this->_crew_table .".id_seatizen = ". $this->_primary_table .".pelaut_id",
            "left outer"
        );

        $this->datatables->join(
            $this->_departement_table,
            $this->_departement_table .".department_id = ". $this->_crew_table .".department",
            "left outer"
        );

        // modify first and last column for table bulk or individual operation.

        $this->load->helper("seatizen");
        $this->datatables->edit_column(
            "block_link",
            '$2 <input type="hidden" class="object-id" value="$1">',
            "block_link, get_seatizen_block_action(status, checkbox)");

        $checkbox = form_checkbox("list_checkboxes[]", "$1");
        $this->datatables->edit_column("checkbox", $checkbox, "checkbox");

        // link to log list
        $this->datatables->edit_column(
            "log_link",
            '<a href="'. base_url() .'seatizen/log/$1">'.
            '<i class="fa fa-bars"></i>' .
            '</a>',
            "log_link");

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output($this->datatables->generate());
    }

    /**
     * Show item detail
     * @param $item_id
     */
    public function show_item_detail($item_id) {
		
        set_page_title("Seatizen Detail");
        $this->load->model("vessel_model");
        $this->load->model("coc_model");
        $this->load->model("resume_model");
		

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $item_detail = $this->generic->retrieve_one( $this->_primary_table, array("pelaut_id" => $item_id));
		
        if (empty($item_detail)) {
            set_notification("Detail is not available.", NOTIF_ERROR);
            redirect($this->_route);
        }
		
		// buat apaan ini ? 
        //$crew_detail = $this->generic->retrieve_one($this->_crew_table, array("id_seatizen" => $item_id));
		$crew_detail   		= $this->generic->retrieve_one($this->_primary_table,array("pelaut_id" => $item_id));
		$profile_resume_tr  = $this->generic->retrieve_one($this->_prtr,array("pelaut_id"=>$item_id));
		
		//print_r($crew_detail);

        if (empty($item_detail)) {

            // give sign to view
            $crew_detail = array("detail_available" => false);

        } else {

            $crew_detail["detail_available"] = true;

            // retrieve seatizen rank
            $rank = $this->generic->retrieve_one(
                $this->_rank_table, array("rank_id" => $profile_resume_tr["rank"]));

            if (empty($rank)) {
				
                $crew_detail["rank_name"] = "";
				
            } else {
                $crew_detail["rank_name"] = $rank["rank"];
            }
        }

        $crew_detail["item_id"] = $item_id;
        $crew_detail["activation"] = $item_detail["activation"];


        // retrieve profile picture
        $photo = $this->generic->retrieve_one(
            $this->_photo_table,
            array("id_pelaut" => $item_id),
            array("datetime" => "DESC")
        );

        if (empty($photo) || empty($photo["nama_gambar"])) {
            $crew_detail["photo"] = img_url() . "img_default_profile.png";
        } else {
            $crew_detail["photo"] = PHOTO_HOME_ADDRESS . $item_detail["username"] .
                "/profile_pic/" . $photo["nama_gambar"];
        }

        $resume = $this->resume_model->get_resume($item_id);
        $crew_detail['profile']        = $resume['profile'];

          $crew_detail['pelaut']        = $resume['pelaut'];
          $crew_detail['competency']    = $resume['competency'];
          $crew_detail['proficiency']   = $resume['proficiency'];
          $crew_detail['experience']    = $resume['experience'];
          $crew_detail['document']      = $resume['document'];
          $crew_detail['medical']       = $resume['medical'];
          $crew_detail['visa']          = $resume['visa'];
		  $crew_detail["file_resume"]   = $this->resume_model->list_upload_resume($item_id); 

          $crew_detail['extra_css']    = "seatizen/resume-components/js_top";
          $crew_detail['extra_script'] = "seatizen/resume-components/js_under";

        $crew_detail["block_route"] 	   = $this->_route;
		$crew_detail['jumlah_view'] 	   = $this->seatizen->jumlah_view($item_detail['username']);
		$crew_detail["register_from"] 	 = $this->seatizen->register_from($item_detail["username"]);
		
		//print_r($crew_detail["register_from"]); exit;
		
		$crew_detail["applied_vacantsea"] = $this->seatizen->applied_vacantsea($item_detail["username"]); 

        $this->load->view($this->_view_folder ."/item_detail", $crew_detail);
    }

    function add_document_process()
    {
    	
        $this->load->model('document_model');
        $this->load->library('form_validation');
      	
		$type_document 		= "Seaman Book";
        $country			  = $this->input->post('national');
        $type 				 = $type_document;
        $place 				= $this->input->post("place");
        $source 			   = $this->input->post("source");
        $number 			   = $this->input->post("number");
        $date_issued		  = $this->input->post("date_issued");
        $date_expired		 = $this->input->post("date_expired");
        $id_pelaut			= $this->input->post("pelaut_id",true);
		
		$f 			 = $this->seatizen->get_detailseatizen($id_pelaut);
		$username	  = $f["username"];
		
        // $this->form_validation->set_rules("doc_type","Type Document",'required');
        // if($type == "") $this->form_validation->set_rules("type","Type Document",'');
        $this->form_validation->set_rules('national','Nationality','required');
        $this->form_validation->set_rules("place","Place","required");
        $this->form_validation->set_rules("number","Number","required");
//        $this->form_validation->set_rules("date_issued","Date Issued","required");
        $this->form_validation->set_rules("date_expired","Expired Date","required");

        $hasil = $this->form_validation->run() ? "berhasil":"gagal";

//        echo $type." -> ".$place." -> ".$number." -> ".$date_issued." -> ".$date_expired."<br>".$hasil;
        if($hasil == "berhasil") {
			
			if(!empty($_FILES['attachment']["name"]))
			{
			  	$valid_ext = array('jpg', 'jpeg', 'png', 'pdf');
				$file_ext = explode('/', $_FILES["attachment"]["type"])[1];
				
				if(!in_array($file_ext, $valid_ext)) {
					$result["message"] = "The filetype you are attempting to upload is not allowed.";
					$result["status"] = "error";
					echo json_encode($result);
					exit();
				}
			  $this->load->helper("upload_file_document");
			  
			  $attachment = $_FILES['attachment'];
  
			  $nama_file  = (str_replace(' ', '_', strtolower($country)))."_seaman_book.";
			  $nama_file .= end(explode('.', $attachment['name']));
			  
			  // buat foldernya dahulu
			  // dari username_folder_helper
			  make_username_folder_doc($username,"doc");
			  
			  $attachment['name'] = $nama_file;
			  $upload_file = upload_document_pelaut($attachment, $username, "document_record");
			  
			  // ADA ERROR UPLOADING 
			  // KUNGLAW 23-08-2016
			  
			  if($upload_file["pesan"] == "sukses")
			  {
				  $data_upload = $upload_file['data'];
			  }
			  else
			  {
				  $result["message"] = $data_upload = "<div class='alert alert-danger'>".$upload_file["data"]."</div>";
				  $result["status"]  = "error";
				  
				  echo json_encode($result);
				  exit;	
			  }
			  
			}
        	
            // $tb_name = $show_source(e."_ms";
            // $table = strpos('cert', $tb_name) ? str_replace('_cert','', $tb_name) : $tb_name;
            // $jml = $this->document_model->check_table_ms($table,$type);// or die("<br>gagal di query search = $jml");
            // if ($jml == 0) //artinya belum ada medical di medical_ms
            // {
            //     $this->document_model->add_table_ms($table,$type);// or die("Gagal di query tambah document ms");
            // }
            $q = $this->document_model->add_document_process($id_pelaut, 
			$type, 
			$number, 
			$place, 
			$date_issued, 
			$date_expired, 
			$source, 
			$country, 
			$data_upload['file_name']);
		
            if (!$q) {
				
                $this->db->_error_message();
				
            } else {
                $result["message"]  = "<div class='alert alert-success'> Data document Successfully Added </div>";
                $result["message"] .= "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
				$result["status"]   = "success";
            }

        }
        else {
        	
            $result["message"] = "<div class='alert alert-danger'>" . validation_errors() . " </div>";
			$result["status"]  = "error";
            
        }
		
		echo json_encode($result);
    }

    function add_experience_process()
	{
		//print_r($this->input->post()); exit;
		
		$this->load->model('experience_model');
		return $this->experience_model->add_experience_process();
		
	}
	
	function update_experience_process()
	{
		//print_r($this->input->post()); exit;
		
		$this->load->model('experience_model');
		return $this->experience_model->update_experience_process();
		
	}
	
	function delete_experience_process()
	{
		$this->load->model('experience_model');
		return $this->experience_model->delete_experience_process();	
		
	}

    function resume_data() // semua resume data dijalankan disini 
	{
		
		$this->load->model("resume_data");
		//print $this->resume_data->get_json_ship(); exit;		
		
		$function_post = $this->input->post("function");
		$function_get = $this->input->get("function");
		//print $this->resume_data->get_json_ship();
		
		$function = !empty($function_post) ? $function_post : $function_get;
		
		//$function = $this
		
		if($function == "ship_json")
		{	
			print $this->resume_data->get_json_ship();
		}
		else if($function == "ship_type_json")
		{
			print $this->resume_data->get_json_ship_type();	
			
		}
		else if($function == "rank_json")
		{
			return $this->resume_data->get_json_rank();	
		}	
		
		/* ===================================================== */
		if($function == "get_ship_type")
		{
			return $this->resume_data->get_ship_type();
		}
		else if($function == "get_ship")
		{
			return $this->resume_data->get_ship();	
		}
		else if($function == "get_ship_bytype")
		{
			//$type_id = $this->input->post("type_id");
			return $this->resume_data->get_ship_bytype();
		}
		else if($function == "get_ship_type_byvi")
		{
			return $this->resume_data->get_ship_type_byvi();	
		}
	}

    function add_proficiency_process()
	{
		if($this->input->is_ajax_request()){

			
			$this->load->model('proficiency_model');
			
			$result = $this->proficiency_model->add_proficiency_process();	
			echo json_encode($result);
		} else {
			
			header('location:'.base_url('custom404'));
		}
		
	}
	
	function delete_visa_process(){
		
		$this->db = $this->load->database(DB2_GROUP,TRUE);	
		
		if($this->input->is_ajax_request()){
			
			$visa_id = $this->input->post('id_update');

			$str = "DELETE FROM document_tr WHERE document_id = '$visa_id'";
			$q = $this->db->query($str);;
			if($q){
				echo "<div class='alert alert-success'> Visa has been delete </div>";
				
			}else{
				echo "";
			}
			
		} else {
			header('location:'.base_url('custom404'));
		}
		
	}
	
    function add_document_visa(){
		
		if($this->input->is_ajax_request()){
        $this->db = $this->load->database(DB2_GROUP, TRUE);

			$this->load->library('form_validation');
			$type 		  = $this->input->post('visa_type');
			
			if($type == "other"){
				$type = $this->input->post('type');
			}
			
			$number 		= $this->input->post('number');
			$issued_place  = $this->input->post('place_issue');
			$issued_date   = $this->input->post('date_issued');
			$expired_date  = $this->input->post('expired_date');
			$type_document = "visa";
			$pelaut_id 	 = $this->input->post('pelaut_id');
			$ip_address 	= $_SERVER['REMOTE_ADDR'];


			if($type == "other"){ 

				$this->form_validation->set_rules('type','Type','required');

			}else{
				$this->form_validation->set_rules('visa_type','Visa','required');
			}
			
			$this->form_validation->set_rules('expired_date','Expiry Date','required');


			if($this->form_validation->run() == TRUE){ 
				
				if(!empty($_FILES['attachment']["name"]))
				{
					$valid_ext = array('jpg', 'jpeg', 'png', 'pdf');
					$file_ext = explode('/', $_FILES["attachment"]["type"])[1];
					
					if(!in_array($file_ext, $valid_ext)) {
						$result["message"] = "The filetype you are attempting to upload is not allowed.";
						$result["status"] = "error";
						echo json_encode($result);
						exit();
					}
				 
				  $this->load->helper("upload_file_document");
				  $username   = $this->session->userdata("username");
				  $attachment = $_FILES['attachment'];
  				  
				  // buat foldernya dahulu
				  // dari username_folder_helper
				  make_username_folder_doc($username,"doc");
				  
				  $nama_file  = (str_replace(' ', '_', strtolower($type))).".";
				  $nama_file .= end(explode('.', $attachment['name']));
				  
				  $attachment['name'] = $nama_file;
				  $upload_file = upload_document_pelaut($attachment, $username, "visa"); // "visa" subfolder
  				  
				  
				  if($upload_file["pesan"] == "sukses")
				  {
					  $data_upload = $upload_file['data'];
				  }
				  else
				  {
					  $result["message"] = $data_upload = "<div class='alert alert-danger'>".$upload_file["data"]."</div>";
					  $result["status"]  = "error";
					  echo json_encode($result);
					  exit;	
				  }
				}

				$str = "INSERT INTO document_tr (type,number,place,date_issued,date_expired,pelaut_id,ip_address,datetime,type_document, attachment)
				VALUES ('$type','$number','$issued_place','$issued_date','$expired_date','$pelaut_id','$ip_address',now(),'$type_document', '".$data_upload['file_name']."')";
				
				$q = $this->db->query($str);
				
				if($q){
					
					$result["message"]  = "<div class='alert alert-success'> Visa has been inserted </div>";
					
					$result["status"]   = "success";
					
				} else{
					
					$result["message"] = $this->db->_error_message();
					$result["status"]  = "error";
					
				}

			} else {
				
				$result["message"] = "<div class='alert alert-danger'>" . validation_errors() . " </div>";
				$result["status"]  = "error";
			}
			
			echo json_encode($result);

		} else {
			header('location:'.base_url('custom404'));
		}

	}
		/* === end Visa ===*/
	
	function delete_document_process()
	{
		$this->load->model('document_model');
		return $this->document_model->delete_document_process();	
		
	}
	
	function add_document_medical(){
		
		$this->load->model('document_model');
		$this->load->library('form_validation');
		
		$this->db = $this->load->database(DB2_GROUP, TRUE);
		$type 	= $this->input->post('document_type');

		if($type == "other"){
			
			$type = $this->input->post('type');
			
		}else{
			
			$this->form_validation->set_rules('document_type','Medical','required');
		}

		$place 		= $this->input->post('place');
		$source 	   = $this->input->post('source');
		$number 	   = $this->input->post('number');
		$date_issued  = $this->input->post('date_issued');
		$date_expired = $this->input->post('date_expired');
		$id_pelaut    = $this->input->post('pelaut_id',true);
		$username    = $this->input->post('username',true);
		$country 	  = '';

		$this->form_validation->set_rules("place","Place","required");
        $this->form_validation->set_rules("number","Number","required");
//        $this->form_validation->set_rules("date_issued","Date Issued","required");
        $this->form_validation->set_rules("date_expired","Expired Date","required");
		
        $hasil = $this->form_validation->run() ? "berhasil":"gagal";

        if($hasil == "berhasil"){
			// print_r($_FILES); exit;
			
			if(!empty($_FILES["attachment"]["name"]))
			{
				$valid_ext = array('jpg', 'jpeg', 'png', 'pdf');
				$file_ext = explode('/', $_FILES["attachment"]["type"])[1];
				
				if(!in_array($file_ext, $valid_ext)) {
					$result["message"] = "The filetype you are attempting to upload is not allowed.";
					$result["status"] = "error";
					echo json_encode($result);
					exit();
				}

        		$this->load->helper("upload_file_document");
        		// $username = $this->session->userdata("username");
        		$attachment = $_FILES['attachment'];
				
				// buat foldernya dahulu
				// dari username_folder_helper
				make_username_folder_doc($username,"doc");
				
        		$nama_file = (str_replace(' ', '_', strtolower($type))).".";
        		$nama_file .= end(explode('.', $attachment['name']));
        		$attachment['name'] = $nama_file;
        		$upload_file = upload_document_pelaut($attachment, $username, "medical_record");
        		// echo "hai";
        		if($upload_file["pesan"] == "sukses")
				{
					$data_upload = $upload_file['data'];
				}
				else
				{
					$result["message"] = $data_upload = "<div class='alert alert-danger'>".$upload_file["data"]."</div>";
					$result["status"]  = "error";
					exit;	
				}
			}

			$q = $this->document_model->add_document_process($id_pelaut, 
			$type, 
			$number, 
			$place, 
			$date_issued, 
			$date_expired, 
			$source,
			$country, 
			$data_upload['file_name']) or die("gagal di query tambah document tr nih");
	//          
				if (!$q) {
					$result["message"] = $this->db->_error_message();
					$result["status"] = "error";
				} else {
					$result["message"]  =  "<div class='alert alert-success'> Data document Successfully Added </div>";
					
					$result["status"]   =  "success";
				}
	
			} 
			else {
				$result["message"] = "<div class='alert alert-danger'>" . validation_errors() . " </div>";
				$result["status"] = "error";
			}
			
			echo json_encode($result);
	} 

	function tes_update_document(){
			
			/*print_r($_POST); 
			print_r($_FILES); exit;*/
			$this->db = $this->load->database(DB2_GROUP, TRUE);
    		$this->load->model('document_model');
    		$this->load->library('form_validation');
			
			$pelaut_id 		   = $this->input->post("pelaut_id");
			//Array ( [certificate] => [no_certificate] => [date_issue] => [place_issue] => )
			$document_id		 = $this->input->post("id_update",true);
			
			$typee 			   = "Seaman Book";
			$country			 = $this->input->post('national');
			$tipe 				= $this->input->post('tipenya');
			
			if($tipe == 'Passport'){
				
				$type  ='Passport';
				
			} else{
			
				$type = 'Seaman Book';
			}

			$number 			  = $this->input->post("number",true);
			$place 			   = $this->input->post("place",true);
			$date_issued		 = $this->input->post("date_issued");
			$date_expired		= $this->input->post("date_expired",true);
			
			// $this->form_validation->set_rules("type","Type Document",'required');
			$this->form_validation->set_rules("place","Place","required");
			$this->form_validation->set_rules("number","Number","required");
			$this->form_validation->set_rules("date_issued","Date Issue","required");
			$this->form_validation->set_rules("date_expired","Expired Date","required");
			
			if($this->form_validation->run() == TRUE)
			{
				$attachment_query = "";
				if(!empty($_FILES['attachment']["name"]))
				{
				  $this->load->helper("upload_file_document");
				  $username = $this->session->userdata("username");
				  $attachment = $_FILES['attachment'];
	  			  
				  // ingat, ini rule hanya untuk UPDATE/EDIT document record 
				  if($type == "Seaman Book")
				  {
				  	$nama_file  = (str_replace(' ', '_', strtolower($country)))."_seaman_book.";
				  	$nama_file .= end(explode('.', $attachment['name']));
				  }
				  else if($type == "Passport")
				  {
					$nama_file  = (str_replace(' ', '_', strtolower($country)))."_passport.";
				  	$nama_file .= end(explode('.', $attachment['name']));  
				  }
				  
				  // buat foldernya dahulu
				  // dari username_folder_helper
				  make_username_folder_doc($username,$type);
				  
				  $attachment['name'] = $nama_file;
				  $upload_file = upload_document_pelaut($attachment, $username, "document_record");
				  
				  // pesan error kalau gambar tidak sesuai ketentuan
				  // data sql pun tidak masuk
				  if($upload_file["pesan"] == "sukses")
				  {
					  $data_upload 								= $upload_file['data'];
					  $attachment_query = "attachment				= '$data_upload[file_name]'				,";
					  
				  }
				  else
				  {
					  $result['message'] = $data_upload = "<div class='alert alert-danger'>".$upload_file["data"]."</div>";
					  $result['status']			     = "error";
					  echo json_encode($result);
					  exit;	
				  }
				  
				}
				
				$str  = "update document_tr set 			 	 		 				 ";
				$str .= "type 					= '$type'			 					,";
				$str .= "place				    = '$place' 								,";
				$str .= "number				    = '$number'								,";
				
				$str .= $attachment_query;
				
				$str .= "date_issued			= '$date_issued'						,";
				$str .= "date_expired			= '$date_expired'						,";
				$str .= "ip_address				= '".$_SERVER['REMOTE_ADDR']."'		   ,";
				$str .= "datetime				= now()					 				 ";
				$str .= "where		 							 						 ";
				$str .= "pelaut_id				= '$pelaut_id'	 AND 	 				 ";
				$str .= "document_id			= '$document_id'	 	 				 ";
				
				//echo $str;
				
				$q = $this->db->query($str);
				
				if(!$q)
				{
					$result["message"] = $this->db->_error_message();
					$result["status"]  = "error"; 	
				}	
				else
				{
					$result["message"]  =  "<div class='alert alert-success'> Data document Successfully Edited </div>"; 
					
          			$result["status"]   = "success";
				}
			}
			else
			{
				$result["message"] = "<div class='alert alert-danger'>".validation_errors()." </div>";
				$result["status"]  = "error";
			}
			
			echo json_encode($result);

    }
	
	function update_medical_process(){
    	
    	$this->load->model('document_model');
		
    	$result = $this->document_model->update_medical_process();
		
		echo json_encode($result);
    }
	
	function edit_competency_process()
	{
		if($this->input->is_ajax_request()){
			
			$this->load->model('competency_model');
			$result =  $this->competency_model->edit_competency_process();
			echo json_encode($result);
			
		}else {
			
			header('location:'.base_url('custom404'));
		}
	}

	function delete_competency_process()
	{	
		if($this->input->is_ajax_request()){

			$this->load->model('competency_model');
			$result =  $this->competency_model->delete_competency_process();
			echo json_encode($result);
			
		} else {
			header('location:'.base_url('custom404'));
		}
		
	}		
	
	function edit_proficiency_process()
	{
		$this->load->model('proficiency_model');
		$result = $this->proficiency_model->edit_proficiency_process();
		echo json_encode($result);
	}
	
	function delete_proficiency_process()
	{
		$this->load->model('proficiency_model');
		return $this->proficiency_model->delete_proficiency_process();	
	}
	
    function modal()
    {
        # code...
        // error_reporting(E_ALL);
        $ajax = $this->input->post("x");
        if($ajax){
			
          $this->db = $this->load->database(DB2_GROUP, TRUE);
            // untuk tanggalan "year_range" 
          $data['sign_in']      = "-50:+0";
          $data['sign_off']        = "-50:+0";
          $data['date_issued']  = "-50:+0"; // maxDate:0
          $data['date_expired']   = "-5:+15"; // minDate:0
          
          // untuk label 
          $data['date_issued_lbl']  = "Date of Issue";
          $data['date_expired_lbl'] = "Date of Expiry";
          $data['sign_on_lbl']    = "Sign On";
          $data['sign_off_lbl']  = "Sign Off";  
          // echo $this->uri->segment(4);
          $modal_type = $this->input->post("modal");
          /*echo "<script>alert('$modal_type')</script>";*/
          $id_update = $this->input->post("id_update");
		  $pelaut_id = $this->input->post("pelaut_id");
		  
		  $q = "select username from pelaut_ms where pelaut_id = '$pelaut_id'";
		  $exec = $this->db->query($q);
		  $dt_username = $exec->row_array();

          $data['id_update'] = $id_update;
		  $data["pelaut_id"] = $pelaut_id; 
		  $data["id_pelautnya"] = $pelaut_id;
		  $data["usernamenya"] = $dt_username['username'];
		  
          $this->load->helper("date_format");
          $this->load->model('nation_model');
          if($modal_type == "form-profile")
          {
              $this->load->model('vacantsea_model');
              $this->load->model('vessel_model');
             
              $data['nation']       = $this->nation_model->get_nationality();
              $data['resume']       = $this->resume_model->get_resume();
              
              
              $this->load->view("seatizen/resume-components/modal/form-profile",$data);   
          }
          else if($modal_type == "form-kepelautan")
          {
             
              $this->load->model('vessel_model'); 
              $this->load->model('vacantsea_model');
              
              //echo "test"; exit;
              $data['vessel_type']   = $this->vessel_model->get_ship_type();
              $data['coc_class']     = $this->resume_model->get_coc_class();
              $data['department']   = $this->vacantsea_model->call_department();
              $data['rank']           = $this->resume_model->get_rank();
              $data['resume']       = $this->resume_model->get_resume();
              
              $this->load->view("seatizen/resume-components/modal/form-kepelautan",$data);
          }
          else if($modal_type == "form-add-proficiency") // proficiency
          {
              $this->load->model('proficiency_model');
              //$data['resume'] = $this->resume_modal->get_resume();
              $this->load->view("seatizen/resume-components/modal/form-add-proficiency", $data); 
          }
          else if($modal_type == "form-add-competency") //competency
          {
          	$this->load->model('nation_model');
              $data['profile_resume'] = $this->resume_model->get_resume();
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          else if($modal_type == "form-add-document") //competency
          {
          		
              $this->load->model("document_model");
//              echo "hallo";
              $data['myDocument'] = $this->document_model->get_all_table_ms("document");
              // $data['id_pelaut'] = $this->session->userdata("id_user");
              //$data['resume'] = $this->resume_modal->get_resume();
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          else if($modal_type == "form-add-visa"){
            $this->load->model('document_model');
            
            $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }

          else if($modal_type == "form-add-medical") //competency
          {
             
              $this->load->model("document_model");
              
              $data['myDocument'] = $this->document_model->get_all_table_ms("medical");
              $data['id_pelaut'] = $this->session->userdata("id_user");
              
              //$data['resume'] = $this->resume_modal->get_resume();
              $this->load->view("seatizen/resume-components/modal/".$modal_type, $data);
          }
          else if($modal_type == "form-add-experience")
          {
              
              $this->load->model('resume_model');
             
              $this->load->model('vessel_model');
               
               
              //$data['department']     = $this->vacantsea_model->call_department();
              
              $data['vessel']       = $this->vessel_model->get_ship();           
              $data['ship_type']     = $this->vessel_model->get_ship_type();
              
              $data['rank']           = $this->resume_model->get_rank();
              $data['resume']       = $this->resume_model->get_resume();
              //$data['coc_class']     = $this->resume_model->get_coc_class();
              
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          } else if($modal_type == "form-update-visa"){
            $this->load->model('document_model');
          
            $data['visa'] = $this->document_model->get_detail_visa();

          	$this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
		  }
          else  if($modal_type == "form-update-proficiency")
          {
              $this->load->model('proficiency_model');
              $data['proficiency'] = $this->proficiency_model->get_proficiency_tr();
			  
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          else  if($modal_type == "form-update-competency")
          {
              $this->load->model('competency_model');
			  
              $data['profile_resume'] = $this->resume_model->get_resume();
              $data['competency'] 	 = $this->competency_model->get_competency_tr();
			  
			  
			  
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          else  if($modal_type == "form-update-experience")
          {
              $this->load->model("experience_model");
              
              $data['resume']       = $this->resume_model->get_resume();
              $data['experience'] = $this->experience_model->get_experience_detail();
              
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          else if($modal_type == "form-update-document")
          {
              $this->load->model("document_model");
              $data['document'] = $this->document_model->get_document_tr();
              
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          else if($modal_type == "form-update-medical"){
            $this->load->model("document_model");
            $data['document'] = $this->document_model->get_document_tr();
            /* echo "<script>alert('masih disini')</script>"; */
            $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);

          }
		  
		  else if($modal_type == "form-edit-describe")
		  {
			  
			   $this->load->model('vessel_model');
			   $this->load->model("rank_model");
			   $this->load->model("experience_model");
			   

			  $data['resume'] 		= $this->resume_model->get_resume();

			  $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);

		  }
		  else if($modal_type == "form-update-cover-letter")
		  {
			  $data['resume'] 		= $this->resume_model->get_resume();
			  
			  $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
		  }
		  
		  
		  else if($modal_type == "form-upload-resume")
		  {

			  $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
		  }

          else if($modal_type == "delete-competency-modal")
          {
              $this->load->model('competency_model');
              $data['competency'] = $this->competency_model->get_competency_tr();
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          
          else if($modal_type == "delete-proficiency-modal")
          {
              $this->load->model('proficiency_model');
              $data['proficiency'] = $this->proficiency_model->get_proficiency_tr();
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }
          
          else if($modal_type == "delete-experience-modal")
          {
              $this->load->model('experience_model');
              $data['experience'] = $this->experience_model->get_experience_detail();
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }else if($modal_type == "delete-visa-modal"){
            $this->load->model('document_model');
            $data['visa'] = $this->document_model->get_detail_visa();
            $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          }


           else if($modal_type == "delete-document-modal")
          {
              $this->load->model('document_model');
              $data['document'] = $this->document_model->get_document_tr();
              $this->load->view("seatizen/resume-components/modal/".$modal_type,$data);
          } else if($modal_type == "delete-friend-modal"){
            
            $this->load->model('seatizen/seatizen_model');
         
                $data['seatizen'] = $this->seatizen_model->get_detail_pelaut_by_id($id_update);
            $this->load->view("friends/".$modal_type,$data);

          } else if($modal_type == "delete-friend-modal-2"){
            
            $this->load->model('seatizen/seatizen_model');
          
            $data['seatizen'] = $this->seatizen_model->get_detail_pelaut_by_id($id_update);
            $this->load->view("friends/".$modal_type,$data);
          } else if($modal_type == "cancel-apply-modal") {

            $this->load->model('vacantsea_model');
            $data['applicant'] = $this->vacantsea_model->get_detail_applicant($id_update);
            
            $data['vacantsea'] = $this->vacantsea_model->detail_vacantsea($data['applicant']['id_vacantsea']);
            

            //print_r($data['vacantsea']);
            //print_r($data['applicant']); echo "<br>";
            //print_r($data['vacantsea']);
            //echo $id_update;
         // echo "<script>alert(\'$id_update\')</scirpt>";
            $this->load->view("applied/cancel-apply-modal",$data);
          }else if($modal_type = "modal-delete-resume-upload"){


                $data['resume_upload'] = $this->resume_model->detail_upload_resume($id_update);
                $this->load->view("resume-upload/".$modal_type,$data);
          }
        }
    }
	
	
	function add_file_resume()
	{
		$this->load->library('upload');
		$this->load->helper('username_folder_helper');
		
		$username    = $this->input->post('username',true);
		
		//$type = explode("/",$_FILES['file_resume']['type']);
		$new_file_name = strtolower(str_replace(" ","-",$_FILES['file_resume']['name']));
		
		$mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'odt' => 'application/vnd.oasis.opendocument.text'
        );
		
		//cari nama file untuk nama folder 
		$type = array_search($_FILES['file_resume']['type'],$mime_types);
		
		/* $configupload['upload_path'] = "../infrasset/document/$username/$type"; // uplaod path itu gak usah pake nama filenya segala 
		$configupload['file_name'] = $new_file_name;
		$configupload['allowed_types'] = "pdf";
		$configupload['max_size']	=  1024 * 1024 * 1024 * 100; // 10MB;
		//echo $_FILES['picture']['size']; exit;
		//$configupload['max_width']  = '1024';
		//$configupload['max_height']  = '1024';

		//print $configupload['upload_path'];
		$this->upload->initialize($configupload);
		//print_r($configupload); exit;
		$file_resume = 'file_resume'; // name dari form file

		/*check folder selesai 
		
		$this->upload->do_upload($file_resume);
		$dt_resume = $this->upload->data();
		
		echo $error_upload = $this->upload->display_errors('<p class="alert alert-danger"> Upload : ', '</p>'); */
		
		// buat foldernya dahulu
		// dari username_folder_helper
		make_username_folder_doc($username,$type);
		
		$upl = move_uploaded_file($_FILES['file_resume']["tmp_name"],"../infrasset/document/$username/$type/$new_file_name");
		
		$dt_resume["file_name"] = $_FILES["file_resume"]["name"];
		$dt_resume["file_type"] = $_FILES["file_resume"]["type"];
		$dt_resume["file_size"] = $_FILES["file_resume"]["size"];
		
		//echo $id_pelaut = $this->input->post("id_user"); exit;
		
		if($upl)
		{
			$id_pelaut = $this->input->post("id_user");
			$this->resume_model->add_file_resume($id_pelaut,$dt_resume);
			//header("location:".base_url("seaman/resume/resume_upload"));
			echo "<div class='alert alert-success'>Resume has successfully upload </div>";
			echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
		}
			
	}
	
	function update_describe_process()
	{

		if($this->input->is_ajax_request()){

			return $this->resume_model->update_describe_process();	


		} else{

			header('location:'.base_url('custom404'));

		}	


	}
	
	function update_cover_letter_process()
	{

		if($this->input->is_ajax_request()){

			return $this->resume_model->update_cover_letter_process();	


		} else{

			header('location:'.base_url('custom404'));

		}
	

	}

	
    function add_competency_process()
	{	
		if($this->input->is_ajax_request()){

			
			$this->load->model('competency_model');
			$this->competency_model->add_competency_process();
		} else {
			
			header('location:'.base_url('custom404'));
		}
		
	}


    /**
     * Block item.
     * @param $object_id
     * @return bool
     */
    private function block($object_id) {

        // arrange delete configuration
        $item_criteria = array("pelaut_id" => $object_id);
        $item_conf = array("activation" => "BLOCKED");

        $result = $this->generic->retrieve_one(
            $this->_primary_table,
            $item_criteria
        );

        $item_exist = false;

        if (! empty($result)) {

            $this->generic->update(
                $this->_primary_table,
                $item_conf,
                $item_criteria
            );

            $item_exist = true;


            $this->load->helper("notification");
            follow_up_request($object_id, NOTIF_BLOCK_SEATIZEN);
        }

        return $item_exist;

    }

    /**
     * Block just one item
     */
    public function ajax_block_one() {

        $response = array();
        $object_id = json_decode($this->input->post("id"));

        // request for approval if not super admin
        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            // make notification for seatizen block operation.

            // request for block this seatizen. (flag: not followed up yet)
            $notification = array(
                "source" => $this->session->userdata("id"),
                "destination" => NULL,
                "type" => NOTIF_BLOCK_SEATIZEN,
                "target" => $object_id,
                "status" => false // haven't followed up yet
            );

            $this->generic->create($this->_notification_table, $notification);


            $response["status"] = "success";
            $response["notification"] = "Seatizen block is waiting for super admin approval.";

        } else {

            // arrange block configuration
            $result = $this->block($object_id);

            if ($result) {
                $response["status"] = "success";
                $response["notification"] = "One item has been blocked.";
            } else {
                $response["status"] = "error";
                $response["notification"] = "Cannot block item";
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }


    /**
     * Block several item
     */
    public function ajax_block_several() {

        $response = array();

        $checked_object = json_decode($this->input->post("listCheckboxes"), true);
        $incomplete_action = false;



        // request for approval if not super admin
        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            // make notification for seatizen block operation.
            foreach($checked_object as $object_id) {

                // request for block this seatizen. (flag: not followed up yet)
                $notification = array(
                    "source" => $this->session->userdata("id"),
                    "destination" => NULL,
                    "type" => NOTIF_BLOCK_SEATIZEN,
                    "target" => $object_id,
                    "status" => false // haven't followed up yet
                );

                $this->generic->create($this->_notification_table, $notification);
            }

            $response["status"] = "success";
            $response["notification"] = "Seatizen block is waiting for super admin approval.";

        } else {

            // do not execute instructions if checked object contains no data.
            if (! empty($checked_object)) {

                foreach($checked_object as $object_id) {
                    $action_result = $this->block($object_id);

                    if (! $action_result) {
                        $incomplete_action = true;
                    }
                }
            }

            // message for incomplete block.
            if ($incomplete_action) {
                if (empty($checked_object)) {
                    $response["status"] = "error";
                    $response["notification"] = "Item cannot be blocked.";
                } else {
                    $response["status"] = "success";
                    $response["notification"] = "Some item cannot be blocked.";
                }
            } else { // message for complete delete.
                if (empty($checked_object)) {
                    $response["status"] = "error";
                    $response["notification"] = "There is no item to be blocked";
                } else {
                    $response["status"] = "success";
                    $response["notification"] = "Successfully block item";
                }
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }

    /**
     * Unblock item
     * @param $object_id
     * @return bool
     */
    private function unblock($object_id) {

        // arrange delete configuration
        $item_criteria = array("pelaut_id" => $object_id);
        $item_conf = array("activation" => "ACTIVE");

        $result = $this->generic->retrieve_one(
            $this->_primary_table,
            $item_criteria
        );

        $item_exist = false;

        if (! empty($result)) {

            $this->generic->update(
                $this->_primary_table,
                $item_conf,
                $item_criteria
            );

            $this->load->helper("notification");
            follow_up_request($object_id, NOTIF_UNBLOCK_SEATIZEN);

            $item_exist = true;
        }

        return $item_exist;

    }


    /**
     * Unblock just one item
     */
    public function ajax_unblock_one() {

        $response = array();
        $object_id = json_decode($this->input->post("id"));

        // request for approval if not super admin
        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            // make notification for seatizen block operation.

            // request for unblock this seatizen. (flag: not followed up yet)
            $notification = array(
                "source" => $this->session->userdata("id"),
                "destination" => NULL,
                "type" => NOTIF_UNBLOCK_SEATIZEN,
                "target" => $object_id,
                "status" => false // haven't followed up yet
            );

            $this->generic->create($this->_notification_table, $notification);

            $response["status"] = "success";
            $response["notification"] = "Seatizen unblock is waiting for super admin approval.";

        } else {
            // arrange unblock configuration
            $result = $this->unblock($object_id);

            if ($result) {
                $response["status"] = "success";
                $response["notification"] = "One item has been unblocked.";
            } else {
                $response["status"] = "error";
                $response["notification"] = "Cannot unblock item";
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }

    /**
     * Unblock several item
     */
    public function ajax_unblock_several() {

        $response = array();

        $checked_object = json_decode($this->input->post("listCheckboxes"), true);
        $incomplete_action = false;

        // request for approval if not super admin
        if ($this->session->userdata("role") != USER_SUPER_ADMIN) {

            // make notification for seatizen unblock operation.
            foreach($checked_object as $object_id) {

                // request for unblock this seatizen. (flag: not followed up yet)
                $notification = array(
                    "source" => $this->session->userdata("id"),
                    "destination" => NULL,
                    "type" => NOTIF_UNBLOCK_SEATIZEN,
                    "target" => $object_id,
                    "status" => false // haven't followed up yet
                );

                $this->generic->create($this->_notification_table, $notification);
            }

            $response["status"] = "success";
            $response["notification"] = "Seatizen unblock is waiting for super admin approval.";

        } else {

            // do not execute instructions if checked object contains no data.
            if (! empty($checked_object)) {
                foreach($checked_object as $object_id) {
                    $action_result = $this->unblock($object_id);

                    if (! $action_result) {
                        $incomplete_action = true;
                    }
                }
            }


            // message for incomplete block.
            if ($incomplete_action) {
                if (empty($checked_object)) {
                    $response["status"] = "error";
                    $response["notification"] = "Item cannot be unblocked.";
                } else {
                    $response["status"] = "success";
                    $response["notification"] = "Some item cannot be unblocked.";
                }
            } else { // message for complete delete.
                if (empty($checked_object)) {
                    $response["status"] = "error";
                    $response["notification"] = "There is no item to be unblocked";
                } else {
                    $response["status"] = "success";
                    $response["notification"] = "Successfully unblock selected item";
                }
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }
}

/* End of file admin.php */
/* Location: ./application/controllers/web/admin.php */