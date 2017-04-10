<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * Home of all miscellaneous function belongs to no one.

 * @author badr

 *

 */

class Misc extends CI_Controller {



    public function __construct() {

        parent::__construct();

        $this->load->helper("misc");

    }

	

	/**

 	 * Ajax function for uploading the image.

 	 */

	public function upload_image_ajax() {



//		check_role("contributor");



		// upload configuration.

		

		$upload_path = get_app_config("server_url") . "upload/tmp/";



//		if ($this->input->post("upload_picture_location")) {

//			$upload_path = get_app_config("server_url") .

//				$this->input->post("upload_picture_location") ."/";

//		}

		

		$config["upload_path"] = $upload_path;

		$config["allowed_types"] = "jpg|jpeg|png|gif";

		$config["max_size"] = 10000;

		$config["max_width"] = 200000;

		$config["max_height"] = 200000;

		$config["encrypt_name"] = TRUE;



		$this->load->library("upload", $config);

		// upload the image from input. (image data is in $_FILES)

		if (! $this->upload->do_upload("picture_url")) {



            $response["status"] = "error";

            $response["notification"] = $this->upload->display_errors();



		} else {

			// image data after upload.

			$upload_data = $this->upload->data();



            $response["status"] = "success";

            $response["notification"] = "Image has been uploaded";

		}



        echo json_encode($response);

	}

	

	/**

	 * Ajax function for cropping image, by given coordinate.

	 * Final submit POST is indicating that this crop is the last one.

	 */

	public function crop_image_ajax() {

//		check_role("contributor");
		$image_conf = array();

		// x, y, weight and height of selected area in cropping image.

		$image_conf["x"] = $this->input->post("x");

		$image_conf["y"] = $this->input->post("y");

		$image_conf["w"] = $this->input->post("w");

		$image_conf["h"] = $this->input->post("h");

		// weight and height displayed vs original (for scaling the selected area to original one)

		$image_conf["w_displayed"] = $this->input->post("w_displayed");

		$image_conf["h_displayed"] = $this->input->post("h_displayed");

		$image_conf["w_original"] = $this->input->post("w_original");

		$image_conf["h_original"] = $this->input->post("h_original");

		$image_conf["picture_file_name"] = $this->input->post("picture_file_name");

		$image_conf["image_type"] = $this->input->post("image_type");

        $width_ratio = ($image_conf["w_original"] / $image_conf["w_displayed"]);

        $height_ratio = ($image_conf["h_original"] / $image_conf["h_displayed"]);



        // decide which ratio to choose if both width and height ratio differs

        $min_ratio = min($width_ratio, $height_ratio);





		// re-locate the coordinate according to scale of original and displayed image.

		$image_conf["x"] = $image_conf["x"] * $min_ratio;

		$image_conf["y"] = $image_conf["y"] * $min_ratio;

		$image_conf["w"] = $image_conf["w"] * $min_ratio;

		$image_conf["h"] = $image_conf["h"] * $min_ratio;









		// crop and utilize the image using GD library.



        if ($this->input->post("final_width") == 0 &&

            $this->input->post("final_height") == 0) {



            $target_width = $image_conf["w"];

            $target_height = $image_conf["h"];



        } else {



            $target_width = $this->input->post("final_width");

            $target_height = $this->input->post("final_height");

        }







		// address of image source, and resource of image source and destination.

		$src = get_app_config("server_url") . "assets/img/tmp/" . $image_conf["picture_file_name"];

		

		if ($this->input->post("upload_picture_location")) {

			$src = get_app_config("server_url") . "assets/img/".

					$this->input->post("upload_picture_location") ."/". $image_conf["picture_file_name"];

		}

		



// 		$file_name_parts = explode(".", $image_conf["picture_file_name"]);

// 		$dst_name = $file_name_parts[0] ."_". get_temp_data("product_id_counter") .".". $file_name_parts[1];

		$dst = $src;





		if ($image_conf["image_type"] == "jpeg") {

			$image_source_res = imagecreatefromjpeg($src);

		} else if ($image_conf["image_type"] == "png") {

			$image_source_res = imagecreatefrompng($src);

		} else if ($image_conf["image_type"] == "gif") {

			$image_source_res = imagecreatefromgif($src);

		}



		$image_dest_res = imagecreatetruecolor($target_width, $target_height);



        if ($image_conf["image_type"] == "png") {

            imagealphablending($image_dest_res, FALSE);

            imagesavealpha($image_dest_res, TRUE);

        }



		// resample the image.

		imagecopyresampled($image_dest_res, $image_source_res, 0, 0,

				$image_conf["x"], $image_conf["y"], $target_width,

				$target_height, $image_conf["w"], $image_conf["h"]);



		// write image to file.

		if ($image_conf["image_type"] == "jpeg") {

			imagejpeg($image_dest_res, $dst, 90); // create JPEG with good quality (90)

		} else if ($image_conf["image_type"] == "png") {

			imagepng($image_dest_res, $dst, 0); // create PNG with no compression (0)

		} else if ($image_conf["image_type"] == "gif") {

			imagegif($image_dest_res, $dst);

		}



		// preparing the ajax response after cropping the image.

        $time = time();



		$ajax_response = array(

			"picture_html" => img("tmp/". $image_conf["picture_file_name"] ."?time=". $time,

					array("id" => "cropbox")),

            "picture_link" => img_url(). "tmp/". $image_conf["picture_file_name"] ."?time=". $time,

			"file_name" => $image_conf["picture_file_name"],

			"w_original" => $target_width,

			"h_original" => $target_height,

			"image_type" => $image_conf["image_type"]

		);

		

		if ($this->input->post("upload_picture_location")) {



			$ajax_response["picture_html"] = img($this->input->post("upload_picture_location") ."/". 

					$image_conf["picture_file_name"] ."?time=". $time,

                array("id" => "cropbox"));



            $ajax_response["picture_link"] = img_url(). $this->input->post("upload_picture_location") ."/".

                $image_conf["picture_file_name"] ."?time=". $time;

		}

		

		echo json_encode($ajax_response);

	}













    public function upload_thumbnail($field_name) {

        $config['upload_path'] = './upload/thumbnail/';

        $config['allowed_types'] = 'jpg|png';

        $config['max_size']	= '17000';



        $this->load->library('upload', $config);



        if (!$this->upload->do_upload($field_name))

        {

            $error = array('error' => true, 'error_message' => $this->upload->display_errors());

            echo json_encode($error);

        }

        else

        {

            $data = $this->upload->data();

            $data['error'] = false;

            echo json_encode($data);

        }

    }



    public function upload_crop_thumbnail() {



        $params = array(

			"src" => $_POST['thumbnail_src'],

            "data" => $_POST['thumbnail_data'],

			"file" => $_FILES['thumbnail_file']

        );

        $this->load->library("CropAvatar", $params);



        $response = array(

            'state'  => 200,

            'filename' => $this->cropavatar->getFileName(),

            'message' => $this->cropavatar->getMsg(),

            'result' => $this->cropavatar->getResult()

        );



        $this->output->set_content_type("application/json");

        $this->output->set_status_header($response["state"]);

        $this->output->set_output(json_encode($response));

    }

}

