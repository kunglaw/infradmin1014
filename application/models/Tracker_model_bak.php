<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for tracking purposes
 *
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_DB_active_record $_current_db
 *
 * @copyright PT. Badr Interactive (c) 2015
 * @author pulung
 */
class Tracker_model extends CI_Model {

    // current database object used
    private $_current_db = NULL;
    private $_seatizen_table = "log_seatizen";
    private $_agentsea_table = "log_agentsea";
    private $_vacantsea_table = "log_vacantsea";
    private $_login_seatizen_table = "log_login_seatizen";
    private $_login_agentsea_table = "log_login_agentsea";

    private $_notification_table = "admin_message";

    /**
     * Load database with database name options
     * @param string $database_name
     */
    public function __construct($database_name = "") {

        $this->_current_db = $this->load->database($database_name, TRUE);

        // set timezone for further db query.
        $this->_current_db->query("SET time_zone = '+7:00'");
    }

    /**
     * Save seatizen action in text
     *
     * @param $seatizen_id
     * @param $action
     */
    public function save_seatizen_action($seatizen_id, $action) {

        $log = array(
            "seatizen_id" => $seatizen_id,
            "action" => $action
        );

        $this->db->insert($this->_seatizen_table, $log);

    }

    /**
     * Save agentsea action in text
     *
     * @param $agentsea_id
     * @param $action
     */
    public function save_agentsea_action($agentsea_id, $action) {

        $log = array(
            "agentsea_id" => $agentsea_id,
            "action" => $action
        );

        $this->db->insert($this->_agentsea_table, $log);

    }

    /**
     * Save vacantsea visitor
     *
     * @param $seatizen_id
     * @param $vacantsea_id
     */
    public function save_vacantsea_visitor($seatizen_id, $vacantsea_id) {

        $log = array(
            "seatizen_id" => $seatizen_id,
            "vacantsea_id" => $vacantsea_id
        );

        $query = $this->db->get_where($this->_vacantsea_table, $log);
        $result = $query->row_array();

        if (empty($result)) {
            $this->db->insert($this->_vacantsea_table, $log);
        }

    }

    /**
     * Save login action
     *
     * @param $seatizen_id
     */
    public function save_login_seatizen_action($seatizen_id) {

        $log = array(
            "seatizen_id" => $seatizen_id
        );

        $this->db->insert($this->_login_seatizen_table, $log);

    }

    /**
     * Save login action
     *
     * @param $agentsea_id
     */
    public function save_login_agentsea_action($agentsea_id) {

        $log = array(
            "agentsea_id" => $agentsea_id
        );

        $this->db->insert($this->_login_agentsea_table, $log);

    }

    /**
     * Save new agentsea notification
     *
     * @param $agentsea_id
     */
    public function save_new_agentsea_notification($agentsea_id) {

        $notification = array(
            "source" => NULL,
            "destination" => NULL,
            "type" => 2,
            "target" => $agentsea_id
        );

        $this->db->insert($this->_notification_table, $notification);

    }

    /**
     * Save new seatizen notification
     *
     * @param $seatizen_id
     */
    public function save_new_seatizen_notification($seatizen_id) {

        $notification = array(
            "source" => NULL,
            "destination" => NULL,
            "type" => 1,
            "target" => $seatizen_id
        );

        $this->db->insert($this->_notification_table, $notification);

    }
}