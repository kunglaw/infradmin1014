<?php if(!defined("BASEPATH")) exit ("No Direct Script Access Allowed");

class Excel_management{
	
	private $CI;
	private $table; // seatizen, vessel, vacantsea
	private $upload_location; // upload location
	private $excel_filename;
	
	function __construct()
	{
		//echo "Excel management exists ... ";	
		$this->CI =& get_instance();
		
		//$this->set($setting);
		// $this->test = "ini adalah test";
	}
	
	// function ini dijalankan pada function yang public, yaitu langsung di panggil di controller 
	private function set($setting)
	{
		$CI = $this->CI;
		
		// seatizen = "upload/seatizen/excel_data"
		$this->upload_location = $setting["upload_location"];
		$this->table		   = $setting["table"];
		
	}
	
	public function test($setting)
	{
		$this->set($setting);
		
		$this->handle_uploaded_excel();	
	}
	
    /**
     * Handle uploaded excel file, place them into /upload/excel.
     * @return array|null
     */
    private  function handle_uploaded_excel() {

		
		$CI = $this->CI;
		
        $upload_path    			= $this->upload_location;

        $config["upload_path"]  	  = $upload_path;
        $config["allowed_types"] 	= "xls|xlsx";
        $config["max_size"] 		 = 10000;
        $config["max_width"] 		= 200000;
        $config["max_height"] 	   = 200000;
        $config["encrypt_name"]     = TRUE;

        $CI->load->library("upload", $config);
        $upload_data = NULL;

        // upload the image from input. (image data is in $_FILES)
        if (! $CI->upload->do_upload("excel_file")) {
			
            log_message("error", $CI->upload->display_errors());
			
        } else {
            // image data after upload.
            $upload_data = $CI->upload->data();
        }

        return $upload_data;
    }


    /**
     * Handle uploaded excel file, place them into /upload/excel.
     * @return array|null
     */
    private function convert_formatted_cell($value) {

        $formatted_text = "";

        // detect rich text element
        if ($value instanceof PHPExcel_RichText) {

            // loop all RTE
            foreach($value->getRichTextElements() as $element) {

                if ($element instanceof PHPExcel_RichText_Run) {

                    if ($element->getFont()->getItalic()) {
                        $formatted_text .= "<i>";
//                        log_message("debug", "XXX import excel: <i>");
                    }
                    if ($element->getFont()->getBold()) {
                        $formatted_text .= "<b>";
//                        log_message("debug", "XXX import excel: <b>");
                    }
                    if ($element->getFont()->getUnderline() != "none") {
                        $formatted_text .= "<u>";
//                        log_message("debug", "XXX import excel: <u>");
                    }

                    if ($element->getFont()->getSuperScript()) {
                        $formatted_text .= "<sup>";
//                        log_message("debug", "XXX import excel: <sup>");
                    } else if ($element->getFont()->getSubScript()) {
                        $formatted_text .= "<sub>";
//                        log_message("debug", "XXX import excel: <sub>");
                    }

                    $formatted_text .= $element->getText();
//                    log_message("debug", "XXX import excel: ". $element->getText());

                    if ($element->getFont()->getSuperScript()) {
                        $formatted_text .= "</sup>";
//                        log_message("debug", "XXX import excel: </sup>");
                    } else if ($element->getFont()->getSubScript()) {
                        $formatted_text .= "</sub>";
//                        log_message("debug", "XXX import excel: </sub>");
                    }

                    if ($element->getFont()->getUnderline() != "none") {
                        $formatted_text .= "</u>";
//                        log_message("debug", "XXX import excel: </u>");
                    }
                    if ($element->getFont()->getBold()) {
                        $formatted_text .= "</b>";
//                        log_message("debug", "XXX import excel: </b>");
                    }
                    if ($element->getFont()->getItalic()) {
                        $formatted_text .= "</i>";
//                        log_message("debug", "XXX import excel: </i>");
                    }

                } else {
                    $formatted_text .= $element->getText();
//                    log_message("debug", "XXX import excel only text: ". $element->getText());
                }
            }

        } else { // special for non-RTE items
//            log_message("debug", "XXX import excel not a RichTextElements: ". $value);
            $formatted_text = $value;
        }

        return $formatted_text;
    }

