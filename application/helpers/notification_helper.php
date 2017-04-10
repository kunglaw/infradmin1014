<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to assist in notification.
 * 
 * @copyright   Badr Interactive
 * @link        http://badr-interactive.com
 */

if (!function_exists('get_notification_action')) {
    function get_notification_action($type, $target, $source) {

        $CI =& get_instance();

        $route_action = array(

            NOTIF_NEW_SEATIZEN =>
                '<a href="'. base_url() .'seatizen/detail/page/'. $target . '">'.
                        '<i class="fa fa-user"></i>' .
                '</a>',

            NOTIF_NEW_AGENTSEA =>
                '<a href="'. base_url() .'agentsea/detail/page/'. $target . '">'.
                        '<i class="fa fa-building"></i>' .
                '</a>',

            NOTIF_BLOCK_SEATIZEN =>
                '<a href="#" class="block-one-button" '.
                    'data-toggle="modal" data-target="#block-one-confirmation">'.
                        '<i class="fa fa-ban"></i>' .
                '</a><input type="hidden" class="object-id" value="'. $target . '">',

            NOTIF_BLOCK_SEATIZEN_REPLY =>
                '<a href="'. base_url() .'seatizen/detail/page/'. $target . '">'.
                '<i class="fa fa-user"></i>' .
                '</a>',

            NOTIF_UNBLOCK_SEATIZEN =>
                '<a href="#" class="unblock-one-button " '.
                'data-toggle="modal" data-target="#unblock-one-confirmation">'.
                    '<i class="fa fa-unlock"></i>' .
                '</a><input type="hidden" class="object-id" value="'. $target . '">',

            NOTIF_UNBLOCK_SEATIZEN_REPLY =>
                '<a href="'. base_url() .'seatizen/detail/page/'. $target . '">'.
                '<i class="fa fa-user"></i>' .
                '</a>',

            NOTIF_DELETE_VESSEL =>
                '<a href="#" class="delete-one-button" '.
                'data-toggle="modal" data-target="#delete-one-confirmation">'.
                    '<i class="fa fa-trash"></i>' .
                '</a><input type="hidden" class="object-id" value="'. $target . '">',

            NOTIF_DELETE_VESSEL_REPLY =>
                '<a href="'. base_url() .'vessel/detail/page/'. $target . '">'.
                '<i class="fa fa-ship"></i>' .
                '</a>',

            NOTIF_NEW_REPORT =>
                '<a href="'. base_url() .'report_problem">'.
                '<i class="fa fa-edit"> </i>' .
                '</a>',


                NOTIF_EDIT_PIC => 
                '<a href="'. base_url() .'report_problem/detai/page'.$target.'">'.
                '<i class=""></i>'.
                '</a>'


        );

        // add reject option, special for admin
        if ($CI->session->userdata("role") == USER_SUPER_ADMIN) {

            $reject_html = '&nbsp;&nbsp;&nbsp;<a href="#" class="reject-request-one-button" '.
                'data-toggle="modal" data-target="#reject-request-one-confirmation">'.
                '<i class="fa fa-times"></i>' .
                '</a>'.
                '<input type="hidden" class="object-id" value="'. $target . '">'.
                '<input type="hidden" class="type" value="'. $type . '">'.
                '<input type="hidden" class="author-id" value="'. $source . '">';

            $route_action[NOTIF_BLOCK_SEATIZEN] = $route_action[NOTIF_BLOCK_SEATIZEN] . $reject_html;
            $route_action[NOTIF_UNBLOCK_SEATIZEN] = $route_action[NOTIF_UNBLOCK_SEATIZEN] . $reject_html;
            $route_action[NOTIF_DELETE_VESSEL] = $route_action[NOTIF_DELETE_VESSEL] . $reject_html;

        }

        return $route_action[$type];
    }
}



