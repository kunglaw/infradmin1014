<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');



class Experience_model extends CI_Model{

	

	public function __construct()
	{

		$this->db = $this->load->database(DB2_GROUP,TRUE);	

	}


	function get_experience_pelaut($username = "")
	{

		if($username == "")

		{

			$pelaut_id = $this->input->post('id_pelaut');

		}

		else

		{

			$this->load->model("users/user_model");

			$pelaut = $this->user_model->get_detail_pelaut($username);

			$pelaut_id = $pelaut['pelaut_id'];	

		}

			
if($pelaut_id == "") return null;
			else{
		$str_experience = "SELECT * from experiences where pelaut_id = '$pelaut_id' order by periode_to desc ";

		$q_experience =  $this->db->query($str_experience);

		$f_experience = $q_experience->result_array();

		

		return $f_experience;
}
	}

	

	function last_experience($id_pelaut = '')
	{
		if(empty($id_pelaut))
		{
			$id_pelaut = $this->post->input('is_pelaut');
		}
		
		$str = "select * from experiences where pelaut_id = '$id_pelaut' order by last_update DESC LIMIT 1 ";

		$q = $this->db->query($str);

		$f = $q->row_array();

		

		return $f;

	}

	

	// untuk experience-panel

	function get_exp_gbcompany($pelaut_id = "")

	{

		if($pelaut_id == "")

		{

			$pelaut_id = $this->session->userdata("id_user");

		}

		$str = "select * from experiences where pelaut_id = '$pelaut_id' group by company order by experience_id DESC";

		$q = $this->db->query($str);

		$f = $q->result_array();

		

		return $f;

	}

	

	function get_experience_detail() // by experience_id

	{

		$experience_id = $this->input->post("id_update");

		$str = "select * from experiences where experience_id = '$experience_id' ";

		$q = $this->db->query($str);

		$f = $q->row_array();

		return $f;

		

	}

	function delete_experience_process()

	{

		$pelaut_id     = $this->input->post('pelaut_id');

		$experience_id = $this->input->post('id_update',true); // dari modal ( id_license ) 

		

		$str = "delete from experiences where experience_id = '$experience_id' ";

		$q = $this->db->query($str);

		

		if(!$q)

		{

			$this->db->_error_message();

			

		}

		else

		{

			echo "<div class='alert alert-success'>this data Experience has Successfully Deleted </div> ";

		}

	}

	function total_exp_rank($id_pelaut = 5)
	{
		
		$sql 	= "SELECT periode_from, periode_to , SUM(datediff(periode_to, periode_from)) as total_experience 
		FROM experiences WHERE pelaut_id = '$id_pelaut' ";
		$query	= $this->db->query($sql);
		$f		= $query->row_array();

		$total_hari = $f["total_experience"];

		if ($total_hari >= 365) {
			//total dibagi 365
			$tahun      = floor($total_hari/365);
			//sisa pembagian tahun, dibagi 30 
			$sisa_thn   = $total_hari%365;
			$bulan      = floor($sisa_thn/30);
			//sisa pembagian tahun, di modulus 30(bulan)
			$hari       = $sisa_thn%30;

			return $tahun. " years"; //.$bulan." months, ".$hari." days";                           

		}elseif ($total_hari >= 30) {
			$bulan      = floor($total_hari/30);
			$hari       = $total_hari%30;
			
			return $bulan. " months"; //.$hari." days";

		}elseif ($total_hari >= 1) {
			
			return $total_hari ." days";

		}else{
			return " no sea record";
		}	
		
	}
	
	function total_experience_ship($id_pelaut,$ship_type)
	{	
		$sql 	= "SELECT periode_from, periode_to , SUM(datediff(periode_to, periode_from)) as total_experience FROM experiences WHERE ship_type_id = '$ship_type' AND pelaut_id = '$id_pelaut' ";
		
		$query	= $this->db->query($sql);
		$f		= $query->row_array();

		$total_hari = $f["total_experience"];

		if ($total_hari >= 365) {
			//total dibagi 365
			$tahun      = floor($total_hari/365);
			//sisa pembagian tahun, dibagi 30 
			$sisa_thn   = $total_hari%365;
			$bulan      = floor($sisa_thn/30);
			//sisa pembagian tahun, di modulus 30(bulan)
			$hari       = $sisa_thn%30;

			return $tahun. " years"; //.$bulan." months, ".$hari." days";                           

		}elseif ($total_hari >= 30) {
			$bulan      = floor($total_hari/30);
			$hari       = $total_hari%30;
			
			return $bulan. " months"; //.$hari." days";

		}elseif ($total_hari >= 1) {
			
			return $total_hari ." days";

		}else{
			return " no sea record";
		}	
		
		
	}

	function add_experience_process()

