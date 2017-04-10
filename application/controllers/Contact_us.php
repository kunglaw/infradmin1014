<?php if(!defined('BASEPATH')) exit('no direct script access allowed');



	class Contact_us extends CI_Controller {





    private $_primary_table = "contact_us";



    private $_respon_table = "contact_us";





    private $_menu = MENU_CONTACT;



    private $_route = "contact_us";

    private $_view_folder = "contact_us";



	function __construct(){

	parent::__construct();

	}



	function list_item(){

 set_page_title("Contact Us List");

 $this->load->model('contact_model');



        $this->session->set_userdata("sidebar_flag", $this->_menu);

        $data['contact'] = $this->contact_model->all_contact();



       $this->load->view($this->_view_folder.'/item_all',$data);

	}



	function reply_item($id){

		set_page_title('Repply Contact Us');



		$this->load->model('contact_model');

  		

  		$this->session->set_userdata("sidebar_flag", $this->_menu);

        $data['contact'] = $this->contact_model->detail_contact($id);





        $this->load->view($this->_view_folder.'/item_detail',$data);



	}



	function repply_message(){

		$this->load->model('contact_model');

		$message = $this->input->post('messagenew');

		$email_pengirim = $this->input->post('email');

		$id_contact = $this->input->post('id_contact');

		$subject = $this->input->post('subject');
		
		//$dt["message"] = $message;
		//$dtt["message"] = $message;
		$dt["content_template"] = $message;
		//$dt["content_template"] = $this->load->view("contact_us/contactus_email",$dtt,true);
		$msg = $this->load->view("template_email2016/new_email_template",$dt,true);

                    $this->load->library('email');

                        //echo "aa";

        // set email config

			        $config = array();

			        $config['protocol']  = 'smtp';

			        $config['mailtype']  = 'html';

			        $config['priority']  = '1';

			        $config['wordwrap']  = FALSE;

			        $config['smtp_host'] = 'ssl://mail.informasea.com';

			        $config['smtp_port'] = 465;

			        $config['smtp_user'] = 'info@informasea.com';

			        $config['smtp_pass'] = 'uA8Q_MOh%%Ol';

			        

			        $data['config'] = $config;;

			        $config['charset']  = 'utf-8';

			        $this->email->initialize($config);

			        $this->email->from($config['smtp_user'], $subject);

			        $this->email->to($email_pengirim); 

			        

			        $this->email->subject($subject);

			        

			        $this->email->message($msg);

			     		 $a =  $this->email->send();



			     		 if($a){



			     		 	$str = $this->contact_model->updatedata($id_contact,$subject,$balasan);

			     		 	if($str){



			     		 		redirect('contact_us');



			     		 	}

			     		 }



	}



	function detail($id){



	set_page_title('Detail Contact Us');



		$this->load->model('contact_model');

  		

  		$this->session->set_userdata("sidebar_flag", $this->_menu);

        $data['contact'] = $this->contact_model->detail_contact($id);





        $this->load->view($this->_view_folder.'/detail',$data);



	}





	}