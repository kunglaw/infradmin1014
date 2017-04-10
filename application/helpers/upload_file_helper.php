<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if(!function_exists("upload_file_email"))
{
	function upload_file_email($attachment)
	{
		$CI =& get_instance();
		// $usernam_comp = $CI->session->userdata("username_company");
		$path_utama = "img/email";
		
		// database bisa dipersingkat
		// kalau bisa dipindahkan ke model masing - masing 
		
        if(!empty($attachment["name"]))
		{
			
			$config['upload_path'] = infrasset_path().$path_utama;
			
			$config['allowed_types'] = '*';
			$config['max_size']	= '1000'; // kb
			// $config['max_width']  = '1024';
			// $config['max_height']  = '768';
			$CI->load->library('upload', $config);
			
			//Perform upload.
			$lamp 	= array();
			$pesan 	= "";
			$filenya = $config['upload_path']."/".$attachment['name'];
			$file_jpg = $config['upload_path']."/".explode('.', $attachment['name'])[0].".jpg";
			$file_jpeg = $config['upload_path']."/".explode('.', $attachment['name'])[0].".jpeg";
			$file_png = $config['upload_path']."/".explode('.', $attachment['name'])[0].".png";
			$file_gif = $config['upload_path']."/".explode('.', $attachment['name'])[0].".gif";

			if(is_file($file_jpeg)) unlink($file_jpeg);
			if(is_file($file_jpg)) unlink($file_jpg);
			if(is_file($file_png)) unlink($file_png);
			if(is_file($file_gif)) unlink($file_gif);
			

			if($CI->upload->do_upload("browse_img", $attachment['name']))
			{
				$pesan = "sukses";
				$lamp = $CI->upload->data();
			} else {
				$pesan = "gagal";
				$lamp = $CI->upload->display_errors(); 
			}
		}		
		return array('data' => $lamp, 'pesan' => $pesan);
	}
}
	?>