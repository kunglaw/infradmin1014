<?php  if ( ! defined('BASEPATH')) exit('No direct script datatables allowed');

/**
 * Helper to assist in datatables operation.
 *
 * $Date: 2014-05-07 14:53:43 +0700 (Wed, 07 May 2014) $
 * $Revision: 37 $
 * $Author: pulung $
 *
 * @author      pulung
 * @copyright 	2014 PT. Badr Interactive
 * @link		http://badr.co.id
 */

if (!function_exists('get_role')) {

    /**
     *
     * @param $role
     * @return bool
     */
    function get_role($role) {

        $role_lib = array(
            USER_ADMIN => "Admin",
            USER_CID => "CID",
            USER_CATI => "CATI",
            USER_FINANCE => "Finance",
            USER_MP => "MP",
            USER_DIV_INSIGHT => "Insight Division",
            USER_DIV_INSTITUTE => "Institute Division",
            USER_DIV_CONSULTING => "Consulting Division",
            USER_DIV_MARKETEERS => "Marketeers Division"
        );

        return $role_lib[$role];
    }
}

if (!function_exists('get_verify_style')) {

    /**
     *
     * @param $role
     * @return bool
     */
    function get_verify_style($status) {

        $response = "";

        if ($status) {
            $response = "verify-color";
        }

        return $response;
    }
}

if (!function_exists('get_unverify_style')) {

    /**
     *
     * @param $role
     * @return bool
     */
    function get_unverify_style($status) {

        $response = "";

        if (!$status) {
            $response = "unverify-color";
        }

        return $response;
    }
}

if (!function_exists('convert_to_unix_timestamp')) {

    /**
     * @param $date
     * @return int
     */
    function convert_to_unix_timestamp($date) {

        $time = 0;

        if ($date != "") {

            $date_fragment = explode("-", $date);
            $time = strtotime($date_fragment[0] ."-". $date_fragment[1] ."-01 00:00:00");

            $time = strtotime("+7 hour", $time);
        }

        return $time;
    }
}

if (!function_exists('create_dropdown_status')) {

    /**
     * Create dropdown from status list by role.
     * @param $status
     * @param $product_type
     * @return array
     */
    function create_dropdown_status($status, $product_type) {

        return form_dropdown("status", get_status_list_by_role($status, $product_type), $status, 'class="col-md-10 status"').'<div class="col-md-2 notif"></div>';
    }
}



if (!function_exists('get_all_project_status')) {
    /**
     * @return array
     */
    function get_all_project_status() {

        // library of all status.
        $status_list_lib = array(
            STATUS_NEED_MANAGER_APPROVAL => "Need Manager Approval",

            STATUS_APPROVED_BY_MANAGER => "Approved by Manager",
            STATUS_APPROACHING => "Approaching",
            STATUS_PROBING => "Probing",
            STATUS_REQUEST_PROPOSAL => "Request Proposal",
            STATUS_PROPOSAL_DONE => "Proposal Done",
            STATUS_PRESENTATION => "Presentation",
            STATUS_NEGOTIATION => "Negotiation",

            STATUS_CONFIRMED => "Confirmed",
            STATUS_FAILED => "Failed",

            STATUS_KICK_OFF => "Kick Off",
            STATUS_ON_GOING => "On Going",
            STATUS_CLOSED => "Closed",
            STATUS_MSQI => "Sending MSQI",
            STATUS_MSQI_FINISHED => "MSQI Finished"
        );

        return $status_list_lib;
    }
}