if (!function_exists('get_notification_text')) {
    function get_notification_text($type, $target, $source, $status) {

        $CI =& get_instance();

        $table_name_for_type = array(

            NOTIF_NEW_SEATIZEN => "pelaut_ms",
            NOTIF_NEW_AGENTSEA => "perusahaan",

            NOTIF_BLOCK_SEATIZEN => "pelaut_ms",
            NOTIF_BLOCK_SEATIZEN_REPLY => "pelaut_ms",

            NOTIF_UNBLOCK_SEATIZEN => "pelaut_ms",
            NOTIF_UNBLOCK_SEATIZEN_REPLY => "pelaut_ms",

            NOTIF_DELETE_VESSEL => "ship",
            NOTIF_DELETE_VESSEL_REPLY => "ship",

            NOTIF_NEW_REPORT => "report_problem",
            NOTIF_EDIT_PIC => "report_problem"
        );

        $primary_key_type = array(

            NOTIF_NEW_SEATIZEN => "pelaut_id",
            NOTIF_NEW_AGENTSEA => "id_perusahaan",

            NOTIF_BLOCK_SEATIZEN => "pelaut_id",
            NOTIF_BLOCK_SEATIZEN_REPLY => "pelaut_id",

            NOTIF_UNBLOCK_SEATIZEN => "pelaut_id",
            NOTIF_UNBLOCK_SEATIZEN_REPLY => "pelaut_id",

            NOTIF_DELETE_VESSEL => "ship_id",
            NOTIF_DELETE_VESSEL_REPLY => "ship_id",

            NOTIF_NEW_REPORT => "id_report",
            NOTIF_EDIT_PIC => "id_report"
        );

        $detail = $CI->generic->retrieve_one(
            $table_name_for_type[$type],
            array($primary_key_type[$type] => $target)
        );

        $author = $CI->generic->retrieve_one(
            "admin_user",
            array("id" => $source)
        );

        $notification_text = "";
        switch ($type) {
            case NOTIF_NEW_SEATIZEN:
                $notification_text = '<b>'. $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b> is registered as seatizen.";
                $notification_text = '<div class="notification-text" route="seatizen" value="'. $target .'">' . $notification_text  . '</div>';
                break;
            case NOTIF_NEW_AGENTSEA:
                $notification_text = '<b>'. $detail["nama_perusahaan"] ."</b> is registered as agentsea.";
                $notification_text = '<div class="notification-text" route="agentsea" value="'. $target .'">' . $notification_text  . '</div>';
                break;


            case NOTIF_BLOCK_SEATIZEN:
                $notification_text = $author["name"] ." request for seatizen block: <b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>";
                $notification_text = '<div class="notification-text" route="seatizen" value="'. $target .'">' . $notification_text  . '</div>';
                break;
            case NOTIF_BLOCK_SEATIZEN_REPLY:
                $notification_text = "Your request for seatizen block (<b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>) ";

                if ($status == 0) {
                    $notification_text = $notification_text ."is rejected.";
                } else {
                    $notification_text = $notification_text ."is approved.";
                }

                $notification_text = '<div class="notification-text" route="seatizen" value="'. $target .'">' . $notification_text  . '</div>';
                break;


            case NOTIF_UNBLOCK_SEATIZEN:
                $notification_text = $author["name"] ." request for seatizen unblock: <b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>";
                $notification_text = '<div class="notification-text" route="seatizen" value="'. $target .'">' . $notification_text  . '</div>';
                break;
            case NOTIF_UNBLOCK_SEATIZEN_REPLY:
                $notification_text = "Your request for seatizen unblock (<b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>) ";

                if ($status == 0) {
                    $notification_text = $notification_text ."is rejected.";
                } else {
                    $notification_text = $notification_text ."is approved.";
                }

                $notification_text = '<div class="notification-text" route="seatizen" value="'. $target .'">' . $notification_text  . '</div>';
                break;


            case NOTIF_DELETE_VESSEL:
                $notification_text = $author["name"] ." request for vessel delete: <b>". $detail["ship_name"] ."</b>";
                $notification_text = '<div class="notification-text" route="vessel" value="'. $target .'">' . $notification_text  . '</div>';
                break;
            case NOTIF_DELETE_VESSEL_REPLY:

                $notification_text = "Your request for vessel delete (<b>". $detail["ship_name"] ."</b>) ";

                if ($status == 0) {
                    $notification_text = $notification_text ."is rejected.";
                } else {
                    $notification_text = $notification_text ."is approved.";
                }

                $notification_text = '<div class="notification-text" route="vessel" value="'. $target .'">' . $notification_text  . '</div>';
                break;

            case NOTIF_NEW_REPORT:

                $notification_text = "NEW report ";

                $notification_text = '<div class="notification-text">' . $notification_text  . '</div>';
                break;

            case NOTIF_EDIT_PIC:

                $notification_text = "You have choosen ";

                $notification_text = '<div class="notification-text">' . $notification_text  . '</div>';

                break;

            default:
                break;
        }



        return $notification_text;
    }
}



