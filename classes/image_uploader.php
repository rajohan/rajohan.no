<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    //if(!defined('INCLUDE')) {

      //  die('Direct access is not permitted.');
        
    //}

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
        
        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->uploadDir = '../uploads/img/';
            $this->watermarkImageWhite = '../img/watermark_white.png';
            $this->watermarkImageBlack = '../img/watermark_black.png';
            $this->fileExtensions = ['jpeg' , 'jpg' , 'png', 'gif'];
            $this->fileTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $this->maxFileSize = (1024 * 1024) * 3; // 3MB

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
        // Method to upload image
        //-------------------------------------------------

        function upload($watermarkEnabled = true, $watermarkColor = "white") {

            if($_FILES['files']['error'][1] < 1) {

                // Set variables needed
                $this->fileInfo = pathinfo($_FILES['files']['name'][1]);
                $this->filename = $this->fileInfo['filename'];
                $this->fileTmpName  = $_FILES['files']['tmp_name'][1];
                $this->fileType = strtolower(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $this->fileTmpName));
                $this->fileSize = $_FILES['files']['size'][1];
                $this->imageSize = getimagesize($this->fileTmpName);
                $this->watermarkEnabled = $watermarkEnabled;
                $this->watermarkColor = $watermarkColor;
                $errors = []; // Create errors array

                // Make sure file extension exists
                if(!empty($this->fileInfo['extension'])) {

                    $this->fileExtension = strtolower($this->fileInfo['extension']);

                }

                // Validate file extension
                if (!in_array($this->fileExtension,$this->fileExtensions)) {

                    $errors[] = "This file extension is not allowed. Please upload a JPEG, JPG, GIF or PNG file.";

                }

                // Validate file type
                if(!in_array($this->fileType, $this->fileTypes)) {

                    $errors[] = "This file type is not allowed. Please upload a JPEG, JPG, GIF or PNG file.";

                }

                // Validate that file is a image
                if(!$this->imageSize) {

                    $errors[] = "Only images can be uploaded.";

                }

                // Validate file size
                if ($this->fileSize > $this->maxFileSize) {

                    $errors[] = "This file is more than "+($this->maxFileSize / 1024)+"MB. Sorry, it has to be less than or equal to "+($this->maxFileSize / 1024)+"MB.";

                }

                // File validated without errors
                if (empty($errors)) {
                    
                    // Confirm we are working on the uploaded file
                    if(is_uploaded_file($this->fileTmpName)) {

                        $upload = $this->imageCreate(); // Create a new image from uploaded file

                        // Imaged created successfully
                        if($upload) {

                            echo json_encode(["status" => "success", "output" => "Image uploaded!<img src='/uploads/img/".basename($this->newFilename).".".$this->fileExtension."'><a href='/uploads/img/".basename($this->newFilename).".".$this->fileExtension."'>Link to your image</a>"]);

                        } else { // Error while creating a new image from uploaded file

                            echo json_encode(["status" => "error", "errors" => "Sorry, an error has occurred while creating the image. Please try again."]);

                        }

                    } else { // Working on wrong file?

                        echo json_encode(["status" => "error", "errors" => "Sorry, an error has occurred. Please try again."]);
                    }

                } else { // File failed validation

                    echo json_encode(["status" => "error", "errors" => $errors]);

                }


            } else { // Error with the submit/ajax request. Usually means file size is > max allowed file size in php.ini

                echo json_encode(["status" => "error", "errors" => "Sorry, an error has occurred while uploading your image. Please make sure the image is less than or equal to "+($this->maxFileSize / 1024)+"MB and try again."]);

            }

        }

    }

?>

<?php 

    if(!empty($_FILES['files'])) {

        $upload = new Image_uploader;
        $upload->upload(true, "black");

    }

?>