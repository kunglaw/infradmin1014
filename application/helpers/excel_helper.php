<?php  if ( ! defined('BASEPATH')) exit('No direct script datatables allowed');

/**
 * Helper to assist in excel operation.
 *
 * @author      pulung
 * @copyright 	2015 PT. Badr Interactive
 * @link		http://badr.co.id
 */

if (!function_exists('handle_uploaded_excel')) {
    /**
     * Handle uploaded excel file, place them into /upload/excel.
     * @return array|null
     */
    function handle_uploaded_excel() {

        $CI =& get_instance();
        $directory      = "vessel";
        $upload_path    = $CI->config->item("server_url") . "upload/". $directory ."/";

        $config["upload_path"]  = $upload_path;
        $config["allowed_types"] = "xls|xlsx";
        $config["max_size"] = 10000;
        $config["max_width"] = 200000;
        $config["max_height"] = 200000;
        $config["encrypt_name"] = TRUE;

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
}

if (!function_exists('convert_formatted_cell')) {
    /**
     * Handle uploaded excel file, place them into /upload/excel.
     * @return array|null
     */
    function convert_formatted_cell($value) {

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
}

if (!function_exists('convert_excel_to_question')) {
    /**
     * Convert excel data into question object
     * @return array|null
     */
    function convert_excel_to_question($table_name = "", $filename = "",
                                       $grade = "", $try_out_id = NULL) {

        $CI =& get_instance();

        // immediately return if there is no table target for question storage.
        if ($table_name == "" || $filename == "" || $grade == "") {
            return;
        }

        $CI->load->library("PHPExcel");

        // load excel file
        $server_url = $CI->config->item("server_url");
        $excel_file = PHPExcel_IOFactory::load($server_url ."upload/excel/". $filename);

        $cell_collection = $excel_file->getActiveSheet()->getCellCollection();

        $data_list = array();

        // convert excel data to respective column in db.
        foreach ($cell_collection as $cell) {
            $column = $excel_file->getActiveSheet()->getCell($cell)->getColumn();
            $row = $excel_file->getActiveSheet()->getCell($cell)->getRow();
            $value = $excel_file->getActiveSheet()->getCell($cell)->getValue();

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
}

if (! function_exists("import_excel_question")) {
    /**
     * Import excel
     *
     * @param string $table_name
     * @param string $grade
     * @return array
     */
    function import_excel_question($table_name = "", $grade = "sma", $try_out_id = NULL) {

        $CI =& get_instance();

        if ($table_name == "" || $grade == "") {
            return;
        }

        // upload excel
        $CI->load->helper("excel");
        $uploaded_file = handle_uploaded_excel();
        $response = array();

        if (!$uploaded_file) {

            $response["status"] = "error";
            $response["notification"] = "Input tidak benar.";
            $response["errors"] = array("excel_file" => "Terdapat error saat upload file.");

            return $response;
        }

        $insert_result = convert_excel_to_question($table_name, $uploaded_file["file_name"], $grade, $try_out_id);

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
}

if (!function_exists('convert_excel_to_vessel')) {
    /**
     * Convert excel data into tips object
     * @return array|null
     */
    function convert_excel_to_vessel($filename = "") {

        $CI =& get_instance();
        $table_name = "ship";

        // immediately return if there is no table target for question storage.
        if ($filename == "") {
            return NULL;
        }

        $CI->load->library("PHPExcel");
        $CI->load->helper("excel");

        // load excel file
        $server_url = $CI->config->item("server_url");
        $excel_file = PHPExcel_IOFactory::load($server_url ."upload/vessel/". $filename);

        $cell_collection = $excel_file->getActiveSheet()->getCellCollection();

        $data_list = array();
        $broken_cell = false;

        // convert excel data to respective column in db.
        foreach ($cell_collection as $cell) {

            $current_cell = $excel_file->getActiveSheet()->getCell($cell);
            $column = $current_cell->getColumn();
            $row = $current_cell->getRow();
            $value = $current_cell->getValue();

            if ($row == 1) {
                continue;

            } else {

                // convert cell value with formatting first.
                $value = convert_formatted_cell($value);
                $value = trim($value);

                switch ($column) {
                    case "A":
                        if (empty($value)) {
                            $broken_cell = true;
                        } else {
                            $new_ship["ship_name"] = $value;
                        }

                        break;
                    case "B":

                        $ship_type = $CI->generic->retrieve_one(
                            "ship_type", array("type_id" => (int) $value));

                        if (empty($ship_type)) {
                            log_message("error", "Ship type doesn't match: ". $value);
                            $broken_cell = true;
                        } else {
                            $new_ship["id_ship_type"] = $value;
                        }

                        break;
                    case "C":

                        $company = $CI->generic->retrieve_one(
                            "perusahaan", array("id_perusahaan" => (int) $value));

                        if (empty($company)) {
                            log_message("error", "Company doesn't match: ". $value);
                            $broken_cell = true;
                        } else {
                            $new_ship["id_perusahaan"] = $value;
                        }

                        break;
                    case "D":
                        if (empty($value)) {
                            $new_ship["description"] = "";
                        } else {
                            $new_ship["description"] = $value;
                        }

                        break;
                    case "E":
                        if (empty($value)) {
                            $new_ship["author"] = "";
                        } else {
                            $new_ship["author"] = $value;
                        }

                        break;
                    case "F":
                        if (empty($value)) {
                            $new_ship["imo"] = "";
                        } else {
                            $new_ship["imo"] = $value;
                        }
                        break;
                    case "G":

                        if (empty($value)) {
                            $new_ship["image_ship"] = "";
                        } else {
                            $new_ship["image_ship"] = $value;
                        }
                        break;
                    case "H":

                        if (empty($value)) {
                            $new_ship["weight"] = "";
                        } else {
                            $new_ship["weight"] = $value;
                        }
                        break;
                    case "I":

                        if (empty($value)) {
                            $new_ship["engine"] = "";
                        } else {
                            $new_ship["engine"] = $value;
                        }
                        break;
                    case "J":

                        $nationality = $CI->generic->retrieve_one(
                            "nationality", array("id" => (int) $value));

                        if (empty($nationality)) {
                            log_message("error", "Nationality doesn't match: ". $value);
                            $broken_cell = true;
                        } else {
                            $new_ship["flag"] = $value;
                        }

                        break;
                    case "K":

                        if (empty($value)) {
                            $new_ship["built"] = "";
                        } else {
                            $new_ship["built"] = $value;
                        }

                        break;
                    case "L":

                        if (empty($value)) {
                            $new_ship["owner"] = "";
                        } else {
                            $new_ship["owner"] = $value;
                        }

                        break;
                    case "M":
                        $new_ship["satuan"] = $value;
                        $new_ship["number_of_views"] = 0;
                        $new_ship["image_ship"] = "";

                        $data_list[] = $new_ship; // end of row, insert one data.
                        $new_ship = array(); // reset new ship
                        break;
                    default:
                        break;
                }
            }

            if ($broken_cell) {
                break;
            }

        }

        $insert_result = NULL;
        if (! $broken_cell) {
            // insert batch of vessel into storage table $table_name
            $insert_result = $CI->generic_model->create_batch($table_name, $data_list);
        }

        return $insert_result;
    }
}

if (! function_exists("import_excel_vessel")) {
    /**
     * Import excel
     *
     * @param string $table_name
     * @param string $grade
     * @return array
     */
    function import_excel_vessel() {

        $CI =& get_instance();

        // upload excel
        $CI->load->helper("excel");
        $uploaded_file = handle_uploaded_excel("vessel");
        $response = array();

        if (! $uploaded_file) {

            $response["status"] = "error";
            $response["notification"] = "Input tidak benar.";
            $response["errors"] = array("excel_file" => "Terdapat error saat upload file.");

            return $response;
        }

        $insert_result = convert_excel_to_vessel($uploaded_file["file_name"]);

        if (! empty($insert_result)) {
            $response["status"] = "success";
            $response["notification"] = "File telah berhasil di import.";

        } else {
            $response["status"] = "error";
            $response["notification"] = "Input tidak benar.";
            $response["errors"] = array("excel_file" => "Terdapat error saat upload file.");

        }

        $server_url = $CI->config->item("server_url");
        $excel_filename = $server_url ."upload/vessel/". $uploaded_file["file_name"];

        if (file_exists($excel_filename)) {
            unlink($excel_filename);
        }

        return $response;

    }
}

if (! function_exists("write_base64_to_file")) {
    /**
     * @return array
     */
    function write_base64_to_file($base64_string) {

        $CI =& get_instance();

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
}

if (! function_exists("convert_content_image_id")) {
    /**
     * @return array
     */
    function convert_content_image_id($content) {

        $CI =& get_instance();

        $pattern = '/##(\d+)!!/i';

        $result = preg_replace_callback(
            $pattern,
            "convert_content_gallery_id_to_base64",
            $content
        );

        return $result;
    }
}

if (! function_exists("convert_content_gallery_id_to_base64")) {
    /**
     * @return array
     */
    function convert_content_gallery_id_to_base64($matches = array()) {

        $CI =& get_instance();

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
}


/* End of file excel_helper.php */