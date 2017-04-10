<?php /* empty content */
/*
	** dimas **
	 - penanganan content yang kosong 
	   - company
	   - seaman
	   - vacantsea
	   - home
	   - dll
*/

// general field
if(!function_exists('e_field'))
{

	function e_field($value)
	{
		$default = "-";
		
		if($value == "")
		{
			return $default;
		}
		else
		{
			return $value;
			
		}
	}
}

if(!function_exists('e_href'))
{

	function e_href($value)
	{
		$default = "#";
		
		if($value == "")
		{
			return $default;
		}
		else
		{
			return $value;
			
		}
	}
}

// ====================== company / agentsea ==================================
if(!function_exists('e_desc'))
{
	function e_desc($value)
	{
		
		$default = "<p> - Description is not defined </p>";
		
		if($value == "")
		{
			return $default;
		}
		else
		{
			return $value;
			
		}
		
	}
}

if(!function_exists('e_about'))
{
	function e_about($value)
	{
		
		$default = "<p> - About Company is not defined </p>";
		
		if($value == "")
		{
			return $default;
		}
		else
		{
			return $value;
			
		}
		
	}
}

