<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to assist in access operation.
 * 
 * $Date: 2014-05-07 14:53:43 +0700 (Wed, 07 May 2014) $
 * $Revision: 37 $
 * $Author: pulung $
 * 
 * @copyright 	2014 PT. Badr Interactive
 * @link		http://badr.co.id
 */

if (!function_exists('check_token')) {

    /**
     * Check if recovery data is available via token.
     * @param $token
     * @return bool
     */
	function check_token($token) {

        $ci =& get_instance();

        $recovery_data = $ci->generic_model->retrieve_one(
            "admin_password_recovery", array("token" => $token));

        return $recovery_data ? TRUE : FALSE;
	}
}

if (!function_exists('get_user_by_token')) {

    /**
     * Check if token exists in API request.
     * @param $token
     * @return bool
     */
    function get_user_by_token($token) {

        $ci =& get_instance();

        delete_expired_token();

        $user_data = NULL;

        if ($token) {
            $token_data = $ci->generic_model->retrieve_one(
                "api_access", array("token" => $token)
            );

            if ($token_data) {
                $user_data = $ci->generic_model->retrieve_one(
                    "user", array("id" => $token_data["user_id"])
                );
            }
        }

        return $user_data;
    }
}

if (!function_exists('delete_expired_token')) {

    /**
     * Delete expired token.
     * @return bool
     */
    function delete_expired_token() {

        $ci =& get_instance();

        $ci->load->helper("date");
        $expiration_limit = strtotime("-7 day");
        $expiration_limit = mdate("%Y-%m-%d %h:%i:%s", $expiration_limit);

        $ci->generic_model->delete(
            "api_access", array("create_time < " => $expiration_limit)
        );
    }
}

if ( ! function_exists('get_login_status')) {
    /**
     * Retrieve login status from current user, logged in or not.
     */
    function get_login_status() {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();

        // check whether the session has the user profile in it (has authorization)
        if($CI->session->userdata("email")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if ( ! function_exists('check_auth')) {
    /**
     * Not logged in -> kicked out to login page.
     * Logged in -> OK
     */
    function check_auth() {

        // check whether the session has the user profile in it (has authorization)
        if(! get_login_status()) {

            redirect("login");
        }
    }
}

if ( ! function_exists('check_privileges')) {
    /**
     * Check user privileges for section of system.
     * @param $privileges_demanded
     */
    function check_privileges($page_id) {

        $CI =& get_instance();
        $user_privileges = $CI->session->userdata("privileges");

        $page = $CI->generic->retrieve_one("admin_pages", array("id" => $page_id));
        $privileges_demanded = (int) $page["sign"];
				//1023
        if (! ($user_privileges & $privileges_demanded)) {
            redirect_to_homepage();
        }
    }
}

if ( ! function_exists('check_role')) {
    /**
     * Check if user has one of the allowed roles.
     * @param array $allowed_roles
     * @return bool
     */
    function check_role($role) {

        $CI =& get_instance();

        if (! ($CI->session->userdata("role") == $role)) {
            redirect_to_homepage();
        }
    }
}


if ( ! function_exists('redirect_to_homepage')) {
    /**
     * Redirect user into homepage suited to his/her role.
     */
    function redirect_to_homepage() {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();

        $homepage = $CI->session->userdata("homepage");
        redirect($homepage);
    }
}

if ( ! function_exists('check_customer_already_login')) {
    /**
     * If user already logged in, kick him back to main page.
     */
    function check_customer_already_login() {
        // check whether the session has the user profile in it (has authorization)
        if(get_login_status()) {
            redirect_to_homepage();
        }
    }
}


/* End of file access_helper.php */