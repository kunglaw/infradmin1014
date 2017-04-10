<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to assist in vessel operation.
 *
 * 
 * @copyright 	Badr Interactive
 * @link		http://badr-interactive.com
 */

if (!function_exists('get_vessel_delete_action')) {
	/**
	 * @param $status
	 * @return string
	 */
	function get_vessel_delete_action($id) {

		$button_html = '';

		$CI =& get_instance();

		$delete_request = $CI->generic->retrieve_one(
			"admin_ship_delete_request", array("ship_id" => $id));

		if ($CI->session->userdata("role") == USER_SUPER_ADMIN) {

			$button_html = '<a href="#" class="delete-one-button" data-toggle="modal" data-target="#delete-one-confirmation">'.
				'<i class="fa fa-trash-o"></i>' .
				'</a>';

		} else {

			if (empty($delete_request)) {

				$button_html = '<a href="#" class="delete-one-button" data-toggle="modal" data-target="#delete-one-confirmation">'.
					'<i class="fa fa-trash-o"></i>' .
					'</a>';

			} else {

				$button_html = '<i class="fa fa-trash-o" style="color: grey;"></i>';
			}


		}

		return $button_html;
	}
}

/* End of file debug_helper.php */