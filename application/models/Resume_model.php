<?php if(!defined('BASEPATH')) exit ('no direct script access allowed');

class resume_model extends CI_Model{
	private $db2 = null;
	function __construct()
		{
			$this->db2 = $this->load->database(DB2_GROUP,TRUE);	
		}	

	function get_resume($pelaut_id = "")
	{
		
		if($pelaut_id == "")
		{
			$pelaut_id = $this->input->post("pelaut_id");	
		}
			
		$this->load->model('competency_model');
		$this->load->model('proficiency_model');
		$this->load->model('experience_model');
		$this->load->model('document_model');
		//$pelaut_id = $this->uri->segment(2);<br />
	
		$pl = "SELECT * from pelaut_ms where pelaut_id = '$pelaut_id' ";
		$qpl = $this->db2->query($pl);
		$fpl = $qpl->row_array();
		
		$sp = "SELECT * from profile_resume_tr where pelaut_id = '$pelaut_id' ";
		$qp = $this->db2->query($sp);
		$fp = $qp->row_array();
		
		// print_r($fp);

		$username = $fpl['username'];
		$f_competency_tr = $this->competency_model->get_competency_pelaut($username);
		
		$f_document_tr = $this->document_model->get_document_pelaut($username);		
		
		$f_proficiency_tr = $this->proficiency_model->get_proficiency_pelaut($username);
		
		$f_experience = $this->experience_model->get_experience_pelaut($username);
		
		$f_medical_tr = $this->document_model->get_document_medical($username);

		$f_visa_tr = $this->document_model->get_document_visa($username);
		

		$arr_resume = array('profile'=>$fp,
		'pelaut'=>$fpl,
		'competency'=>$f_competency_tr,
		'proficiency'=>$f_proficiency_tr,
		'experience'=>$f_experience,
		'document'=>$f_document_tr,
		'medical' =>$f_medical_tr,
		'visa' => $f_visa_tr);
		
		return $arr_resume;

	}
	
	/*
	 ADA di module vacantsea
	function get_department()
	{
		$str = "select * from department";
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;	
		
	}*/
	
	function get_profile_resume($pelaut_id)
	{
	    $sp = "SELECT * from profile_resume_tr where pelaut_id = '$pelaut_id' ";
		$qp = $this->db2->query($sp);
		$fp = $qp->row_array();
		
		return $fp;
		
	}
	function get_pelaut_ms($pelaut_id){
		
		$sp = "SELECT * from pelaut_ms where pelaut_id = '$pelaut_id' ";
		$qp = $this->db2->query($sp);
		$fp = $qp->row_array();

		return $fp;
	}

	function get_detail_pelaut($username){
		$str = "SELECT * FROM pelaut_ms WHERE username = '$username'";
		$f = $this->db2->query($str);
		$q = $f->row_array();
		return $q;
	}
	
	function get_coc_class() // punya model sendiri coc_model
	{
		$str 	= "select * from coc_class ";
		$q 	  = $this->db2->query($str);
		$f 	  = $q->result_array();
		
		return $f;  	
	}
	
	/* Rank Numpang */
	
	function get_rank() // punya Model sendiri bernama rank_model
	{
		// harus berdasarkan
		$str = "select * from rank";	
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;
	}
	
	function get_rank_detail($rank_id) // punya Model sendiri bernama rank_model
	{
		$str = "select * from rank where rank_id = $rank_id";
		$q   = $this->db2->query($str);
		$f   = $q->row_array($str);
		
		return $f; 	
		
	}
	
	/* ==== end rank ==== */ 
	
	
	/*resume upload */
	function list_upload_resume($id_pelaut= "")
	{
		$str = "select * from resume_file where id_pelaut = '$id_pelaut' ";
		$q = $this->db2->query($str);
		$f = $q->result_array();
		return $f;
		
	}

	function list_upload_resume_by_username($username){
$str = "SELECT * FROM pelaut_ms WHERE username = '$username'";
$q = $this->db2->query($str);
$f = $q->row_array();
		
	$id_pelaut = $f['pelaut_id'];

	$str2 = "SELECT * FROM resume_file WHERE id_pelaut = '$id_pelaut'";
	$q2 = $this->db2->query($str2);
	$f2 = $q2->result_array();

	return $f2;

}

	function detail_upload_resume($id_pelaut = ''){
		
		$str = "SELECT * FROM resume_file WHERE id_resume_file = '$id_pelaut'";
		$q = $this->db2->query($str);
		$f = $q->row_array();
		return $f;
	}
	
	function last_file_resume($id_pelaut = '')
	{
		$id_pelaut = $this->session->userdata('id_user');
		
		$str = "select * from resume_file where id_pelaut = '$id_pelaut' order by `datetime` DESC LIMIT 1";
		$q = $this->db2->query($str);
		$f = $q->row_array();
		
		return $f;
			
	}
	
