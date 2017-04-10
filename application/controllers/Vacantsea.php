<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * Class Vacantsea

 * Handle vacantsea operation.

 *

 * @author pulung

 * @copyright 2015 PT. Badr Interactive

 */



class Vacantsea extends CI_Controller {



    private $_primary_table = "vacantsea";

    private $_departement_table = "department";

    private $_company_table = "perusahaan";

    private $_rank_table = "rank";

    private $_ship_table = "ship";

    private $_ship_type_table = "ship_type";

    private $_nation_table = "nationality";

    private $_log_table = "log_vacantsea";



    private $_menu = MENU_VACANTSEA;



    private $_route = "vacantsea";

    private $_view_folder = "vacantsea";



    public function __construct($database_name = DB2_GROUP) {



        parent::__construct();

		

        check_auth();

        check_privileges($this->_menu);

		$this->_current_db = $this->load->database($database_name, TRUE);
		$this->db2 = $this->load->database(DB2_GROUP,TRUE);

		$this->load->model("vacantsea_model", "vacantsea");

		$this->load->model("seatizen_model");

		

		$this->load->model("vessel_model");

		$this->load->model("department_model");

		$this->load->model("nation_model");

		$this->load->model("rank_model");

		$this->load->model("Profile_resume_model");

		//$this->load->model("test_model");



    }





    /**

     * Show list page.

     */

    public function list_item() {

		

		$this->load->model("agentsea_model");

		

        set_page_title("Vacantsea Management");



        $this->session->set_userdata("sidebar_flag", $this->_menu);



        $data["base_url"] = base_url();

        $data["controller_name"] = $this->_route;

        $data["view_folder"] = $this->_view_folder;

        //$data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/list";

        $data["table_name"] = $this->_primary_table;



        $data["need_image_tools"] = false;

		

		$data["list_active"] = "active";

		$data["post_active"] = "";

		

		if($_GET["tab"] == "post")

		{

			$data["app_active"] = "";

			$data["list_active"] = "";

			$data["post_active"] = "active";

			$data["post_scrap_active"] = "";

		}

		else if($_GET["tab"] == "app")

		{

			$data["app_active"] = "active";

			$data["list_active"] = "";

			$data["post_active"] = "";

			$data["post_scrap_active"] = "";

		}

		else if($_GET["tab"] == "post_scrap")

		{

			$data["app_active"] = "";

			$data["list_active"] = "";

			$data["post_active"] = "";

			$data["post_scrap_active"] = "active";

		}

		else

		{

			$data["app_active"] = "";

			$data["list_active"] = "active";

			$data["post_active"] = "";

			$data["post_scrap_active"] = "";

		}

		

		

		$data["list_vacantsea"] = $this->vacantsea->list_vacantsea();

		$data["type_ship"] 	= $this->vessel_model->get_ship_type();

		//$data["ship"]	  	  = $this->vessel_model->get_ship();

		$data["department"]   = $this->department_model->get_department();

		//$data["rank"]	   	  = $this->rank_model->get_rank();

		$data["nationality"]  = $this->nation_model->get_nationality();

		

		$data["applicant_list"] = $this->vacantsea->applicant_list_all();



        $this->load->view($data["view_folder"] ."/item_list", $data);

    }



    /**

     * Return all item in specified table.

     */

    public function get_list_item_ajax() {



        $this->load->library("datatables");





        $edit_button_area = ", ".

            $this->_primary_table .".vacantsea_id AS log_link";



        // specify columns for datatables

        $this->datatables->select(

            $this->_primary_table .".vacantsea_id AS checkbox, ".

            $this->_primary_table .".vacantsea AS name, ".

            $this->_company_table .".nama_perusahaan AS company, ".

            $this->_departement_table .".department AS department, ".

            $this->_rank_table 	.".rank AS rank, ".

            $this->_primary_table .".create_date AS create_date, ".

            $this->_primary_table .".expired_date AS expired_date, ".

            $this->_primary_table .".annual_sallary AS salary, ".

            'COUNT('. $this->_log_table .'.vacantsea_id) AS view'.

            $edit_button_area

        );



        $this->datatables->from($this->_primary_table);



        $this->datatables->join(

            $this->_company_table,

            $this->_company_table .".id_perusahaan = ". $this->_primary_table .".id_perusahaan"

        );



        $this->datatables->join(

            $this->_departement_table,

            $this->_departement_table .".department_id = ". $this->_primary_table .".department"

        );



        $this->datatables->join(

            $this->_rank_table,

            $this->_rank_table .".rank_id = ". $this->_primary_table .".rank_id"

        );



        $this->datatables->join(

            $this->_log_table,

            $this->_log_table .".vacantsea_id = ". $this->_primary_table .".vacantsea_id",

            "left outer"

        );



        $this->datatables->group_by($this->_primary_table .".vacantsea_id");



        // modify first and last column for table bulk or individual operation.



        $checkbox = form_checkbox("list_checkboxes[]", "$1"); // create, bawaan codeigniter

		//$datep	= date_format_db("$1");

		

        $this->datatables->edit_column("checkbox", $checkbox, "checkbox");



        // link to log list

        $this->datatables->edit_column(

            "log_link",

            '<a href="'. base_url() .'vacantsea/viewer/$1">'.

            '<i class="fa fa-users"></i>' .

            '</a>',

            "log_link");

			

		//$this->datatables->edit_column("salary"," test","salary");

		

		//$this->datatables->edit_column('create_date',$datep,'create_date');



        $this->output->set_content_type("application/json");

        $this->output->set_status_header(200);

        $this->output->set_output($this->datatables->generate());

    }

