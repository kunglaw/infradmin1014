<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');



if ( ! function_exists('make_username_folder'))

{

	function make_username_folder($username = '')

	{

		make_username_folder_pt($username);

		make_username_folder_tml($username);

		

	}

}



function make_username_company($username)
{	

	if(!is_dir("../infrasset/company/photo/$username"))

	{

		mkdir("../infrasset/company/photo/$username");

		

		if(!is_dir("../infrasset/company/photo/$username/cover"))

		{

			mkdir("../infrasset/company/photo/$username/cover",0777);	

		}

		

		if(!is_dir("../infrasset/company/photo/$username/logo"))

		{

			mkdir("../infrasset/company/photo/$username/logo",0777);	

		}

		

		if(!is_dir("../infrasset/company/photo/$username/resume"))

		{

			mkdir("../infrasset/company/photo/$username/resume",0777);	

		}

		

		if(!is_dir("../infrasset/company/photo/$username/ship"))

		{

			mkdir("../infrasset/company/photo/$username/ship",0777);	

		}

		

		if(!is_dir("../infrasset/company/photo/$username/profile_pic"))

		{

			mkdir("../infrasset/company/photo/$username/profile_pic",0777);	

		}

		

		if(!is_dir("../infrasset/company/photo/$username/photo"))

		{

			mkdir("../infrasset/company/photo/$username/photo",0777);	

		}



	}

	

}



function make_username_folder_pt($username = '')
{

	if(!is_dir("../infrasset/photo/$username"))

	{

		mkdir("../infrasset/photo/$username");

		if(!is_dir("../infrasset/photo/$username/big"))

		{

			mkdir("../infrasset/photo/$username/big",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/thumbnail"))

		{

			mkdir("../infrasset/photo/$username/thumbnail",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/small"))

		{

			mkdir("../infrasset/photo/$username/small",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/resume"))

		{

			mkdir("../infrasset/photo/$username/resume",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/cover"))

		{

			mkdir("../infrasset/photo/$username/cover",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/profile_pic"))

		{

			mkdir("../infrasset/photo/$username/profile_pic",0777);	

		}

	}

	else

	{

		if(!is_dir("../infrasset/photo/$username/big"))

		{

			mkdir("../infrasset/photo/$username/big",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/thumbnail"))

		{

			mkdir("../infrasset/photo/$username/thumbnail",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/small"))

		{

			mkdir("../infrasset/photo/$username/small",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/resume"))

		{

			mkdir("../infrasset/photo/$username/resume",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/cover"))

		{

			mkdir("../infrasset/photo/$username/cover",0777);	

		}

		

		if(!is_dir("../infrasset/photo/$username/profile_pic"))

		{

			mkdir("../infrasset/photo/$username/profile_pic",0777);	

		}

	}

}



function make_username_folder_tml($username = '')
{

	if(!is_dir("../infrasset/timeline/$username"))

	{

		mkdir("../infrasset/timeline/$username");

		if(!is_dir("../infrasset/timeline/$username/big"))

		{

			mkdir("../infrasset/timeline/$username/big",0777);	

		}

		

		if(!is_dir("../infrasset/timeline/$username/thumbnail"))

		{

			mkdir("../infrasset/timeline/$username/thumbnail",0777);	

		}

		

		if(!is_dir("../infrasset/timeline/$username/small"))

		{

			mkdir("../infrasset/timeline/$username/small",0777);	

		}

	}

	else

	{

		if(!is_dir("../infrasset/timeline/$username/big"))

		{

			mkdir("../infrasset/timeline/$username/big",0777);	

		}

		

		if(!is_dir("../infrasset/timeline/$username/thumbnail"))

		{

			mkdir("../infrasset/timeline/$username/thumbnail",0777);	

		}

		

		if(!is_dir("../infrasset/timeline/$username/small"))

		{

			mkdir("../infrasset/timeline/$username/small",0777);	

		}

	}

	

}



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