	function update_cover_letter_process()

	{

		$this->load->library("form_validation");	

		$pelaut_id 	= $this->input->post("pelaut_id");

		$cover_letter2 = htmlspecialchars($this->input->post("cover_letter"),ENT_QUOTES); 
		$cover_letter3 = htmlentities($cover_letter2); 
		$cover_letter  = $cover_letter3;//strip_tags($cover_letter3);
		
		//echo $cover_letter ; exit;
		
		$this->form_validation->set_rules("cover_letter","Cover Letter","required");

		if($this->form_validation->run() == TRUE)

		{

			$str = "UPDATE profile_resume_tr SET cover_letter = '$cover_letter' WHERE pelaut_id = '$pelaut_id' ";

			

			$q = $this->db2->query($str);

			

			$data["message"]  = "<div class='alert alert-success'> Cover Letter has Successfully Changed</div> ";
			$data["message"] .= "<script>setInterval(function(){ location.reload(); }, 3000);</script>";

		  	$data["type"]     = "success";	

		}

		else

		{

			$data["message"] = "<div class='alert alert-danger'>".validation_errors()."</div>";

			$data["type"]    = "error";

		}

		

		echo json_encode($data);

	}

	
	function update_describe_process()

	{

		$this->load->library("form_validation");	

		

		$pelaut_id 	= $this->input->post("pelaut_id");

		$describe 	 = $this->input->post("describe",TRUE);

		

		$this->form_validation->set_rules("describe","Describe","required");

		

		if($this->form_validation->run() == TRUE)

		{

			$str = "UPDATE profile_resume_tr SET `describe` = '$describe' WHERE pelaut_id = '$pelaut_id' ";

			$q = $this->db2->query($str);

			

			$data["message"]  = "<div class='alert alert-success'>Describe has Successfully Changed</div> ";

			$data["message"] .= "<script>setInterval(function(){ location.reload(); }, 3000);</script>"; 

		  	$data["type"]     = "success";	

		}

		else

		{

			$data["message"] = "<div class='alert alert-danger'>".validation_errors()."</div>";

			$data["type"]    = "error";

		}

		

		echo json_encode($data);

	}
	
	function add_file_resume($id_pelaut = "",$dt_resume)
	{
		
		$this->load->library("form_validation");	

		$title = explode(".",$dt_resume['file_name']);
		$title = $title[0];		
		//$title	 	 = $this->input->post("title");
		$file_name 	 = $dt_resume['file_name'];
		$file_size 	 = $dt_resume['file_size'];
		$file_type 	 = $dt_resume['file_type'];
		
		$ip_address	= $_SERVER['REMOTE_ADDR'];
		
		
		$str 	 = "insert into resume_file set		  ";
		$str	.= "file_name		= 		'$file_name' ,";
		$str	.= "file_size		= 		'$file_size' ,";
		$str	.= "file_type		= 		'$file_type' ,";
		$str	.= "title			= 		'$title' 	 ,";
		$str	.= "id_pelaut		= 		'$id_pelaut' ,";
		$str	.= "ip_address		= 		'$ip_address',";
		$str	.= "datetime		= 		now()		  ";
		
		//echo $str; exit;
		
		$q = $this->db2->query($str);
		//$f = $q->result_array();
		 
	}

	function jumlah_apply($id_pelaut){
		
		$str = "SELECT * FROM applicant_tr WHERE id_pelaut = '$id_pelaut'";
		$q = $this->db2->query($str);
		$f = $q->num_rows();
		return $f;
	}
	/*end resume upload */
	
