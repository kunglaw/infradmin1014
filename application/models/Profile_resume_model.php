<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');



class Profile_resume_model extends CI_Model{

	

	public function __construct()

	{

		$this->db = $this->load->database(DB2_GROUP,TRUE);	

	}

	

	function last_profile_resume($id_pelaut = '')

	{

		$id_pelaut = $this->session->userdata('id_user');

		

		$str = "select * from profile_resume_tr where pelaut_id = '$id_pelaut' ORDER BY last_update DESC LIMIT 1 ";

		$q = $this->db->query($str);

		$f = $q->row_array();

		

		return $f;

		

	}

	

	function get_profile_resume($id_pelaut = '')
	{

		$str = "select * from profile_resume_tr where pelaut_id = '$id_pelaut' ";
		$q = $this->db->query($str);
		$f = $q->row_array();

		return $f;

	}



	function cek_lengkap_resume($id_pelaut = ''){

		/* $str = "SELECT * FROM profile_resume_tr WHERE pelaut_id = '$id_pelaut' AND 
		(height != '' and weight != '' AND clothes_size != '' and last_education != '' 
		and shoes_size != '' and expected_sallary != 0 and exp_sallary_curr != '' and vessel_type != 0 
		and department != 0 and sallary_range != '')";
		//echo $str;
		$q = $this->db->query($str);
		$f = $q->row_array();
		return $f; */
		$str_prtr = "SELECT * FROM profile_resume_tr WHERE 
			pelaut_id = '$id_pelaut' AND 
			(
			clothes_size != '' and 
			last_education != '' 
			and shoes_size != '' 
			
			and vessel_type != 0 
			and department != 0 )"; 
			
			/* and 
			height != '' and weight != '' AND 
			and expected_sallary != 0 
			and exp_sallary_curr != '' 
			sallary_range != ''
			
			)";*/
			//echo $str;
			$q_prtr = $this->db->query($str_prtr);
			$f_prtr = $q_prtr->row_array();
			
			// document -> type document 											bawaan <> 1
			$str_document = "SELECT * FROM document_tr WHERE type_document = 'document' AND pelaut_id = '$id_pelaut' ";
			$q_document   = $this->db->query($str_document);
			$f_document   = $q_document->result_array();
			
			/* $str_visa	 = "SELECT * FROM document_tr WHERE type_document = 'visa' AND pelaut_id = '$id_pelaut'";
			$q_visa 	   = $this->db->query($str_visa);
			$f_visa 	   = $q_visa->result_array(); */
			
			/* $str_medical  = "SELECT * FROM document_tr WHERE type_document = 'medical_cert' AND pelaut_id = '$id_pelaut'";
			$q_medical	= $this->db->query($str_medical);
			$f_medical	= $q_medical->result_array(); */   
			
			$str_competency = "SELECT * FROM competency_tr WHERE pelaut_id = '$id_pelaut' ";
			$q_competency   = $this->db->query($str_competency);
			$f_competency   = $q_competency->result_array();
			
			$str_proficiency = "SELECT * FROM proficiency_tr WHERE pelaut_id = '$id_pelaut'";
			$q_proficiency   = $this->db->query($str_proficiency);
			$f_proficiency   = $q_proficiency->result_array();
			
			$str_experience  = "SELECT * FROM experiences WHERE  pelaut_id = '$id_pelaut' ";
			$q_experience	= $this->db->query($str_experience);
			$f_experience	= $q_experience->result_array();
			
			if( empty($f_prtr) || 
				empty($f_document) || 
				/* empty($f_visa) || */
				/* empty($f_medical) || */
				empty($f_competency) || 
				empty($f_proficiency) ||
				empty($f_experience))
			{
				$result = FALSE; // salah, resume gak lengkap	
			}
			else
			{
				$result = TRUE;	
			}
			
			
			return array("result"=>$result,"profile_resume_tr"=>$f_prtr,"document"=>$f_document,/*"visa"=>$f_visa,*//* "medical"=>$f_medical,*/
			"competency"=>$f_competency,"proficiency"=>$f_proficiency,"experience"=>$f_experience);  

	}
	
