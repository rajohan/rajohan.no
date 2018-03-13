<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Image uploader
    //-------------------------------------------------

    class Image_uploader {

        private $uploadDir;
        private $watermarkImageWhite;
        private $watermarkImageBlack;
        private $fileExtensions;
        private $fileTypes;
        private $maxFileSize;
        private $errors;
        private $success;
        private $ip;
        private $user;

        private $fileInfo;
        private $filename;
        private $fileExtension;
        private $fileTmpName;
        private $fileType;
        private $fileSize;
        private $imageSize;
        private $watermarkEnabled;
        private $watermarkColor;
        private $newFilename;
        private $limitFiles;
        
        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->uploadDir = '../../uploads/img/';
            $this->watermarkImageWhite = '../img/watermark_white.png';
            $this->watermarkImageBlack = '../img/watermark_black.png';
            $this->fileExtensions = ['jpeg' , 'jpg' , 'png', 'gif'];
            $this->fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $this->maxFileSize = 3; // In MB
            $this->errors = []; // Create errors array
            $this->success = []; // Create success array
            $this->user = 1;
            $this->ip = $_SERVER['REMOTE_ADDR'];

        }

        //-------------------------------------------------
        // Method to generate a placeholder file to ensure unique file names
        //-------------------------------------------------

        private function placeholder() {

            $filename = tempnam($this->uploadDir, 'image'); // Create a new file
            unlink($filename); // Delete file, we now have the unique file name

            return $filename;

        }

        //-------------------------------------------------
        // Method to generate a watermark to place on uploaded images
        //-------------------------------------------------

        private function watermark($img) {

            // creating png image of watermark
            if($this->watermarkColor === "white") {

                $watermark = imagecreatefrompng($this->watermarkImageWhite); 

            } else {

                $watermark = imagecreatefrompng($this->watermarkImageBlack); 

            }

            // getting dimensions of watermark image
            $watermarkWidth = imagesx($watermark);  
            $watermarkHeight = imagesy($watermark);
            
            // placing the watermark 10px from bottom and right
            $destX = $this->imageSize[0] - $watermarkWidth - 10;  
            $destY = $this->imageSize[1] - $watermarkHeight - 10;

            // creating a cut resource
            $cut = imagecreatetruecolor($watermarkWidth, $watermarkHeight);

            // set background transparent
            imagefill($cut,0,0,0x7fff0000);

            // copying that section of the background to the cut
            imagecopy($cut, $img, 0, 0, $destX, $destY, $watermarkWidth, $watermarkHeight);

            // placing the watermark now
            imagecopy($cut, $watermark, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight);

            // merging both of the images
            imagecopy($img, $cut, $destX, $destY, 0, 0, $watermarkWidth, $watermarkHeight);

            // free memory
            imagedestroy($watermark);

        }

        //-------------------------------------------------
        // Method to generate a new image to replace uploaded image
        //-------------------------------------------------

        private function imageCreate() { 

            // JPEG/JPG image
            if(($this->fileType === "image/jpeg") || ($this->fileType === "image/jpg")) {

                // Create a new file for a unique file name
                $this->newFilename = $this->placeholder();

                // Create image from uploaded file
                $img = imageCreateFromJpeg($this->fileTmpName);
                
                // Add watermark
                if($this->watermarkEnabled === true) {

                    $this->watermark($img);

                }
                
                // Save the new image 
                $newFile = imageJpeg($img, $this->newFilename.".".$this->fileExtension);

            }

            // PNG image
            else if($this->fileType === "image/png") {

                // Create a new file for a unique file name
                $this->newFilename = $this->placeholder();

                // Create image from uploaded file
                $img = imageCreateFromPng($this->fileTmpName);

                // Keep transparency
                imageAlphaBlending($img, true);
                imageSaveAlpha($img, true);

                // Add watermark
                if($this->watermarkEnabled === true) {

                    $this->watermark($img);

                }

                // Save the new image 
                $newFile = imagePng($img, $this->newFilename.".".$this->fileExtension);

            }

            // GIF image
            else if ($this->fileType === "image/gif") {

                $this->newFilename = $this->placeholder();
                $img = imageCreateFromGif($this->fileTmpName);

                // Keep transparency
                imageAlphaBlending($img, true);
                imageSaveAlpha($img, true);

                // Add watermark
                if($this->watermarkEnabled === true) {

                    $this->watermark($img);

                }

                // Convert gif to png. For transparent background on watermark
                $this->fileExtension = "png";

                // Save the new image 
                $newFile = imagePng($img, $this->newFilename.".".$this->fileExtension); 
                

            } else {

                return false;

            }

            // free memory
            imagedestroy($img);

            return $newFile;

        } 

        //-------------------------------------------------
        // Method to get database id for uploaded image
        //-------------------------------------------------

        private function getImageId() {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT ID FROM `IMAGES` WHERE `USER` = ? ORDER BY ID DESC LIMIT 1");
            $stmt->bind_param("i", $this->user);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
        
                $imageId = $row['ID'];
        
            }
        
            return $imageId;

        }

        //-------------------------------------------------
        // Method to initialize the upload
        //-------------------------------------------------

        function init($files, $limitFiles = false, $watermarkEnabled = true, $watermarkColor = "white") {

            // Remove elements with errors from $_FILES array (file missing, empty name etc)
            foreach($files as $key => $value) {

                // Loop inner arrays (name, type, tmp_name, error, size)
                foreach($value as $k => $v) {

                    // Check for errors
                    if($key === "error" && $v !== 0) {
                        
                        // Remove element key's with error from every inner array
                        foreach($files as $key2 => $value2) {

                            unset($files[$key2][$k]);

                        }

                    }
    
                } 

            }

            // Reorder array
            foreach ($files as $key => $value) {

                $files[$key] = array_values($files[$key]);
                
            }

            // No limit to how many images can be uploaded simantanously
            if($limitFiles === false) {

                $this->limitFiles = count($files['name']);

            } else { // Limit is set

                $this->limitFiles = $limitFiles;

            }

            // Loop through every file and upload until last file or max file number is reached
            for($i = 0; $i < $this->limitFiles; $i++) {

                // Set variables needed
                $this->fileInfo = pathinfo($files['name'][$i]);
                $this->filename = $this->fileInfo['filename'];
                $this->fileTmpName  = $files['tmp_name'][$i];
                $this->fileType = strtolower(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $this->fileTmpName));
                $this->fileSize = $files['size'][$i];
                $this->imageSize = getimagesize($this->fileTmpName);
                $this->watermarkEnabled = $watermarkEnabled;
                $this->watermarkColor = $watermarkColor;

                $this->upload($files, $i);

            }

            // Output errors
            if(!empty($this->errors)) {

                echo json_encode(["status" => "error", "errors" => $this->errors]);

            }

            // Output successfully uploaded images
            if(!empty($this->success)) {

                echo json_encode(["status" => "success", "output" => $this->success]);

            }

        }

        //-------------------------------------------------
        // Method to upload image
        //-------------------------------------------------

        private function upload($files , $i) {

            if($files['error'][$i] < 1) {

                // Make sure file extension exists
                if(!empty($this->fileInfo['extension'])) {

                    $this->fileExtension = strtolower($this->fileInfo['extension']);

                }

                // Validate file extension
                if (!in_array($this->fileExtension,$this->fileExtensions)) {

                    $this->errors[] = "This file extension is not allowed. Please upload a JPEG, JPG, GIF or PNG file.";

                }

                // Validate file type
                if(!in_array($this->fileType, $this->fileTypes)) {

                    $this->errors[] = "This file type is not allowed. Please upload a JPEG, JPG, GIF or PNG file.";

                }

                // Validate that file is a image
                if(!$this->imageSize) {

                    $this->errors[] = "Only images can be uploaded.";

                }

                // Validate file size
                if ($this->fileSize > ((1024 * 1024) * $this->maxFileSize)) {

                    $this->errors[] = "This file is more than ".$this->maxFileSize."MB. Sorry, it has to be less than or equal to ".$this->maxFileSize."MB.";

                }

                // File validated without errors
                if (empty($this->errors)) {
                    
                    // Confirm we are working on the uploaded file
                    if(is_uploaded_file($this->fileTmpName)) {

                        $upload = $this->imageCreate(); // Create a new image from uploaded file

                        if($upload) { // Imaged created successfully

                            // Insert image data to database
                            $db_conn = new Database;
                            $db_conn->db_insert('IMAGES', 'FILENAME, FILE_TYPE, USER, IP', 'ssis', array(basename($this->newFilename).".".$this->fileExtension, $this->fileType, $this->user, $this->ip));

                            $imageId = $this->getImageId();

                            $this->success[] = "Image uploaded!<img src='image/".$imageId."'><a href='image/".$imageId."'>Link to your image</a>";

                        } else { // Error while creating a new image from uploaded file

                            $this->errors[] = "Sorry, an error has occurred while creating the image. Please try again.";
                        
                        }

                    } else { // Working on wrong file?

                        $this->errors[] = "Sorry, an error has occurred. Please try again.";
                    }

                }

            } else { // Error with the submit/ajax request. Usually means file size is > max allowed file size in php.ini
                
                $this->errors[] = "Sorry, an error has occurred while uploading your image. Please make sure the image is less than or equal to ".$this->maxFileSize."MB and try again.";

            }

        }

    }

?>