	function kepelautan_edit_process()
	{
		$this->load->model('coc_model');
		$this->load->library('form_validation');
		
		$pelaut_id = $this->input->post("pelaut_id");
		
		$ecs  			   = $this->input->post("exp_sallary_curr",true);
		$expected_sallary  = $this->input->post("expected_sallary",true);
		$sallary_range	 = $this->input->post("sallary_range",true);
		
		$vessel_type	   = $this->input->post("vessel_type",true);
		$department		= $this->input->post("department",true);
		$coc_class		 = $this->input->post("coc_class",true);
		$rank			  = $this->input->post("rank",true);
		$last_education    = $this->input->post("last_education",true);
		
		$this->form_validation->set_rules("department","Department","required");
		$this->form_validation->set_rules("rank","Rank","required");
		
		// $this->form_validation->set_rules("exp_sallary_curr","Currency",'required');
		$this->form_validation->set_rules("expected_sallary","Expected Sallary",'numeric');
		
		$this->form_validation->set_rules("place_birth","Place of Birth",'alpha');
		// $this->form_validation->set_rules("date_birth","Date of Birth",'');
		// $this->form_validation->set_rules("address","Address",'');
		
		//print_r($_POST); exit;
		
		if($this->form_validation->run() == TRUE)
		{
		  $str_check = "select * from profile_resume_tr where pelaut_id = '$pelaut_id' ";
		  $qc = $this->db2->query($str_check);
		  $fc = $qc->row_array();
		  
		  if(!empty($fc))
		  {
			$str  = " update profile_resume_tr set 				  ";
			
			$str .= " vessel_type			= '$vessel_type'	 ,";
			$str .= " department			= '$department'		 ,";
			$str .= " coc_class				= '$coc_class'		 ,";
			$str .= " rank					= '$rank'		     ,";
			$str .= " exp_sallary_curr		= '$ecs'			 ,";
			$str .= " expected_sallary		= '$expected_sallary',";
			$str .= " last_education		= '$last_education'	 ,";
			$str .= " last_update			= now()				 ,";
			$str .= " sallary_range			= '$sallary_range'	  ";
			
			$str .= " where pelaut_id 		= '$pelaut_id'		  ";	
			
			// COMPETENCY , mainkaan
			// $this->db->query($str);
			$coc = $this->coc_model->get_coc_detail($coc_class);
			
			// delete terlebih dahulu type COC yang ada di competency
			$str_delete 	= "delete from competency_tr where type = 'coc' and pelaut_id = '$pelaut_id' ";
			$q_delete_com  = $this->db2->query($str_delete);
		
			// add lagi datanya sesuai dengan COC class yang dipilih
			$str_incom  = "insert into competency_tr set 		 ";
			$str_incom .= "grade_license 	= '$coc[coc_class]'	,";
			$str_incom .= "pelaut_id 		= '$pelaut_id'		,";  
			$str_incom .= "last_update	= now() 			,"; 
			$str_incom .= "type			= 'coc' 			 "; 
			$qin_com =  $this->db2->query($str_incom); 
			
			$coe = "Certificate of Endorsement";
			
			$str_incom  = "insert into competency_tr set 		 ";
			$str_incom .= "grade_license 	= '$coe'			,";
			$str_incom .= "pelaut_id 		= '$pelaut_id'		,";  
			$str_incom .= "last_update	= now() 			,"; 
			$str_incom .= "type			= 'coc' 			 "; 
			$qin_com =  $this->db2->query($str_incom); 			
			
		  }
		  else
		  {
			$str  = " insert into profile_resume_tr set 		  ";
			
			$str .= " vessel_type			= '$vessel_type'	 ,";
			$str .= " department			= '$department'		 ,";
			$str .= " coc_class				= '$coc_class'		 ,";
			$str .= " rank					= '$rank'		     ,";
			$str .= " exp_sallary_curr		= '$ecs'			 ,";
			$str .= " expected_sallary		= '$expected_sallary',";
			$str .= " last_education		= '$last_education'	 ,";
			$str .= " sallary_range			= '$sallary_range'	 ,";
			$str .= " last_update			= now()				 ,";
			
			$str .= " pelaut_id 			= '$pelaut_id'		  ";
			
			// Competency 
			// fetch data coc_class
			
			$coc = $this->coc_model->get_coc_detail($coc_class);
			
			//add competency sesuai dengan COC class yang dipilih
			$str_incom  = "insert into competency_tr set 		 ";
			$str_incom .= "grade_license 	= '$coc[coc_class]'	,";
			$str_incom .= "pelaut_id 		= '$pelaut_id'		,";  
			$str_incom .= "last_update	= now() 			,"; 
			$str_incom .= "type			= 'coc' 			 "; 
			$qin_com =  $this->db2->query($str_incom); 
			
			$coe = "Certificate of Endorsement";
			
			$str_incom  = "insert into competency_tr set 		 ";
			$str_incom .= "grade_license 	= '$coe'			,";
			$str_incom .= "pelaut_id 		= '$pelaut_id'		,";  
			$str_incom .= "last_update	= now() 			,"; 
			$str_incom .= "type			= 'coc' 			 "; 
			$qin_com =  $this->db2->query($str_incom); 
			
			//echo $str;
		  }
		  // echo $str;
		  $q = $this->db2->query($str);
		  $data["message"] = "<div class='alert alert-success'>Data Seaman has Successfully Changed</div> ";
		  $data["type"]    = "success";
		  
		}
		else
		{
			$data["message"] = "<div class='alert alert-danger'>".validation_errors()."</div>";
			$data["type"]    = "error";
		}
		
		echo json_encode($data);
	}
	