	{

		$this->load->library("form_validation");

		

		

		

		$ship_name 		= $this->input->post("vessel_name");

		$rank_id 		= $this->input->post("rank_id");

		$company	    = $this->input->post("company");

		$periode_from   = $this->input->post("periode_from");

		$periode_to 	 = $this->input->post("periode_to");

		$pelaut_id	  = $this->input->post("pelaut_id");

		$ship_type	  = $this->input->post("ship_type");	

		$trade_area_line= $this->input->post("trade_area_line");

		$weight		 = $this->input->post("weight");

		$satuan		 = $this->input->post("satuan");

		

		$this->form_validation->set_rules("vessel_name","Ship","required");

		$this->form_validation->set_rules("rank_id","Rank","required");

		$this->form_validation->set_rules("company","Company","required");

		$this->form_validation->set_rules("periode_from","Periode From",'required');

		$this->form_validation->set_rules("periode_to","Periode To","required");

		$this->form_validation->set_rules("ship_type","Ship Type","required");

		

		

		

		if($this->form_validation->run() == TRUE)

		{		

		  $str_experience  = "insert into experiences set 	 	 	 ";

		  $str_experience .= "ship_name 		= '$ship_name'			,";

		  $str_experience .= "ship_type_id	= '$ship_type'			,";

		  $str_experience .= "rank_id 		= '$rank_id'			,";

		  $str_experience .= "company		= '$company'			,";	

		  $str_experience .= "periode_from	= '$periode_from'		,";

		  $str_experience .= "periode_to 	= '$periode_to'			,";

		  $str_experience .= "datetime		= now()					,";

		  $str_experience .= "last_update	= now()					,";

		  $str_experience .= "trade_area		= '$trade_area_line'	,";

		  $str_experience .= "weight			= '$weight'				,";

		  $str_experience .= "satuan			= '$satuan'				,";

		  $str_experience .= "pelaut_id  	= '$pelaut_id'			 ";

		  

		  

		  $q = $this->db->query($str_experience);

		  

		  if(!$q)

		  {

			  $this->db->_error_message();

		  }

		  else

		  {

			  echo "<div class='alert alert-success'>this data Experience has Successfully Added </div> ";

			  echo "<script> setTimeout(function() { location.reload(); }, 2000); </script>";

		  }

		}

		else

		{

			echo "<div class='alert alert-danger'>".validation_errors()."</div>";

		}

		

	}

	

	function update_experience_process()

	{

		$this->load->library("form_validation");

		

		//print_r($this->input->post());

		$experience_id  = $this->input->post("experience_id");

		

		

		$ship_name 		  = $this->input->post("vessel_name");

		$rank_id 			= $this->input->post("rank_id");

		$company 	 		= $this->input->post("company");

		$periode_from   	   = $this->input->post("periode_from");

		$periode_to 	 	 = $this->input->post("periode_to");

		$pelaut_id	      = $this->input->post("pelaut_id");

		$ship_type      	  = $this->input->post("ship_type");	

		$trade_area_line	= $this->input->post("trade_area_line");

		$weight             = $this->input->post("weight");

		$satuan             = $this->input->post("satuan");

		

		$this->form_validation->set_rules("vessel_name","Ship","required");

		$this->form_validation->set_rules("rank_id","Rank","required");

		$this->form_validation->set_rules("company","Company","required");

		$this->form_validation->set_rules("periode_from","Periode From",'required');

		$this->form_validation->set_rules("periode_to","Periode To","required");

		$this->form_validation->set_rules("ship_type","Ship Type","required");

		

		if($this->form_validation->run() == TRUE)

		{		

		  $str_experience  = "update experiences set 	 	 	 	 ";

		  $str_experience .= "ship_name 		= '$ship_name'			,";

		  $str_experience .= "ship_type_id	= '$ship_type'			,";

		  $str_experience .= "rank_id 		= '$rank_id'			,";

		  $str_experience .= "company		= '$company'			,";	

		  $str_experience .= "periode_from	= '$periode_from'		,";

		  $str_experience .= "periode_to 	= '$periode_to'			,";

		  $str_experience .= "last_update	= now()					,";

		  $str_experience .= "trade_area		= '$trade_area_line'	,";

		  $str_experience .= "weight			= '$weight'				,";

		  $str_experience .= "satuan			= '$satuan'				,";

		  $str_experience .= "pelaut_id  	= '$pelaut_id'			 ";

		  $str_experience .= "where experience_id = $experience_id	 ";

		  

		 

		  //echo $err = $this->db->_error_message();

		  $q = $this->db->query($str_experience);

		  //var_dump($q); exit;

		  

		  if($q == false)

		  {

			 

		  }

		  else

		  {

			  echo "<div class='alert alert-success'>this data Experience has Successfully Updated </div> ";

			  echo "<script> setTimeout(function() { location.reload(); }, 2000); </script>";

		  }

		}

		else

		{

			echo "<div class='alert alert-danger'>".validation_errors()."</div>";

		}

		

	}

	

	function __destruct()

	{

			

	}

	

	

	

	

}