if (!function_exists('get_status_list_by_role')) {

    /**
     *
     * @param $status
     * @param $product_type
     * @return array
     */
    function get_status_list_by_role($status, $product_type) {

        $ci =& get_instance();
        $status_list = array();

        // return empty array for status outside range.
        if ($status > STATUS_MSQI_FINISHED || $status < STATUS_NEED_MANAGER_APPROVAL) {
            return $status_list;
        }

        // library of all status.
        $status_list_lib = array(
            STATUS_NEED_MANAGER_APPROVAL => "Need Manager Approval",
            STATUS_APPROVED_BY_MANAGER => "Approved by Manager",
            STATUS_APPROACHING => "Approaching",
            STATUS_PROBING => "Probing",
            STATUS_REQUEST_PROPOSAL => "Request Proposal",
            STATUS_PROPOSAL_DONE => "Proposal Done",
            STATUS_PRESENTATION => "Presentation",
            STATUS_NEGOTIATION => "Negotiation",
            STATUS_CONFIRMED => "Confirmed",
            STATUS_FAILED => "Failed",
            STATUS_KICK_OFF => "Kick Off",
            STATUS_ON_GOING => "On Going",
            STATUS_CLOSED => "Closed",
            STATUS_MSQI => "Sending MSQI",
            STATUS_MSQI_FINISHED => "MSQI Finished"
        );


        if ($ci->session->userdata("role") == USER_ADMIN) {

            // give all status choices for admin.
            $status_list = $status_list_lib;

        } else if ($ci->session->userdata("role") == USER_CID) {

            if ((STATUS_APPROVED_BY_MANAGER <= $status) && ($status <= STATUS_NEGOTIATION)) {

                $choices = get_allowed_choices($status, STATUS_APPROVED_BY_MANAGER, STATUS_NEGOTIATION);
                $status_list = $choices[$status];

            } else if ($status == STATUS_CONFIRMED) {

                $status_list = array(
                    STATUS_CONFIRMED => "Confirmed",
                    STATUS_KICK_OFF => "Kick Off",
                );

            } else if ((STATUS_KICK_OFF <= $status) && ($status <= STATUS_CLOSED)) {

                $choices = get_allowed_choices($status, STATUS_KICK_OFF, STATUS_CLOSED);
                $status_list = $choices[$status];

            } else {

                // leaves user with no room for maneuver
                $status_list = array(
                    $status => $status_list_lib[$status]
                );
            }


        } else if ($ci->session->userdata("role") == USER_CATI) {

            if ((STATUS_CLOSED <= $status) && ($status <= STATUS_MSQI_FINISHED)) {

                $choices = get_allowed_choices($status, STATUS_CLOSED, STATUS_MSQI_FINISHED);
                $status_list = $choices[$status];

            } else {

                // leaves user with no room for maneuver
                $status_list = array(
                    $status => $status_list_lib[$status]
                );
            }
        } else if ($ci->session->userdata("role") == USER_MP) {

            if ((STATUS_NEED_MANAGER_APPROVAL <= $status) && ($status <= STATUS_APPROVED_BY_MANAGER)) {

                $choices = get_allowed_choices($status, STATUS_NEED_MANAGER_APPROVAL, STATUS_APPROVED_BY_MANAGER);
                $status_list = $choices[$status];

            } else if ((STATUS_NEGOTIATION <= $status) && ($status <= STATUS_FAILED)) {

                $status_list = array(
                    STATUS_NEGOTIATION => "Negotiation",
                    STATUS_CONFIRMED => "Confirmed",
                    STATUS_FAILED => "Failed"
                );

            } else {

                // leaves user with no room for maneuver
                $status_list = array(
                    $status => $status_list_lib[$status]
                );
            }
        }


        return $status_list;
    }
}

if (!function_exists('get_allowed_choices')) {

    /**
     * Arrange dropdown choices so that
     * we can't jump far off from given status.
     *
     * @param $status
     * @param $min
     * @param $max
     * @return array
     */
    function get_allowed_choices($status,
         $min = STATUS_NEED_MANAGER_APPROVAL,
         $max = STATUS_MSQI_FINISHED) {


        // library of all status.
        $status_list_lib = array(
            STATUS_NEED_MANAGER_APPROVAL => "Need Manager Approval",
            STATUS_APPROVED_BY_MANAGER => "Approved by Manager",
            STATUS_APPROACHING => "Approaching",
            STATUS_PROBING => "Probing",
            STATUS_REQUEST_PROPOSAL => "Request Proposal",
            STATUS_PROPOSAL_DONE => "Proposal Done",
            STATUS_PRESENTATION => "Presentation",
            STATUS_NEGOTIATION => "Negotiation",
            STATUS_CONFIRMED => "Confirmed",
            STATUS_FAILED => "Failed",
            STATUS_KICK_OFF => "Kick Off",
            STATUS_ON_GOING => "On Going",
            STATUS_CLOSED => "Closed",
            STATUS_MSQI => "Sending MSQI",
            STATUS_MSQI_FINISHED => "MSQI Finished"
        );

        $allowed_choices = array();

        // counter for every possible status in given range
        for ($counter = $min; $counter <= $max; $counter++) {

            $allowed_choices[$counter] = array();

//            // get previous option before current one.
//            if (($counter - 1) >= STATUS_NEED_MANAGER_APPROVAL && ($counter - 1) >= $min) {
//
//                $prev = $counter - 1;
//                $allowed_choices[$counter][$prev] = $status_list_lib[$prev];
//            }

            $allowed_choices[$counter][$counter] = $status_list_lib[$counter];

            // get next option before current one.
            if (($counter + 1) <= STATUS_MSQI_FINISHED && ($counter + 1) <= $max) {

                $next = $counter + 1;
                $allowed_choices[$counter][$next] = $status_list_lib[$next];
            }

        }

        return $allowed_choices;
    }
}

