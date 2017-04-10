<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "dashboard/show_main_dashboard";

$controller_name = "admin";
$admin_app_folder = "";

$controller_name = "admin";
$parent_route 	= "admin";
$route[$admin_app_folder . "test/sendm"] = "test/send_mailo";

$route["cron"]	= "cron";

$route[$admin_app_folder . 'login'] = "access/login";
$route[$admin_app_folder . 'password/request'] = "access/request_reset_password";
$route[$admin_app_folder . 'password/reset'] = "access/reset_password";
$route[$admin_app_folder . 'password/reset/(:any)'] = "access/reset_password/$1";
$route[$admin_app_folder . 'password/request/sweep'] = "access/sweep_expired_reset_request";
$route[$admin_app_folder . 'logout'] = "access/logout";
$route[$admin_app_folder . 'check'] = "access/is_session_alive";

$controller_name = "admin";
$parent_route = "admin";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route .'/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route .'/add'] = $controller_name ."/add";
$route[$admin_app_folder . $parent_route .'/edit'] = $controller_name ."/edit";
$route[$admin_app_folder . $parent_route .'/detail/ajax/(:num)'] = $controller_name ."/get_item_detail_ajax/$1";

$controller_name = "access";
$parent_route = "admin";
$route[$admin_app_folder . $parent_route .'/own/edit'] = $controller_name ."/edit_own";
$route[$admin_app_folder . $parent_route .'/password/change'] = $controller_name ."/change_password";
$route[$admin_app_folder . $parent_route .'/own/detail/ajax'] = $controller_name ."/get_own_user_detail_ajax";


$controller_name = "role";
$parent_route = "role";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route .'/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route .'/add'] = $controller_name ."/add";
$route[$admin_app_folder . $parent_route .'/edit'] = $controller_name ."/edit";
$route[$admin_app_folder . $parent_route .'/detail/ajax/(:num)'] = $controller_name ."/get_item_detail_ajax/$1";


$controller_name = "seatizen";
$parent_route = "seatizen";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route."/complete"] = "seatizen_print/list_complete_seatizen";
$route[$admin_app_folder . $parent_route .'/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route .'/detail/page/(:num)'] = $controller_name ."/show_item_detail/$1";

$route[$admin_app_folder . $parent_route .'/block/several'] = $controller_name ."/ajax_block_several";
$route[$admin_app_folder . $parent_route .'/block/one'] = $controller_name ."/ajax_block_one";
$route[$admin_app_folder . $parent_route .'/unblock/several'] = $controller_name ."/ajax_unblock_several";
$route[$admin_app_folder . $parent_route .'/unblock/one'] = $controller_name ."/ajax_unblock_one";


$controller_name = "log_seatizen";
$parent_route = "seatizen/log";
$route[$admin_app_folder . $parent_route .'/(:num)'] = $controller_name ."/list_item/$1";
$route[$admin_app_folder . $parent_route .'/list/(:num)'] = $controller_name ."/get_list_item_ajax/$1";


$controller_name = "seatizen_dashboard";
$parent_route = "seatizen/dashboard";
$route[$admin_app_folder . $parent_route] = $controller_name ."/show_dashboard";
$route[$admin_app_folder . $parent_route .'/growth'] = $controller_name ."/get_growth_data";
$route[$admin_app_folder . $parent_route .'/growth/(:num)/(:num)'] = $controller_name ."/get_growth_data/$1/$2";
$route[$admin_app_folder . $parent_route .'/login'] = $controller_name ."/get_login_data";
$route[$admin_app_folder . $parent_route .'/login/(:num)/(:num)'] = $controller_name ."/get_login_data/$1/$2";



$controller_name = "vacantsea";
$parent_route = "vacantsea";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route .'/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route .'/detail/page/(:num)'] = $controller_name ."/show_item_detail/$1";


$controller_name = "log_vacantsea";
$parent_route = "vacantsea/viewer";
$route[$admin_app_folder . $parent_route .'/(:num)'] = $controller_name ."/list_item/$1";
$route[$admin_app_folder . $parent_route .'/list/(:num)'] = $controller_name ."/get_list_item_ajax/$1";


$controller_name = "vacantsea_dashboard";
$parent_route = "vacantsea/dashboard";
$route[$admin_app_folder . $parent_route] = $controller_name ."/show_dashboard";
$route[$admin_app_folder . $parent_route .'/growth'] = $controller_name ."/get_growth_data";
$route[$admin_app_folder . $parent_route .'/growth/(:num)/(:num)'] = $controller_name ."/get_growth_data/$1/$2";


$controller_name = "agentsea";
$parent_route = "agentsea";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route .'/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route .'/detail/page/(:num)'] = $controller_name ."/show_item_detail/$1";


$controller_name = "log_agentsea";
$parent_route = "agentsea/log";
$route[$admin_app_folder . $parent_route .'/(:num)'] = $controller_name ."/list_item/$1";
$route[$admin_app_folder . $parent_route .'/list/(:num)'] = $controller_name ."/get_list_item_ajax/$1";


$controller_name = "notification";
$parent_route = "notification";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route .'/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route .'/get/new'] = $controller_name ."/get_new_notification_ajax";
$route[$admin_app_folder . $parent_route .'/update/time'] = $controller_name ."/update_notification_time_ajax";
$route[$admin_app_folder . $parent_route .'/reject'] = $controller_name ."/reject_request";



$controller_name = "vessel";
$parent_route = "vessel";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route .'/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route .'/list/(:num)'] = $controller_name ."/get_list_item_ajax/$1";
$route[$admin_app_folder . $parent_route .'/detail/page/(:num)'] = $controller_name ."/show_item_detail/$1";
$route[$admin_app_folder . $parent_route .'/import'] = $controller_name ."/import";

$controller_name = "report_problem";
$parent_route = "report_problem";

$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route . '/list'] = $controller_name ."/get_list_item_ajax";
$route[$admin_app_folder . $parent_route . '/detail/page/(:num)'] = $controller_name.'/show_item_detail/$1';
$route[$admin_app_folder . $parent_route . '/all_report'] = $controller_name."/list_item_all";

