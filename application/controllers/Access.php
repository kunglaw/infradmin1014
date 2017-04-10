<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Access
 * Handle access operation.
 *
 * @copyright PT. Badr Interactive (c) 2014
 * @author pulung
 */

class Access extends CI_Controller {

    private $_table_name = "admin_user";
    private $_role_table = "admin_role";
    private $_page_table = "admin_pages";
    private $_password_recovery_table = "admin_password_recovery";

    private $_image_location = "assets/img/admin/";

    /**
     * Login and its validation.
     */
    public function login() {

        check_customer_already_login();

        set_page_title("Login");

        // if we load the form for the 1st time or wrong value on validation.
        if ($this->form_validation->run("login") == FALSE) {

            $errors = validation_errors();
            if ($errors != "") {

                set_notification("You have entered incorrect email or password.", NOTIF_ERROR);
            }

            $this->load->view("access/login");

        } else {
            $configuration = array(
                "email" => $this->input->post("email")
            );

            /// email needs to be lower-cased.
            $configuration["email"] = strtolower($configuration["email"]);

            $profile_data = $this->init_user($configuration); // login to system using $configuration.


            // if we unable to init user data, log user out.
            if (empty($profile_data)) {

                log_message("error", "WEB-ADMIN: Unable to log user in.");
                $this->logout();

            } else {

                $sidebar_data = $this->init_sidebar($profile_data["privileges"]);

                if (empty($sidebar_data)) {

                    log_message("error", "WEB-ADMIN: Sidebar is not available.");
                    $this->logout();

                } else {

                    redirect_to_homepage();
                }
            }

        }
    }

    /**
     * Initialize user profile in session after successful login.
     * @param $configuration
     * @param bool $init_session
     * @return array
     */
    private function init_user($configuration, $init_session = TRUE) {

        // retrieve user profile from db by its email.
        $user = $this->generic->retrieve_one(
            $this->_table_name, $configuration);

        // check for empty user
        if (empty($user)) {
            return NULL;
        }

        // retrieve user role.
        $role = $this->generic->retrieve_one(
            $this->_role_table, array("id" => $user["role"]));

        // check for empty role
        if (empty($role) || $role["privileges"] == 0) {
            return NULL;
        }

        // prepare array for session.
        $profile_data = array(
            "id" => $user["id"],
            "email" => $user["email"],
            "name" => $user["name"],
            "role" => $user["role"],
            "homepage" => $role["homepage"],
            "privileges" => (int) $role["privileges"],
            "last_view_notif" => $user["last_view_notif"]
        );

        if ($init_session) {
            $this->session->set_userdata($profile_data); // set the profile data.
        }


        return $profile_data;
    }

    /**
     * Init list of pages on sidebar according to logged-in user privileges.
     *
     * @param $privileges
     * @return array
     */
    private function init_sidebar($privileges) {

        $page_list = $this->generic->retrieve_many(
            $this->_page_table,
            array(),
            array("show_order" => "ASC")
        );

        $privileged_page_list = array();

        foreach ($page_list as $page) {

            $page["sign"] = (int) $page["sign"];

            if ($privileges & $page["sign"]) {
                $privileged_page_list[] = $page;
            }
        }

        if (empty($privileged_page_list)) {
            $privileged_page_list = NULL;
        } else {
            $this->session->set_userdata("page_list", $privileged_page_list);
            $this->session->set_userdata("total_page", count($page_list));
        }

        return $privileged_page_list;
    }



    /**
     * Logout from session.
     */
    public function logout() {

        $this->session->sess_destroy();
        redirect("login");
    }

    /**
     * Showing reset password request form.
     */
    public function request_reset_password() {

        set_page_title("Reset Password");

        // recover password only for someone who can't login (customer state)
        check_customer_already_login();

        // if we load the form for the 1st time or wrong value on validation.
        if ($this->form_validation->run("request_reset_password") == FALSE) {

            if (validation_errors() == "") {

                clear_notification();
                $this->load->view("access/reset_request");

            } else {

                $validation_error_but_passed = TRUE;

                $error_result = form_error("email");

                if (strpos($error_result, "required") !== FALSE) {
                    set_notification("You have to provide an email address.", NOTIF_ERROR);
                    $validation_error_but_passed = FALSE;
                }

                if (strpos($error_result, "format") !== FALSE) {
                    set_notification("You have provided invalid email format.", NOTIF_ERROR);
                    $validation_error_but_passed = FALSE;
                }

                if ($validation_error_but_passed) {

                    sleep(7);
                    set_notification("Please check your email to reset the password.", NOTIF_SUCCESS);
                    redirect("login");

                } else {

                    redirect("password/request");
                }
            }

        } else {

            $this->process_recover_password(strtolower($this->input->post("email")));

            set_notification("Please check your email to reset the password.", NOTIF_SUCCESS);
            redirect("login");
        }
    }