    /**

     * Show item detail

     * @param $item_id

     */

    public function show_item_detail($item_id) {



        set_page_title("Vacantsea Detail");



        $this->session->set_userdata("sidebar_flag", $this->_menu);



        $item_detail = $this->generic->retrieve_one(

            $this->_primary_table, array("vacantsea_id" => $item_id));



        if (empty($item_detail)) {

            set_notification("Detail is not available.", NOTIF_ERROR);

            redirect($this->_route);

        }

		

        $company = $this->generic->retrieve_one(

           $this->_company_table, array("id_perusahaan" => $item_detail["id_perusahaan"]));



        $item_detail["company"] = "";
		$data_scrap = json_decode($item_detail["data_scrap"],TRUE);

        if ($item_detail["id_perusahaan"] != 0) {
            $item_detail["company"] = $company["nama_perusahaan"];
			$item_detail["url_source"] = "";
        }
		else
		{
			$item_detail["company"] = $item_detail["perusahaan"];	
			$item_detail["url_source"] = $data_scrap["url_source"];
		}


        $department = $this->generic->retrieve_one(

            $this->_departement_table, array("department_id" => $item_detail["department"]));

		

        $item_detail["department"] = "";

        if (! empty($department)) {

            $item_detail["department"] = $department["department_id"];

        }


        $rank = $this->generic->retrieve_one(

            $this->_rank_table, array("rank_id" => $item_detail["rank_id"]));



        $item_detail["rank"] = "";

        if (! empty($rank)) {

            $item_detail["rank"] = $rank["rank"];

        }

        $ship = $this->generic->retrieve_one(

            $this->_ship_table, array("ship_id" => $item_detail["ship"]));



        $item_detail["ship"] = "";

        if (! empty($ship)) {

            $item_detail["ship"] = $ship["ship_name"];

        }

        $ship_type = $this->generic->retrieve_one(

            $this->_ship_type_table, array("type_id" => $item_detail["ship_type"]));



        $item_detail["ship_type"] = "";

        if (! empty($ship_type)) {

            $item_detail["ship_type"] = $ship_type["ship_type"];

        }


        $nationality = $this->generic->retrieve_one(

            $this->_nation_table, array("id" => $item_detail["id_nationality"]));



        $item_detail["nationality"] = "";

        if (! empty($nationality)) {

            $item_detail["nationality"] = $nationality["name"];

        }



        $item_detail["total_viewer"] = $this->generic->get_total_rows(

            $this->_log_table, array("vacantsea_id" => $item_id));

			

		$item_detail["applicant_list"] = $this->vacantsea->applicant_list($item_detail["vacantsea_id"]); 

        $this->load->view($this->_view_folder ."/item_detail", $item_detail);

    }

	function get_company_byemail()
	{

		$this->load->model("company_model","cm"); 

		$key = $this->input->get("term");

		if(!empty($key))

		{

			$company = $this->cm->get_company_byemail($key);

		

			echo json_encode($company);

		}else { echo ""; }



	}

	function get_company_byname()
	{

		$this->load->model("company_model","cm"); 
		$key = $this->input->get("term");

		if(!empty($key))
		{
			$company = $this->cm->get_company_byemail($key);
			echo json_encode($company);

		}else { echo ""; }

	}

	function get_company_byusername(){

		$this->db = $this->load->database("infr6975_2015",TRUE);

		$this->load->model("company_model","cm");


		$key = $this->input->get("username");

		$company = $this->cm->get_company_byusername($key);

		echo json_encode($company);	

	}

