<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');



class coc_model extends CI_model{

	

	function __construct()

	{
		$this->db = $this->load->database(DB2_GROUP,true);
	}

	function get_coc_class() // punya model sendiri coc_model

	{

		$str 	= "select * from coc_class ";

		$q 	  = $this->db->query($str);

		$f 	  = $q->result_array();

		

		return $f;  	

	} 

	

	function get_coc_detail($id)

	{

		$str 	= "select * from coc_class where id_coc_class = '$id' ";

		$q 	  = $this->db->query($str);

		$f 	  = $q->row_array();

		

		return $f;

		

	}

	

	function get_coc_bydept($id)

	{

		$str 	= "select * from coc_class where department_id = '$id' ";

		$q 	  = $this->db->query($str);

		$f 	  = $q->result_array();

		

		return $f;

	}

	

	function get_coc_by_name($coc){

		

		$str = "select * from coc_class where coc_class = '$coc'";

		$q = $this->db->query($str);

		$f = $q->result_array();

		return $f;

		

	}



	function get_detail_coc_by_name($coc){

		

		$str = "SELECT * FROM coc_class WHERE coc_class = '$coc'";

		$q = $this->db->query($str);

		$f = $q->row_array();

		return $f;

	}

	

	

	

	function insert_coc()

	{

		

	}

	

	function update_coc()

	{

		

		

	}

	

	function delete_coc()

	{

		

		

	}

	

	

}

	