if (!function_exists('get_project_status')) {

    /**
     * @param $status
     * @return mixed
     */
    function get_project_status($status) {

        // return empty array for status outside range.
        if ($status > STATUS_MSQI_FINISHED || $status < STATUS_NEED_MANAGER_APPROVAL) {
            return "";
        }

        // library of all status.
        $status_list_lib = array(
            STATUS_NEED_MANAGER_APPROVAL => "Need Manager Approval",
            STATUS_APPROVED_BY_MANAGER => "Approved by Manager",
            STATUS_APPROACHING => "Approaching",
            STATUS_PROBING => "Probing",
            STATUS_REQUEST_PROPOSAL => "Request Proposal",
            STATUS_PROPOSAL_DONE => "Proposal Done",
            STATUS_PRESENTATION => "Presentation",
            STATUS_NEGOTIATION => "Negotiation",
            STATUS_CONFIRMED => "Confirmed",
            STATUS_FAILED => "Failed",
            STATUS_KICK_OFF => "Kick Off",
            STATUS_ON_GOING => "On Going",
            STATUS_CLOSED => "Closed",
            STATUS_MSQI => "On MSQI",
            STATUS_MSQI_FINISHED => "MSQI Finished"
        );

        return $status_list_lib[$status];
    }
}

if (!function_exists('get_product_type_name')) {

    /**
     * Get product type name from its ID.
     * @param $product_type
     * @return string
     */
    function get_product_type_name($product_type) {

        $product_type_name = "";

        if ($product_type == PRODUCT_MPI) {
            $product_type_name = "MarkPlus Insight";
        } else if ($product_type == PRODUCT_MI) {
            $product_type_name = "MarkPlus Institute";
        } else if ($product_type == PRODUCT_MPC) {
            $product_type_name = "MarkPlus Consulting";
        } else if ($product_type == PRODUCT_MARKETEERS) {
            $product_type_name = "Marketeers";
        } else if ($product_type == PRODUCT_PEP_FULL) {
            $product_type_name = "PEP Full Day";
        } else if ($product_type == PRODUCT_PEP_HALF) {
            $product_type_name = "PEP Half Day";
        } else if ($product_type == PRODUCT_WS) {
            $product_type_name = "WS";
        } else if ($product_type == PRODUCT_SR) {
            $product_type_name = "SR";
        } else if ($product_type == PRODUCT_MEMBER) {
            $product_type_name = "Member";
        } else if ($product_type == PRODUCT_EVENT) {
            $product_type_name = "Event";
        }

        return $product_type_name;
    }
}

if (!function_exists('get_total_cid_target_in_group')) {
    /**
     * Get total target from CID inside group.
     * @param $group_id
     * @return int
     */
    function get_total_cid_target_in_group($group_id) {

        $ci =& get_instance();

        $ci->load->model("group_model");
        $result = $ci->group_model->get_total_cid_target_in_group($group_id);
        $total_cid = 0;

        foreach ($result as $element) {
            $total_cid += (int) $element["target"];
        }

        return $total_cid;
    }
}

