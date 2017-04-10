<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Special model for vacantsea
 *
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_DB_active_record $_current_db
 *
 * @copyright PT. Badr Interactive (c) 2015
 * @author pulung
 */
class Vacantsea_model extends CI_Model {

    // current database object used
    private $_current_db = NULL;
    private $_primary_table = "vacantsea";

    /**
     * Load database with database name options
     * @param string $database_name
     */
    public function __construct($database_name = DB2_GROUP) {

        $this->_current_db = $this->load->database($database_name, TRUE);
		$this->db2 = $this->load->database(DB2_GROUP,TRUE);
		
        // set timezone for further db query.
        $this->_current_db->query("SET time_zone = '+7:00'");
    }
	
	function list_vacantsea()
	{
		// WHERE b.tampil = 1
		$str = "SELECT a.*,b.tampil 
		FROM vacantsea a LEFT JOIN perusahaan b ON a.id_perusahaan = b.id_perusahaan ORDER BY a.create_date DESC";	
		
		$q = $this->db2->query($str);
		
		$f = $q->result_array();
		
		return $f;
		
	}

    function call_department()
    {
        $str = "select * from department";
        $q = $this->db2->query($str);
        return $f = $q->result_array();
    }
	
	function applicant_list_all()
	{
		$str = "SELECT * FROM applicant_tr ORDER BY datetime DESC";
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;
		
	}
	
	function applicant_list($id_vacantsea)
	{
		$str = "SELECT * FROM applicant_tr WHERE id_vacantsea = '$id_vacantsea' ";
		$q = $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;	
	}
	
	function log_vacantsea($id_vacantsea)
	{
		$str = "SELECT * FROM log_vacantsea WHERE vacantsea_id = '$id_vacantsea' ORDER BY action_time DESC ";
		$q= $this->db2->query($str);
		$f = $q->result_array();
		
		return $f;	
	}
	
	function vacantsea_detail($vacantsea_id)
	{
		$str = "SELECT * FROM vacantsea WHERE vacantsea_id = '$vacantsea_id' ";
		$q = $this->db2->query($str);
		$f = $q->row_array();
		
		return $f;	
	}
	
    /**
     * Get total vacantsea in a month, per day grouping.
     *
     * @param null $year
     * @param null $month
     * @return int
     */
    public function get_total_vacantsea_in_a_month($year = NULL, $month = NULL) {

        if ($year == NULL || $month == NULL) {
            $year = date("Y");
            $month = date("m");
        }

        // check if table exist in db.
        if (!$this->_current_db->table_exists($this->_primary_table)) {
            return NULL;
        }

        $this->_current_db->select(
            "DAY(". $this->_primary_table .".create_date) AS day, ".
            "COUNT(". $this->_primary_table .".create_date) AS total"
        );

        $this->_current_db->where("YEAR(". $this->_primary_table .".create_date)", $year);
        $this->_current_db->where("MONTH(". $this->_primary_table .".create_date)", $month);

        $this->_current_db->group_by($this->_primary_table .".create_date");
        $this->_current_db->order_by("day", "ASC");

        $query = $this->_current_db->get($this->_primary_table);

        return $query->result_array();
    }
}