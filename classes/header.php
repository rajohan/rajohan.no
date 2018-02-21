<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Header image/title handler
    //-------------------------------------------------
    
    class Header {

        private $db_conn;
        private $filter;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->db_conn = new Database;
            $this->filter = new Filter;
            
        }

        //-------------------------------------------------
        // Method to get header content
        //-------------------------------------------------

        function get_header_content() {

            $stmt = $this->db_conn->connect->prepare("SELECT `IMAGE`, `TITLE`, `SUB_TITLE`, `BUTTON_TEXT`, `LINK` FROM `HEADER` ORDER BY `ID` DESC"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result
            $header = []; // Crate array to put database rows in

            while ($row = $result->fetch_assoc()) {
                
                array_push($header, $this->filter->sanitize_array($row)); // Push rows to array
        
            }

            $this->db_conn->free_close($result, $stmt); // Free result and close database connection

            echo json_encode($header); // Output the result

        }
        
    }
 
?>