if (!function_exists('get_percentage_income_from_total')) {
    /**
     * Get percentage income from total fee that must be paid.
     * @param $project_id
     * @param $fund
     * @return int
     */
    function get_percentage_income_from_total($project_id, $fund) {

        $ci =& get_instance();

        $percentage = "";

        $project = $ci->generic_model->retrieve_one("project", array("id" => $project_id));

        if ($project) {
            $percentage = bcmul("100", $fund, 2);
            $percentage = bcdiv($percentage, $project["closing_fee"], 2);
        }

        return $percentage . " %";
    }
}

if (!function_exists('get_percentage_of_all_income_project')) {
    /**
     * Get percentage of all income project
     * @param $project_id
     * @return string
     */
    function get_percentage_of_all_income_project($project_id) {

        $ci =& get_instance();

        $percentage = 0;

        $project = $ci->generic_model->retrieve_one("project", array("id" => $project_id));

        $transactions = $ci->generic_model->retrieve_many("transaction", array("project_id" => $project_id));

        if ($project && $transactions) {

            $total_income = 0;

            foreach($transactions as $transaction) {

                $total_income += $transaction["fund"];
            }

            $percentage = bcmul("100", $total_income, 2);
            $percentage = bcdiv($percentage, $project["closing_fee"], 2);
        }

        return $percentage . " %";
    }
}

if (!function_exists('show_formatted_currency')) {
    /**
     * @param $amount
     * @return string
     */
    function show_formatted_currency($amount) {

        return number_format((double) $amount, 0, ",", ".");
    }
}


if (!function_exists('create_incentive_dropdown_status')) {

    /**
     * Create dropdown from incentive status list by role.
     * @param $status
     * @param $incentive_status
     * @return array
     */
    function create_incentive_dropdown_status($status) {

        $datatables_notif = '&nbsp;<span class="notif"></span>';

        return form_dropdown("status", get_incentive_status_list_by_role($status),
            $status, 'class="status left"') . $datatables_notif;
    }
}

if (!function_exists('get_all_incentive_status')) {
    /**
     * @return array
     */
    function get_all_incentive_status() {

        // library of all status.
        $status_list_lib = array(
            INCENTIVE_UNCONFIRMED => "Unconfirmed",
            INCENTIVE_CONFIRMED_BY_CID => "Confirmed by CID",
            INCENTIVE_APPROVED_BY_MANAGER => "Approved by Manager",
            INCENTIVE_PAID => "Paid",
        );

        return $status_list_lib;
    }
}

if (!function_exists('get_incentive_status_list_by_role')) {

    /**
     *
     * @param $status
     * @return array
     */
    function get_incentive_status_list_by_role($status) {

        $ci =& get_instance();
        $status_list = array();

        // return empty array for status outside range.
        if ($status > INCENTIVE_PAID || $status < INCENTIVE_UNCONFIRMED) {
            return $status_list;
        }

        // library of all status.
        $status_list_lib = array(
            INCENTIVE_UNCONFIRMED => "Unconfirmed",
            INCENTIVE_CONFIRMED_BY_CID => "Confirmed by CID",
            INCENTIVE_APPROVED_BY_MANAGER => "Approved by Manager",
            INCENTIVE_PAID => "Paid",
        );


        if ($ci->session->userdata("role") == USER_ADMIN) {

            // give all status choices for admin.
            $status_list = $status_list_lib;

        } else if ($ci->session->userdata("role") == USER_CID) {

            if ($status <= INCENTIVE_CONFIRMED_BY_CID) {

                $status_list = array(
                    INCENTIVE_UNCONFIRMED => "Unconfirmed",
                    INCENTIVE_CONFIRMED_BY_CID => "Confirmed by CID",
                );

            } else {

                // leaves user with no room for maneuver
                $status_list = array(
                    $status => $status_list_lib[$status]
                );
            }


        } else if ($ci->session->userdata("role") == USER_MP) {

            if ((INCENTIVE_CONFIRMED_BY_CID <= $status) && ($status <= INCENTIVE_APPROVED_BY_MANAGER)) {

                $status_list = array(
                    INCENTIVE_CONFIRMED_BY_CID => "Confirmed by CID",
                    INCENTIVE_APPROVED_BY_MANAGER => "Approved by Manager",
                );

            } else {

                // leaves user with no room for maneuver
                $status_list = array(
                    $status => $status_list_lib[$status]
                );
            }

        } else if ($ci->session->userdata("role") == USER_FINANCE) {

            if ((INCENTIVE_APPROVED_BY_MANAGER <= $status) && ($status <= INCENTIVE_PAID)) {

                $status_list = array(
                    INCENTIVE_APPROVED_BY_MANAGER => "Approved by Manager",
                    INCENTIVE_PAID => "Paid",
                );

            } else {

                // leaves user with no room for maneuver
                $status_list = array(
                    $status => $status_list_lib[$status]
                );
            }

        }


        return $status_list;
    }
}