if (!function_exists('get_notification_status')) {
    function get_notification_status($type, $target, $source, $status, $destination) {

        $CI =& get_instance();

        $table_name_for_type = array(

            NOTIF_NEW_SEATIZEN => "pelaut_ms",
            NOTIF_NEW_AGENTSEA => "perusahaan",

            NOTIF_BLOCK_SEATIZEN => "pelaut_ms",
            NOTIF_BLOCK_SEATIZEN_REPLY => "pelaut_ms",

            NOTIF_UNBLOCK_SEATIZEN => "pelaut_ms",
            NOTIF_UNBLOCK_SEATIZEN_REPLY => "pelaut_ms",

            NOTIF_DELETE_VESSEL => "ship",
            NOTIF_DELETE_VESSEL_REPLY => "ship",

            NOTIF_NEW_REPORT => "report_problem",
            NOTIF_EDIT_PIC => "report_problem"
        );

        $primary_key_type = array(

            NOTIF_NEW_SEATIZEN => "pelaut_id",
            NOTIF_NEW_AGENTSEA => "id_perusahaan",

            NOTIF_BLOCK_SEATIZEN => "pelaut_id",
            NOTIF_BLOCK_SEATIZEN_REPLY => "pelaut_id",

            NOTIF_UNBLOCK_SEATIZEN => "pelaut_id",
            NOTIF_UNBLOCK_SEATIZEN_REPLY => "pelaut_id",

            NOTIF_DELETE_VESSEL => "ship_id",
            NOTIF_DELETE_VESSEL_REPLY => "ship_id",

            NOTIF_NEW_REPORT => "id_report",
            NOTIF_EDIT_PIC => "id_report"
        );

        $detail = $CI->generic->retrieve_one(
            $table_name_for_type[$type],
            array($primary_key_type[$type] => $target)
        );




        $author = $CI->generic->retrieve_one(
            "admin_user",
            array("id" => $source)
        );

        $notification_text = "";
        switch ($type) {
            case NOTIF_NEW_SEATIZEN:
                $notification_text = '<i class="fa fa-user" style="margin-right: 10px;"></i>'.
                    '<b>'. $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b> is registered as seatizen.";
                $notification_text = '<a href="'. base_url() .'seatizen/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;
            case NOTIF_NEW_AGENTSEA:
                $notification_text = '<i class="fa fa-building" style="margin-right: 10px;"></i>'.
                    '<b>'. $detail["nama_perusahaan"] ."</b> is registered as agentsea.";
                $notification_text = '<a href="'. base_url() .'agentsea/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;



            case NOTIF_BLOCK_SEATIZEN:
                $notification_text = '<i class="fa fa-ban" style="margin-right: 10px;"></i>'.
                    $author["name"] ." request for seatizen block: <b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>";
                $notification_text = '<a href="'. base_url() .'seatizen/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;



            case NOTIF_BLOCK_SEATIZEN_REPLY:
                $notification_text = '<i class="fa fa-ban" style="margin-right: 10px;"></i>'.
                    "Your request for seatizen block: (<b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>) ";

                if ($status == 0) {
                    $notification_text = $notification_text ."is rejected.";
                } else {
                    $notification_text = $notification_text ."is approved.";
                }

                $notification_text = '<a href="'. base_url() .'seatizen/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;

            case NOTIF_UNBLOCK_SEATIZEN:
                $notification_text = '<i class="fa fa-unlock" style="margin-right: 10px;"></i>'.
                    $author["name"] ." request for seatizen unblock: <b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>";
                $notification_text = '<a href="'. base_url() .'seatizen/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;
            case NOTIF_UNBLOCK_SEATIZEN_REPLY:
                $notification_text = '<i class="fa fa-ban" style="margin-right: 10px;"></i>'.
                    "Your request for seatizen unblock: (<b>". $detail["nama_depan"] ." ". $detail["nama_belakang"] ."</b>) ";

                if ($status == 0) {
                    $notification_text = $notification_text ."is rejected.";
                } else {
                    $notification_text = $notification_text ."is approved.";
                }

                $notification_text = '<a href="'. base_url() .'seatizen/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;

            case NOTIF_DELETE_VESSEL:
                $notification_text = '<i class="fa fa-trash" style="margin-right: 10px;"></i>'.
                    $author["name"] ." request for vessel delete: <b>". $detail["ship_name"] ."</b>";
                $notification_text = '<a href="'. base_url() .'vessel/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;
            case NOTIF_DELETE_VESSEL_REPLY:
                $notification_text = '<i class="fa fa-ship" style="margin-right: 10px;"></i>'.
                    "Your request for vessel delete: (<b>". $detail["ship_name"] ."</b>) ";

                if ($status == 0) {
                    $notification_text = $notification_text ."is rejected.";
                } else {
                    $notification_text = $notification_text ."is approved.";
                }

                $notification_text = '<a href="'. base_url() .'vessel/detail/page/'. $target .'">' . $notification_text  . '</a>';
                break;


            case NOTIF_NEW_REPORT:

                $notification_text = "<i class='fa fa-bug'> </i> New Report problem ";

                $notification_text = '<a href="'. base_url() .'report_problem">' .$notification_text.'</a>';
                break;

             case NOTIF_EDIT_PIC:
                     $notification_text = $destination."  is assign for report number : ".$target;

                $notification_text = '<a href="'. base_url() .'report_problem/detail/page/'.$target.'">' .$notification_text.'</a>';
                break;


            default:
                break;
        }





        return $notification_text;
    }
}

