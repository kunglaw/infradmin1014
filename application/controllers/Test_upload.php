<?php
 
 class Test_upload extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		echo "
			<form action='".base_url("test_upload/process")."' method='post' enctype='multipart/form-data'>
				<div>
					<span> Select File </span>
					<input type='file' name='file_upload' >
				</div>
				<input type='submit'>
				
			</form>
		";
		
	}
	
	function process()
	{		
		$config['upload_path']          = realpath(APPPATH . '../upload2');
		$config['allowed_types']        = 'pdf';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file_upload'))
		{
				$error = array('error' => $this->upload->display_errors());
				
				echo "<p> $error[error] </p>";
				echo "<a href='".base_url("test_upload/index")."'> << back </a>";
				//$this->load->view('upload_form', $error);
		}
		else
		{
				$data = array('upload_data' => $this->upload->data());

				echo "<p> success <a href='".base_url("test_upload/index")."'> << back </a> </p>";
				//$this->load->view('upload_success', $data);
		}
	}
	 
 }