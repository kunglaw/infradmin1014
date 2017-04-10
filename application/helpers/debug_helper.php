<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to assist in debugging.
 * 
 * $Date: 2014-05-07 14:53:43 +0700 (Wed, 07 May 2014) $
 * $Revision: 37 $
 * $Author: pulung $
 * 
 * @copyright 	Badr Interactive
 * @link		http://badr-interactive.com
 */

if (!function_exists('dump_debug')) {
	/**
	 * Show dump result in beautiful view.
	 *
	 * @param $var
	 */
	function dump_debug($var) {
		echo "<pre>";
		var_dump($var);
		echo "</pre>";
	}
}

if (!function_exists('get_buffered_output')) {
	/**
	 * Buffered the output into variable.
	 * Ideal for send output to log files.
	 *
	 * @param $var
	 * @return string
	 */
	function get_buffered_output($var) {
		ob_start();
		var_dump($var);
		$dump_result = ob_get_clean();

		return $dump_result;
	}
}

/* End of file debug_helper.php */