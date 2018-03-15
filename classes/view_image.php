<?php
 
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    //-------------------------------------------------
    // View image
    //-------------------------------------------------

    class View_image {
        
        private $url;
        private $filter;
        private $id;
        private $image;
        private $uploadDir;
        private $errorImage;
        private $errorImageType;

        //-----------------------------------------------
        // Construct
        //-----------------------------------------------

        function __construct() {    

            $this->filter = new Filter;
            $this->url = $this->filter->sanitize(strtolower($_SERVER['REQUEST_URI']));
            $this->uploadDir = '../uploads/img/';
            $this->errorImage = "img/logo_3d.svg";
            $this->errorImageType = "image/svg+xml";
    
        }

        //-------------------------------------------------
        // Method to validate image id
        //-------------------------------------------------

        private function validate_id() {

            $params = rtrim($this->url, " /"); // Remove trailing '/'
            $params = preg_split("/\//", $params); // Split url at each '/' 
            $last_param = $params[count($params)-1]; // Select the last parameter

            $this->id = $last_param;

            // Only numbers are valid id's
            return preg_match("/^[0-9]{1,}$/", $this->id);

        }

        //-------------------------------------------------
        // Method to get requested image
        //-------------------------------------------------

        function get_image() {
        
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `IMAGES` WHERE `ID` = ?");
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
        
                $filename = $this->filter->sanitize($row['FILENAME']);
                $fileType = $this->filter->sanitize($row['FILE_TYPE']);
        
            }
        
            $db_conn->free_close($result, $stmt);

            // If image dont exist in the database
            if((!isset($filename) || !isset($fileType))) {

                $this->image = ["filename" => $this->errorImage, "fileType" => $this->errorImageType];

            } else { // Image found

                $this->image = ["filename" => $this->uploadDir.$filename, "fileType" => $fileType];
            
            }
        
        }
            
        //-------------------------------------------------
        // Method initialize the image request
        //-------------------------------------------------

        function init() {

            // Validate the image id
            if(!$this->validate_id()) {

                $this->image = ["filename" => $this->errorImage, "fileType" => $this->errorImageType];

            } else { // Get the requested image

                $this->get_image();

            }

            header("Content-Type: ".$this->image['fileType']);
            readfile($this->image['filename']);
            exit;

        }

    }

?>