if (!function_exists('get_bonus_status_indication')) {

    /**
     *
     * @param $status
     * @return array
     */
    function get_bonus_status_indication($status = 0) {

        $indication = "";
        if ($status > 0) {
            $indication = '<span class="level-up-color"><i class="fa fa-level-up"></i></span>';
        } else if ($status < 0) {
            $indication = '<span class="level-down-color"><i class="fa fa-level-down"></i></span>';
        } else {
            $indication = '<span class="level-static-color"><i class="fa fa-minus"></i></span>';
        }

        return $indication;
    }
}

function db_get_one($table, $id, $field="name"){
    $ci =& get_instance();
    $row = $ci->generic_model->retrieve_one($table, array('id'=>$id));
    if(isset($row[$field])) return $row[$field];
    return "-";
}

function action_edit_delete($id, $url_edit, $url_delete, $item_name='ini', $admin_only=""){
    $edit = '';
    if($url_edit!="#"){
        $edit =  anchor("$url_edit?id=$id", ic('pencil'))." &nbsp; ";
    }
    return $edit.anchor("$url_delete?id=$id", ic('trash-o'),  'onclick="return confirm(\'Apakah anda yakin ingin menghapus item '.$item_name.'?\')"');
}


if (!function_exists('create_dropdown_group')) {

    /**
     * Create dropdown from status list by role.
     * @param $group_id
     * @return string
     */
    function create_dropdown_group($group_id) {
        $ci =& get_instance();
        $group = array();
        $temp = $ci->generic_model->retrieve_many('group', array('industry'=>NULL));
        foreach ($temp as $t) {
            $group[$t['id']] = $t['name'];
        }
        return form_dropdown("group_id", $group, $group_id);
    }
}

$newest_30_tips = array();

if (!function_exists('initialize_thirty_newest_tips')) {

    function initialize_thirty_newest_tips() {

        global $newest_30_tips;
        $ci =& get_instance();

        $ci->load->model("tips_model");
        $tips = $ci->tips_model->get_tips_limited_with_author();
        $newest_30_tips = convert_to_dropdown_conf($tips, "id", "id");
    }
}

if (!function_exists('get_tips_status')) {

    function get_tips_status($id, $post_date) {

        global $newest_30_tips;
        $status_name = "";

        $current_time_last_second_of_the_day = strtotime(date("Y-m-d") . " 23:59:59");
        $post_time = strtotime($post_date . " 00:00:00");

        if ($post_time > $current_time_last_second_of_the_day) {
            $status_name = "Draft";
        } else {

            if (isset($newest_30_tips[$id])) { // within newest 30 tips
                $status_name = "Published";
            } else {
                $status_name = "Expired";
            }
        }


        return $status_name;
    }
}

if (!function_exists('deconstruct_thirty_newest_tips')) {

    function deconstruct_thirty_newest_tips() {

        global $newest_30_tips;
        $newest_30_tips = array();
    }
}




if (!function_exists('convert_grade')) {

    /**
     * Convert grade number to text.
     * @param $grade
     * @return string
     */
    function convert_grade($grade = 1) {

        $grade_list = array(1 => "SMP", 2 => "SMA");
        return $grade_list[$grade];

    }
}

if (!function_exists('convert_major')) {

    /**
     * Convert major number to text.
     * @param $major
     * @return string
     */
    function convert_major($major = "") {

        $major_list = array("" => "", 1 => "IPA", 2 => "IPS");
        return $major_list[$major];

    }
}

