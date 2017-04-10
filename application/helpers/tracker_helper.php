<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Helper to track several things.
 * 
 * @copyright 	Badr Interactive
 * @link		http://badr.co.id
 */

if (! function_exists('track_seatizen')) {

    /**
     * Track any of seatizen action, save them in log.
     *
     * @param $action
     */
	function track_seatizen($seatizen_id,$action) {
		
        if (! empty($action)) {
			
            $CI =& get_instance();
            $CI->load->model("tracker_model", "tracker");
			
			$is_array = is_array($action);
			if($is_array == TRUE)
			{
				$action = format_action($action);
			}
			
            //$seatizen_id = $CI->session->userdata("id_user"); @todo please change this to logged-in seatizen ID
			$seatizen_id = !empty($seatizen_id) ? $seatizen_id : 0;

            $CI->tracker->save_seatizen_action($seatizen_id, $action);
        }
	}
}

if (! function_exists('track_agentsea')) {

    /**
     * Track any of agentsea action, save them in log.
     *
     * @param $action
     */
	function track_agentsea($agentsea_id,$action) {

        if (! empty($action)) {
            $CI =& get_instance();
            $CI->load->model("tracker_model", "tracker");
			
			$is_array = is_array($action);
			if($is_array == TRUE)
			{
				$action = format_action($action);
			}
			
            //$agentsea_id = $CI->session->userdata("id_perusahaan"); // @todo please change this to logged-in agentsea ID
			$agentsea_id = !empty($agentsea_id) ? $agentsea_id : 0;
			
            $CI->tracker->save_agentsea_action($agentsea_id, $action);
        }
	}
}

if (! function_exists('track_vacantsea_visitor')) {

    /**
     * Track vacantsea visitor
     *
     * @param $vacantsea_id
     */
	function track_vacantsea_visitor($vacantsea_id) {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        //$seatizen_id = $this->; // @todo please change this to logged-in seatizen ID
        $seatizen_id = $CI->session->userdata('id_user');
		$seatizen_id = !empty($seatizen_id) ? $seatizen_id : 0;
		
        $CI->tracker->save_vacantsea_visitor($seatizen_id, $vacantsea_id);
	}
}

if (! function_exists('track_seatizen_login')) {

    /**
     * Track any of seatizen login action
     */
    function track_seatizen_login($seatizen_id) {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $seatizen_id = $CI->session->userdata("id_user");

        $CI->tracker->save_login_seatizen_action($seatizen_id);

    }
}

if (! function_exists('track_seatizen_logout')) {

    /**
     * Track any of seatizen login action
     */
    function track_seatizen_logout($seatizen_id) {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $seatizen_id = $CI->session->userdata("id_user");

        $CI->tracker->delete_login_seatizen($seatizen_id);

    }
}

if (! function_exists('track_agentsea_login')) {

    /**
     * Track any of agentsea login action
     */
    function track_agentsea_login($agentsea_id) {

        $CI =& get_instance();

        $CI->load->model("tracker_model","tracker");
        $agentsea_id = $CI->session->userdata("id_perusahaan");

        $CI->tracker->save_login_agentsea_action($agentsea_id);

    }
}

if (! function_exists('track_agentsea_logout')) {

    /**
     * Track any of seatizen login action
     */
    function track_agentsea_logout($agentsea_id) {

        $CI =& get_instance();

        $CI->load->model("tracker_model", "tracker");
        $agentsea_id = $CI->session->userdata("id_perusahaan");

        $CI->tracker->delete_login_agentsea($agentsea_id);

    }
}

/*function buatan kunglaw yang berfungsi nge track 
yang tidak login sama sekali */
if(!function_exists('track_user')){
	
	function track_user($action = "")
	{
		$CI =& get_instance();
		$CI->load->model("tracker_model","tracker");
		
		$is_array = is_array($action);
		if($is_array == TRUE)
		{
			$action = format_action($action);	
		}
		
		$CI->tracker->save_user_history($action);
		
	}
	
}

if(!function_exists('run_tracker')){
	
  function run_tracker($action=''){
	  
	  $CI     =& get_instance();
  
	  $username_login         = $CI->session->userdata("username");
	  $username_company       = $CI->session->userdata("username_company");
	  
	  $id_seatizen 			= $CI->session->userdata("id_user");
	  $agentsea_id 			= $CI->session->userdata("id_perusahaan");
	  
	  if(!empty($username_login))
	  {
		  track_seatizen($id_seatizen,$action);  
	  }
	  if(!empty($username_company))
	  {
		  track_agentsea($agentsea_id,$action);
	  }
	  else
	  {
		  track_user($action); // yang tidak login
	  }
  
  }
}


if(!function_exists ('edit_password')){


    function edit_password($id_user){
        $CI =& get_instance();

        $CI->load->model("tracker_model","tracker");

        $CI->tracker->history_editpassword($id_user);



    }

}

if(!function_exists('edit_username')){

    function edit_username($id_user){

        $CI =& get_instance();

        $CI->load->model('tracker_model','tracker');

        $CI->tracker->history_editusername($id_user);

    }

}

/* ===================================== format action =========================================================  */

if(!function_exists('format_action')){
	
  function format_action($dt)
  {
	  $CI =& get_instance();
	  $CI->load->helper('text');
	  
	  $count = count($dt);
	  foreach($dt as $key => $val)
	  {
		  $line = "";
		  if($count > 1)
		  {
			  $line = "&";
		  }
		  
		  $val = url_title($val,"+");
		  $val = strtolower($val);
		  
		  $format .= "$key=$val$line";
		  $count--;
		  
	  }
	  
	  return $format;	
  }

}


if(!function_exists('get_value_action')){

  function get_value_action($query_string)
  {
	  $CI =& get_instance();
	  
	  $query_string = str_replace("+"," ",$query_string);
	  
	  $ex = explode("&",$query_string);
	  
	  return $ex;
	  
	  
  }
}

/* End of file tracker_helper.php */