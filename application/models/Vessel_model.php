<?php if(!defined('BASEPATH')) exit ('no direct script access allowed ');

class Vessel_model extends CI_Model{
	
	public function __construct()
	{
		$this->db = $this->load->database(DB2_GROUP,TRUE);	
	}
	
	function get_ship() // vessel
	{
		$str = "select * from ship";
		$q = $this->db->query($str);
		$f = $q->result_array();
		
		return $f;	
	}
	
	function get_ship_type_json()
	{
		$term = $this->input->post("vessel_id");
		
		
		if(empty($term))
		{
			$str1 = "select * from ship_type";
			$q1   = $this->db->query($str1);
			$f1   = $q1->result_array();
			
			foreach($f1 as $vessel)
			{
				$a['type_id'] = $vessel['type_id'];
				$a['ship_type'] = $vessel['ship_type'];
				
				$hasil[] = $a;
				
			} 	
			
			echo json_encode($f1);
			//echo $term; exit;
			
				
		}
		else if(!empty($term))
		{
		  $str = "select * from ship where id_ship_type LIKE '%$term%'";
		  $q = $this->db->query($str);
		  $f = $q->row_array();
		  
		  if(!empty($f))
		  {
		  
			$str1 = "select * from ship_type where type_id = '$f[id_ship_type]'";
			$q1 = $this->db->query($str1);
			$f1 = $q1->row_array();
		  
		  	echo "<option value='$f1[type_id]'>$f1[ship_type]</option>";
		  }
		  else
		  {
			$str1 = "select * from ship_type";
			$q1   = $this->db->query($str1);
			$f1   = $q1->result_array();
			
			foreach($f1 as $vessel)
			{
				$a['type_id'] = $vessel['type_id'];
				$a['ship_type'] = $vessel['ship_type'];
				
				echo "<option value='$a[type_id]'>$a[ship_type]</option>";
				
			} 
			
			 
		  }
		}
		
		
		//print_r($f);
	
	}
	
	function get_ship_json()
	{
		//echo $term = $this->input->get("term");
		$str = "select * from ship";
		$q = $this->db->query($str);
		$f = $q->result_array();
		
		//print_r($f);
		
		foreach($f as $vessel)
		{
			$a['ship_id'] = $vessel['ship_id'];
			$a['ship_name'] = $vessel['ship_name'];
			
			$hasil[] = $a;
		}
		
		echo json_encode($hasil);
	}
	
	function get_ship_type()
	{
		$str = "select * from ship_type";
		$q = $this->db->query($str);
		$f = $q->result_array();
		
		return $f;
		
	}
	
	// get ship_type by ship_id 
	function get_shiptype_byshipid($type_id)
	{
		// type_id didapat dari table ship 
		$str = "select * from ship_type where type_id = '$type_id' ";
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;
		
		
		
	}
	
	// get ship by type_id
	function get_ship_bytypeid($type_id)
	{
		$str = "select * from ship where id_ship_type = '$type_id' ";
		$q = $this->db->query($str);
		$f = $q->result_array();
		
		return $f;
		
	}
	
	function get_ship_detail($ship_id) // by ship_id
	{
		$str = "select * from ship where ship_id = '$ship_id' ";	
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;
		
	}
	
	function get_ship_type_detail($type_id) // 
	{
		$str = "select * from ship_type where type_id = '$type_id' ";
		$q = $this->db->query($str);
		$f = $q->row_array();
		
		return $f;	
		
	}

    function get_ship_type_detail_byname($name) //
    {
        $str = "select * from ship_type where ship_type = '$name'";
        $q = $this->db->query($str);
        $f = $q->row_array();

        return $f;

    }
	
	// left panel
	function get_ship_byname($ship_name)
	{
		
		// type_id didapat dari table ship 
		$str = "select * from ship where ship = '$ship_name' order by ship_id DESC LIMIT 5 ";
		$q = $this->db->query($str);
		$f = $q->result_array();
		
		return $f;
	}
	
	// right panel 
	function ship_panel()
	{
		$str = "select * from ship order by ship_id DESC LIMIT 5";
		$q = $this->db->query($str);
		$f = $q->result_array();
		
		return $f;
			
	}

	function detail_ship_by_name($name){
		$str = "SELECT * FROM ship_type WHERE ship_type = '$name'";
		$q = $this->db->query($str);
		$f = $q->row_array();
		return $f;
	}
	
	
	
	
	
}