if (!function_exists('convert_subject')) {

    /**
     * Convert subject number to text.
     * @param $subject
     * @return string
     */
    function convert_subject($subject = "") {

        $CI =& get_instance();

        $subject_list = $CI->generic_model->retrieve_many("lib_subject");
        $subject_list = convert_to_dropdown_conf($subject_list, "id", "subject");

        return $subject_list[$subject];

    }
}

if (!function_exists('convert_type')) {

    /**
     * Convert type number to text.
     * @param $type
     * @return string
     */
    function convert_type($type = "") {

        $type_list = array("" => "", 1 => "UN", 2 => "SPMB");
        return $type_list[$type];

    }
}

if (!function_exists('convert_answer')) {

    /**
     * Convert answer number to text.
     * @param $answer
     * @return string
     */
    function convert_answer($answer = "") {

        $CI =& get_instance();

        $answer_list = array("A", "B", "C", "D", "E");
        $answer_text = "Input jawaban salah";

        switch ($answer) {
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
                $answer_text = $answer_list[$answer - 1];
                break;

            default:
                break;
        }

        return $answer_text;

    }
}

if (!function_exists('get_mime_from_base64')) {

    /**
     * Convert answer number to text.
     * @param $answer
     * @return string
     */
    function get_mime_from_base64($base64_image_string = "") {

        $file_pointer = finfo_open();
        $mime_type = finfo_buffer($file_pointer, base64_decode($base64_image_string), FILEINFO_MIME_TYPE);

        return $mime_type;
    }
}

if (!function_exists('get_transaction_status')) {


    function get_transaction_status($status) {

        $status_text = "Unpaid";
        if ($status == 1) {
            $status_text = "Paid";
        }

        return $status_text;
    }
}

if (!function_exists('get_activation_link')) {


    function get_activation_link($transaction_id, $status, $transaction_type) {

        $status_text = '<a href="'. base_url() .'subscription/activate/'.
            $transaction_type .'/'. $transaction_id .'">
            <i class="fa fa-square-o"></i></a>';

        if ($status == 1) {
            $status_text = '<a href="'. base_url() .'subscription/deactivate/'.
                $transaction_type .'/'. $transaction_id .'">
                <i class="fa fa-check-square"></i></a>';
        }

        return $status_text;
    }
}

if (!function_exists('get_contributor_status')) {


    function get_contributor_status($status, $id) {

        $status_name = "";

        $approval_url = base_url() ."contributor/approve/". $id;

        switch($status) {
            case -2:
                $status_name = "ID Rejected";
                break;
            case -1:
                $status_name = "Blocked";
                break;
            case 0:
                $status_name = "Email Not Confirmed";
                break;
            case 1:
//                $status_name = '<a class="button-red-white rounded approve-one-button" '.
//                    'data-target="#approve-one-confirmation" '.
//                    'data-toggle="modal" '.
//                    'href="#">Approve</a>';
                $status_name = "Email Confirmed";
                break;
            case 2:
                $status_name = "Active";
                break;
            default:
                break;
        }

        return $status_name;
    }
}

if (!function_exists('get_user_status')) {


    function get_user_status($status) {

        $status_name = "";

        switch($status) {
            case 0:
                $status_name = "Inactive";
                break;
            case 1:
                $status_name = "Active";
                break;
            default:
                break;
        }

        return $status_name;
    }
}

if (!function_exists('get_contributor_photo_status')) {


    function get_contributor_photo_status($status) {

        $status_name = "";

        switch($status) {
            case -1:
                $status_name = "Rejected";
                break;
            case 0:
                $status_name = "Unapproved";
                break;
            case 1:
                $status_name = "Approved";
                break;
            default:
                break;
        }

        return $status_name;
    }
}

if (!function_exists('get_payment_status')) {


    function get_payment_status($status) {

        $status_name = "";

        switch($status) {
            case -2:
                $status_name = "Rejected";
                break;
            case -1:
                $status_name = "Rejected";
                break;
            case 0:
                $status_name = "Unapproved";
                break;
            case 1:
                $status_name = "Approved";
                break;
            default:
                break;
        }

        return $status_name;
    }
}

if (!function_exists('get_photo_total_download')) {

    function get_photo_total_download($photo_id) {

        $CI =& get_instance();

        $total_download = $CI->generic_model->get_total_rows(
            "download", array("photo_id" => $photo_id));

        return $total_download;
    }
}