	function profile_edit_process()
	{
		// library form validation
		$this->load->library('form_validation');
		
		$pelaut_id = $this->session->userdata('id_user');
		$nama_depan 		= $this->input->post("nama_depan",true);
		$nama_belakang 	 = $this->input->post("nama_belakang",true);
		$gender 			= $this->input->post("gender",true);
		$height 			= $this->input->post("height",true);
		$weight			= $this->input->post("weight",true);
		$clothes_size  	  = $this->input->post("clothes_size",true);
		$shoes_size 		= $this->input->post("shoes_size",true);
		$nationality   	   = $this->input->post("nationality",true);
		$kin 		   	   = $this->input->post("kin",true);
		$marrital_status   = $this->input->post("marrital_status",true);
		$agama			 = $this->input->post("agama",true);
		//$email			 = $this->input->post("email",true);
		$hubungan       =  $this->input->post('relationship',true);
		$telepon		   = $this->input->post("phone",true);
		$handphone		 = $this->input->post("handphone",true);
		
		$place_birth	   = $this->input->post("place_birth",true);
		$date_birth 		= $this->input->post("date_birth",true);
		$address		   = $this->input->post("address",true);
		
		
		// set rules 
		$this->form_validation->set_rules("nama_depan","First Name",'required|xss_clean');
		$this->form_validation->set_rules("nama_belakang","Last Name",'required'); 
		
		$this->form_validation->set_rules("height","Height",'required');
		$this->form_validation->set_rules("weight","Weight",'required');
		
		$this->form_validation->set_rules("clothes_size","Clothes Size",'required');
		$this->form_validation->set_rules("shoes_size","Shoes Size",'required');
		
		$this->form_validation->set_rules("gender","Gender",'required');
		$this->form_validation->set_rules("nationality","Nationality",'required');
		
//$this->form_validation->set_rules("email","Email",'valid_email');
		$this->form_validation->set_rules("phone","Phone",'required|numeric');
		$this->form_validation->set_rules("handphone","Handphone",'required|numeric');
		
		if($this->form_validation->run() == TRUE)
		{
		  $str_check = "select * from profile_resume_tr where pelaut_id = '$pelaut_id' ";
		  $qc = $this->db2->query($str_check);
		  $fc = $qc->row_array();
		  
		  $str_cpms = "select * from pelaut_ms where pelaut_id = '$pelaut_id' ";
		  $qcpms = $this->db2->query($str_cpms);
		  $fcpms = $qcpms->row_array();

		  $kebangsaanya = $fcpms['kebangsaan'];

		  $str_fordoc = "SELECT * FROM document_tr WHERE pelaut_id = '$pelaut_id' AND country = '$kebangsaan'";
		  $qc = $this->db2->query($str_fordoc);
		  $fcxx = $qc->result_array();

		 // print_r($fcxx);
		  
		  if(!empty($fcpms))
		  {



		  	//return $a;

		  	//delete document dulu 
		  	$str_delete = "DELETE FROM document_tr WHERE pelaut_id = '$pelaut_id' AND type_document = 'document' AND
		  	country = '$kebangsaanya' AND bawaan = 1";
		  	$qqz = $this->db2->query($str_delete);

		  		$ip_ad = $_SERVER['REMOTE_ADDR'];
		  	$str = "INSERT INTO document_tr (type,pelaut_id,ip_address,date_issued,datetime,type_document,country,bawaan) 
		  	VALUES ('Passport','$pelaut_id','$ip_ad','',now(),'document','$nationality',1)";
		  	$qq = $this->db2->query($str);
		  	$str2 = "INSERT INTO document_tr(type,pelaut_id,ip_address,date_issued,datetime,type_document,country,bawaan)
		  	VALUES ('Seaman Book','$pelaut_id','$ip_ad','',now(),'document','$nationality',1)";
		  	$aa = $this->db2->query($str2);
		  
		
			$str  = " update pelaut_ms set 				          ";
			$str .= " nama_depan 			= '$nama_depan' 	 ,";
			$str .= " nama_belakang	 		= '$nama_belakang'   ,";
			$str .= " gender 				= '$gender'			 ,";
			//$str .= " height 				= '$height'			 ,";
			//$str .= " weight				= '$weight'			 ,";
			//$str .= " clothes_size			= '$clothes_size'	 ,";
			//$str .= " shoes_size 			= '$shoes_size'		 ,";
			$str .= " kebangsaan    		= '$nationality'	 ,";
			$str .= " keluarga_terdekat		= '$kin'			 ,";
			$str .= " hubungan  			= '$hubungan'        ,";
			$str .= " status_perkawinan		= '$marrital_status' ,";
			$str .= " agama					= '$agama'			 ,";
			//$str .= " email					= '$email'			 ,";
			$str .= " telepon				= '$telepon'		 ,";
			$str .= " handphone				= '$handphone'		 ,";
			$str .= " tempat_lahir			= '$place_birth' 	 ,";
			$str .= " tanggal_lahir	 		= '$date_birth'		 ,";
			$str .= " alamat				= '$address'		 ,";
			//$str .= " vessel_type			= '$vessel_type'	 ,";
			//$str .= " department			= '$department'		 ,";
			//$str .= " coc_class				= '$coc_class'		 ,";
			//$str .= " rank					= '$rank'		     ,";
			//$str .= " exp_sallary_curr		= '$ecs'			 ,";
			//$str .= " expected_sallary		= '$expected_sallary',";
			//$str .= " sallary_range			= '$sallary_range'	 ,";
			//$str .= " last_education		= '$last_education'  ,";
			$str .= " last_update			= now()		  		  ";
			
			$str .= " where pelaut_id 		= '$pelaut_id'		  ";
			
			$q = $this->db2->query($str);
			
			/*ubah session */	
			$this->session->set_userdata('nama',"$nama_depan $nama_belakang");
			//$this->session->set_userdata('email',$email);
			
			$update_coc = "UPDATE competency_tr SET negara = '$nationality' WHERE pelaut_id = '$pelaut_id' and type = 'coc'";
			$zz = $this->db2->query($update_coc);

			if(!empty($fc))
			{
			
			  $str_pr  = " update profile_resume_tr set		          ";
			  
			  $str_pr .= " height 				= '$height'			 ,";
			  $str_pr .= " weight				= '$weight'			 ,";
			  $str_pr .= " clothes_size			= '$clothes_size'	 ,";
			  $str_pr .= " shoes_size 			= '$shoes_size'		 ,";
			  
			  /*$str_pr .= " vessel_type			= '$vessel_type'	 ,";
			  $str_pr .= " department			= '$department'		 ,";
			  $str_pr .= " coc_class				= '$coc_class'		 ,";
			  $str_pr .= " rank					= '$rank'		     ,";
			  $str_pr .= " exp_sallary_curr		= '$ecs'			 ,";
			  $str_pr .= " expected_sallary		= '$expected_sallary',";
			  $str_pr .= " sallary_range			= '$sallary_range'	 ,";
			  $str_pr .= " last_education		= '$last_education'  ,";*/
			  $str_pr .= " last_update			= now()		  		  ";
			  
			  $str_pr .= " where pelaut_id 		= '$pelaut_id'		  ";  
			  
			  $q2 = $this->db2->query($str_pr);
			  
			}
			else
			{
			  $str_pr  = " insert into profile_resume_tr set  		  ";
			
			  $str_pr .= " height 				= '$height'			 ,";
			  $str_pr .= " weight				= '$weight'			 ,";
			  $str_pr .= " clothes_size			= '$clothes_size'	 ,";
			  $str_pr .= " shoes_size 			= '$shoes_size'		 ,";
			  
			  /*$str_pr .= " vessel_type			= '$vessel_type'	 ,";
			  $str_pr .= " department			= '$department'		 ,";
			  $str_pr .= " coc_class				= '$coc_class'		 ,";
			  $str_pr .= " rank					= '$rank'		     ,";
			  $str_pr .= " exp_sallary_curr		= '$ecs'			 ,";
			  $str_pr .= " expected_sallary		= '$expected_sallary',";
			  $str_pr .= " sallary_range			= '$sallary_range'	 ,";
			  $str_pr .= " last_education		= '$last_education'  ,";*/
			  $str_pr .= " last_update			= now()		  		 ,";
			  $str_pr .= " pelaut_id 			= '$pelaut_id'		  ";
			  
			  $q2 = $this->db2->query($str_pr);
			}


			
			//echo $str;
			
			// 
			
			
			//
		  }
		  /* else
		  {
			$str  = " insert into pelaut_ms set 		  		  ";
			$str .= " first_name 			= '$nama_depan' 	 ,";
			$str .= " last_name		 		= '$nama_belakang'   ,";
			$str .= " gender 				= '$gender'			 ,";
			//$str .= " height 				= '$height'			 ,";
			//$str .= " weight				= '$weight'			 ,";
			//$str .= " clothes_size			= '$clothes_size'	 ,";
			//$str .= " shoes_size 			= '$shoes_size'		 ,";
			$str .= " kebangsaan    		= '$nationality'	 ,";
			$str .= " keluarga_terdekat		= '$kin'			 ,";
			$str .= " status_perkawinan		= '$marrital_status' ,";
			$str .= " agama					= '$agama'			 ,";
			$str .= " email					= '$email'			 ,";
			$str .= " telepon				= '$telepon'		 ,";
			$str .= " handphone				= '$handphone'		 ,";
			$str .= " tempat_lahir			= '$place_birth' 	 ,";
			$str .= " tanggal_lahir	 		= '$date_birth'		 ,";
			$str .= " alamat				= '$address'		 ,";
			//$str .= " vessel_type			= '$vessel_type'	 ,";
			//$str .= " department			= '$department'		 ,";
			//$str .= " coc_class				= '$coc_class'		 ,";
			//$str .= " rank					= '$rank'		     ,";
			//$str .= " exp_sallary_curr		= '$ecs'			 ,";
			//$str .= " expected_sallary		= '$expected_sallary',";
			//$str .= " sallary_range			= '$sallary_range'	 ,";
			//$str .= " last_education		= '$last_education'  ,";
			$str .= " last_update			= now()		  		 ,";
			$str .= " pelaut_id 			= '$pelaut_id'		  ";
			
			$q = $this->db2->query($str);
			
			
			$str_pr  = " insert into profile_resume_tr set  		  ";
			
			$str_pr .= " height 				= '$height'			 ,";
			$str_pr .= " weight					= '$weight'			 ,";
			$str_pr .= " clothes_size			= '$clothes_size'	 ,";
			$str_pr .= " shoes_size 			= '$shoes_size'		 ,";
			
			$str_pr .= " vessel_type			= '$vessel_type'	 ,";
			$str_pr .= " department				= '$department'		 ,";
			$str_pr .= " coc_class				= '$coc_class'		 ,";
			$str_pr .= " rank					= '$rank'		     ,";
			$str_pr .= " exp_sallary_curr		= '$ecs'			 ,";
			$str_pr .= " expected_sallary		= '$expected_sallary',";
			$str_pr .= " sallary_range			= '$sallary_range'	 ,";
			$str_pr .= " last_education			= '$last_education'  ,";
			$str_pr .= " last_update			= now()		  		 ,";
			$str_pr .= " pelaut_id 				= '$pelaut_id'		  ";
			
			$q2 = $this->db2->query($str_pr);
		  }*/
		  
		  
		  
		  echo "<div class='alert alert-success'>Data Profile has Successfully Changed</div> ";
		  echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
		  
		}
		else
		{
			echo "<div class='alert alert-danger'>".validation_errors()."</div>";
		}
		  
		
	}
	

