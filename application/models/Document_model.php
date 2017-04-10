<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');



	class Document_model extends CI_Model{

		

		public function __construct()

		{

			$this->db = $this->load->database(DB2_GROUP,TRUE);	

		}


		function get_document_pelaut($username = "")
		{
			if($username == "")
			{
				$pelaut_id = $this->session->userdata('id_user');

			}

			else

			{

				$this->load->model("user_model");

				$pelaut = $this->user_model->get_detail_pelaut($username);

				$pelaut_id = $pelaut['pelaut_id'];	

			}

			if($pelaut_id == "") return null;
			else{
				$str_document_tr = "SELECT * from document_tr where pelaut_id = '$pelaut_id' order by type,bawaan AND type_document = 'document'  DESC";

				$q_document_tr = $this->db->query($str_document_tr);

				$f_document_tr = $q_document_tr->result_array();

				return $f_document_tr;
			}
		}



		function get_document_visa($username = ''){

			if($username == ''){

				$pelaut_id = $this->session->userdata('id_user');

			}else{

				$this->load->model('users/user_model');

				$pelaut = $this->user_model->get_detail_pelaut($username);

				$pelaut_id = $pelaut['pelaut_id'];

			}

if($pelaut_id == "") return null;
			else{

			$str = "SELECT * FROM document_tr WHERE pelaut_id = '$pelaut_id' AND type_document = 'visa'";

			$q = $this->db->query($str);

			$f = $q->result_array();

			return $f;
}
		}



		function get_detail_visa(){

			$visa_id = $this->input->post('id_update');


			$str = "SELECT * FROM document_tr WHERE document_id = '$visa_id'";

			$q = $this->db->query($str);

			$f = $q->row_array();

			return $f;

		}



		function list_visa(){

			$str = "SELECT * FROM visa";

			$q = $this->db->query($str);

			$f = $q->result_array();

			return $f;

		}



		function get_document_medical($username = ""){



			if($username == ""){

				$pelaut_id = $this->session->userdata('id_user');

			}else{

				$this->load->model("users/user_model");

				$pelaut = $this->user_model->get_detail_pelaut($username);

				$pelaut_id = $pelaut['pelaut_id'];

			}


if($pelaut_id == "") return null;
			else{
			$str = "SELECT * FROM document_tr WHERE pelaut_id = '$pelaut_id' AND (type_document = 'medical' OR type_document = 'medical_cert') 

			ORDER BY type_document DESC";

			$q_medical = $this->db->query($str);

			$f_document = $q_medical->result_array();



			return $f_document;
}




		}

		

		function last_document($pelaut_id = '')
		{

			$pelaut_id = $this->session->userdata("id_user");

			

			$str = "select * from document_tr where pelaut_id = '$pelaut_id' order by datetime DESC LIMIT 1";

			$q = $this->db->query($str);

			$f = $q->row_array();

			

			return $f;

			

		}

		

		function get_json_document_pelaut()
		{

			

			$document = $this->get_json_document_pelaut();

			return json_encode($document);

				

		}

		

		function get_document_tr()

		{

			$pelaut_id = $this->input->post("pelaut_id");

			// echo "<br>";

			$document_id = $this->input->post("id_update"); // id_update dari javasecript

				

			$str_document_tr = "sELECT * from document_tr where pelaut_id = '$pelaut_id' and document_id = '$document_id' ";

			$q_document_tr = $this->db->query($str_document_tr);

			$f_document_tr = $q_document_tr->row_array();

			

			return $f_document_tr;

		}



        //function radit

        function get_all_table_ms($table_name)

        {

            $new_tb = $table_name."_ms";

            $str = "select * from $new_tb";

            $q = $this->db->query($str);

            $r = $q->result_array();

            return $r;

        }



        function get_medical_except($a){

        	$str = "SELECT * FROM medical_ms WHERE medical != '$a'";

        	$q = $this->db->query($str);

        	$r = $q->num_rows();

        	return $r;

        }



        //function radit

        function add_table_ms($table_name, $type)
        {

            $kolom = str_replace('_ms','',$table_name);

            $str = "insert $table_name set $kolom = '$type'";

            $this->db->query($str);

//            return $q;

        }



        //function radit

        function check_table_ms($table_name,$doc_name)

        {

            $kolom = str_replace('_ms','',$table_name);

//            $doc_name = strtolower($doc_name);

            $str = "select * from $table_name where $kolom = '$doc_name'";

            $q = $this->db->query($str);

            $r = $q->num_rows();

            return $r;

        }

        //iqbal

    	function get_medical_by_id($id){

    		$str = "SELECT * FROM document_tr WHERE pelaut_id = '$id' AND type_document = 'medical'";

    		$q = $this->db->query($str);

    		$r = $q->result_array();

    		return $r;

    	}



    	function get_medical_except2($kecuali){

    		$str = "SELECT * FROM medical_ms WHERE medical != '$kecuali' OR medical <> '$kecuali'";

    		$q = $this->db->query($str);

    		$r = $q->result_array();

    		return $r;

    	}



    	function get_all_medical(){

    		$str = "SELECT * FROM medical_ms ";

    		$q = $this->db->query($str);

    		$r = $q->result_array();

    		return $r;

    	}



//

//        //function radit

//        function get_all_medical_ms()

//        {

//            $str = "select * from medical_ms";

//            $q = $this->db->query($str);

//            $r = $q->result_array();

//            return $r;

//        }

//

//        //function radit

//        function add_medical_ms($type)

//        {

//            $str = "insert medical_ms set medical = '$type'";

//            $this->db->query($str);

////            return $q;

//        }

//

//        //function radit

//        function check_medical_ms($med_name)

//        {

////            $doc_name = strtolower($doc_name);

//            $str = "select * from medical_ms where medical = '$med_name'";

//            $q = $this->db->query($str);

//            $r = $q->num_rows();

//            return $r;

//        }





        //function radit

		function add_document_process($id_pelaut, $type, $number, $place, $date_issued, $date_expired, $source, $country, $attachment)

		{
//			$pelaut_id      = $this->session->userdata("id_user");

				$str  = "insert document_tr set 			 	 		 ";
				$str .= "type 					= '$type'			 	,";
			    $str .= "type_document 			= '$source'		 	    ,";
				$str .= "number				    = '$number'				,";
				$str .= "place				    = '$place' 				,";
				$str .= "date_issued			= '$date_issued'		,";
				$str .= "date_expired			= '$date_expired'		,";
				$str .= "attachment				= '$attachment'		,";
				$str .= "ip_address				= '".$_SERVER['REMOTE_ADDR']."',";
				$str .= "datetime				= now()					,";
				$str .= "country 				= '$country'			 ,";
				$str .= "pelaut_id				= '$id_pelaut'			 ";

				return $this->db->query($str);

		}



		function update_medical_process(){

			$this->load->library('form_validation');

			$pelaut_id = $this->input->post("pelaut_id");
			
			$document_id  = $this->input->post('id_update',true);
			$type 		 = $this->input->post('type',true);
			$number 	   = $this->input->post('number',true);
			$place 		= $this->input->post('place',true);
			$date_issued  = $this->input->post('date_issued');
			$date_expired = $this->input->post('date_expired');

			$this->form_validation->set_rules("type","Type Document",'required');
			$this->form_validation->set_rules("place","Place","required");
			//$this->form_validation->set_rules("number","Number");
			$this->form_validation->set_rules("date_issued","Date Issue","required");
			$this->form_validation->set_rules("date_expired","Expired Date","required");

			if($this->form_validation->run() == TRUE)
			{

				$str  = "update document_tr set 			 	 		 ";

				$str .= "type 					= '$type'			 	,";

				$str .= "place				    = '$place' 				,";

				$str .= "number				    = '$number'				,";

				$str .= "date_issued			= '$date_issued'		,";

				$str .= "date_expired			= '$date_expired'		,";

				$str .= "ip_address				= '".$_SERVER['REMOTE_ADDR']."',";

				$str .= "datetime				= now()					 ";

				$str .= "where		 							 		 ";

				$str .= "pelaut_id				= '$pelaut_id'	 and 	 ";

				$str .= "document_id			= '$document_id'	 	 ";
				

				$q = $this->db->query($str);

				if(!$q)
				{

					$this->db->_error_message();	

				}
				else
				{

					$result["message"] = "<div class='alert alert-success'> Data document Successfully Edited </div>";
					$result["status"] = "success";
				

				}

			}

			else

			{

				$result["message"] =  "<div class='alert alert-danger'>".validation_errors()." </div>";
				$result["status"] = "error";

			}
			
			return $result;


		}

		

		function update_document_process()

		{

			$this->load->library('form_validation');

			

			$pelaut_id 		  = $this->session->userdata("id_user");

			//Array ( [certificate] => [no_certificate] => [date_issue] => [place_issue] => )

			$document_id		 = $this->input->post("id_update",true);

			$type 				= $this->input->post("type",true);

			$number 			  = $this->input->post("number",true);

			$place 			   = $this->input->post("place",true);

			$date_issued		 = $this->input->post("date_issued");

			$date_expired		= $this->input->post("date_expired",true);

			

			$this->form_validation->set_rules("type","Type Document",'required');

			$this->form_validation->set_rules("place","Place","required");

			$this->form_validation->set_rules("number","Number","required");

			$this->form_validation->set_rules("date_issued","Date Issue","required");

			$this->form_validation->set_rules("date_expired","Expired Date","required");

			

			if($this->form_validation->run() == TRUE)

			{

				$str  = "update document_tr set 			 	 ";

				$str .= "type 					= '$type'			 	,";

				$str .= "place				    = '$place' 				,";

				$str .= "number				    = '$number'				,";

				$str .= "date_issued			= '$date_issued'		,";

				$str .= "date_expired			= '$date_expired'		,";

				$str .= "ip_addess				= '".$_SERVER['REMOTE_ADDR']."',";

				$str .= "datetime				= now()					 ";

				$str .= "where		 							 ";

				$str .= "pelaut_id				= '$pelaut_id'	 and 	 ";

				$str .= "document_id			= '$document_id'	 	 ";

				

				echo $str;

				

				$q = $this->db->query($str);

				

				if(!$q)

				{

					$this->db->_error_message();	

				}

				else

				{

					echo "<div class='alert alert-success'> Data document Successfully Edited </div>";

					echo "<script> setTimeout(function() { location.reload(); }, 2000); </script>";

				}

			}

			else

			{

				echo "<div class='alert alert-danger'>".validation_errors()." </div>";

			}

		}

		

		function delete_document_process()

		{

			$pelaut_id  	 = $this->session->userdata('id_user');

			$document_id = $this->input->post('id_update',true); // dari modal ( id_sertifikat ) 

			

			$str = "delete from document_tr where document_id = $document_id ";

			$q = $this->db->query($str);

			

			if(!$q)

			{

				$this->db->_error_message();

				

			}

			else

			{

				echo "<div class='alert alert-success'>this data document has Successfully Deleted </div> ";

				echo "<script> setTimeout(function() { location.reload(); }, 2000); </script>";

			}

		}



	}