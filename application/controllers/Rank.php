<?php 

	class Rank extends CI_Controller{
	
		function __construct()
		{
			
			parent::__construct();
			$this->db = $this->load->database("infr6975_2015",true);	
		}
		
		function get_rank()
		{
			
			
		}
		
		function call_rank($id_department="")
		{
			if($id_department == "")
			{
				$id_department = $this->input->post('id_department');
				
				$str = "select * from rank where id_department = '$id_department'";
				$q = $this->db->query($str);
				return $f = $q->result_array();	
			} 
			else
			{
				
				$str = "select * from rank where id_department = '$id_department'";
				$q = $this->db->query($str);
				return $f = $q->result_array();
			}		
		}
		
		function rankajax_bydept()
		{
			$id_department = $this->input->post('id_department');
			
			$rank = $this->call_rank($id_department);
			//print_r($rank);
			
			foreach($rank as $row)
			{
				echo "<option value='$row[rank_id]'>$row[rank]</option>";
			}
			
		}
	
	}