    /**
     * Convert excel data into tips object
     * @return array|null
     */
    private function convert_excel_to_sql($filename = "") {
		
        $CI = $this->CI;
		
        $table_name      = $this->table;
		
        // immediately return if there is no table target for question storage.
        if ($filename == "") {
            return NULL;
        }
		
		//require("PHPExcel.php");
        $CI->load->library("PHPExcel");
		$CI->load->helper("excel_field");
		$CI->load->library("my_email");// buat kirim email
		
		$config_email = $CI->config->item("info");
        //$CI->load->helper("excel");

        // load excel file
        $server_url = $CI->config->item("server_url");
		
		//echo $this->upload_location."/".$filename;
												// var changeable
        $excel_file = PHPExcel_IOFactory::load($this->upload_location."/".$filename);

        $cell_collection = $excel_file->getActiveSheet()->getCellCollection();

        $data_list   = array();
        $broken_cell = false;

        // convert excel data to respective column in db.
		
		/*
			print_r($cell_collection);
			
			Array
			(
				[0] => A1
				[1] => B1
				[2] => C1
				[3] => A2
				[4] => B2
				[5] => C2
				[6] => A3
				[7] => B3
				[8] => C3
			)
		
		*/
		
        foreach ($cell_collection as $cell) {
			$i = 0;
            $current_cell  = $excel_file->getActiveSheet()->getCell($cell);
            $column 		= $current_cell->getColumn();
            $row 		   = $current_cell->getRow();
            $value 		 = $current_cell->getValue();

            if ($row == 1) {
                continue;

            } else {
				
                // convert cell value with formatting first.
                $value = $this->convert_formatted_cell($value);
                $value = trim($value);
				
				// yang ini harus fleksibel, tergantung tabel nya apa 
				if($table_name == "pelaut_ms")
				{
                	$outpt = seatizen_excel_field($column,$value);
					$dt[$outp["key"]]  = $outp["new"];
					
					// untuk menambah $dt, harus diluar function helper
					// set username and password
					if($outp["key"] == "email")
					{
						$ex 			= explode("@",$dt["email"]);
						$dt["username"]= $ex[0];
					}
					
					if($outp["last"] == TRUE)
					{
						$dt["password"] = mt_rand(100000,999999);	
					}
					
					$dt_email = array(
		  		
						  "smtp_user"	=> $config_email["smtp_user"],
						  "nama" 		 => $dt['nama_depan']." ".$dt['nama_belakang'],
						  "agentsea"	 => $agentsea['nama_perusahaan'],
						  "username"	 => $agent["username"],
						  "password"	 => $password,
						  "agent_name"   => $agent["nama"]
						  
					);
					
					
				}
				else if($table_name == "ship")
				{
					$outp = vessel_excel_field($column,$value);
					$dt[$outp["key"]] = $outp["new"];
				}
				else if($table_name == "test")
				{
					// thats a long story bro 
					// nilai ini adalah satuan, bukan dalam bentuk assosiatif array
					// intinya nilai ini adalah satuan
					$outp = test_excel_field($column,$value);
					$dt[$outp["key"]] = $outp["new"];
					
					
				}
				
				// kalau sudah mencapai row akhir
				if($outp["last"] == TRUE)
				{
					$data_list[] = $dt;
					$dt		  = array();
				}
            }

            if ($outp["broken_cell"] == TRUE) {
                break;
            }

        } // end foreach
		
        $insert_result = NULL;
		
        if (!empty($data_list) && !$broken_cell) {
			
			// buat insert sendiri 
			// buat lebih fleksible 
			if($table_name == "pelaut_ms")
			{
				$insert_result = insert_batch_seatizen($data_list);
				
				 // kirim email melalui datalist
				foreach($data_list as $row)
				{
					$content = array(
		
					  "subject" => 	   "New Seatizen Registered",
					  "subject_title" => "informasea.com",
					  "to" => 			$dt["email"],
					  "dt_email"=>  	   $dt_email,
					  "message" => 	   "email/email_confirmation", // message ini path
					  "alt_message" =>   "email/email_confirmation_alt",
					  "mv" => TRUE, // karena path set TRUE
					  "amv" => TRUE
					  
					);
					
					
					$this->my_email->send_email("info",$content);
				} 	
			}
			else if($table_name == "ship")
			{
				$insert_result = "";
			}
			else if($table_name == "test")
			{
				$insert_result = insert_batch_test($data_list);
			}
			
            // insert batch of vessel into storage table $table_name
            //$insert_result = $CI->generic_model->create_batch($table_name,$ressef["data_list"]);
        }

        return $insert_result;
    }

