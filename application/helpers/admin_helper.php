<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to assist in admin operation.
 * 
 * @copyright 	2015 PT. Badr Interactive
 * @link		http://badr.co.id
 */

if (!function_exists('get_admin_status')) {


    function get_admin_status($role_id) {

        $CI =& get_instance();

        $role = $CI->generic->retrieve_one("admin_role", array("id" => $role_id));

        $status_name = "";
        if (! empty($role)) {
            $status_name = $role["name"];
        }

        return $status_name;
    }
}

if (!function_exists('describe_privileges')) {

    function describe_privileges($privileges) {

        $privileges = (int) $privileges;

        $CI =& get_instance();

        $pages = $CI->generic->retrieve_many("admin_pages");

        $privileges_desc = "";
        foreach($pages as $page) {

            $page["sign"] = (int) $page["sign"];

            if ($privileges & $page["sign"]) {

                if ($privileges_desc != "") {
                    $privileges_desc .= ", ";
                }

                $privileges_desc .= $page["name"];
            }
        }

        return $privileges_desc;
    }
}

if (!function_exists('get_admin_delete_link')) {

    /**
     * Get admin delete link
     * @return int
     */
    function get_admin_delete_link($email, $id) {
		$delete_link = '';
	
		if($email != MASTER_EMAIL) {
			$delete_link = '<a href="#" class="delete-one-button" data-toggle="modal" data-target="#delete-one-confirmation">'.
            '<i class="fa fa-trash-o"></i>' .
            '</a><input type="hidden" class="object-id" value="'. $id .'">';
		}
		
		return $delete_link;
	}
}

if (!function_exists('get_admin_checkboxes')) {

    /**
     * Get admin checkbox
     * @return int
     */
    function get_admin_checkboxes($email, $id) {
		$checkbox = '';
	
		if($email != MASTER_EMAIL) {
			$checkbox = form_checkbox("list_checkboxes[]", $id);
		}
		
		return $checkbox;
	}
}

/* End of file access_helper.php */