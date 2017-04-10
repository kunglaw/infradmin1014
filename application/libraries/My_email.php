<?php if(!defined("BASEPATH")) exit ("No direct Script access allowed");

/*
	buatan kunglaw
*/
class My_email{
	
	private $CI;
	private $mv  = TRUE;
	private $amv = TRUE;
	private $debugger;
	function __construct()
	{
		$this->CI =& get_instance();
		$CI = $this->CI;
		$CI->load->library("email");
		$CI->config->load("email");

	}

	
	
	private function config_email($user)
	{
		$CI = $this->CI;
		// set email config
		$config = array();
		
		if(is_array($user)){
			
			$config['protocol']  = "smtp";
			$config['mailtype']  = "html";
			$config['priority']  = "1";
			$config['wordwrap']  = FALSE;
			$config['smtp_host'] = "ssl://mail.informasea.com";
			$config['smtp_port'] = 465;
			$config['smtp_user'] = $user['smtp_user'];
			$config['smtp_pass'] = $user['smtp_pass'];
			$config['charset']   = "utf-8";	
		}
		else
		{
			if(!empty($user))
			{
				  $username_mail = $CI->config->item($user);					  
				  
				  $config['protocol']  = $username_mail['protocol'];
				  $config['mailtype']  = $username_mail['mailtype'];
				  $config['priority']  = $username_mail['priority'];
				  $config['wordwrap']  = $username_mail['wordwrap'];
				  $config['smtp_host'] = $username_mail['smtp_host'];
				  $config['smtp_port'] = $username_mail['smtp_port'];
				  $config['smtp_user'] = $username_mail['smtp_user'];
				  $config['smtp_pass'] = $username_mail['smtp_pass'];
				  // $config_email['smtp_user'] = 'dummybadr@yahoo.co.id';
				  // $config_email['smtp_pass'] = 'gantengganteng';
				  $config['charset']   = $username_mail['charset'];
				
			}
			else // default config
			{
			  // config 
			  $user = $CI->config->item("admin");	
			  
			  // $config = array();
			  
			  $config['protocol']  = $user['protocol'];
			  $config['mailtype']  = $user['mailtype'];
			  $config['priority']  = $user['priority'];
			  $config['wordwrap']  = $user['wordwrap'];
			  $config['smtp_host'] = $user['smtp_host'];
			  $config['smtp_port'] = $user['smtp_port'];
			  $config['smtp_user'] = $user['smtp_user'];
			  $config['smtp_pass'] = $user['smtp_pass'];
			  // $config_email['smtp_user'] = 'dummybadr@yahoo.co.id';
			  // $config_email['smtp_pass'] = 'gantengganteng';
			  $config['charset']   = $user['charset'];	
			}
		}
		return $config;
	}
	
	/* private function set_mv($mv)
	{
		$CI = $this->CI;
		$CI->mv = $mv;	
	}
	
	private function set_amv($amv)
	{
		$CI = $this->CI;
		$CI->amv = $amv;
	} */
	
	private function config_content($content)
	{
		$config['subject'] 		= $content['subject']; // string
		$config["subject_title"]  = $content["subject_title"]; //string
		$config["to"]			 = $content["to"];
		
		// alt email
		$config['cc']			 = $content["cc"]; // string
		$config["bcc"]			= $content["bcc"]; // string
		
		$config['message']		= $content["message"]; // String, bisa sebuah path untuk di view
		$config["mv"]   			 = $content["mv"]; // BOOLEAN , apakah message ini 
		$config["alt_message"]	= $content["alt_message"]; // string
		$config["amv"]			= $content["amv"];
		$config['attachment'] = $content['attachment'];
		
		return $config;
		
	}
	
	public function send_email($user,$content)
	{
		$CI = $this->CI;
		
		$config  = $this->config_email($user);
		$isi     = $this->config_content($content);
		
		// set config ke page view
		$data		   = $content["data"]; // adanya tambahan data yg akan di tampilkan di view, array
		$data['config'] = $config; // array
		
		// setting
		$CI->email->initialize($config);
		
		$CI->email->from($config['smtp_user'], $isi['subject_title']);
		$CI->email->to($isi["to"]); 
		
		// setting alt email
		if(!empty($isi["cc"]))
		{
			$CI->email->cc($isi["cc"]);
		}
		if(!empty($isi["bcc"]))
		{
			$CI->email->bcc($isi["bcc"]);
		}
		
		$CI->email->subject($isi['subject']);
		
		// setting message
		if($isi["mv"] == TRUE)
		{
			$message = $CI->load->view($isi["message"],$data,true);
		}
		else
		{
			$message = $isi["message"];
		}

		$CI->email->message($message);
		
		if(!empty($isi['attachment']) or $isi['attachment'] != "")
		{
			$CI->email->attach($isi['attachment']);
		}

		// setting alt_message
		if($isi["amv"] == TRUE)
		{
			$alt_message = $CI->load->view($isi["alt_message"],$data,true);
		}
		else
		{
			$alt_message = $isi["alt_message"];		
		}
		$CI->email->set_alt_message($alt_message);
	
		$CI->email->send();
		$this->debugger = $CI->email->print_debugger();
	}

	

	public function printDebugger()
	{
		return $this->debugger;
	}

}