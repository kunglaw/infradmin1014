<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Build to control page navigation system.
 * 
 * @author pulung
 * @copyright 2014 PT. Badr Interactive
 */


if (!function_exists('set_temp_data')) {
	/**
	 * Setting temporary data for next request.
	 * @param string $temp_data temporary data to be stored.
	 */
	function set_temp_data($index, $temp_data) {
		// get an instance of CI so we can access our configuration
		$CI =& get_instance();
		$CI->session->set_userdata($index, $temp_data);
	}
}

if (!function_exists('get_temp_data')) {
	/**
	 * Get temporary data.
	 */
	function get_temp_data($index) {
		// get an instance of CI so we can access our configuration
		$CI =& get_instance();
		return $CI->session->userdata($index);
	}
}

if (!function_exists('clear_temp_data')) {
	/**
	 * Clearing the temporary data.
	 */
	function clear_temp_data($index) {
		// get an instance of CI so we can access our configuration
		$CI =& get_instance();
		return $CI->session->unset_userdata($index);
	}
}


if (!function_exists('set_page_title')) {
	/**
	 * Set page title for each page.
	 * @param array $title title of the page.
	 */
	function set_page_title($title = "") {
		// get an instance of CI so we can access our configuration
		$CI =& get_instance();
		
		$CI->session->set_userdata("page_title", $title);
	}
}


if (!function_exists('get_page_title')) {
	/**
	 * Get page title for each page.
	 */
	function get_page_title() {
		// get an instance of CI so we can access our configuration
		$CI =& get_instance();

		return $CI->session->userdata("page_title");
	}
}


if (!function_exists('show_notification')) {
	/**
	 * Print notification if there's any of them.
	 */
	function show_notification() {

        // get notification data (if there's any)
        $notification_message = get_temp_data("notification_message");
        $notification_type = get_temp_data("notification_type");

        $data = array(
            "message" => "",
            "type" => ""
        );

        if ($notification_message && $notification_type) {

            $data["message"] = $notification_message;
            $data["type"] = $notification_type;

            // clear notification data after use.
            clear_temp_data("notification_message");
            clear_temp_data("notification_type");
        }

        // get an instance of CI so we can access our configuration
        $CI =& get_instance();
        $CI->load->view("element/notification", $data);

	}
}

if (!function_exists('get_notification')) {
    /**
     * Print notification if there's any of them.
     */
    function get_notification() {

        // get notification data (if there's any)
        $notification_message = get_temp_data("notification_message");
        $notification_type = get_temp_data("notification_type");

        $data = array();
        $result = "";

        if ($notification_message && $notification_type) {

            $data["message"] = $notification_message;
            $data["type"] = $notification_type;

            // clear notification data after use.
            clear_temp_data("notification_message");
            clear_temp_data("notification_type");

            // get an instance of CI so we can access our configuration
            $CI =& get_instance();
            $result = $CI->load->view("element/notification", $data, TRUE);

        }

        return $result;

    }
}

if (!function_exists('set_notification')) {
	/**
	 * Set a new notification
	 * @see show_notification() to show the notification.
	 */
	function set_notification($message, $type) {

		set_temp_data("notification_message", $message);
		set_temp_data("notification_type", $type);
	}
}

if (!function_exists('clear_notification')) {
    /**
     * Clear all notification
     * @see show_notification() to show the notification.
     */
    function clear_notification() {

        clear_temp_data("notification_message");
        clear_temp_data("notification_type");
    }
}