	function profile_edit_process($username = "")
	{
		// library form validation
		$this->load->library('form_validation');
		
		$this->load->model("user_model");
		
		if($username == "")
		{
			$username = $this->input->post("username",true);
			
			$pelaut = $this->user_model->get_detail_pelaut22($username);
			
			$pelaut_id = $pelaut['pelaut_id'];	

		}
		else
		{

			

			$pelaut = $this->user_model->get_detail_pelaut22($username);
			$pelaut_id = $pelaut['pelaut_id'];	

		}
		
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
		//$email		   = $this->input->post("email",true);
		$hubungan       	  =  $this->input->post('relationship',true);
		$telepon		   = $this->input->post("phone",true);
		$handphone		 = $this->input->post("handphone",true);
		
		$place_birth	   = $this->input->post("place_birth",true);
		$date_birth 		= $this->input->post("date_birth",true);
		$address		   = $this->input->post("address",true);
		
		
		// set rules 
		$this->form_validation->set_rules("nama_depan","First Name",'required');
		//$this->form_validation->set_rules("nama_belakang","Last Name",'required'); 
		
		//$this->form_validation->set_rules("height","Height",'required');
		//$this->form_validation->set_rules("weight","Weight",'required');
		
		//$this->form_validation->set_rules("clothes_size","Clothes Size",'required');
		//$this->form_validation->set_rules("shoes_size","Shoes Size",'required');
		
		$this->form_validation->set_rules("gender","Gender",'required');
		$this->form_validation->set_rules("nationality","Nationality",'required');
		
//$this->form_validation->set_rules("email","Email",'valid_email');
		$this->form_validation->set_rules("phone","Phone",'required|numeric');
		$this->form_validation->set_rules("handphone","Handphone",'required|numeric');
		
		$this->form_validation->set_rules("date_birth","Date birth","required");
		
		if($this->form_validation->run() == TRUE)
		{
		  $str_check = "select * from profile_resume_tr where pelaut_id = '$pelaut_id' ";
		  $qc = $this->db->query($str_check);
		  $fc = $qc->row_array();
		  
		  $str_cpms = "select * from pelaut_ms where pelaut_id = '$pelaut_id' ";
		  $qcpms = $this->db->query($str_cpms);
		  $fcpms = $qcpms->row_array();

		  $kebangsaanya = $fcpms['kebangsaan'];

		  $str_fordoc = "SELECT * FROM document_tr WHERE pelaut_id = '$pelaut_id' AND country = '$kebangsaan'";
		  $qc = $this->db->query($str_fordoc);
		  $fcxx = $qc->result_array();

		 // print_r($fcxx);
		  
		  if(!empty($fcpms))
		  {
		  	//return $a;

		  	//delete document dulu 
		  	$str_delete = "DELETE FROM document_tr WHERE pelaut_id = '$pelaut_id' AND type_document = 'document' AND
		  	country = '$kebangsaanya' AND bawaan = 1";
		  	$qqz = $this->db->query($str_delete);

		  	$ip_ad = $_SERVER['REMOTE_ADDR'];
		  	$str = "INSERT INTO document_tr (type,pelaut_id,ip_address,date_issued,datetime,type_document,country,bawaan) 
		  	VALUES ('Passport','$pelaut_id','$ip_ad','',now(),'document','$nationality',1)";
		  	$qq = $this->db->query($str);
		  	$str2 = "INSERT INTO document_tr(type,pelaut_id,ip_address,date_issued,datetime,type_document,country,bawaan)
		  	VALUES ('Seaman Book','$pelaut_id','$ip_ad','',now(),'document','$nationality',1)";
		  	$aa = $this->db->query($str2);
		  
		
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
			
			$q = $this->db->query($str);
			
			/*ubah session */	
			$this->session->set_userdata('nama',"$nama_depan $nama_belakang");
			//$this->session->set_userdata('email',$email);
			
			$update_coc = "UPDATE competency_tr SET negara = '$nationality' WHERE pelaut_id = '$pelaut_id' and type = 'coc'";
			$zz = $this->db->query($update_coc);

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
			  
			  $q2 = $this->db->query($str_pr);
			  
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
			  
			  $q2 = $this->db->query($str_pr);
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
			
			$q = $this->db->query($str);
			
			
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
			
			$q2 = $this->db->query($str_pr);
		  }*/
		  
		
		  echo "<div class='alert alert-success'>$pelaut_id | $username  | Data Profile has Successfully Changed</div> ";
		  echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";
		  
		}
		else
		{
			echo "<div class='alert alert-danger'>".validation_errors()."</div>";
		}
		  
		
	}

	

	

	

}