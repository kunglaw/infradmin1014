<?php  // content_general_helper

/*
	dimas 
	- menangani formating 
	- menangani hal - hal kecil 

*/

if(!function_exists("flag_nationality"))
{
	function flag_nationality($value)
	{
		$CI =& get_instance();	
		$a = $CI->load->database("infr6975_2015",TRUE);
		
		if(!empty($value))
		{
			$str = "SELECT * FROM nationality WHERE name = '$value' OR id = '$value' ";	
			$q   = $a->query($str);
			$f   = $q->row_array();
		
			$flag = strtolower($f["flag"]);
			$flag_url = infr_asset("flags/".$flag);
			$format = "<span title='$f[name]'> <img src='$flag_url'> $f[name] </span>";
		}
		else
		{
			$format = "";	
		}
		
		return $format;	
	}
}

if(!function_exists("flag_plus_rank"))
{
	function flag_plus_rank($flag_value, $rank_value)
	{
		$CI =& get_instance();	
		$a = $CI->load->database("infr6975_2015",TRUE);
		
		if(!empty($flag_value) && !empty($rank_value))
		{
			$str = "SELECT * FROM nationality WHERE name = '$flag_value' OR id = '$flag_value' ";	
			$q   = $a->query($str);
			$flag_data   = $q->row_array();

			$str  = "SELECT * FROM rank where rank = '$rank_value' ";
			$q	= $a->query($str);
			$rank_data 	= $q->row_array();
			
			if(empty($rank))
			{				
				$str  = "SELECT * FROM rank where rank_id = '$rank_value' ";
				$q	= $a->query($str);
				$rank_data 	= $q->row_array();
			}
		
			$flag = strtolower($flag_data["flag"]);
			$flag_url = infr_asset("flags/".$flag);
			$format = "<span title='$flag_data[name]'> <img src='$flag_url'> $rank_data[rank] </span>";
		}
		else
		{
			$format = "";	
		}
		
		return $format;	
	}
}

if(!function_exists("format_rank"))
{
	function format_rank($value)
	{
		$CI =& get_instance();
		$a = $CI->load->database("infr6975_2015",TRUE);
		
		if(!empty($value))
		{
			$str  = "SELECT * FROM rank where rank = '$value' ";
			$q	= $a->query($str);
			$f 	= $q->row_array();
			
			if(empty($f))
			{				
				$str  = "SELECT * FROM rank where rank_id = '$value' ";
				$q	= $a->query($str);
				$f 	= $q->row_array();
			}
						
			$format  = "<img src='".infr_asset("img/star-small.png")."' height='16' width='16'>";
			$format .= "<span> $f[rank]</span>";			
		}
		else
		{
			$format  = "";
		}
		
		return $format;
		
	}
}



if(!function_exists("profiler"))
{
	function profiler()
	{
		$CI =& get_instance();
		
		$CI->output->enable_profiler(TRUE);
		
		$sections = array(
			'config'  => TRUE,
			'queries' => TRUE
			);
		
		$CI->output->set_profiler_sections($sections);
		
	}
}

if(!function_exists("filter"))
{
  function filter($val)
  {
	  // $var = filter_input(INPUT_POST,$var_name,FILTER_SANITIZE_STRING);
	  // $var = filter_input(INPUT_POST,$var_name,FILTER_SANITIZE_SPECIAL_CHARS);
	  
	  $val = filter_var($val,FILTER_SANITIZE_STRING);
	  $val = filter_var($val,FILTER_SANITIZE_SPECIAL_CHARS);
	  
	  // $var = filter_var($val,FILTER_SANITIZE_URL);
	  
	  return $val;
  }
}

if(!function_exists('random_string'))
{
  function random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}
