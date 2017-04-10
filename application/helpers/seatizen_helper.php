<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to assist in seatizen operation.
 *
 * 
 * @copyright 	Badr Interactive
 * @link		http://badr-interactive.com
 */

if (!function_exists('get_seatizen_block_action')) {
	/**
	 * @param $status
	 * @return string
	 */
	function get_seatizen_block_action($status, $id) {

		$button_html = '';

		$CI =& get_instance();

		if ($CI->session->userdata("role") == USER_SUPER_ADMIN) {

			if ($status == "ACTIVE") {

				$button_html =
					'<a href="#" class="block-one-button" data-toggle="modal" data-target="#block-one-confirmation">'.
					'<i class="fa fa-ban"></i></a>';

			} else if ($status == "BLOCKED") {

				$button_html =
					'<a href="#" class="unblock-one-button" data-toggle="modal" data-target="#unblock-one-confirmation">'.
					'<i class="fa fa-unlock"></i></a>';
			}

		} else {

			if ($status == "ACTIVE") {

				$previous_request = $CI->generic->retrieve_one(
					"admin_message",
					array(
						"type" => NOTIF_BLOCK_SEATIZEN,
						"target" => $id,
						"status <" => 2
					)
				);

				if (count($previous_request) > 0) {
					$button_html =
						'<i class="fa fa-ban" style="color: grey;"></i>';
				} else {
					$button_html =
						'<a href="#" class="block-one-button" data-toggle="modal" data-target="#block-one-confirmation">'.
						'<i class="fa fa-ban"></i></a>';
				}

			} else if ($status == "BLOCKED") {

				$previous_request = $CI->generic->retrieve_one(
					"admin_message",
					array(
						"type" => NOTIF_UNBLOCK_SEATIZEN,
						"target" => $id,
						"status <" => 2
					)
				);

				if (count($previous_request) > 0) {
					$button_html =
						'<i class="fa fa-unlock" style="color: grey;"></i>';
				} else {
					$button_html =
						'<a href="#" class="unblock-one-button" data-toggle="modal" data-target="#unblock-one-confirmation">'.
						'<i class="fa fa-unlock"></i></a>';
				}
			}


		}



		return $button_html;
	}
}

/* End of file debug_helper.php */