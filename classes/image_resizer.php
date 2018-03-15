<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Image resizer
    //-------------------------------------------------
    
    class Image_resizer {

        private $uploadDir;
        private $errors;
        private $success;
        private $user;
        private $ip;
        private $filter;

        private $width;
        private $height;
        private $newWidth;
        private $newHeight;
        private $srcTop;
        private $srcLeft;
        private $dstLeft;
        private $dstTop;
        private $originalWidth;
        private $originalHeight;
        private $image;
        private $newImage;
        private $filename;
        private $imageId;
        private $crop;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->uploadDir = '../../uploads/img/';
            $this->errors = []; // Create errors array
            $this->success = []; // Create success array
            $this->user = 1;
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->filter = new Filter;

        }

        //-------------------------------------------------
        // Create image
        //-------------------------------------------------

        private function imageCreate() {

            // JPEG/JPG image
            if(($this->fileType === "image/jpeg") || ($this->fileType === "image/jpg")) {

                // Create image
                $this->image = imagecreatefromJpeg($this->uploadDir.$this->filename);

            }

            // PNG image
            else if(($this->fileType === "image/png") || ($this->fileType === "image/gif")) {

                // Create image
                $this->image = imagecreatefromPng($this->uploadDir.$this->filename);

            } else {

                $this->errors[] = "This file extension is not allowed. Only JPEG, JPG, GIF or PNG are allowed.";

            }

        }

        //-------------------------------------------------
        // Save image
        //-------------------------------------------------

        private function saveImage() {
            
            // JPEG/JPG image
            if(($this->fileType === "image/jpeg") || ($this->fileType === "image/jpg")) {

                // Save image
                imageJpeg($this->newImage, $this->uploadDir.$this->filename);

            }
            
            // PNG image
            else if(($this->fileType === "image/png") || ($this->fileType === "image/gif")) {

                // Save image
                imagePng($this->newImage, $this->uploadDir.$this->filename);

            } else {

                $this->errors[] = "This file extension is not allowed. Only JPEG, JPG, GIF or PNG are allowed.";

            }
            
        }

        //-------------------------------------------------
        // Resize image
        //-------------------------------------------------

        private function resize() {

            // Create a empty image
            $this->newImage = imagecreatetruecolor($this->width, $this->height);
            
            // Set background transparent
            imagefill($this->newImage,0,0,0x7fff0000);
            
            // Create image
            $this->imageCreate();

            if(empty($this->errors)) { 

                // Create new image
                imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $this->width, $this->height, $this->originalWidth, $this->originalHeight);

                // Keep transparency
                imageAlphaBlending($this->newImage, true);
                imageSaveAlpha($this->newImage, true);

                // Save image
                $this->saveImage();

            }
        
        }

        //-------------------------------------------------
        // Crop image
        //-------------------------------------------------

        private function crop() { 

            // Create a empty image
            $this->newImage = imagecreatetruecolor($this->newWidth, $this->newHeight);
            
            // Set background transparent
            imagefill($this->newImage,0,0,0x7fff0000);
            
            // Create image
            $this->imageCreate();

            if(empty($this->errors)) { 

                // Create new image
                imagecopyresampled($this->newImage, $this->image, $this->dstLeft, $this->dstTop, $this->srcLeft, $this->srcTop, $this->newWidth, $this->newHeight, $this->newWidth, $this->newHeight);

                // Keep transparency
                imageAlphaBlending($this->newImage, true);
                imageSaveAlpha($this->newImage, true);

                // Save image
                $this->saveImage();

            }

        }

        //-------------------------------------------------
        // Get image filename and filetype from image id
        //-------------------------------------------------

        private function getImage() {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `IMAGES` WHERE `ID` = ?");
            $stmt->bind_param("i", $this->imageId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
        
                $this->filename = $this->filter->sanitize($row['FILENAME']);
                $this->fileType = $this->filter->sanitize($row['FILE_TYPE']);
        
            }
        
            $db_conn->free_close($result, $stmt);

            if((empty($this->filename)) || (empty($this->fileType))) {

                $this->errors[] = "The image does not exist or you dont have permission to edit it.";

            }

        }

        //-------------------------------------------------
        // Get image width/height
        //-------------------------------------------------

        private function getImageSize() {

            if($size = getimagesize($this->uploadDir.$this->filename)) {

                $this->originalWidth = $size[0];
                $this->originalHeight = $size[1];

            } else {
                
                $this->errors[] = "Could not get width/height of the image. Image might be corrupt.";
                
            }

        }

        //-------------------------------------------------
        // Method to initialize the resize/crop
        //-------------------------------------------------

        function init($details) {
            
            $this->imageId = $details['imageId'];
            $this->width = $details['imageWidth'];
            $this->height = $details['imageHeight'];

            // Toggle crop on/off
            if(isset($details['crop'])) {

                $this->crop = true;

            }

            // Get image
            $this->getImage();

            // If image is found
            if(empty($this->errors)) {
                
                $this->getImageSize();

                // Successfully got width/hight
                if(empty($this->errors)) {

                    $this->resize();

                    // Successfully resized image
                    if(empty($this->errors)) { 

                        // If crop is applied
                        if((isset($this->crop)) && ($this->crop === true)) {

                            $this->newWidth = $details['cropWidth'];
                            $this->newHeight = $details['cropHeight'];
                            $this->srcTop = $details['cropOffsetTop'];
                            $this->srcLeft = $details['cropOffsetLeft'];
                            $this->dstLeft = 0;
                            $this->dstTop = 0;

                            $this->crop();

                        }

                    }

                    // Successfully resized/cropped image
                    if(empty($this->errors)) {
                        $this->success[] = "Image edited!<img src='image/".$this->imageId."'><a href='image/".$this->imageId."'>Link to your image</a>";
                    }

                }
            
            }

            // Output errors
            if(!empty($this->errors)) {

                echo json_encode(["status" => "error", "errors" => $this->errors]);

            }

            // Output successfully edited image
            if(!empty($this->success)) {

                echo json_encode(["status" => "success", "output" => $this->success]);

            }

        }

    }

?>