	public function insert_vacantsea()
	{

		$this->db = $this->load->database("infr6975_2015",TRUE);

		$this->load->model("company_model","cm");

		$this->load->library("check_data");

		// POST

	

		// 	insert_company

		$create_date 	  = date('Y-m-d H:i:s');

		$ip_address	   = $this->input->ip_address();

		$user_agent	   = $this->input->user_agent();

		

		$company 		  = $this->input->post("company",true);

		$contact_person   = $this->input->post("contact_person",true);

		$email			= $this->input->post("email",true);

		$username		 = $this->input->post("username",true);

		$description	  = $this->input->post("description");

		

		//$dt_company	= $this->vacantsea_model->detail_agentsea($username);

		

		//	insert_vacantsea	

		$id 			   = $this->input->post("id",true);		

		$title			= $this->input->post('title',true);

		$detail		   = $this->input->post('detail',true);

		$nav_area		 = $this->input->post('nav_area',true);

		$ship_type 		= $this->input->post('ship_type',true);

		$ship_id		  = $this->input->post('ship_id',true);

		$department_id	= $this->input->post('department_id',true);

		$rank_id 		  = $this->input->post('rank_id',true);

		$sallary_curr 	 = $this->input->post('sallary_curr',true);

		$salary 		   = str_replace('.', '', $this->input->post('salary',true));

		$salary_type 	  = $this->input->post('salary_type',true);

		$contract_type	= $this->input->post('contract_type',true);

		$contract_dyn	 = $this->input->post('contract_dyn',true);

		$req_cert		 = $this->input->post('req_cert',true);

		$req_coc		  = $this->input->post('req_coc',true);

		$nationality_id   = $this->input->post('nationality_id',true);

		$expired_date	 = date('Y-m-d', strtotime($this->input->post('expired_date',true)));

		$benefits 		 = $this->input->post('benefits',true);

		$experience 	   = $this->input->post('experience',true);



		if ($expired_date =="1970-01-01" || $expired_date == "0000-00-00") {

			

			$expired_date 	= date('Y-m-d', strtotime('+7 days', strtotime($create_date))); // vacantsea free, default expired date 1 minggu

			

		}else{

			

			$expired_date 	= $expired_date;

		}



		$sess_admin_id = $this->session->userdata("id");

		

		$dt_vacantsea 	= array(

				

				'vacantsea'			=> isset($title) ? $title : '',

				'id_perusahaan'		=> isset($id) ? $id : '',

				'perusahaan'		   => isset($company) ? $company : '',

				'author' 			   => isset($id_agent) ? $id_agent : '',

				'description'		  => isset($detail) ? $detail : '',

				'department'		   => isset($department_id) ? $department_id : '',

				'rank_id'			  => isset($rank_id) ? $rank_id : '', 

				'ship_type' 		    => isset($ship_type) ? $ship_type : '',

				'navigation_area'	  => isset($nav_area) ? $nav_area : '',

				'annual_sallary'	   => isset($salary) ? $salary : '',

				'contract_type'		=> isset($contract_type) ? $contract_type : '',

				'contract_dynamic'	 => isset($contract_dyn) ? $contract_dyn : '',

				'ship'				 => isset($ship_id) ? $ship_id : '',

				'requested_certificates'		=> isset($req_cert) ? $req_cert : '',

				'requested_coc'		=> isset($req_coc) ? $req_coc : '',

				'id_nationality'	   => isset($nationality_id) ? $nationality_id : '',

				'create_date'		  => $create_date,

				

				'expired_date'		 => isset($expired_date) ? $expired_date : '',

				

				'benefits'			 => isset($benefits) ? $benefits : '',

				'sallary_range'		=> isset($salary_type) ? $salary_type : '',

				'sallary_curr'		 => isset($sallary_curr) ? $sallary_curr : '',

				'experience'		   => isset($experience) ? $experience : '',

				'stat' 				 => 'open', //sementara close	

				

				'admin_post'		   => $sess_admin_id //admin_post menandakan bahwa posting vacantsea berasal dari admin

		

		);

		

		$dt_company = array(

			

			"company" 		=> $company,

			"email"   		  => $email,

			"username"	   => $username,

			"contact_person" => $contact_person,

			"description"	=> $description,

			

			"ip_address"	 => $ip_address,

			"user_agent"	 => $user_agent,

			

			"admin_post"	 => $sess_admin_id //admin_post menandakan bahwa posting vacantsea berasal dari admin

		

		);

		

		$this->form_validation->set_rules('company','company','required');

		$this->form_validation->set_rules('contact_person','Contact Person','required');

		$this->form_validation->set_rules('email','Email','required|valid_email');

		//$this->form_validation->set_rules('description','Description','required');

		

		$this->form_validation->set_rules('title','Title','required');

		$this->form_validation->set_rules('detail','Detail','required');

		//$this->form_validation->set_rules('ship_type','Vessel Type','required');

		//$this->form_validation->set_rules('department_id','Department','required');

		//$this->form_validation->set_rules('rank_id','Rank','required');

		

		$check_email 	= $this->check_data->check_email_company($email);

		$check_username = $this->check_data->check_username_company($username);



		if ($this->form_validation->run() == FALSE ) {

			/* echo "<div class='alert alert-danger' role='alert'><i class='fa fa-warning'></i>

			* <b>Title </b> Required <br />

			* <b>Detail Vacantsea </b> Required <br />

			* <b>Vessel Type </b> Required <br />

			* <b>Department </b> Required <br />

			* <b>Rank </b> Required <br />

			</div>";*/

			//print_r($_POST);

			$err =  "<div class='alert alert-danger' role='alert'><i class='fa fa-warning'></i>";

			/* if(!empty($check_email))

			{

				echo "<div> Email has been used</div>";

			}

			if(!empty($check_username))

			{

				echo "<div> Username has been used</div>";

			} */

			$err .= validation_errors();

			$err .= "</div>";

			

			$result["msg"] = $err;

			$result["status"] = "error";



		}else{

			

			$this->load->library("my_email");

			

			// insert company, check berdasarkan email

			if(empty($check_email) /* || empty($check_username) */ )

			{

				// comment untuk sementara	

				$dt_cl = $this->cm->insert_company($dt_company);

				

				// insert vacantsea

				$dt_vacantsea["id_perusahaan"] = $dt_cl["id_perusahaan"];

				$this->db->insert('vacantsea', $dt_vacantsea);

				$vacantsea_id = $this->db->insert_id();

				

				// kirim email bahwa sudah terdaftar sebagai perusahaan

				// send email

				$str_url 	= "https://www.informasea.com/users/login/agentsea";

				

				$aaa = array(

				

					"id_perusahaan"=>$dt_cl["id_perusahaan"],

					"vacantsea_id"=>$vacantsea_id,

					"vacantsea"=>$dt_vacantsea,

					"company"=>$dt_company,

					"emali_to"=>$email,

					"username"=>$username,

					"email"=>$email,

					"password"=>$dt_cl["real_password"],

					"str_url"=>$str_url,

					"contact_person"=>$dt_company["contact_person"],

					

				);

									

				$content_template = $this->load->view("email_agentsea/registered-company",$aaa,true);

				$msg = "template_email2016/new_email_template";

				

				$dt_email   = array(

								"user_type"=>"agentsea",	

								"type"=>"agentsea",

								"content_template" => $content_template	

									

							  );

				

				$content 	= array(

					

					  "subject" 		=> "Informasea Company Account",

					  "subject_title"  => WEBSITE,

					  "to" 			 => array($email,"vacantsea@informasea.com","alhusna901@gmail.com"), 

					  "data" 		   => $dt_email,

					 

					  "message" 		=> $msg, // harus ada template nya 

					  "mv" 			 => TRUE,

					  "alt_message" 	=> $alt_msg, // harus ada template nya 

					  "amv" 		    => FALSE // untuk sementara ditiadakan

				

				);

				

				$user = "vacantsea";

				

				$this->my_email->send_email($user,$content);

				

			}

			else

			{

				if(!empty($check_email))

				{

					$dt_cl["id_perusahaan"] = $id; // id_perusahaan

				}

				

				/* if(!empty($check_username))

				{

					$dt_cl = $check_username["id_perusahaan"];

				}*/	

				

			}

			

			if(!empty($check_email))

			{

				// insert vacantsea

				$dt_vacantsea["id_perusahaan"] = $dt_cl["id_perusahaan"];

				$this->db->insert('vacantsea', $dt_vacantsea);

				$vacantsea_id = $this->db->insert_id();

			}

			

			// catat log vacantsea

			

			

			$result["msg"] = "<div class='alert alert-success' role='alert'><b>Well Done!</b> add vacantsea success</div>";

			$result["status"] = "success";

			

			// jumlah vacantsea

			/* $jml = $this->vacantsea_model->get_jml_vacantsea_day($id);

			

			if($jml['enable'] == TRUE)

			{

				$dtDepartemen = $this->vacantsea_model->GetDepartment("where department_id = '$department_id'")->row_array();

				$dtRank = $this->vacantsea_model->GetRank("where rank_id = '$rank_id'")->row_array();



				$this->load->helper("tracker");

				$aksi = "Pengguna menambahkan data Vacantsea (Lowongan Kerja) : $title untuk departemen $dtDepartemen[departemen] dengan rank $dtRank[rank]";

				track_manager_agent($aksi);

				

				$this->db->insert('vacantsea', $data);

				echo "<div class='alert alert-success' role='alert'><b>Well Done!</b> add vacantsea success</div>";

				

			}

			else

			{

				echo "<div class='alert alert-danger' role='alert'>

					<b> Total Vacantsea reach limit for this day </b><br>";

					//print_r($jml['dt']);

				echo "<span> Vacantsea you can post for this day only 6 posts . </span>

				</div>";

			}*/ 

			

		}

		

		echo json_encode($result);



	

		

	}
	
