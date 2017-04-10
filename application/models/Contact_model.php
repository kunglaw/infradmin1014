<?php if(!defined('BASEPATH')) exit('NO direct script access allowed');

	

	class Contact_model extends CI_Model {		





		function __construct(){



					$this->db = $this->load->database(DB2_GROUP,TRUE);	

					$this->db2 = $this->load->database(DB_GROUP,TRUE);

		}



		function all_contact(){

			$str = $this->db->query("SELECT  * FROM contact_us ORDER BY waktu_pengirim DESC");

			$q = $str->result_array();

			return $q;

		}



		function detail_contact($id){

			$str = "SELECT * FROM contact_us WHERE id_contact = '$id'";

			$q = $this->db->query($str);

			$f = $q->row_array();

			return $f;

		}



		function updatedata($id,$su,$mes){

			$waktu = date('Y-m-d H:i:s');

			$nama = $this->session->userdata('name');

			$str = "UPDATE contact_us SET reply_by = '$nama', waktu_reply = '$waktu',subject_reply = '$su',message_reply = '$mes'

			 WHERE id_contact = '$id'";

			$z = $this->db->query($str);

			return $z;



		}



	}