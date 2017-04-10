<?php

	class Cron extends CI_Controller{
		
		function __construct()
		{
			parent::__construct();	
			
		}
		
		function index()
		{
			
			$arr = array($_ENV['TERM'],$_ENV['SSH_CLIENT'],$_ENV["SSH"],$_ENV["SSH_TTY"],$_ENV["SSH_CONNECTION"]); 
			

			$sapi_type = php_sapi_name();
			echo $sapi_type;
			
		}		
		
		function send_email()
		{
			// ambil email dari database
			
			
		}
		
		
	}