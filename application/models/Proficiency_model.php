<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');



class Proficiency_model extends CI_Model{

	

	public function __construct()

	{

		$this->db = $this->load->database(DB2_GROUP,TRUE);	

	}

	

	function get_proficiency_pelaut($username = "")

	{	

		if($username == "")

		{

			$pelaut_id = $this->session->userdata('id_user');

		}

		else

		{

			$this->load->model("users/user_model");

			$pelaut = $this->user_model->get_detail_pelaut($username);

			$pelaut_id = $pelaut['pelaut_id'];	

		}

		
		if($pelaut_id == "") return null;
			else{
		$str_proficiency_tr = "SELECT * from proficiency_tr where pelaut_id = '$pelaut_id' order by id_sertifikat DESC";

		$q_proficiency_tr = $this->db->query($str_proficiency_tr);

		$f_proficiency_tr = $q_proficiency_tr->result_array();

		

		return $f_proficiency_tr;
}
			

	}

	

	function last_proficiency($id_pelaut = '')

	{

		$id_pelaut = $this->session->userdata('id_user');

		

		$str = "select * from proficiency_tr where pelaut_id = '$id_pelaut' order by last_update DESC LIMIT 1";

		$q   = $this->db->query($str);

		$f   = $q->row_array();

		

		return $f; 	

	}

	

	function get_json_proficiency_pelaut()

	{

		

		$proficiency = $this->get_json_proficiency_pelaut();

		return json_encode($proficiency);

			

	}



	function get_proficiency_all(){



		$str = "SELECT * FROM proficiency_ms ORDER BY proficiency ASC";



		$q = $this->db->query($str);



		$f = $q->result_array();



		return $f;



	}



	function get_proficiency_pribadi($id){



		$str = "SELECT * FROM proficiency_tr WHERE pelaut_id = '$id'";



		$q  =$this->db->query($str);



		$f = $q->result_array();



		return $f;



	}

	

	function get_proficiency_tr()
	{

		$pelaut_id = $this->input->post('pelaut_id');
		$id_sertifikat = $this->input->post("id_update"); // id_update dari javasecript
			

		$str_proficiency_tr = "SELECT * from proficiency_tr where pelaut_id = '$pelaut_id' and id_sertifikat = '$id_sertifikat' ";

		$q_proficiency_tr = $this->db->query($str_proficiency_tr);

		$f_proficiency_tr = $q_proficiency_tr->row_array();

		return $f_proficiency_tr;
	}

	

	function add_proficiency_process()

	{

		$this->load->library('form_validation');

		$pelaut_id = $this->input->post('pelaut_id');

		//Array ( [certificate] => [no_certificate] => [date_issue] => [place_issue] => ) 

		$certificate 		= $this->input->post("certificate",true);

		if($certificate == "other"){
			
			$this->form_validation->set_rules("proficiency_lain","Other Proficiency","required");
			$certificate = $this->input->post('proficiency_lain');

		}

		$no_certificate 	 = $this->input->post("no_certificate");

		$date_issue		 = $this->input->post("date_issue");

		$place_issue		= $this->input->post("place_issue");

		$expired_date 	   = $this->input->post("expired_date",true);

		

		$this->form_validation->set_rules("certificate","Certificate",'required');

		//$this->form_validation->set_rules("no_certificate","No Certificate","");

		//$this->form_validation->set_rules("date_issue","Date Issue","");

		//$this->form_validation->set_rules("place_issue","Place Issue","");



		// $this->form_validation->set_rules("expired_date","Expired Date","required"); // sementara di comment

		

		if($this->form_validation->run() == TRUE && $certificate != "other")

		{
			
			/* if(!empty($_FILES['attachment']["name"])){ 
			
					$a = json_encode($_FILES['attachment']);
					$result["message"] = $a." , tidak kosong"; 
					$result["status"] = "error";
					
					
			}
			else
			{
					$a = json_encode($_FILES['attachment']);
					$result["message"] = $a." , kosong "; 
					$result["status"] = "error";
			}
			return $result;
			exit;*/
			
			if(!empty($_FILES["attachment"]["name"]))

			{

        		$this->load->helper("upload_file_document");

        		$username = $this->session->userdata("username");

        		$attachment = $_FILES['attachment'];

				
				$set_nama_file = $certificate;

				
				 // buat foldernya dahulu
				// dari username_folder_helper
				make_username_folder_doc($username,"proficiency");
				
				
				$nama_file  = (str_replace(' ', '_', strtolower($set_nama_file))).".";

				$nama_file .= end(explode('.', $attachment['name']));

				$replace = array('name' => $nama_file);

				$attachment = array_replace($attachment,$replace);

				

				$upload_file = upload_prof_pelaut($attachment, $username);
				


        		if($upload_file["pesan"] == "sukses")

				{

					$data_upload = $upload_file['data'];

				}

				else

				{

					$result["message"] = $data_upload = "<div class='alert alert-danger'>".$upload_file["data"]."</div>";

					$result["status"]  = "error";

					

					return $result;

					exit;	

				}

			}

			

			$str  = "insert proficiency_tr set 			 	 ";

			$str .= "no_sertifikat 		= '$no_certificate'	,";

			$str .= "sertifikat_stwc	= '$certificate' 	,";

			$str .= "date_issue			= '$date_issue'		,";

			$str .= "place_issue		= '$place_issue'	,";

			$str .= "expired_date 		= '$expired_date'   ,";

			$str .= "attachment			= '$data_upload[file_name]' ,";

			$str .= "last_update		= now()				,";

			$str .= "pelaut_id			= '$pelaut_id'		 ";

			

			//echo $str; exit;

			

			$q = $this->db->query($str);

			

			if(!$q)

			{

				$this->db->_error_message();	

			}

			else

			{

				$result["message"]  = "<div class='alert alert-success'> Data proficiency Successfully Added </div>";

				$result["message"] .= "<script> setTimeout(function() { location.reload(); }, 2000); </script>";

				$result["status"]   = "success";

			}

		}

		else

		{

			

			$result["message"]  = "<div class='alert alert-danger'>".validation_errors()." </div>";

			$result["status"]   = "error"; 

		}

		

		return $result;

		

	}

