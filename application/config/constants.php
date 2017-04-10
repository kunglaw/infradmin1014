<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| LINK URL
|--------------------------------------------------------------------------
| 
| 	Link url untuk img, file, url dll 
*/
define("BASE_URL","https://infradmin1014.informasea.com");
define("ASSET_URL","https://informasea.com/informasea_assets");
define("INFRASSET_URL","https://informasea.com/infrasset");
define("INFRASSET_PATH","../infrasset");
define("INFR_URL","https://informasea.com/");
define("IMG_URL",BASE_URL."/infrasset");
define("FILE_URL",BASE_URL."/infrasset");

/*
|--------------------------------------------------------------------------
| Profile Informasea
|--------------------------------------------------------------------------
|	
| basic profile informasea
|
*/
define("WEBSITE","Informasea");
define("TITLE","informasea.com");
define("COMPANY",""); // nama PT Informasea
define("URL_WEBSITE","https://www.informasea.com");
define("ADDRESS","Jl. K.H Hasyim Ashari Gg. H Masykur No 29 RT 2/2 Kel. Pinang Kec. Pinang Tangerang 
            Tangerang, Indonesia");
define("TELP","");

define("INFORMASEA_SLOGAN","Seafarers networking and Job portal");

define("INFORMASEA_DESC","Informasea is ".INFORMASEA_SLOGAN.". For Shipping company, this is the place where you can manage and search the competent seaman to hire");
define("META_DESCRIPTION","Informasea is ".INFORMASEA_SLOGAN.". For Shipping company, this is the place where you can manage and search the competent seaman to hire");

define("COPYRIGHT","copyright @ 2014 - ".WEBSITE." All right reserved");

define("CONTACT","info@informasea.com");
define("LOGO_INFORMASEA",ASSET_URL."/img/img_logo.png");
define("LOGO_INFORMASEA_BIG",ASSET_URL."/img/img_logo_big.png");
define("LOGO_INFORMASEA_WHITE",ASSET_URL."/img/logo_informasea_white.png");
define("LOGO_INFORMASEA_MOBILE",ASSET_URL."/img/img_logo_mobile.png");
define("LOGO_INFORMASEA_ALT",ASSET_URL."img/img_logo_alt.jpg");
define("EMAIL_IMG",INFRASSET_URL."/img/email/");
define("FAVICON",ASSET_URL."/img/favicon.png");

/*
|--------------------------------------------------------------------------
| Waktu Logout
|--------------------------------------------------------------------------
*/
define("LOGOUT_TIME",1800); // detik, second

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       https://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       https://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       https://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| Email super duper admin
|--------------------------------------------------------------------------
|
*/
define('MASTER_EMAIL', 'admin@informasea.id');

/*
|--------------------------------------------------------------------------
| Notification types
|--------------------------------------------------------------------------
|
| These types are used when dealing with set_notification() and show_notification()
|
*/
define('NOTIF_SUCCESS', 'success');
define('NOTIF_INFO', 'info');
define('NOTIF_WARNING', 'warning');
define('NOTIF_ERROR', 'danger');

/*
|--------------------------------------------------------------------------
| User types
|--------------------------------------------------------------------------
*/
define('USER_SUPER_ADMIN', 1);
define('USER_ADMIN', 2);

/*
|--------------------------------------------------------------------------
| Menu constants for sidebar
|--------------------------------------------------------------------------
*/
define('MENU_ADMIN', 1);
define('MENU_ROLE', 2);
define('MENU_SEATIZEN', 3);
define('MENU_VACANTSEA', 4);
define('MENU_AGENTSEA', 5);
define('MENU_VESSEL', 6);
define('MENU_TOOLS', 7);
define('MENU_DASHBOARD', 8);
define('MENU_REPORT_PROBLEM',9);
define('MENU_CONTACT_US',11);
define('MENU_SEND_EMAIL',12);
define('MENU_REQUEST_UP',13);
define("MENU_ADVERTISE",14);


/*
|--------------------------------------------------------------------------
| Notification type constants
|--------------------------------------------------------------------------
*/
define('NOTIF_NEW_SEATIZEN', 1);
define('NOTIF_NEW_AGENTSEA', 2);

define('NOTIF_BLOCK_SEATIZEN', 3);
define('NOTIF_BLOCK_SEATIZEN_REPLY', 4);

define('NOTIF_UNBLOCK_SEATIZEN', 5);
define('NOTIF_UNBLOCK_SEATIZEN_REPLY', 6);

define('NOTIF_DELETE_VESSEL', 7);
define('NOTIF_DELETE_VESSEL_REPLY', 8);



define('NOTIF_NEW_REPORT', 9);
define('NOTIF_EDIT_PIC',10);

/*
|--------------------------------------------------------------------------
| Menu constants for sidebar
|--------------------------------------------------------------------------
*/
define('APPLICATION_NAME', "Informasea");


define('TEMP_IMAGE_UPLOAD_LOCATION', "upload/");


define('NEED_IMAGE_TOOLS_GLOBAL', TRUE);


define('PHOTO_HOME_ADDRESS', "https://informasea.com/infrasset/photo/");


/*
|--------------------------------------------------------------------------
| database kunglaw
|--------------------------------------------------------------------------
*/

define('DB_GROUP','default');
define("DB2_GROUP",'infr6975_2015');
//define("DB3_GROUP",'infr6975_2014');

define("DB","informasea_admin");
define("DB2","infr6975_informaseadb2015");
//define("DB3","infr6975_informaseadb2014");

/*
|--------------------------------------------------------------------------
| IMAGE
|--------------------------------------------------------------------------
|
|
*/
//img_url("company/default/ic_landing_company.svg");

define("DEFAULT_PHOTO_SMALL",ASSET_URL."/user_img/noprofilepic_small.png");
define("DEFAULT_PHOTO_THUMBNAIL",ASSET_URL."/user_img/noprofilepic_thumb.png");
define("DEFAULT_PHOTO_BIG",ASSET_URL."/user_img/noprofilepic.png");

define("DEFAULT_IMG_PROFILE_SEAMAN",ASSET_URL."/img/ic_landing_seaman.png");
define("DEFAULT_IMG_RESUME_SEAMAN",ASSET_URL."/img/ic_landing_seaman.png");

define("DEFAULT_IMG_LOGO_AGENTSEA",ASSET_URL."/img/ic_landing_company.png");
define("DEFAULT_IMG_PROFILE_MANAGER",ASSET_URL."/img/ic_landing_company.png");
define("DEFAULT_IMG_PROFILE_AGENT",ASSET_URL."/img/ic_landing_company.png");

define("DEFAULT_IMG_LOGO_AGENTSEA_PNG",ASSET_URL."/img/ic_landing_company.png");

define("DEFAULT_IMG_COVER_SEAMAN",ASSET_URL."/img/img_ship.png");
define("DEFAULT_IMG_COVER_AGENT",ASSET_URL."/img/cover.jpg");