$controller_name = "request_upgrade";
$parent_route = "request_upgrade";

//$route[$admin_app_folder . $parent_route] = $controller_name ."/index";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";
$route[$admin_app_folder . $parent_route."/change_status_order"] = $controller_name ."/change_status_order";
// end

$controller_name = "advertise";
$parent_route = "advertise";

//$route[$admin_app_folder . $parent_route] = $controller_name ."/index";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item";

// end

$controller_name = "contact_us";
$parent_route = "contact_us";

$route[$admin_app_folder . $parent_route] = $controller_name."/list_item";

$controller_name = "dashboard";
$parent_route = "dashboard";
$route[$admin_app_folder . $parent_route] = $controller_name ."/show_main_dashboard";

$controller_name = "seatizen_dashboard";
$route[$admin_app_folder . $parent_route .'/seatizen/growth'] = $controller_name ."/get_growth_data";
$route[$admin_app_folder . $parent_route .'/seatizen/growth/(:num)/(:num)'] = $controller_name ."/get_growth_data/$1/$2";
$route[$admin_app_folder . $parent_route .'/seatizen/login'] = $controller_name ."/get_login_data";
$route[$admin_app_folder . $parent_route .'/seatizen/login/(:num)/(:num)'] = $controller_name ."/get_login_data/$1/$2";

$controller_name = "vacantsea_dashboard";
$route[$admin_app_folder . $parent_route .'/vacantsea/growth'] = $controller_name ."/get_growth_data";
$route[$admin_app_folder . $parent_route .'/vacantsea/growth/(:num)/(:num)'] = $controller_name ."/get_growth_data/$1/$2";


$controller_name = "tools";
$parent_route = "tools";
$route[$admin_app_folder . $parent_route] = $controller_name ."/show_memory_usage";
$route[$admin_app_folder . $parent_route .'/memory'] = $controller_name ."/show_memory_usage";

$controller_name = "send_email";
$parent_route = "send_email";
$route[$admin_app_folder . $parent_route] = $controller_name ."/list_item"; // default 
//$route[$admin_app_folder . $parent_route .'/memory'] = $controller_name ."/show_memory_usage";


$route["test_upload"] = "test_upload"; // default 

$route[$admin_app_folder . 'object/delete/several/(:any)'] = "bulk/ajax_delete_several/$1";
$route[$admin_app_folder . 'object/delete/one/(:any)'] = "bulk/ajax_delete_one/$1";


$route[$admin_app_folder . 'misc/crop'] = "misc/upload_crop_thumbnail";

$route[$admin_app_folder . 'migration'] = "access/migrate";


$route[$admin_app_folder . '(:any)']    = "welcome/$1";



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