	// SCRAP
	function update_vacantsea_scrap_modal()
	{
		//error_reporting(E_ALL);

		$is_ajax = $this->input->is_ajax_request();

		if(!$is_ajax)
		{

			show_404();

			exit;	

		}

		$vacantsea_id = $this->input->post("vacantsea_id");

		
		$data["vacantsea_edit"]  = $this->vacantsea->vacantsea_detail($vacantsea_id);
		$data["company"]		 = json_decode($data["vacantsea_edit"]["data_scrap"],TRUE); 
		 
		$data['ship'] 			= $this->vessel_model->get_ship();
		$data['department']  	  = $this->department_model->get_department();
		$data['rank'] 			= $this->rank_model->get_rank_bydept($data['vacantsea_edit']['department']);
		$data['nationality'] 	 = $this->nation_model->get_nationality();
		$data['type_ship']	   = $this->vessel_model->get_ship_type(); 
		$data['sallary_type']    = substr($data['vacantsea_edit']['annual_sallary'],-5);

		  	
		$this->load->view("vacantsea/update_vacantsea_scrap_modal",$data);
	}
	
	function delete_vacantsea_modal()   // delete
	{
		$is_ajax = $this->input->is_ajax_request();
		if(!$is_ajax)
		{
			show_404();
			exit;
		}
		
		$vacantsea_id = $this->input->post("vacantsea_id");
		
		$data["vacantsea"]	= $this->vacantsea->vacantsea_detail($vacantsea_id);

		$this->load->view("vacantsea/vacantsea_delete_modal",$data);

	}
	
