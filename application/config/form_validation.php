<?php
$config = array(

	/**
	 *
	 * access controller page rules.
	 *
	 */
	"login" => array(
		array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[100]|is_valid_email|email_is_found[admin_user]"
		),
		array(
            "field" => "password",
            "label" => "Password",
            "rules" => "required|max_length[72]|password_verification"
		),
	),
    "request_reset_password" => array(
        array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[100]|is_valid_email|email_is_found[admin_user]"
        )
    ),
    "reset_password" => array(
        array(
            "field" => "token",
            "label" => "Token",
            "rules" => "required|max_length[30]|token_is_valid"
        ),
        array(
            "field" => "password",
            "label" => "Password",
            "rules" => "required|max_length[72]"
        ),
        array(
            "field" => "password_confirmation",
            "label" => "Konfirmasi Password",
            "rules" => "required|max_length[72]|matches[password]"
        )
    ),

    "register_api" => array(
        array(
            "field" => "phone",
            "label" => "Phone",
            "rules" => "required|numeric|min_length[9]|max_length[15]|is_indosat_number"
        ),
    ),

    "verification_api" => array(
        array(
            "field" => "phone",
            "label" => "Phone",
            "rules" => "required|numeric|min_length[9]|max_length[15]|is_indosat_number"
        ),
        array(
            "field" => "verification_code",
            "label" => "Verification Code",
            "rules" => "required|exact_length[5]"
        ),
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[300]"
        ),
        array(
            "field" => "gcm_key",
            "label" => "GCM Key",
            "rules" => "required|max_length[500]"
        ),
    ),

    "edit_profile_api" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[300]"
        ),
        array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[100]|is_valid_email"
        ),
        array(
            "field" => "grade",
            "label" => "Grade",
            "rules" => "required|numeric"
        ),
        array(
            "field" => "school",
            "label" => "School",
            "rules" => "required|max_length[100]"
        ),
        array(
            "field" => "city",
            "label" => "City",
            "rules" => "required|numeric|is_object_exist[lib_city]|is_valid_city"
        ),
        array(
            "field" => "province",
            "label" => "Province",
            "rules" => "required|numeric|is_object_exist[lib_province]"
        ),
    ),





    /**
     *
     * user controller page rules.
     *
     */
    "add_admin" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[100]"
        ),
        array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[100]|is_valid_email|email_is_available[admin_user]"
        ),
        array(
            "field" => "role",
            "label" => "Role",
            "rules" => "required|numeric|is_object_exist[admin_role]"
        ),
    ),
    "edit_admin" => array(
        array(
            "field" => "id",
            "label" => "ID",
            "rules" => "required|numeric|is_object_exist[admin_user]"
        ),
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[100]"
        ),
        array(
            "field" => "role",
            "label" => "Role",
            "rules" => "required|numeric|is_object_exist[admin_role]"
        ),
    ),
    "edit_own_profile" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[100]"
        ),
    ),
    "change_password" => array(
        array(
            "field" => "old_password",
            "label" => "Old Password",
            "rules" => "required|max_length[72]|password_change_verification"
        ),
        array(
            "field" => "new_password",
            "label" => "New Password",
            "rules" => "required|max_length[72]"
        ),
        array(
            "field" => "new_password_confirmation",
            "label" => "New Password Confirmation",
            "rules" => "required|max_length[72]|matches[new_password]"
        ),
    ),


    /**
     *
     * role controller page rules.
     *
     */
    "add_role" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[100]"
        ),
        array(
            "field" => "privileges[]",
            "label" => "Privileges",
            "rules" => "required|is_object_exist[admin_pages]"
        ),
    ),
    "edit_role" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[100]"
        ),
        array(
            "field" => "privileges[]",
            "label" => "Privileges",
            "rules" => "required|is_object_exist[admin_pages]"
        ),
    ),


    /**
     *
     * contributor rules
     *
     */
    "add_contributor" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[254]"
        ),
        array(
            "field" => "username",
            "label" => "Username",
            "rules" => "required|max_length[254]|username_is_available[contributor]"
        ),
        array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[254]|is_valid_email|email_is_available[contributor]"
        ),
        array(
            "field" => "address",
            "label" => "Address",
            "rules" => "required|max_length[1000]"
        ),
        array(
            "field" => "subjects",
            "label" => "Subject",
            "rules" => "max_length[1000]"
        ),
        array(
            "field" => "equipments",
            "label" => "Equipment",
            "rules" => "max_length[1000]"
        ),
    ),
    "edit_contributor" => array(
        array(
            "field" => "id",
            "label" => "ID",
            "rules" => "required|numeric|is_object_exist[contributor]"
        ),
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[254]"
        ),
        array(
            "field" => "username",
            "label" => "Username",
            "rules" => "required|max_length[254]|username_is_available[contributor]"
        ),
        array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[254]|is_valid_email|email_is_available[contributor]"
        ),
        array(
            "field" => "address",
            "label" => "Address",
            "rules" => "required|max_length[1000]"
        ),
        array(
            "field" => "subjects",
            "label" => "Subject",
            "rules" => "max_length[1000]"
        ),
        array(
            "field" => "equipments",
            "label" => "Equipment",
            "rules" => "max_length[1000]"
        ),
    ),


    /**
     *
     * user rules
     *
     */
    "add_user" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[254]"
        ),
        array(
            "field" => "phone_number",
            "label" => "Phone Number",
            "rules" => "required|numeric|max_length[40]"
        ),
        array(
            "field" => "username",
            "label" => "Username",
            "rules" => "required|max_length[254]|username_is_available[user]"
        ),
        array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[254]|is_valid_email|email_is_available[user]"
        ),
        array(
            "field" => "address",
            "label" => "Address",
            "rules" => "required|max_length[1000]"
        ),
        array(
            "field" => "status",
            "label" => "Status",
            "rules" => "required|greater_than[-1]|less_than[2]"
        ),
    ),
    "edit_user" => array(
        array(
            "field" => "id",
            "label" => "ID",
            "rules" => "required|numeric|is_object_exist[user]"
        ),
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[254]"
        ),
        array(
            "field" => "phone_number",
            "label" => "Email",
            "rules" => "required|numeric|max_length[40]"
        ),
        array(
            "field" => "username",
            "label" => "Username",
            "rules" => "required|max_length[254]|username_is_available[user]"
        ),
        array(
            "field" => "email",
            "label" => "Email",
            "rules" => "required|max_length[254]|is_valid_email|email_is_available[user]"
        ),
        array(
            "field" => "address",
            "label" => "Address",
            "rules" => "required|max_length[1000]"
        ),
        array(
            "field" => "status",
            "label" => "Status",
            "rules" => "required|greater_than[-1]|less_than[2]"
        ),
    ),


    /**
     *
     * photo rules
     *
     */
    "add_photo" => array(
        array(
            "field" => "title",
            "label" => "Title",
            "rules" => "required|max_length[254]"
        ),
        array(
            "field" => "contributor",
            "label" => "Contributor",
            "rules" => "required|numeric|is_object_exist[contributor]"
        ),
        array(
            "field" => "category_1",
            "label" => "Category 1",
            "rules" => "required|numeric|is_object_exist[category]"
        ),
        array(
            "field" => "category_2",
            "label" => "Category 2",
            "rules" => "numeric|is_object_exist[category]"
        ),
        array(
            "field" => "image",
            "label" => "Image",
            "rules" => "required"
        ),
    ),
    "edit_photo" => array(
        array(
            "field" => "id",
            "label" => "ID",
            "rules" => "required|numeric|is_object_exist[photo]"
        ),
        array(
            "field" => "title",
            "label" => "Title",
            "rules" => "required|max_length[254]"
        ),
        array(
            "field" => "contributor",
            "label" => "Contributor",
            "rules" => "required|numeric|is_object_exist[contributor]"
        ),
        array(
            "field" => "category_1",
            "label" => "Category 1",
            "rules" => "required|numeric|is_object_exist[category]"
        ),
        array(
            "field" => "category_2",
            "label" => "Category 2",
            "rules" => "numeric|is_object_exist[category]"
        ),
    ),

    /**
     *
     * category rules
     *
     */
    "add_category" => array(
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[254]"
        ),
    ),
    "edit_category" => array(
        array(
            "field" => "id",
            "label" => "ID",
            "rules" => "required|numeric|is_object_exist[category]"
        ),
        array(
            "field" => "name",
            "label" => "Name",
            "rules" => "required|max_length[254]"
        ),
    ),


    /**
     * information
     */
    "edit_static_page" => array(
        array(
            "field" => "id",
            "label" => "Info",
            "rules" => "required|is_object_exist[static]"
        ),
        array(
            "field" => "content",
            "label" => "Info",
            "rules" => "required"
        ),
    ),


    /**
     * information
     */
    "edit_featured_image" => array(
        array(
            "field" => "image",
            "label" => "Image",
            "rules" => "required"
        ),
    ),


    /**
     * commission
     */
    "minimum_commission" => array(
        array(
            "field" => "settings",
            "label" => "Minimum Earning Settings",
            "rules" => "required|numeric"
        ),
    ),


    /**
     * commission
     */
    "toekangpoto_email" => array(
        array(
            "field" => "subject",
            "label" => "Subject",
            "rules" => "required|max_length[300]"
        ),
        array(
            "field" => "content",
            "label" => "Content",
            "rules" => "required|max_length[1000]"
        ),
    ),



);
?>