    /**
     * Import excel
     *
     * @param string $table_name
     * @param string $grade
     * @return array
     */
    public function import_excel($setting) {

        $CI = $this->CI;

        // upload excel
        //$CI->load->helper("excel");
		
		// setting dolo bro 
		$this->set($setting);
		
        $uploaded_file = $this->handle_uploaded_excel();
		
        $response = array();

        if (! $uploaded_file) {

            $response["status"] 	   = "error";
            $response["notification"] = "Input is invalid.";
            $response["errors"] 	   = array("excel_file" => "There is an error while uploaded file");

            return $response;
        }
		
        $insert_result = $this->convert_excel_to_sql($uploaded_file["file_name"]);
		
        if (!empty($insert_result)) {
            $response["status"] 	   = "success";
            $response["notification"] = "File has been sucessfully uploaded.";

        } else {
            $response["status"] 	   = "error";
            $response["notification"] = "Input is invalid.";
            $response["errors"] 	   = array("excel_file" => "There is an error while uploaded.");

        }
		
		
		// hapus bekas uploaded file 
        $excel_filename = $this->upload_location.$uploaded_file["file_name"];

        if (file_exists($excel_filename)) {
			
            unlink($excel_filename);
        }

        return $response;

    }

    /**
     * @return array
     */
    private function write_base64_to_file($base64_string) {

        $CI = $this->CI;

        // get file extension from base64 string
        $image_data = base64_decode($base64_string);

        $f = finfo_open();
        $mime_type = finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE);

        $mime_parts = explode("/", $mime_type);
        $extension = $mime_parts[1];

        switch($extension) {
            case "jpeg":
            case "jpg":
            case "gif":
            case "png":
                break;

            default:
                return "";
                break;
        }

        // set up a new random file for imported base64.
        $CI->load->helper("string");
        $server_url = $CI->config->item("server_url");

        do {
            $random_filename = random_string("alnum", 15);

        } while(file_exists($server_url ."assets/img/tips/". $random_filename .".". $extension));


        // write them into image file.
        $file_pointer = fopen($server_url ."assets/img/tips/". $random_filename .".". $extension, "wb");

        fwrite($file_pointer, $image_data);
        fclose($file_pointer);