	function profileaa_edit_process()
	{
		// library form validation
		$this->load->library('form_validation');
		
		$pelaut_id = $this->session->userdata('id_user');
		$nama_depan 		= $this->input->post("nama_depan",true);
		$nama_belakang 	 = $this->input->post("nama_belakang",true);
		$gender 			= $this->input->post("gender",true);
		$height 			= $this->input->post("height",true);
		$weight			= $this->input->post("weight",true);
		$clothes_size  	  = $this->input->post("clothes_size",true);
		$shoes_size 		= $this->input->post("shoes_size",true);
		$nationality   	   = $this->input->post("nationality",true);
		$kin 		   	   = $this->input->post("kin",true);
		$marrital_status   = $this->input->post("marrital_status",true);
		$agama			 = $this->input->post("agama",true);
		$email			 = $this->input->post("email",true);
		
		$telepon		   = $this->input->post("phone",true);
		$handphone		 = $this->input->post("handphone",true);
		
		$place_birth	   = $this->input->post("place_birth",true);
		$date_birth 		= $this->input->post("date_birth",true);
		$address		   = $this->input->post("address",true);
		
		
		// set rules 
		$this->form_validation->set_rules("nama_depan","Nama Depan",'xss_clean');
		$this->form_validation->set_rules("nama_belakang","Nama Belakang",''); 
		
		$this->form_validation->set_rules("height","Height",'');
		$this->form_validation->set_rules("weight","Weight",'');
		
		$this->form_validation->set_rules("clothes_size","Clothes Size",'');
		$this->form_validation->set_rules("shoes_size","Shoes Size",'');
		
		$this->form_validation->set_rules("nationality","Nationality",'');
		
		$this->form_validation->set_rules("email","Email",'valid_email');
		$this->form_validation->set_rules("phone","Phone",'numeric');
		$this->form_validation->set_rules("handphone","Handphone",'numeric');
		
		if($this->form_validation->run() == TRUE)
		{
		  $str_check = "select * from profile_resume_tr where pelaut_id = '$pelaut_id' ";
		  $qc = $this->db2->query($str_check);
		  $fc = $qc->row_array();
		  
		  $str_cpms = "select * from pelaut_ms where pelaut_id = '$pelaut_id' ";
		  $qcpms = $this->db2->query($str_cpms);
		  $fcpms = $qcpms->row_array();

		  $kebangsaanya = $fcpms['kebangsaan'];

		  $str_fordoc = "SELECT * FROM document_tr WHERE pelaut_id = '$pelaut_id' AND country = '$kebangsaan'";
		  $qc = $this->db2->query($str_fordoc);
		  $fcxx = $qc->result_array();

		 // print_r($fcxx);
		  
		  if(!empty($fcpms))
		  {



		  	//return $a;

		  	//delete document dulu 
		  	$str_delete = "DELETE FROM document_tr WHERE pelaut_id = '$pelaut_id' AND type_document = 'document' AND
		  	country = '$kebangsaanya' AND bawaan = 1";
		  	$qqz = $this->db2->query($str_delete);

		  		$ip_ad = $_SERVER['REMOTE_ADDR'];
		  	$str = "INSERT INTO document_tr (type,pelaut_id,ip_address,date_issued,datetime,type_document,country,bawaan) 
		  	VALUES ('Passport','$pelaut_id','$ip_ad','',now(),'document','$nationality',1)";
		  	$qq = $this->db2->query($str);
		  	$str2 = "INSERT INTO document_tr(type,pelaut_id,ip_address,date_issued,datetime,type_document,country,bawaan)
		  	VALUES ('Seaman Book','$pelaut_id','$ip_ad','',now(),'document','$nationality',1)";
		  	$aa = $this->db2->query($str2);
		  
		
			$str  = " update pelaut_ms set 				          ";
			$str .= " nama_depan 			= '$nama_depan' 	 ,";
			$str .= " nama_belakang	 		= '$nama_belakang'   ,";
			$str .= " gender 				= '$gender'			 ,";
			//$str .= " height 				= '$height'			 ,";
			//$str .= " weight				= '$weight'			 ,";
			//$str .= " clothes_size			= '$clothes_size'	 ,";
			//$str .= " shoes_size 			= '$shoes_size'		 ,";
			$str .= " kebangsaan    		= '$nationality'	 ,";
			$str .= " keluarga_terdekat		= '$kin'			 ,";
			$str .= " status_perkawinan		= '$marrital_status' ,";
			$str .= " agama					= '$agama'			 ,";
			$str .= " email					= '$email'			 ,";
			$str .= " telepon				= '$telepon'		 ,";
			$str .= " handphone				= '$handphone'		 ,";
			$str .= " tempat_lahir			= '$place_birth' 	 ,";
			$str .= " tanggal_lahir	 		= '$date_birth'		 ,";
			$str .= " alamat				= '$address'		 ,";
			//$str .= " vessel_type			= '$vessel_type'	 ,";
			//$str .= " department			= '$department'		 ,";
			//$str .= " coc_class				= '$coc_class'		 ,";
			//$str .= " rank					= '$rank'		     ,";
			//$str .= " exp_sallary_curr		= '$ecs'			 ,";
			//$str .= " expected_sallary		= '$expected_sallary',";
			//$str .= " sallary_range			= '$sallary_range'	 ,";
			//$str .= " last_education		= '$last_education'  ,";
			$str .= " last_update			= now()		  		  ";
			
			$str .= " where pelaut_id 		= '$pelaut_id'		  ";
			
			$q = $this->db2->query($str);
			
			/*ubah session */	
			$this->session->set_userdata('nama',"$nama_depan $nama_belakang");
			$this->session->set_userdata('email',$email);
			
			$update_coc = "UPDATE competency_tr SET negara = '$nationality' WHERE pelaut_id = '$pelaut_id' and type = 'coc'";
			$zz = $this->db2->query($update_coc);

			if(!empty($fc))
			{
			
			  $str_pr  = " update profile_resume_tr set		          ";
			  
			  $str_pr .= " height 				= '$height'			 ,";
			  $str_pr .= " weight				= '$weight'			 ,";
			  $str_pr .= " clothes_size			= '$clothes_size'	 ,";
			  $str_pr .= " shoes_size 			= '$shoes_size'		 ,";
			  
			  /*$str_pr .= " vessel_type			= '$vessel_type'	 ,";
			  $str_pr .= " department			= '$department'		 ,";
			  $str_pr .= " coc_class				= '$coc_class'		 ,";
			  $str_pr .= " rank					= '$rank'		     ,";
			  $str_pr .= " exp_sallary_curr		= '$ecs'			 ,";
			  $str_pr .= " expected_sallary		= '$expected_sallary',";
			  $str_pr .= " sallary_range			= '$sallary_range'	 ,";
			  $str_pr .= " last_education		= '$last_education'  ,";*/
			  $str_pr .= " last_update			= now()		  		  ";
			  
			  $str_pr .= " where pelaut_id 		= '$pelaut_id'		  ";  
			  
			  $q2 = $this->db2->query($str_pr);
			  
			}
			else
			{
			  $str_pr  = " insert into profile_resume_tr set  		  ";
			
			  $str_pr .= " height 				= '$height'			 ,";
			  $str_pr .= " weight				= '$weight'			 ,";
			  $str_pr .= " clothes_size			= '$clothes_size'	 ,";
			  $str_pr .= " shoes_size 			= '$shoes_size'		 ,";
			  
			  /*$str_pr .= " vessel_type			= '$vessel_type'	 ,";
			  $str_pr .= " department			= '$department'		 ,";
			  $str_pr .= " coc_class				= '$coc_class'		 ,";
			  $str_pr .= " rank					= '$rank'		     ,";
			  $str_pr .= " exp_sallary_curr		= '$ecs'			 ,";
			  $str_pr .= " expected_sallary		= '$expected_sallary',";
			  $str_pr .= " sallary_range			= '$sallary_range'	 ,";
			  $str_pr .= " last_education		= '$last_education'  ,";*/
			  $str_pr .= " last_update			= now()		  		 ,";
			  $str_pr .= " pelaut_id 			= '$pelaut_id'		  ";
			  
			  $q2 = $this->db2->query($str_pr);
			}


			
			//echo $str;
			
			// 
			
			
			//
		  }
		  /* else
		  {
			$str  = " insert into pelaut_ms set 		  		  ";
			$str .= " first_name 			= '$nama_depan' 	 ,";
			$str .= " last_name		 		= '$nama_belakang'   ,";
			$str .= " gender 				= '$gender'			 ,";
			//$str .= " height 				= '$height'			 ,";
			//$str .= " weight				= '$weight'			 ,";
			//$str .= " clothes_size			= '$clothes_size'	 ,";
			//$str .= " shoes_size 			= '$shoes_size'		 ,";
			$str .= " kebangsaan    		= '$nationality'	 ,";
			$str .= " keluarga_terdekat		= '$kin'			 ,";
			$str .= " status_perkawinan		= '$marrital_status' ,";
			$str .= " agama					= '$agama'			 ,";
			$str .= " email					= '$email'			 ,";
			$str .= " telepon				= '$telepon'		 ,";
			$str .= " handphone				= '$handphone'		 ,";
			$str .= " tempat_lahir			= '$place_birth' 	 ,";
			$str .= " tanggal_lahir	 		= '$date_birth'		 ,";
			$str .= " alamat				= '$address'		 ,";
			//$str .= " vessel_type			= '$vessel_type'	 ,";
			//$str .= " department			= '$department'		 ,";
			//$str .= " coc_class				= '$coc_class'		 ,";
			//$str .= " rank					= '$rank'		     ,";
			//$str .= " exp_sallary_curr		= '$ecs'			 ,";
			//$str .= " expected_sallary		= '$expected_sallary',";
			//$str .= " sallary_range			= '$sallary_range'	 ,";
			//$str .= " last_education		= '$last_education'  ,";
			$str .= " last_update			= now()		  		 ,";
			$str .= " pelaut_id 			= '$pelaut_id'		  ";
			
			$q = $this->db2->query($str);
			
			
			$str_pr  = " insert into profile_resume_tr set  		  ";
			
			$str_pr .= " height 				= '$height'			 ,";
			$str_pr .= " weight					= '$weight'			 ,";
			$str_pr .= " clothes_size			= '$clothes_size'	 ,";
			$str_pr .= " shoes_size 			= '$shoes_size'		 ,";
			
			$str_pr .= " vessel_type			= '$vessel_type'	 ,";
			$str_pr .= " department				= '$department'		 ,";
			$str_pr .= " coc_class				= '$coc_class'		 ,";
			$str_pr .= " rank					= '$rank'		     ,";
			$str_pr .= " exp_sallary_curr		= '$ecs'			 ,";
			$str_pr .= " expected_sallary		= '$expected_sallary',";
			$str_pr .= " sallary_range			= '$sallary_range'	 ,";
			$str_pr .= " last_education			= '$last_education'  ,";
			$str_pr .= " last_update			= now()		  		 ,";
			$str_pr .= " pelaut_id 				= '$pelaut_id'		  ";
			
			$q2 = $this->db2->query($str_pr);
		  }*/
		  
		  
		  
		  echo "<div class='alert alert-success'>Data Profile has Successfully Changed</div> ";
		  echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
		  
		}
		else
		{
			echo "<div class='alert alert-danger'>".validation_errors()."</div>";
		}
		  
		
	}

	
	function cek_edit_password($id_user){

		$str = "SELECT * FROM log_seatizen WHERE seatizen_id = '$id_user' AND action = 'Edit Password'";
		$q = $this->db2->query($str);
		$c = $q->num_rows();
		return $c;
	}

		function cek_edit_username($id_user){

		$str = "SELECT * FROM log_seatizen WHERE seatizen_id = '$id_user' AND action = 'Edit Username'";
	
		$q = $this->db2->query($str);
		$c = $q->result_array();
	return $c;
	}
	
	function __destruct()
	{
		//echo "<!-- end class -->";	
	}
	
	
	
	
	
}