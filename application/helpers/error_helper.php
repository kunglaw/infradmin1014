<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to assist in error reporting.
 * 
 * $Date: 2014-05-07 14:53:43 +0700 (Wed, 07 May 2014) $
 * $Revision: 37 $
 * $Author: pulung $
 * 
 * @copyright 	Badr Interactive
 * @link		http://badr-interactive.com
 */

if (!function_exists('pack_error_ajax')) {
    /**
     * @param array $fields
     * @return array
     */
	function pack_error_ajax($fields = array()) {

        $errors = array();

        foreach ($fields as $field) {

            $errors[$field] = form_error($field, " ", " ");
        }

        return $errors;
	}
}

if (!function_exists('pack_error_message_ajax')) {
    /**
     * @param array $validation_config
     * @return array
     */
    function pack_error_message_ajax($validation_config = array()) {

        $CI =& get_instance();

        $errors = array();

        foreach ($validation_config as $rule_name) {

            $rules = $CI->config->item($rule_name);

            foreach ($rules as $rule) {

                $errors[$rule["field"]] = form_error($rule["field"], " ", " ");
            }
        }

        return $errors;
    }
}

/* End of file error_helper.php */