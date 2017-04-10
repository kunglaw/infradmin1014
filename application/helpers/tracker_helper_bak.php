<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to track several things.
 * 
 * @copyright 	Badr Interactive
 * @link		http://badr.co.id
 */

if (! function_exists('track_seatizen')) {

    /**
     * Track any of seatizen action, save them in log.
     *
     * @param $action
     */
	function track_seatizen($action) {

        if (! empty($action)) {
            $CI =& get_instance();

            $CI->load->model("tracker_model", "tracker");
            $seatizen_id = 1; // @todo please change this to logged-in seatizen ID

            $CI->tracker->save_seatizen_action($seatizen_id, $action);
        }
	}
}

if (! function_exists('track_agentsea')) {

    /**
     * Track any of agentsea action, save them in log.
     *
     * @param $action
     */
	function track_agentsea($action) {

        if (! empty($action)) {
            $CI =& get_instance();

            $CI->load->model("tracker_model", "tracker");
            $agentsea_id = 1; // @todo please change this to logged-in agentsea ID

            $CI->tracker->save_agentsea_action($agentsea_id, $action);
        }
	}
}

if (! function_exists('track_vacantsea_visitor')) {

    /**
     * Track vacantsea visitor
     *
     * @param $vacantsea_id
     */
	function track_vacantsea_visitor($vacantsea_id) {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $seatizen_id = 1; // @todo please change this to logged-in seatizen ID

        $CI->tracker->save_vacantsea_visitor($seatizen_id, $vacantsea_id);
	}
}

if (! function_exists('track_seatizen_login')) {

    /**
     * Track any of seatizen login action
     */
    function track_seatizen_login() {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $seatizen_id = 1; // @todo please change this to logged-in seatizen ID

        $CI->tracker->save_login_seatizen_action($seatizen_id);

    }
}

if (! function_exists('track_agentsea_login')) {

    /**
     * Track any of agentsea login action
     */
    function track_agentsea_login() {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $agentsea_id = 1; // @todo please change this to logged-in agentsea ID

        $CI->tracker->save_login_agentsea_action($agentsea_id);

    }
}

if (! function_exists('track_new_agentsea')) {

    /**
     * Track newly registered agentsea
     */
    function track_new_agentsea() {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $agentsea_id = 1; // @todo please change this to newly registered agentsea ID

        $CI->tracker->save_new_agentsea_notification($agentsea_id);

    }
}

if (! function_exists('track_new_seatizen')) {

    /**
     * Track newly registered seatizen
     */
    function track_new_seatizen() {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $seatizen_id = 1; // @todo please change this to newly registered seatizen ID

        $CI->tracker->save_new_seatizen_notification($seatizen_id);

    }
}

/* End of file tracker_helper.php */