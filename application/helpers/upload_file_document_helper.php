<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 



function make_username_folder_doc($username = '',$type)

{



	if(!is_dir(pathup("document/$username")))

	{



		mkdir(pathup("document/$username"));



		



		if(!is_dir(pathup("document/$username/$type")))



		{



			mkdir(pathup("document/$username/$type",0777));

			

			if($type == "doc")

			{

			

			  if(!is_dir(pathup("document/$username/$type/document_record")))

			  {

				  mkdir(pathup("document/$username/$type/document_record",0777));

			  }

			  

			  if(!is_dir(pathup("document/$username/$type/medical_record")))

			  {

				  mkdir(pathup("document/$username/$type/medical_record",0777));

			  }

			  

			  if(!is_dir(pathup("document/$username/$type/visa")))

			  {

				  mkdir(pathup("document/$username/$type/visa",0777));

			  }

			}



		}



		



	}



	else



	{



		if(!is_dir(pathup("document/$username/$type")))



		{



			mkdir(pathup("document/$username/$type",0777));	

			

			if($type == "doc")

			{

			

			  if(!is_dir(pathup("document/$username/$type/document_record")))

			  {

				  mkdir(pathup("document/$username/$type/document_record",0777));

			  }

			  

			  if(!is_dir(pathup("document/$username/$type/medical_record")))

			  {

				  mkdir(pathup("document/$username/$type/medical_record",0777));

			  }

			  

			  if(!is_dir(pathup("document/$username/$type/visa")))

			  {

				  mkdir(pathup("document/$username/$type/visa",0777));

			  }

			}



		}



	}



}



if(!function_exists('view_attachment'))

{

	function view_attachment()

	{

		$CI =& get_instance();

	

			

	}

}



if(!function_exists("upload_document_pelaut"))

{

	function upload_document_pelaut($attachment, $username, $type_document)

	{

		$CI =& get_instance();
		// database bisa dipersingkat

		// kalau bisa dipindahkan ke model masing - masing 
        if(!empty($attachment["name"]))
		{

			$config['upload_path']   = infr_img_path("document/$username/doc/$type_document");
			$config['allowed_types'] = "*";
			$config['max_size']	  = '1024'; // kb
			$config['file_name']	 = $attachment['name'];
			
			// $config['max_width']  = '1024';

			// $config['max_height']  = '768';

			$CI->load->library('upload', $config);
			//Perform upload.
			
			$lamp 	= array();

			$pesan 	= "";

			$filenya = $config['upload_path']."/".$attachment['name'];

			if(is_file($filenya)) unlink($filenya);
			// echo "hallo";
			if($CI->upload->do_upload("attachment"))
			{
				$pesan = "sukses";
				$lamp = $CI->upload->data();
				// print_r($lamp);

			} else {

				$pesan = "gagal";

				$lamp = $CI->upload->display_errors(); 

			}

		}		
		// print_r($lamp);

		return array('data' => $lamp, 'pesan' => $pesan);

	}

	

	function upload_coc_pelaut($attachment, $username)

	{

		$CI =& get_instance();

		

		// database bisa dipersingkat

		// kalau bisa dipindahkan ke model masing - masing 

		

        if(!empty($attachment["name"]))

		{

			

			$config['upload_path'] = infr_img_path("document/$username/coc");

			

			$config['allowed_types']  = '*';

			$config['max_size']	   = '1024'; // kb

			$config['file_name']	  = $attachment['name'];

			// $config['max_width']   = '1024';

			// $config['max_height']  = '768';

			$CI->load->library('upload', $config);

	

			//Perform upload.

			$lamp 	= array();

			$pesan 	= "";

			$filenya = $config['upload_path']."/".$attachment['name'];

			if(is_file($filenya)) unlink($filenya);



			if($CI->upload->do_upload("attachment", $attachment['name']))

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

	

	function upload_prof_pelaut($attachment, $username)

	{

		$CI =& get_instance();

		

		// database bisa dipersingkat

		// kalau bisa dipindahkan ke model masing - masing 

		

        if(!empty($attachment["name"]))

		{

			

			$config['upload_path'] = infr_img_path("document/$username/proficiency");

			

			$config['allowed_types']  = '*';

			$config['max_size']	   = '1024'; // kb

			$config['file_name']	  = $attachment['name'];

			// $config['max_width']   = '1024';

			// $config['max_height']  = '768';

			$CI->load->library('upload', $config);

	

			//Perform upload.

			$lamp 	= array();

			$pesan 	= "";

			$filenya = $config['upload_path']."/".$attachment['name'];

			if(is_file($filenya)) unlink($filenya);



			if($CI->upload->do_upload("attachment", $attachment['name']))

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