	function edit_proficiency_process()
	{

		$this->load->library('form_validation');

		$pelaut_id 		  = $this->input->post("id_pelaut");
		$id_certificate	 = $this->input->post("id_certificate",true);

		//Array ( [certificate] => [no_certificate] => [date_issue] => [place_issue] => ) 

		$certificate 		= $this->input->post("certificate",true);

		$no_certificate 	 = $this->input->post("no_certificate");

		$date_issue		 = $this->input->post("date_issue");

		$place_issue		= $this->input->post("place_issue");

		$expired_date  		= $this->input->post("expired_date",true);

		//$this->form_validation->set_rules("certificate","Certificate",'');
		//$this->form_validation->set_rules("no_certificate","No Certificate","");
		//$this->form_validation->set_rules("date_issue","Date Issue","");
		//$this->form_validation->set_rules("place_issue","Place Issue","");
		
		$this->form_validation->set_rules("certificate","Certificate",'required');

		$this->form_validation->set_rules("no_certificate","No Certificate","required");

		$this->form_validation->set_rules("date_issue","Date Issue","required");

		$this->form_validation->set_rules("place_issue","Place Issue","required");

		//$this->form_validation->set_rules("expired_date","Expired date","required");


		if($this->form_validation->run() == TRUE)
		{

			$str  = "update proficiency_tr set 			 	 ";

			$str .= "no_sertifikat 		= '$no_certificate'	,";

			$str .= "sertifikat_stwc	= '$certificate' 	,";

			$str .= "date_issue			= '$date_issue'		,";

			$str .= "last_update		= now()				,";

			$str .= "place_issue		= '$place_issue'	,";

			$str .= "expired_date		= '$expired_date'   ";

			$str .= "where		 							 ";

			$str .= "pelaut_id			= '$pelaut_id'	 and ";

			$str .= "id_sertifikat		= '$id_certificate'	 ";


			$q = $this->db->query($str);


			if(!$q)
			{

				$result["message"] = $this->db->_error_message();	
				$result["status"] = "error";
			}
			else
			{

				$result["message"] =  "<div class='alert alert-success'> Data proficiency Successfully Edited </div>";
				$result["status"] =  "success";
			}

		}

		else

		{

			$result["message"] = "<div class='alert alert-danger'>".validation_errors()." </div>";
			$result["status"] = "error";
		}
		
		return $result;

	}

	

	function delete_proficiency_process()
	{

		$pelaut_id  	 = $this->session->userdata('id_user');

		$id_sertifikat = $this->input->post('id_update',true); // dari modal ( id_sertifikat ) 

		

		$str = "delete from proficiency_tr where id_sertifikat = $id_sertifikat ";

		$q = $this->db->query($str);

		

		if(!$q)

		{

			$this->db->_error_message();

			

		}

		else

		{

			echo "<div class='alert alert-success'>this data Proficiency has Successfully Deleted </div> ";

			echo "<script> setTimeout(function() { location.reload(); }, 2000); </script>";

		}

	}

	

}







	