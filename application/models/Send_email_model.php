<?php

class Send_email_model extends CI_model{
	
	 // current database object used
    private $_current_db = NULL;
    private $_primary_table = "pelaut_ms";
	
	private $db;

    /**
     * Load database with database name options
     * @param string $database_name
     */
    public function __construct() {

		parent::__construct();
		
		$this->db = $this->load->database("default",true);
       
    }
	
	public function get_email()
	{
		$str = "SELECT * FROM admin_send_email ORDER BY datetime DESC";
		$q   = $this->db->query($str);
		$f   = $q->result_array();
		
		return $f; 
		
	}
	
	function get_email_agentsea()
	{
		$str = "SELECT * FROM admin_send_email_agentsea ORDER BY datetime DESC";
		$q   = $this->db->query($str);
		$f   = $q->result_array();
		
		return $f; 
			
	}
	
	public function get_email_detail($id)
	{
		$str = "SELECT * FROM admin_send_email WHERE id = '$id'";
		$q   = $this->db->query($str);
		$f   = $q->row_array();
		
		return $f; 
		
	}

	function insert_data_contract($dt)
	{
		# code...
		$q = "INSERT INTO admin_offer_contract values (
			'',
			'$dt[nama_perusahaan]',
			'$dt[alamat_perusahaan]',
			'$dt[telp_perusahaan]',
			'$dt[pic]',
			'$dt[jabatan_pic]',
			now(),
			'$dt[content]',
			'0','0','0',
			now(), '$dt[token]'
		)";

		$this->db->query($q);
		return $this->db->insert_id();
	}
	
	function delete_email($id)
	{
		$str = "DELETE from admin_send_email WHERE id = '$id'";
		$q = $this->db->query($str);
		
		return $q;	
	}
	
	public function list_agentsea()
	{
		// khusus untuk email saja 
		$str = "SELECT *
		FROM `infr6975_informaseadb2015`.`perusahaan`
		WHERE `tampil` =1
		AND `activation_code` = 'ACTIVE'
		ORDER BY `id_perusahaan` DESC
		LIMIT 8 ";
		
		$q = $this->db->query($str);
		
		return $dt_agentsea = $q->result_array();
	}
	
	public function list_seatizen()
	{
		// khusus untuk email saja
		$a = $this->load->database(DB2_GROUP,true);
	
		$str = "SELECT *
		FROM `infr6975_informaseadb2015`.`pelaut_ms`
		WHERE `activation` = 'ACTIVE' and `show` = TRUE
		ORDER BY `pelaut_id` DESC
		LIMIT 8 ";
		
		$q = $a->query($str);
		
		return $dt_seatizen = $q->result_array();
	}
	
	public function list_vacantsea()
	{
		// khusus untuk email saja
		$aaa = $this->load->database(DB2_GROUP,true);
		$str = " SELECT a.*,b.tampil FROM vacantsea a LEFT JOIN perusahaan b ON 
		
		a.id_perusahaan = b.id_perusahaan
		WHERE 
		`stat` = 'open' AND b.tampil = 1 ";
		
		$q = $aaa->query($str);
		
		return $dt_vacantsea = $q->result_array();	
		
	}
	
	public function insert_data_email($dt)
	{
		
		
		$str  = "INSERT INTO admin_send_email SET    ";
		$str .= "name 			= '$dt[name]' 	    ,";
		$str .= "email_to		= '$dt[email_to]'   ,";
		$str .= "subject		= '$dt[subject]'	,";
		$str .= "content		= '$dt[content]'	,";
		$str .= "attachment		= '$dt[attachment]'	,";
		$str .= "template		= '".mysql_real_escape_string('$dt[template]')."',";
		$str .= "type_email		= '$dt[type_email]'	,";
		$str .= "pic			= '$dt[pic]'		,";
		$str .= "ip_address		= '$dt[ip_address]'	,";
		$str .= "user_agent		= '$dt[user_agent]'	 ";
		
		$q = $this->db->query($str);
		
		return $q;
			
	}
	
	public function update_data_email()
	{
		
		
		
	}
	
	
}