    /**
     * Recover the password, send user the link to reset the password.
     * @param $email
     * @return bool
     */
    private function process_recover_password($email) {
		
        // get the complete user profile using email criteria
        $user_profile = $this->generic_model->retrieve_one($this->_table_name, array("email" => $email));

        // set up a new password from random text.
        //$this->load->helper("string");
		$this->load->library("token");
        $token = $this->token->generate(16);//random_string("alnum",8); exit;

        $this->load->helper("date");

        // prepare the recovery conf to expire in 2 hours time.
        $recovery_conf = array(
            "user_id" => $user_profile["id"],
            "token" => $token,
            "expired_time" => mdate("%Y-%m-%d %H:%i:%s", strtotime("+2 hours"))
        );

        $recovery_data = $this->generic_model->retrieve_one($this->_password_recovery_table,
            array("user_id" => $user_profile["id"]));

        // if recover password is already requested
        if ($recovery_data) {
            $this->generic_model->update_with_transaction(
                $this->_password_recovery_table,
                $recovery_conf,
                array("user_id" => $user_profile["id"])

            );
        } else { // create recover password

            $recovery_data = $this->generic_model->retrieve_one(
                $this->_password_recovery_table,
                array("user_id" => $user_profile["id"])
            );

            // if previous recovery data is available, delete them.
            if ($recovery_data) {

                $this->generic_model->delete(
                    $this->_password_recovery_table,
                    array("user_id" => $user_profile["id"])
                );
            }

            $this->generic_model->create($this->_password_recovery_table, $recovery_conf);
        }

        // send email containing new password.
        $this->load->helper("email");

        $subject = APPLICATION_NAME .": Reset Password untuk Akun " . $user_profile["name"];

        $data["recovery_link"] = base_url() ."password/reset/". $token;

        $message = $this->load->view("email/password_recovery", $data, TRUE);
        $send_result = @send_email($user_profile["email"], $subject, $message);

        return $send_result;
    }

    /**
     * Reset the password with token
     * @param string $token
     */
    public function reset_password($token="") {

        set_page_title("Reset Password");

        if ($token == "") {
            $token = $this->input->post("token");
        }

        if ($token == "") {
            redirect("login");
        }

        // check token validity
        if (! check_token($token)) {
            redirect("login");
        }

        // if we load the form for the 1st time or wrong value on validation.
        if ($this->form_validation->run("reset_password") == FALSE) {

            if (validation_errors() != "") {

                set_notification("Please try again.", NOTIF_ERROR);

            } else {

                set_notification("Enter a new password", NOTIF_SUCCESS);
            }

            $revival_data["token"] = $token;
            $this->load->view("access/reset_password", $revival_data);

        } else {
            // retrieve user ID
            $token_data = $this->generic_model->retrieve_one(
                $this->_password_recovery_table, array("token" => $token));

            $new_password_conf = array(
                "password" => password_hash($this->input->post("password"), PASSWORD_BCRYPT)
            );

            $this->generic_model->update(
                $this->_table_name,
                $new_password_conf,
                array("id" => $token_data["user_id"])
            );

            set_notification("You have successfully reset your password.", NOTIF_SUCCESS);

            redirect("login");
        }
    }