if (!function_exists('get_contributor_photo')) {

    function get_contributor_photo($filename) {

        $CI =& get_instance();

        $image_source = "";

        if (! empty($filename)) {
            $image_source = '<img src="'. base_url() .'asset/photo/'. $filename .'" style="width: 100%;">';
        }

        return $image_source;
    }
}

if (!function_exists('get_photo_category')) {

    function get_photo_category($photo_id) {

        $CI =& get_instance();

        $CI->load->model("photo_model");
        $category = $CI->photo_model->get_photo_category($photo_id);

        return $category;
    }
}

if (!function_exists('get_user_plan_list_status')) {

    /**
     * Decide that this plan is active or not, from
     * plan duration and plan download limit compared
     * to current subscription condition.
     *
     * @param $subscription_id
     * @param $date
     * @param $plan_duration
     * @param $plan_download_limit
     * @return mixed
     */
    function get_user_plan_list_status($subscription_id,
           $date, $plan_duration, $plan_download_limit) {

        $CI =& get_instance();

        $expired_time = strtotime("+". $plan_duration ." day", strtotime($date ." 00:00:00"));
        $today_time = time();

        $download_conf = array("sub_id" => $subscription_id);

        $total_download = $CI->generic_model->get_total_rows("download", $download_conf);

        $status = "inactive";
        if ($today_time < $expired_time && $total_download < $plan_download_limit) {
            $status = "active";
        }

        return $status;
    }
}

if (!function_exists('get_total_download_by_date_and_plan')) {

    /**
     * Get total download by date and plan.
     * @param $date
     * @param $plan_id
     * @return mixed
     */
    function get_total_download_by_date_and_plan($date, $plan_id) {

        $CI =& get_instance();

        $CI->load->model("summary_model");
        $total_download = $CI->summary_model->get_total_download_by_date_and_plan($date, $plan_id);

        if (empty($total_download)) {
            $total_download = array("download_date" => $date, "download_total" => 0);
        }

        return $total_download["download_total"];
    }
}

if (!function_exists('get_total_subscription_by_date_and_plan')) {

    /**
     * Get total subscription by date and plan.
     * @param $date
     * @param $plan_id
     * @return mixed
     */
    function get_total_subscription_by_date_and_plan($date, $plan_id) {

        $CI =& get_instance();

        $CI->load->model("summary_model");
        $total_download = $CI->summary_model->get_total_subscription_by_date_and_plan($date, $plan_id);

        if (empty($total_download)) {
            $total_download = array("subscription_date" => $date, "subscription_total" => 0);
        }

        return $total_download["subscription_total"];
    }
}

if (!function_exists('get_total_earning_by_date_and_plan')) {

    /**
     * Get total download by date and plan.
     * @param $date
     * @param $plan_id
     * @return mixed
     */
    function get_total_earning_by_date_and_plan($date, $plan_id, $download_total) {

        $CI =& get_instance();

        $plan = $CI->generic_model->retrieve_one("plan", array("id" => $plan_id));

        return $download_total * $plan["price"];
    }
}

if (!function_exists('sum_all_total_download_plan')) {

    /**
     * Sum all total download by plan.
     * @return int
     */
    function sum_all_total_download_plan() {

        $CI =& get_instance();

        $arguments = func_get_args();

        $total_download = 0;
        foreach ($arguments as $argument) {

            $total_download += (int) $argument;
        }

        return $total_download;
     }
}

if (!function_exists('sum_all_total_earning_plan')) {

    /**
     * Sum all total download by plan.
     * @return int
     */
    function sum_all_total_earning_plan() {

        $CI =& get_instance();

        $arguments = func_get_args();

        $total_earning = 0;
        foreach ($arguments as $argument) {

            $total_earning += (int) $argument;
        }

        return $total_earning;
     }
}

if (!function_exists('get_commission_status')) {

    /**
     * Get commission status
     * @return int
     */
    function get_commission_status($status) {

        $status_text = "";

        switch ($status) {
            case 1:
                $status_text = "Paid";
                break;
            default:
                $status_text = "Unpaid";
                break;
        }


        return $status_text;
     }
}


/* End of file datatables_helper.php */