if (! function_exists("follow_up_request")) {
    /**
     * @param $object_id
     * @param $type
     * @param int $request_reply_status
     */
    function follow_up_request($object_id, $type, $request_reply_status = 1) {

        $CI =& get_instance();
        $CI->_current_db = $CI->load->database(DB_GROUP, true);
        $_notification_table = "admin_message";

        $previous_request_criteria = array(
            "type" => $type,
            "target" => $object_id,
            "status" => 0
        );
        // print_r($previous_request_criteria);
        $previous_request = $CI->generic->retrieve_many(
            $_notification_table,
            $previous_request_criteria
        );
        
        // $sections = array(
        //     'config' => true,
        //     'query' => true
        //     );
        // $CI->output->set_profiler_sections($sections);
        // exit;
        //print_r($previous_request);
        foreach ($previous_request as $request) {

            // just tell requester that his/her request is approved/rejected
            $notification = array(
                "source" => $CI->session->userdata("id"),
                "destination" => $request["source"],
                "type" => $type + 1,
                "target" => $object_id,
                "status" => $request_reply_status
            );

            $CI->generic->create($_notification_table, $notification);
        }

        // set all previous request notification to "followed up"
        unset($previous_request_criteria["status"]);

        // set all delete vessel request notification to "followed up"
        $CI->generic->update(
            $_notification_table,
            array("status" => 2),
            $previous_request_criteria
        );
        $str = "select * from admin_message";
        $CI->db->query($str);
        echo $CI->_current_db->last_query();
    }
}

/* End of file debug_helper.php */