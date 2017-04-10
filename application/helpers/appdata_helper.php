<?php if(!defined("BASEPATH")) exit ("No Direct Script Access Allowed");

if(!function_exists("download_seatizen_exctmpl"))
{
	function download_seatizen_exctmpl()
	{
		
		$CI =& get_instance();
		
		$CI->load->helper("download");
		
		$server_url = $CI->config->item("server_url");
		// $server  = $CI->config->item("server"); 
		
		$det = $server_url."upload/seatizen/excel_template/seatizen_excel_template.xlsx";
		$z = file_get_contents($det);
		force_download("seatizen_excel_template.xlsx", $z);
		
		//return $det;
		
	}
}