<?php 

	$base_url = "https://www.informasea.com/infrasset/img/asset_email"; //img
	$include_url = "template_email2016";
	//$name = "Aries Dimas Yudhistira";
	
	// $user = "seatizen"; //tujuan user 
	// $type;
	
	if($user_type == "seatizen")
	{
		$header_title 	 = "Hello Seatizen";
		$header_statement = "Find your preferable vacantsea and networking with seafarers or agentsea.";
		
	}
	else if($user_type == "agentsea")
	{
		$header_title 	 = "Hello Agentsea";
		$header_statement = "Manage crew's document and hire qualified crew.";
	}
	else
	{
		$header_title 	 = "Hello Seafarer and Agentseas";
		$header_statement = "Find Awesomeness in Informasea.com .";	
	}