	public function vacantsea_delete_process()
	{
		$id_vacantsea = $this->input->post("id_vacantsea");
		
		$str = "DELETE FROM vacantsea WHERE vacantsea_id = '$id_vacantsea' ";
		$q   = $this->db2->query($str);	
		
		$result["status"] = "success";
		$result["message"] = "<div class='alert alert-success' role='alert'><b>Well Done!</b> Delete vacantsea success</div>";
		$result["message"] .= "<script> setTimeout(function() { location.reload(); }, 3000); </script>";		

		echo json_encode($result);
		
	}
	
	public function insert_scrap_vacantsea()
	{
		
		$this->db = $this->load->database("infr6975_2015",TRUE);
		$this->load->model("company_model","cm");
		$this->load->library("check_data");

		// POST
		// 	insert_company

		$create_date 	  = date('Y-m-d H:i:s');
		$ip_address	   = $this->input->ip_address();
		$user_agent	   = $this->input->user_agent();
		
		// semua data ini disimpan kedalam field scrap. 
		// yang isinya dalam bentuk JSON
		$company 		  = $this->input->post("company",true);
		$username		 = $this->input->post("username",true);
		$contact_person   = $this->input->post("contact_person",true);
		$website		  = $this->input->post("website",true);
		$email			= $this->input->post("email",true);
		$no_telp	   	  = $this->input->post("no_telp",true);
		$url_source 	   = $this->input->post("url_source",true);
		
		//	insert_vacantsea

		$title			= $this->input->post('title',true);
		$detail		   = $this->input->post('detail',true);
		$nav_area		 = $this->input->post('nav_area',true);
		$ship_type 		= $this->input->post('ship_type',true);
		$ship_id		  = $this->input->post('ship_id',true);
		$department_id	= $this->input->post('department_id',true);
		$rank_id 		  = $this->input->post('rank_id',true);
		$sallary_curr 	 = $this->input->post('sallary_curr',true);
		$salary 		   = str_replace('.', '', $this->input->post('salary',true));
		$salary_type 	  = $this->input->post('salary_type',true);
		$contract_type	= $this->input->post('contract_type',true);
		$contract_dyn	 = $this->input->post('contract_dyn',true);
		$req_cert		 = $this->input->post('req_cert',true);
		$req_coc		  = $this->input->post('req_coc',true);
		$nationality_id   = $this->input->post('nationality_id',true);
		$expired_date	 = date('Y-m-d', strtotime($this->input->post('expired_date',true)));
		$benefits 		 = $this->input->post('benefits',true);
		$experience 	   = $this->input->post('experience',true);
		$description	  = $this->input->post("description",TRUE);

		
		
		if ($expired_date =="1970-01-01" || $expired_date == "0000-00-00") {	

			$expired_date 	= date('Y-m-d', strtotime('+7 days', strtotime($create_date))); // vacantsea free, default expired date 1 minggu

		}else{
			$expired_date 	= $expired_date;
		}

		$sess_admin_id = $this->session->userdata("id");
		
		$dt_company = array(

			"company" 		=> $company,
			"username"	   => $username,
			"contact_person" => $contact_person,
			"website"   		=> $website,
			"email"   		  => $email,
			"no_telp"   		=> $no_telp,
			"url_source"	 => $url_source

		);
		
		// kalau terisi menandakan vacantsea ini hasil scrapping 
		$data_scrap = json_encode($dt_company);
		
		$dt_vacantsea 	= array(

			'vacantsea'			  => isset($title) ? $title : '',
			//'id_perusahaan'		 => isset($id) ? $id : '',
			'perusahaan'		     => isset($company) ? $company : '',
			'author' 			     => isset($id_agent) ? $id_agent : '',
			'description'		    => isset($detail) ? $detail : '',
			'department'		     => isset($department_id) ? $department_id : '',
			'rank_id'			    => isset($rank_id) ? $rank_id : '', 
			'ship_type' 		      => isset($ship_type) ? $ship_type : '',
			'navigation_area'	    => isset($nav_area) ? $nav_area : '',
			'annual_sallary'	     => isset($salary) ? $salary : '',
			'contract_type'		  => isset($contract_type) ? $contract_type : '',
			'contract_dynamic'	   => isset($contract_dyn) ? $contract_dyn : '',
			'ship'				   => isset($ship_id) ? $ship_id : '',
			'requested_certificates' => isset($req_cert) ? $req_cert : '',
			'requested_coc'		  => isset($req_coc) ? $req_coc : '',
			'id_nationality'	     => isset($nationality_id) ? $nationality_id : '',
			'create_date'		    => $create_date,
			'expired_date'		   => isset($expired_date) ? $expired_date : '',
			'benefits'			   => isset($benefits) ? $benefits : '',
			'sallary_range'		  => isset($salary_type) ? $salary_type : '',
			'sallary_curr'		   => isset($sallary_curr) ? $sallary_curr : '',
			'experience'		     => isset($experience) ? $experience : '',
			'stat' 				   => 'open', //sementara close	
			'admin_post'		     => $sess_admin_id, //admin_post menandakan bahwa posting vacantsea berasal dari admin.
			"data_scrap"		     => $data_scrap

		);
		
		$this->form_validation->set_rules('company','company','required');
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('website','website','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		//$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('detail','Detail','required');

		//$this->form_validation->set_rules('ship_type','Vessel Type','required');
		//$this->form_validation->set_rules('department_id','Department','required');
		//$this->form_validation->set_rules('rank_id','Rank','required');
		//$check_email 	= $this->check_data->check_email_company($email);
		//$check_username = $this->check_data->check_username_company($username);

		
		if ($this->form_validation->run() == FALSE ) {
			
			$err =  "<div class='alert alert-danger' role='alert'><i class='fa fa-warning'></i>";
			$err .= validation_errors();
			$err .= "</div>";
			$result["msg"] = $err;
			$result["status"] = "error";

		}else{

			$this->load->library("my_email");
			$this->db->insert('vacantsea', $dt_vacantsea);
			$vacantsea_id = $this->db->insert_id();

			$result["msg"] = "<div class='alert alert-success' role='alert'><b>Well Done!</b> add vacantsea success</div>";
			$result["status"] = "success";

			

		}	

		echo json_encode($result);

	}
	
	public function update_scrap_vacantsea_process()
	{
		
		$this->db = $this->load->database("infr6975_2015",TRUE);
		$this->load->model("company_model","cm");
		$this->load->library("check_data");

		// POST
		// 	insert_company

		$create_date 	  = date('Y-m-d H:i:s');
		$ip_address	   = $this->input->ip_address();
		$user_agent	   = $this->input->user_agent();
		
		// semua data ini disimpan kedalam field scrap. 
		// yang isinya dalam bentuk JSON
		$company 		  = $this->input->post("company",true);
		$username		 = $this->input->post("username",true);
		$contact_person   = $this->input->post("contact_person",true);
		$website		  = $this->input->post("website",true);
		$email			= $this->input->post("email",true);
		$no_telp	   	  = $this->input->post("no_telp",true);
		$url_source 	   = $this->input->post("url_source",true);
		
		//	insert_vacantsea
		$vacantsea_id	 = $this->input->post("vacantsea_id",TRUE);
		$title			= $this->input->post('title',true);
		$detail		   = $this->input->post('detail',true);
		$nav_area		 = $this->input->post('nav_area',true);
		$ship_type 		= $this->input->post('ship_type',true);
		$ship_id		  = $this->input->post('ship_id',true);
		$department_id	= $this->input->post('department_id',true);
		$rank_id 		  = $this->input->post('rank_id',true);
		$sallary_curr 	 = $this->input->post('sallary_curr',true);
		$salary 		   = str_replace('.', '', $this->input->post('salary',true));
		$salary_type 	  = $this->input->post('salary_type',true);
		$contract_type	= $this->input->post('contract_type',true);
		$contract_dyn	 = $this->input->post('contract_dyn',true);
		$req_cert		 = $this->input->post('req_cert',true);
		$req_coc		  = $this->input->post('req_coc',true);
		$nationality_id   = $this->input->post('nationality_id',true);
		$expired_date	 = date('Y-m-d', strtotime($this->input->post('expired_date',true)));
		$benefits 		 = $this->input->post('benefits',true);
		$experience 	   = $this->input->post('experience',true);
		$description	  = $this->input->post("description",TRUE);

		
		
		if ($expired_date =="1970-01-01" || $expired_date == "0000-00-00") {	

			$expired_date 	= date('Y-m-d', strtotime('+7 days', strtotime($create_date))); // vacantsea free, default expired date 1 minggu

		}else{
			$expired_date 	= $expired_date;
		}

		$sess_admin_id = $this->session->userdata("id");
		
		$dt_company = array(

			"company" 		=> $company,
			"username"	   => $username,
			"contact_person" => $contact_person,
			"website"   		=> $website,
			"email"   		  => $email,
			"no_telp"   		=> $no_telp,
			"url_source"	 => $url_source

		);
		
		// kalau terisi menandakan vacantsea ini hasil scrapping 
		$data_scrap = json_encode($dt_company);
		
		$dt_vacantsea 	= array(

			'vacantsea'			  => isset($title) ? $title : '',
			//'id_perusahaan'		 => isset($id) ? $id : '',
			'perusahaan'		     => isset($company) ? $company : '',
			'author' 			     => isset($id_agent) ? $id_agent : '',
			'description'		    => isset($detail) ? $detail : '',
			'department'		     => isset($department_id) ? $department_id : '',
			'rank_id'			    => isset($rank_id) ? $rank_id : '', 
			'ship_type' 		      => isset($ship_type) ? $ship_type : '',
			'navigation_area'	    => isset($nav_area) ? $nav_area : '',
			'annual_sallary'	     => isset($salary) ? $salary : '',
			'contract_type'		  => isset($contract_type) ? $contract_type : '',
			'contract_dynamic'	   => isset($contract_dyn) ? $contract_dyn : '',
			'ship'				   => isset($ship_id) ? $ship_id : '',
			'requested_certificates' => isset($req_cert) ? $req_cert : '',
			'requested_coc'		  => isset($req_coc) ? $req_coc : '',
			'id_nationality'	     => isset($nationality_id) ? $nationality_id : '',
			'create_date'		    => $create_date,
			'expired_date'		   => isset($expired_date) ? $expired_date : '',
			'benefits'			   => isset($benefits) ? $benefits : '',
			'sallary_range'		  => isset($salary_type) ? $salary_type : '',
			'sallary_curr'		   => isset($sallary_curr) ? $sallary_curr : '',
			'experience'		     => isset($experience) ? $experience : '',
			'stat' 				   => 'open', //sementara close	
			'admin_post'		     => $sess_admin_id, //admin_post menandakan bahwa posting vacantsea berasal dari admin.
			"data_scrap"		     => $data_scrap

		);
		
		$this->form_validation->set_rules('company','company','required');
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('website','website','required');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		//$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('title','Title','required');
		$this->form_validation->set_rules('detail','Detail','required');

		//$this->form_validation->set_rules('ship_type','Vessel Type','required');
		//$this->form_validation->set_rules('department_id','Department','required');
		//$this->form_validation->set_rules('rank_id','Rank','required');
		//$check_email 	= $this->check_data->check_email_company($email);
		//$check_username = $this->check_data->check_username_company($username);

		
		if ($this->form_validation->run() == FALSE ) {
			
			$err =  "<div class='alert alert-danger' role='alert'><i class='fa fa-warning'></i>";
			$err .= validation_errors();
			$err .= "</div>";
			$result["msg"] = $err;
			$result["status"] = "error";

		}else{

			$this->load->library("my_email");
			
			$this->db->where('vacantsea_id', $vacantsea_id);
			$this->db->update('vacantsea', $dt_vacantsea);

			$result["msg"] = "<div class='alert alert-success' role='alert'><b>Well Done!</b> Update vacantsea success</div>";
			$result["status"] = "success";

		}	

		echo json_encode($result);
	}

	

	function modal()
	{

		$x = $this->input->post("x");

		if($x == 1)

		{

			

			$modal_type = $this->input->post("modal");//echo $modal_type;exit;

			

			if($modal_type == "edit_modal")	//edit tab1
			{

				$data["vacantsea_edit"]		= $this->vacantsea_model->get_vacantsea_tr();
				$data['ship'] 			= $this->ship_model->get_all_ship();
				$data['department']  	= $this->department_model->all_department();
				$data['rank'] 			= $this->rank_model->call_rank($data['vacantsea_edit']['department']);
				$data['nationality'] 	= $this->vacantsea_model->call_nationality();
				$data['type_ship']		= $this->vacantsea_model->GetShipType();   				
				$data['sallary_type'] = substr($data['vacantsea_edit']['annual_sallary'],-5);


				$type_user = $this->type_user; //cek type user



				if ($type_user == "company") {

					

					$id_perusahaan 			= $this->session->userdata('id_perusahaan');

					$company 				= $this->company_model->get_company($id_perusahaan);

					echo $company['account_type'];

					if ($company['account_type'] == "Premium") {

						$this->load->view('edit_modal', $data);  //Edit vacantsea premium

		

					}elseif ($company['account_type'] == "Free") {

						$this->load->view("edit_modal_free",$data); //edit vacantsea free				

					}



				}elseif ($type_user == "agent") {

					

					$id_perusahaan 		= $this->session->userdata('id_perusahaan_agent');

					$company 			= $this->vacantsea_model->cek_account_agent("where a1.id_perusahaan='$id_perusahaan'")->row_array();



					if ($company['account_type'] == "Premium") {

						$this->load->view('edit_modal', $data);  //Edit vacantsea premium



					}else{

						$this->load->view("edit_modal_free",$data); //edit vacantsea free				

					}



				}

				

			} 
			

			

		} //end if	

	}

	

	function update_modal()
	{

		error_reporting(E_ALL);

		$is_ajax = $this->input->is_ajax_request();

		if(!$is_ajax)
		{

			show_404();

			exit;	

		}

		

		$vacantsea_id = $this->input->post("vacantsea_id");


		$data["vacantsea_edit"] = $this->vacantsea->vacantsea_detail($vacantsea_id);
		$data['ship'] 			= $this->vessel_model->get_ship();
		$data['department']  	= $this->department_model->get_department();
		$data['rank'] 			= $this->rank_model->get_rank_bydept($data['vacantsea_edit']['department']);
		$data['nationality'] 	 = $this->nation_model->get_nationality();
		$data['type_ship']	   = $this->vessel_model->get_ship_type(); 
		$data['sallary_type']    = substr($data['vacantsea_edit']['annual_sallary'],-5);

		  	
		$this->load->view("vacantsea/update_vacantsea_modal",$data);

	}

	

	function update_process()

	{

		$this->db = $this->load->database("infr6975_2015",TRUE);

		

		$this->load->library("form_validation");

		

		$this->load->model("company_model");

		

		$id 			  = $this->input->post("id_perusahaan");

		

		$dt_perusahaan 	= $this->company_model->get_detail_company($id);

		$perusahaan 	  = $dt_perusahaan['nama_perusahaan'];

		

		$vacantsea_id 	= $this->input->post('vacantsea_id');

		$title		   = $this->input->post('title');

		$detail		  = $this->input->post('detail');

		$nav_area		= $this->input->post('nav_area');

		$ship_type 	   = $this->input->post('ship_type');

		$ship_id		 = $this->input->post('ship_id');

		$department_id   = $this->input->post('department_id');

		$rank_id 		 = $this->input->post('rank_id');

		$sallary_curr 	= $this->input->post('salary_curr');

		$salary 		  = $this->input->post('salary');

		$salary_type 	 = $this->input->post('salary_type');

		$exp_date 		= $this->input->post('expired_date');

		// $contract_type	= $this->input->post('contract_type');

		$contract_dyn	= $this->input->post('contract_dyn');

		$benefits 		= $this->input->post('benefits');

		$req_cert		= $this->input->post('req_cert');

		$req_coc		 = $this->input->post('req_coc');

		$nationality_id  = $this->input->post('nationality_id');

		$experience 	  = $this->input->post('experience');

		

		$this->form_validation->set_rules("title","Vacantsea Title","required|trim");

		$this->form_validation->set_rules("detail","Detail","required|trim");

		$this->form_validation->set_rules("department_id","Department","required|trim");

		$this->form_validation->set_rules("rank_id","Rank","required|trim");

		$this->form_validation->set_rules("expired_date","Expired Date","required|trim");

		$this->form_validation->set_rules("ship_type","Ship type","required|trim");

		

		if($this->form_validation->run() == true){ 

		

		  $data 	= array(

		  

			'vacantsea'			   => isset($title) ? $title : '',

			'id_perusahaan'		   => isset($id) ? $id : '',

			'perusahaan'		   	  => isset($perusahaan) ? $perusahaan : '',

			'description'		  	 => isset($detail) ? $detail : '',

			'department'		   	  => isset($department_id) ? $department_id : '',

			'rank_id'			  	 => isset($rank_id) ? $rank_id : '', 

			'ship_type' 		       => isset($ship_type) ? $ship_type : '',

			'navigation_area'	  	 => isset($nav_area) ? $nav_area : '',

			'annual_sallary'	   	  => isset($salary) ? $salary : '',

			//'contract_type'	   	  => isset($contract_type) ? $contract_type : '',

			'contract_dynamic'	 	=> isset($contract_dyn) ? $contract_dyn : '',

			'ship'				 	=> isset($ship_id) ? $ship_id : '',

			'requested_certificates'  => isset($req_cert) ? $req_cert : '',

			'requested_coc'		   => isset($req_coc) ? $req_coc : '',

			'id_nationality'	  	  => isset($nationality_id) ? $nationality_id : '',

			'expired_date'		 	=> isset($exp_date) ? $exp_date : '',

			'benefits'			 	=> isset($benefits) ? $benefits : '',

			'sallary_range'		   => isset($salary_type) ? $salary_type : '',

			'sallary_curr'			=> isset($sallary_curr) ? $sallary_curr : '',

			'experience'		   	  => isset($experience) ? $experience : ''

				  

		  );

		  

		  $where = array('vacantsea_id' => $vacantsea_id);

  

  

		  /* $this->load->helper("change_column");

		  $kolom_yang_berubah = changed_column("vacantsea", $pk, $data_baru);*/

		  $this->db->update('vacantsea', $data, $where);

		  

		  $result["status"] = "success";

		  $result["message"] = "<div class='alert alert-success'> success </div>";


		} 

		else

		{

		  $result["status"] = "error";

		  $result["message"] = "<div class='alert alert-danger'>".validation_errors()."</div>";	

				

		}

		

		echo json_encode($result);

		/* $this->load->helper("tracker");

		$aksi = "Pengguna melakukan perubahan data Vacantsea (Lowongan Kerja) $title ($vacantsea_id) pada kolom $kolom_yang_berubah";

		track_manager_agent($aksi);*/

		// $data 	= array(

		// 	'agentsea_id' 	=> $id,

		// 	'action' 		=> "id=$vacantsea_id&title=$title&action=update&page=vacantsea",

		// 	'action_time' 	=> date('Y-m-d H:i:s'),

		// 	'username'		=> $usernamenya,

		// 	'url'			=> base_url('vacantsea/update_process'),

		// 	'nama' 			=> $dtperusahaan['contact_person'],

		// 	'ip_address'	=> $this->session->userdata("ip_address"),

		// 	'user_agent'	=> $this->session->userdata("user_agent"),

		// 	'session_id'	=> $this->session->userdata("session_id")

		// );



		// $this->db->insert("log_agentsea", $data);

		

	}

	

	function delete_process()

	{

		return $this->vacantsea_model->del_vacantsea_process();

	}

	

	function get_vacantsea_company()

	{

		

		

	}

	

	function get_applicant_vacantsea($id_vacantsea)

	{

		

		

	}



}



/* End of file admin.php */

/* Location: ./application/controllers/web/admin.php */