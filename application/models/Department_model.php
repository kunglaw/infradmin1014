<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');

class Department_model extends CI_Model{

	

	public function __construct()
	{

		$this->db = $this->load->database(DB2_GROUP,TRUE);	

	}

	function get_department()
	{

		$str = "select * from department";

		$q = $this->db->query($str);

		$f = $q->result_array();

		return $f;

	}

	public function get_detail_department($id = '') // department id
 	{

		$str   = "select * from department where department_id = '$id' ";

		$q 	 = $this->db->query($str);

		$f 	 = $q->row_array(); 	

		return $f;

	}

	function get_detail_department_by_name($name = '') // department id
 	{

		$str   = "select * from department where department = '$name' ";

		$q 	 = $this->db->query($str);

		$f 	 = $q->row_array(); 	

		return $f;
	

	}

	

	function insert_department()
	{

		

		

	}

	

	function update_department()
	{

		

		

	}


	function delete_department()
	{

		

		

	}

}



?>