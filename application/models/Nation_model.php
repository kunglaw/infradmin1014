<?php
	
	class Nation_model extends CI_Model{
		
		public function __construct()
		{
			$this->db = $this->load->database(DB2_GROUP,TRUE);	
		}
		
		public function get_nationality()
		{
			$str = "select * from nationality";
			$q = $this->db->query($str);
			$f = $q->result_array();
			
			return $f;	
			
		}
		
		public function get_detail_nationality($nation)
		{
			$str = "select * from nationality where name LIKE '$nation' or id = '$nation' ";
			$q = $this->db->query($str);
			$f = $q->row_array();
			
			return $f;	
			
		}

		public function get_nationality_pelaut($id_pelaut){
			$str = "SELECT * FROM pelaut_ms WHERE pelaut_id = '$id_pelaut'";
			$q = $this->db->query($str);
			$f = $q->row_array();
			return $f;
		}

		function get_nationality_except($kebangsaan){
			$str = "SELECT * FROM nationality WHERE name != '$kebangsaan' OR name <> '$kebangsaan'";
			
			$q = $this->db->query($str);

			$f = $q->result_array();
			return $f;
		}
		
	}

?>