        return $random_filename .".". $extension;
    }

    /**
     * @return array
     */
    private function convert_content_image_id($content) {

        $CI = $this->CI;

        $pattern = '/##(\d+)!!/i';

        $result = preg_replace_callback(
            $pattern,
            "convert_content_gallery_id_to_base64",
            $content
        );

        return $result;
    }

    /**
     * @return array
     */
    private function convert_content_gallery_id_to_base64($matches = array()) {

        $CI = $this->CI;

        $match_part = explode("##", $matches[0]);
        $match_second_part = explode("!!", $match_part[1]);
        $content_gallery_id = $match_second_part[0];

        $image_data = $CI->generic_model->retrieve_one("content_gallery", array("id" => $content_gallery_id));


        $image_code = "";
        if ($image_data) {
            $image_code = "##". $image_data["base64_image"] ."##";
        }

        return $image_code;
    }
	
	/**
     * Convert excel data into question object
     * @return array|null
     */
    private function convert_excel_to_question($table_name = "", $filename = "",$grade = "", $try_out_id = NULL) {

        $CI = $this->CI;

        // immediately return if there is no table target for question storage.
        if ($table_name == "" || $filename == "" || $grade == "") {
            return;
        }

        $CI->load->library("PHPExcel");

        // load excel file
        $server_url = $CI->config->item("server_url");
		
		//echo $server_url ."upload/excel/". $filename;
		
												// var changeable
        $excel_file = PHPExcel_IOFactory::load($server_url ."upload/excel/". $filename);

        $cell_collection = $excel_file->getActiveSheet()->getCellCollection();

        $data_list = array();

        // convert excel data to respective column in db.
        foreach ($cell_collection as $cell) {
			
            $column = $excel_file->getActiveSheet()->getCell($cell)->getColumn();
            $row    = $excel_file->getActiveSheet()->getCell($cell)->getRow();
            $value  = $excel_file->getActiveSheet()->getCell($cell)->getValue();

            if ($row == 1) {
                continue;

            } else {

                // convert cell value with formatting first.
                $value = convert_formatted_cell($value);

                switch ($column) {
                    case "A":
                        $data_list[$row - 1]["subject"] = $value;
                        break;
                    case "B":
                        $data_list[$row - 1]["section"] = $value;
                        break;
                    case "C":
                        $content = convert_content_image_id($value);
                        $data_list[$row - 1]["question"] = $content;
                        break;
                    case "D":
                        $content = convert_content_image_id($value);
                        $data_list[$row - 1]["choice_1"] = $content;
                        break;
                    case "E":
                        $content = convert_content_image_id($value);
                        $data_list[$row - 1]["choice_2"] = $content;
                        break;
                    case "F":
                        $content = convert_content_image_id($value);
                        $data_list[$row - 1]["choice_3"] = $content;
                        break;
                    case "G":
                        $content = convert_content_image_id($value);
                        $data_list[$row - 1]["choice_4"] = $content;
                        break;
                    case "H":
                        $content = convert_content_image_id($value);
                        $data_list[$row - 1]["choice_5"] = $content;
                        break;
                    case "I":
                        $data_list[$row - 1]["answer"] = $value;
                        break;
                    case "J":
                        $content = convert_content_image_id($value);
                        $data_list[$row - 1]["explanation"] = $content;
                        break;
                    default:
                        break;
                }

                switch($grade) {
                    case "sma":
                        $data_list[$row - 1]["grade"] = 2;
                        break;
                    case "smp":
                        $data_list[$row - 1]["grade"] = 1;
                        break;
                    default:
                        break;
                }

                // if we import try out questions,
                if ($try_out_id != NULL) {
                    $data_list[$row - 1]["try_out_id"] = $try_out_id;
                    unset($data_list[$row - 1]["section"]);
                }

            }
        }

        // insert batch of questions into storage table $table_name
        $insert_result = $CI->generic_model->create_batch($table_name, $data_list);

        return $insert_result;
    }

    /**
     * Import excel
     *
     * @param string $table_name
     * @param string $grade
     * @return array
     */
    private function import_excel_question($table_name = "", $grade = "sma", $try_out_id = NULL) {

        $CI = $this->CI;

        if ($table_name == "" || $grade == "") {
            return;
        }
		
        $uploaded_file = $this->handle_uploaded_excel();
        $response = array();

        if (!$uploaded_file) {

            $response["status"] = "error";
            $response["notification"] = "Input tidak benar.";
            $response["errors"] = array("excel_file" => "Terdapat error saat upload file.");

            return $response;
        }

        $insert_result = $this->convert_excel_to_question($table_name, $uploaded_file["file_name"], $grade, $try_out_id);

        if ($insert_result) {
            $response["status"] = "success";
            $response["notification"] = "File telah berhasil di import.";
        } else {
            $response["status"] = "error";
            $response["notification"] = "Input tidak benar.";
            $response["errors"] = array("excel_file" => "Terdapat error saat pemrosesan file ke dalam database.");
        }

        $server_url = $CI->config->item("server_url");
        if (file_exists($server_url ."upload/excel/". $uploaded_file["file_name"])) {
			
            unlink($server_url ."upload/excel/". $uploaded_file["file_name"]);
        }


        return $response;

    }


	function __destruct()
	{
		
	}
	
}