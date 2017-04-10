<?php
    class CropAvatar {
        private $src;
        private $filename;
        private $data;
        private $file;
        private $type;
        private $extension;
        private $srcDir;
        private $msg;
        private $state;

        private $widthRatio;
        private $heightRatio;

        function __construct($params) {

            $this->state = 200;
            $this->widthRatio = $params[4];
            $this->heightRatio = $params[5];
        	$this -> srcDir = $params[3];
        	$this -> setSrc($params[0]);
            $this -> setData($params[1]);
            $this -> setFile($params[2]);
            $this -> crop($this -> src, $this -> data, $this->widthRatio, $this->heightRatio);
        }

        private function setSrc($src) {
            if (!empty($src)) {
                $type = exif_imagetype($src);

                if ($type) {
                    $this -> src = $src;
                    $this -> type = $type;
                    $this -> extension = image_type_to_extension($type);
                }
            }
        }

        private function setData($data) {
            if (!empty($data)) {
                $this -> data = json_decode(stripslashes($data));
            }
        }

        private function setFile($file) {
            $errorCode = $file['error'];

            if ($errorCode === UPLOAD_ERR_OK) {
                $type = exif_imagetype($file['tmp_name']);

                if ($type) {
                    $dir = $this -> srcDir;

                    if (!file_exists($dir)) {
                    	mkdir($dir, 0777);
                    }

                    $extension = image_type_to_extension($type);
                    $this -> filename = date('YmdHis') . $extension;
                    $src = $dir . '/' . $this -> filename;

                    if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {

                        if (file_exists($src)) {
                            unlink($src);
                        }

                        $result = move_uploaded_file($file['tmp_name'], $src);

                        if ($result) {
                            $this -> src = $src;
                            $this -> type = $type;
                            $this -> extension = $extension;
                        } else {
                             $this -> msg = 'Failed to save file';
                            $this->state = 400;
                        }
                    } else {
                        $this -> msg = 'Please upload image with the following types: JPG, PNG, GIF';
                        $this->state = 400;
                    }
                } else {
                    $this -> msg = 'Please upload image file';
                    $this->state = 400;
                }
            } else {
                $this -> msg = $this -> codeToMessage($errorCode);
                $this->state = 400;
            }
        }

        private function crop($src, $data, $target_width, $target_height) {

            if (!empty($src) && !empty($data)) {
                switch ($this -> type) {
                    case IMAGETYPE_GIF:
                        $src_img = imagecreatefromgif($src);
                        break;

                    case IMAGETYPE_JPEG:
                        $src_img = imagecreatefromjpeg($src);
                        break;

                    case IMAGETYPE_PNG:
                        $src_img = imagecreatefrompng($src);
                        break;
                }

                if (!$src_img) {
                    $this -> msg = "Failed to read the image file";
                    $this->state = 400;
                    return;
                }

                // make target width and height aligned with cropped image size,
                // because it has been cropped to a certain ratio by JS cropper.
                $target_width = $data->width;
                $target_height = $data->height;


                $dst_img = imagecreatetruecolor($target_width, $target_height);
                $result = imagecopyresampled($dst_img, $src_img, 0, 0, $data -> x, $data -> y,
                    $target_width, $target_height, $data->width, $data->height);
                
                if ($result) {
                	switch ($this -> type) {
                		case IMAGETYPE_GIF:
                			$result = imagegif($dst_img, $src);
                			break;
                
                		case IMAGETYPE_JPEG:
                			$result = imagejpeg($dst_img, $src);
                			break;
                
                		case IMAGETYPE_PNG:
                			$result = imagepng($dst_img, $src);
                			break;
                	}
                
                	if (!$result) {
                		$this -> msg = "Failed to save the cropped image file";
                        $this->state = 400;
                	}
                } else {
                	$this -> msg = "Failed to crop the image file";
                    $this->state = 400;
                }
                
                imagedestroy($src_img);
                imagedestroy($dst_img);
            }
        }

        private function codeToMessage($code) {
            switch ($code) {
                case UPLOAD_ERR_INI_SIZE:
                    $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                    break;

                case UPLOAD_ERR_FORM_SIZE:
                    $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                    break;

                case UPLOAD_ERR_PARTIAL:
                    $message = 'The uploaded file was only partially uploaded';
                    break;

                case UPLOAD_ERR_NO_FILE:
                    $message = 'No file was uploaded';
                    break;

                case UPLOAD_ERR_NO_TMP_DIR:
                    $message = 'Missing a temporary folder';
                    break;

                case UPLOAD_ERR_CANT_WRITE:
                    $message = 'Failed to write file to disk';
                    break;

                case UPLOAD_ERR_EXTENSION:
                    $message = 'File upload stopped by extension';
                    break;

                default:
                    $message = 'Unknown upload error';
            }

            return $message;
        }

        public function getResult() {
            return $this -> src;
        }
        
        public function getFileName() {
        	return $this -> filename;
        }

        public function getMsg() {
            return $this -> msg;
        }

        public function getState() {
            return $this->state;
        }
    }

?>