    /**
     * Change password of logged-in profile.
     */
    public function change_password() {

        check_auth();

        $response = array();

        // if we load the form for the 1st time or wrong value on validation.
        if ($this->form_validation->run("change_password") == FALSE) {

            $error = validation_errors();
            if ($error == "") {

            } else {

                set_notification("Incorrect input.", NOTIF_ERROR);
                $response["status"] = "error";
                $response["notification"] = get_notification();
                $response["errors"] = pack_error_message_ajax(array("change_password"));
            }

        } else {

            $new_profile = array("password" => $this->create_password($this->input->post("new_password")));

            $this->generic->update(
                $this->_table_name,
                $new_profile,
                array("id" => $this->session->userdata("id"))
            );

            set_notification("Your password has been changed.", NOTIF_SUCCESS);
            $response["status"] = "success";
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }

    /**
     * Edit own profile
     */
    public function edit_own() {

        check_auth();

        $response = array();
        $id = $this->session->userdata("id");

        // if we load the form for the 1st time or wrong value on validation.
        if ($this->form_validation->run("edit_own_profile") == FALSE) {

            if (validation_errors() == "") {

            } else {

                set_notification("Incorrect input.", NOTIF_ERROR);
                $response["status"] = "error";
                $response["notification"] = get_notification();
                $response["errors"] = pack_error_message_ajax(array("edit_own_profile"));
            }


        } else {

            $item = $this->generic->retrieve_one($this->_table_name, array("id" => $id));
            if (! $item) {

                set_notification("Incorrect input.", NOTIF_ERROR);
                $response["status"] = "error";
                $response["notification"] = get_notification();

            } else {
                $edited_item = array(
                    "name" => $this->input->post("name")
                );

                // update image if image is changed.
                $image = $this->input->post("image");

                if (! empty($image)) {
                    // move image from upload to img folder
                    $server_url = $this->config->item("server_url");
                    $temp_image_file = $server_url . TEMP_IMAGE_UPLOAD_LOCATION . $image;
					// ../infradmin1014_upload/upload/$image

                    $this->load->helper("misc");
                    $new_image_file = move_from_temp_loc(
                        $temp_image_file,
                        $server_url . $this->_image_location,
                        $item["id"]
                    );

                    $edited_item["image"] = $new_image_file;
                }

                $this->generic->update(
                    $this->_table_name,
                    $edited_item,
                    array("id" => $id)
                );

                // set session after editing name.
                $this->session->set_userdata("name", $edited_item["name"]);

                set_notification("Your profile has been saved.", NOTIF_SUCCESS);
                $response["status"] = "success";
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }

    /**
     * Retrieve logged-in user detail, returning them as JSON.
     * @param $item_id
     */
    public function get_own_user_detail_ajax() {

        check_auth();

        // retrieve item detail
        $item = $this->generic->retrieve_one(
            $this->_table_name,
            array("id" => $this->session->userdata("id")),
            array(),
            "id, email, name, role, image"
        );

        // give full URL to profile picture.
        if (! empty($item)) {
            $item["image"] = base_url() . $this->_image_location . $item["image"];
        }

        $role = $this->generic->retrieve_one(
            $this->_role_table,
            array("id" => $item["role"]),
            array(),
            "name"
        );

        $item["role_name"] = $role["name"];


        // pack them into json.
        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($item));
    }

    /**
     * Manually create password for user creation
     *
     * @param $raw_password
     * @return bool|string
     */
    private function create_password($raw_password) {

        $this->load->helper("password");
        return password_hash($raw_password, PASSWORD_BCRYPT);
    }

    /**
     * Sweep all expired reset password request.
     */
    public function sweep_expired_reset_request() {

        $this->load->helper("date");
        $now = mdate("%Y-%m-%d %H:%i:%s");

        $this->generic_model->delete(
            $this->_password_recovery_table,
            array("expired_time <" => $now)
        );

        log_message("debug", "Sweep expired reset request was running!");
    }

    /**
     * Check if session is alive or not.
     * @return bool|mixed
     */
    public function is_session_alive() {

//        dump_debug(time());

//        $ci_last_regenerate = $this->session->userdata("__ci_last_regenerate");
//
//        $last_timestamp = $this->session->userdata("last_timestamp");
//        if ($last_timestamp != $ci_last_regenerate) {
//            $this->session->set_userdata("last_timestamp", $ci_last_regenerate);
//            echo "different!<br/>";
//            dump_debug($ci_last_regenerate);
//            dump_debug($last_timestamp);
//        }






//        $result = $this->session->userdata("id");
//        $result = ! empty($result);
//
//        $this->output->set_content_type("application/json");
//        $this->output->set_status_header(200);
//        $this->output->set_output(json_encode($result));
    }

    public function show_404() {

        $this->load->view("element/404");
    }

    public function migrate() {

        $this->load->library("migration");
        $this->migration->current();
    }
}

/* End of file access.php */
/* Location: ./application/controllers/web/access.php */