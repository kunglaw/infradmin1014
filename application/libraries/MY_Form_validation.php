<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Extension of default CI form validation library.
 *
 * @copyright 2014 PT. Badr Interactive
 * @author pulung
 *
 */
class MY_Form_validation extends CI_Form_validation {
	
	private $ci; // reference to CI instance.
    private $_admin_table = "admin_user";
	
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->ci =& get_instance();
	}

    /**
     * Check if given email is found in user database, for login.
     * @return boolean email is found or not.
     */
    public function email_is_found($str, $user_table = "admin_user") {

        $id = $this->ci->input->post("id");

        $find_conf = array("email" => $str);

        // exclude his own ID to search another profile's email. (edit only)
        if (! empty($id)) {
            $find_conf["id <>"] = $id;
        }

        $result = $this->ci->generic_model->retrieve_one(
            $user_table,
            $find_conf
        );

        if ($result) { // there exists an email.
            return TRUE;
        } else { // email is not found.
            $this->ci->form_validation->set_message("email_is_found", "Email is not found.");
            return FALSE;
        }
    }

    /**
     * Check if given email is available for registration.
     * @return boolean email is available or not.
     */
    public function email_is_available($str, $user_table = "admin_user") {

        $result = ! $this->email_is_found($str, $user_table);

        if (!$result) {
            $this->ci->form_validation->set_message("email_is_available", "Email is already exist.");
        }

        return $result;
    }

    /**
     * Check if given username is found in user database, for login.
     * @return boolean username is found or not.
     */
    public function username_is_found($str, $user_table = "admin_user") {

        $id = $this->ci->input->post("id");

        $find_conf = array("username" => $str);

        // exclude his own ID to search another profile's email. (edit only)
        if ($id) {
            $find_conf["id <>"] = $id;
        }

        $result = $this->ci->generic_model->retrieve_one(
            $user_table,
            $find_conf
        );

        if ($result) { // there exists an username.
            return TRUE;
        } else { // username is not found.
            $this->ci->form_validation->set_message("username_is_found", "Username is not found.");
            return FALSE;
        }
    }

    /**
     * Check if given username is available for registration.
     * @return boolean username is available or not.
     */
    public function username_is_available($str, $user_table = "admin_user") {

        $result = ! $this->username_is_found($str, $user_table);

        if (!$result) {
            $this->ci->form_validation->set_message("username_is_available", "Username is already exist.");
        }

        return $result;
    }

    /**
     * Verify the hashed password given by user from api.
     * @return boolean password-matching result
     */
    public function hashed_password_verification() {

        $criteria = array("email" => $this->ci->input->post("email"));

        // retrieve user profile by username criteria.
        $user_profile = $this->ci->generic_model->retrieve_one("admin_user", $criteria);

        if (!$user_profile) { // if user profile can't be retrieved by username.
            return FALSE;
        }

        // password stored inside db.
        $real_password = $user_profile['password'];
        $hashed_input_password = $this->ci->input->post("password");


        // compare the input and user password.
        if ($hashed_input_password == $real_password) {
            $passed = TRUE;
        } else {
            $passed = FALSE;
            $this->ci->form_validation->set_message("hashed_password_verification", "Invalid email or password.");
        }

        return $passed;
    }

    /**
     * Verify the password given by user from login form.
     * @return boolean password-matching result
     */
    public function password_verification() {

        $criteria = array("email" => $this->ci->input->post("email"));

        $passed = $this->verify_password($criteria, $this->ci->input->post("password")); // variable to mark the user is allowed to pass or not.

        if (!$passed) {
            $this->ci->form_validation->set_message("password_verification", "Invalid email or password.");
        }

        return $passed;
    }

    /**
     * Verify the password given by user from login form.
     * @return boolean password-matching result
     */
    public function password_change_verification() {

        $criteria = array("id" => $this->ci->input->post("id"));

        $passed = $this->verify_password($criteria, $this->ci->input->post("old_password")); // variable to mark the user is allowed to pass or not.

        if (!$passed) {
            $this->ci->form_validation->set_message("password_change_verification", "Invalid password.");
        }

        return $passed;
    }

    /**
     * Verify the password by given criteria.
     * @param $criteria
     * @param $input_password
     * @return bool
     */
    private function verify_password($criteria, $input_password) {

        $this->ci->load->helper("password");

        $passed = FALSE; // variable to mark the user is allowed to pass or not.

        // retrieve user profile by username criteria.
        $user_profile = $this->ci->generic_model->retrieve_one($this->_admin_table, $criteria);

        if (!$user_profile) { // if user profile can't be retrieved by username.
            return FALSE;
        }

        $passed = password_verify($input_password, $user_profile["password"]);

        return $passed;

    }

    /**
     * Check validity of given token.
     * @return bool
     */
    public function token_is_valid() {
        $token = $this->ci->input->post("token");

        $this->ci->load->helper("access");
        return check_token($token);
    }

    /**
     * Check for valid input role, admin is excluded.
     * @return bool
     */
    public function valid_input_role() {
        $role = $this->ci->input->post("role");

        if ($role == USER_CATI || $role == USER_CID || $role == USER_FINANCE ||
            $role == USER_MP || $role == USER_DIV_MARKETEERS || $role == USER_DIV_CONSULTING ||
            $role == USER_DIV_INSTITUTE || $role == USER_DIV_INSIGHT
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Check for valid email format.
     * @return bool
     */
    public function is_valid_email() {

        $this->ci->form_validation->set_message("is_valid_email", "Invalid email format.");
        $result = ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",
            $this->ci->input->post("email"))) ? FALSE : TRUE;
        return $result;
    }

    /**
     * Check object existance by its ID.
     *
     * @param $id
     * @param $table_name
     * @return bool
     */
    public function is_object_exist($id, $table_name) {

        $primary_field = $this->ci->generic_model->primary($table_name);

        $result = $this->ci->generic_model->retrieve_one(
            $table_name,
            array(
                $primary_field => $id
            )
        );

        if ($result) { // there exists an object.
            return TRUE;
        } else { // object is not found.
            $this->ci->form_validation->set_message("is_object_exist", "Object is not exist.");
            return FALSE;
        }
    }

    /**
     * Check transaction existance by its package ID and package type.
     *
     * @return bool
     */
    public function is_transaction_exist() {

        $transaction = $this->ci->generic_model->retrieve_one(
            "transaction_general",
            array(
                "package_id" => $this->ci->input->post("package_id"),
                "package_type" => $this->ci->input->post("package_type")
            )
        );

        if ($transaction) { // there exists an object.
            return TRUE;
        } else { // object is not found.
            $this->ci->form_validation->set_message("is_transaction_exist", "Paket belum dibeli.");
            return FALSE;
        }
    }

    /**
     * Check for valid city ID.
     * @return bool
     */
    public function is_valid_city($str) {

        $result = $this->ci->generic_model->retrieve_one("lib_city",
            array(
                "id_provinsi" => $this->ci->input->post("province"),
                "id" => $str
            )
        );

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }

        return $result;
    }

    /**
     * Check phone number whether this is indosat provider or not.
     *
     * @param $number
     * @return bool
     */
    public function is_indosat_number($number) {

        $indosat_prefix = array("62814", "62815", "62816", "62855",
            "62856", "62857", "62858");

        $prefix = substr($number, 0, 5);

        if (in_array($prefix, $indosat_prefix)) {

            return TRUE;

        } else {

            $this->ci->form_validation->set_message(
                "is_indosat_number", "Maaf, aplikasi ini hanya tersedia untuk pelanggan Indosat.");
            return FALSE;
        }

    }


}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */