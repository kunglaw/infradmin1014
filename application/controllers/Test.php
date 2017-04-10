<?php

class Test extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function test_view()
	{
		$this->load->model("seatizen_model","sm");
		
		$data["name"]    = "Aries Dimas Yudhistira";
		$data["content"] = "send_email/email/template_2016/email-seatizen-list"; 
		//print_r($this->session->all_userdata());
		$this->load->view("template_email2016/new_email_template",$data);
		//$this->load->view("test/test2.php");
		//$this->load->view("test");
	}
	
	function list_template_seatizen()
	{
		$this->load->model("seatizen_model","sm");
		
		// engine 4
		// deck 3
		
		// 206 - 2rd engineer
		//$data["department"] = "4";
		$data["rank"]	   = "220";
		//$data["vessel_type"] = "34";
		
		$data["list_title"] = "Hei";
		$data["list_description"] = "Hello";
		
		$this->load->view("send_email/email/template_2016/list-template-seatizen-backup",$data);	
		
	}
	
	function view_session()
	{
		$CI =& get_instance();
		$page_id = 12;
		$user_privileges = $CI->session->userdata("privileges");

        $page = $CI->generic->retrieve_one("admin_pages", array("id" => $page_id));
		
        $privileges_demanded = (int) $page["sign"];
		//$this->load->view("element/header");
		echo "<pre>";
		//echo $this->session->userdata("ip_address");
		//echo session_id();
		//echo $this->session->userdata("session_id");
		// print_r($this->session->all_userdata());
		echo "user_privileges = ".$user_privileges ; echo "<br>";
		echo "priviledges_demanded = ".$privileges_demanded; echo "<br>";
		$a = var_dump(! ($user_privileges & $privileges_demanded));
		if($a == FALSE)
		{
			echo "a = FALSE";	
		}
		else
		{
			echo "a = TRUE";			
		}
		
		print_r($this->session->all_userdata());
		echo "</pre>";	
	}
	
	function send_mailo()
	{
		$this->load->library("my_email");
		$this->load->model("seatizen_model");
		$user = "info";
		
		//$email    = "dimas@ariesdimasy.xyz";
		//$email	= "alhusna901@gmail.com";
		$email	= "reeonredemption@gmail.com";
		$username = "apaaja";
		$password = "999999";
		
		$name		   		   = "Aries Dimas Yudhistira";
		$dt_seatizen			= $this->seatizen_model->get_seatizen_panel();
		$str_url 				= infr_url("users/users_process/activate/?a=sadasdasdasd&x=1&u=$username&p=$password&email=$email");
		
		
		$content = array(
			
			"subject" 		=> "Informasea Account",
			"subject_title"  => WEBSITE,
			"to" 			 => $email, 
			"data" 		   => array("username"=>$username,"password"=>$password,"str_url"=>$str_url,"email_to"=>$email,
				"dt_seatizen" => $dt_seatizen, 'name' => $name),
			
			/* "message" 		=> "seatizen/email/email-activation-seatizen",
			"mv" 			 => TRUE,
			"alt_message" 	=> "seatizen/email/email-activation-seatizen-alt",
			"amv" 		    => TRUE */
			
			"message" 		=> "email_agentsea/create-vacantsea",
			"mv" 			 => TRUE,
			"alt_message" 	=> "email_agentsea/create-vacantsea-alt",
			"amv" 		    => TRUE
		
		);
		
		$this->my_email->send_email($user,$content);	
		echo "terkirim";	
	}
	
	function view_template_email()
	{
		$this->load->library("my_email");
		$this->load->model("seatizen_model");
		
		$data["title_text"] 	 = "Data is not Valid";
		$data["contact_person"] = "Aries Dimas Yudhistira";
		$nae = $data["name"]		   = "Aries Dimas Yudhistira";		
		$data["message_text"]   = array("Lorem Ipsum sit dolor amet","quick brown fox jump over a lazy dog");
		$data["str_url"]	    = infr_url("test/test");
		$data["pelaut"]		 = "Seaman Name";
		$email_to = $data["email_to"]	   = "alhusna901@informasea.com";
		$data['config'] 	     = $this->config->item("info");
		
		$username = $data["username"]	   = "alhusna901";
		$data["true_pass"]	  = "999999";
		$password = $data["password"]	   = "213213";
		
		$data['dt_seatizen']	= $this->seatizen_model->get_seatizen_panel();
		
		$data["content"]		= "
		<center> <h2> Surat Lamaran Kerja PT Informasea </h2> </center> 
		<p> Dengan hormat, </p>
<p> Sesuai dengan informasi pada blog/website di internet, bahwa 'PT Informasea' membutuhkan beberapa lowongan kerja dalam kategori Web Programmer, maka yang bertanda tangan di bawah ini, saya : </p>

    <div> Nama : $data[name] </div>
    <div> Alamat : Jl. Pinang Tangsel </div>
    <div> Tempat, Tanggal Lahir : Jakarta, 9 April 1991 </div>
    <div> Pendidikan Akhir : Universitas Bina Nusantara </div>

<p> Bermaksud untuk mengisi lowongan pada pekerjaan tersebut.Bersama ini saya lampirkan satu lembar daftar riwayat hidup dan data pendukung lainnya sebagai bahan pertimbangan dalam bentuk attachment. </p> 

<p> Bila dikehendaki, saya bersedia memenuhi panggilan Bapak/Ibu untuk dites dan diwawancarai.Atas perhatian Bapak/Ibu, saya ucapkan banyak terima kasih. </p> 

<div> Hormat saya, </div> 


<div> (Zabir Al Ahsan) </div>   ";
		
		$data['str_url']		= infr_url("user/demo"); // demo
		$data['str_reg']		= infr_url("user/register"); // register
		$data['title_btn']	  = "Demo content";
		$data['title_btn_reg']  = "Register"; 
		
		$data['is_reg']		 = FALSE;
			
		//$this->load->view("email_agentsea/authorized",$data);	// done
		//$this->load->view("email_agentsea/data-not-valid",$data); //done
		//$this->load->view("email_agentsea/phone-not-valid",$data); //done
		//$this->load->view("email_agentsea/unautorized-person",$data); //done
		//$this->load->view("email_agentsea/company-has-been-registered",$data);
		
		//$this->load->view("seatizen/email/email_confirmation",$data);
		//$this->load->view("seatizen/email/email-activation-seatizen",$data);
		
		$a  = $this->load->view("email_agentsea/create-vacantsea",$data,true);
		$a .= $this->load->view("email_agentsea/demo-dashboard",$data,true);
		$a .= $this->load->view("email_agentsea/demo-alpha",$data,true);
		$a .= $this->load->view("email_agentsea/new-content-email-template",$data,true);
		
		echo $a;
		
		/* $content = array(
			
			"subject" 		=> "Informasea Account",
			"subject_title"  => WEBSITE,
			"to" 			 => "alhusna901@gmail.com", 
			"data" 		   => array("username"=>$username,"password"=>$password,"str_url"=>$str_url,"email_to"=>$email,
				'name' => $name),
			
			/* "message" 		=> "seatizen/email/email-activation-seatizen",
			"mv" 			 => TRUE,
			"alt_message" 	=> "seatizen/email/email-activation-seatizen-alt",
			"amv" 		    => TRUE 
			"message" 		=> $a,
			"mv" 			 => FALSE,
			"alt_message" 	=> "email_agentsea/create-vacantsea-alt",
			"amv" 		    => FALSE
		
		);
		//$user = "info";
		$this->my_email->send_email($user,$content);*/
		
		
	}

	
	function test_modal()
	{
		
		$data["title_text"] 	 = "Data is not Valid";
		$data["contact_person"] = "Aries Dimas Yudhistira";
		$data["name"]		   = "Aries Dimas Yudhistira";		
		$data["message_text"]   = array("Lorem Ipsum sit dolor amet","quick brown fox jump over a lazy dog");
		$data["str_url"]	    = infr_url("test/test");
		$data["pelaut"]		 = "Seaman Name";
		$data["email_to"]	   = "alhusna901@informasea.com";
		$data['config'] 	     = $this->config->item("info");
		
		$data["username"]	   = "alhusna901";
		$data["true_pass"]	  = "999999";
		$data["password"]	   = "213213";
		
		//$data['dt_seatizen']	= $this->seatizen_model->get_seatizen_panel();
		
		$data["content"]		= "
		<center> <h2> Surat Lamaran Kerja PT Informasea </h2> </center> 
		<p> Dengan hormat, </p>
<p> Sesuai dengan informasi pada blog/website di internet, bahwa 'PT Informasea' membutuhkan beberapa lowongan kerja dalam kategori Web Programmer, maka yang bertanda tangan di bawah ini, saya : </p>

    <div> Nama : $data[name] </div>
    <div> Alamat : Jl. Pinang Tangsel </div>
    <div> Tempat, Tanggal Lahir : Jakarta, 9 April 1991 </div>
    <div> Pendidikan Akhir : Universitas Bina Nusantara </div>

<p> Bermaksud untuk mengisi lowongan pada pekerjaan tersebut.Bersama ini saya lampirkan satu lembar daftar riwayat hidup dan data pendukung lainnya sebagai bahan pertimbangan dalam bentuk attachment. </p> 

<p> Bila dikehendaki, saya bersedia memenuhi panggilan Bapak/Ibu untuk dites dan diwawancarai.Atas perhatian Bapak/Ibu, saya ucapkan banyak terima kasih. </p> 

<div> Hormat saya, </div> 


<div> (Zabir Al Ahsan) </div>   ";
		
		$data['str_url']		= infr_url("user/demo"); // demo
		$data['str_reg']		= infr_url("user/register"); // register
		$data['title_btn']	  = "Demo content";
		$data['title_btn_reg']  = "Register"; 
		
		$data['is_reg']		 = FALSE;
		
		
		$this->load->view("modal/test_modal",$data);	
	}
	
}


