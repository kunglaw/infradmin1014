<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

	class Report_model extends CI_Model {

		function __construct(){
					$this->db = $this->load->database(DB2_GROUP,TRUE);	
					$this->db2 = $this->load->database(DB_GROUP,TRUE);
		}	

		function get_report_all(){

			$str = $this->db->query("SELECT * FROM report_problem WHERE status_report = '' OR status_report != 'success' order by id_report Desc");
			$q = $str->result_array();
			return $q;
		}

		function detail_report($id_report){
			$str = "SELECT * FROM report_problem WHERE id_report = '$id_report'";
			$q = $this->db->query($str);
			$f = $q->row_array();
			return $f;
		}

		function detail_username($id_user){
			$str = "SELECT * FROM pelaut_ms WHERE pelaut_id = '$id_user'";
			$q = $this->db->query($str);
			$f=  $q->row_array();
			return $f;
		}

		function detail_company($id_user){
			$str = "SELECT * FROM perusahaan WHERE id_perusahaan = '$id_user'";
			$q = $this->db->query($str);
			$f = $q->row_array();
			return $f;
		}

		function get_all_pic(){
			$str = "SELECT * FROM admin_user WHERE role != 1";

			$q = $this->db2->query($str);
			$f = $q->result_array();
			return $f;

		}

		function update_pic($pic,$id){
			$str = "UPDATE report_problem SET 
			pic = '$pic' WHERE id_report = '$id'";
			$q = $this->db->query($str);
			if($q){
				return TRUE;
			} else {
				return FALSE;
			}
			
		}

		function update_report($solution_report,$status_report,$id_report){
			    	$time_response = date('Y-m-d H:i:s');
		$f = $this->db->query("SELECT * FROM report_problem WHERE id_report = '$id_report'");
			$z = $f->row_array();



				$za = "UPDATE history_report SET solution_report = '$solution_report',status = '$status_report' WHERE id_report = '$id_report' AND pic = '$z[pic]'";
				$zz = $this->db->query($za);


			$str = "UPDATE report_problem SET 
				 solution_report  = '$solution_report',
				 status_report = '$status_report',
				 time_reponse = '$time_response'
				 WHERE id_report = '$id_report'";
			$q = $this->db->query($str);


		}

		function get_pic($id_report){
			$str = "SELECT * FROM report_problem WHERE id_report = '$id_report'";
			$q = $this->db->query($str);
			$f = $q->row_array();
			return $f;
		}

		function report_admin($id_admin){
			$str = "SELECT * FROM report_problem WHERE pic = '$id_admin' AND (status_report = '' OR status_report ='pending')";
			$q = $this->db->query($str);
			$f=  $q->result_array();
			return $f;
		}

		function all_report(){
			$str = "SELECT * FROM report_problem ORDER BY id_report DESC";
			$q = $this->db->query($str);
			$f = $q->result_array();
			return $f;
		}

		function add_history($id,$pic,$superadmin,$status){
			$waktu = date('Y-m-d H:i:s');
			$str = "INSERT INTO history_report (id_report,pic,superadmin,status,waktu) VALUES ('$id','$pic','$superadmin','$status','$waktu')";
			$q = $this->db->query($str);
		}

		function get_history($id){
			$str = "SELECT * FROM history_report WHERE id_report = '$id'";
			$q = $this->db->query($str);
			$f = $q->result_array();
			return $f;
		}

		function update_history(){

		}

		
	}