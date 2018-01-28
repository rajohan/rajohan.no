<?php

    // Check for ajax calls
    if(!empty($_POST['get_headers']) && $_POST['get_headers'] === "true") {

        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed 
        require_once('../configs/db.php'); // Get database username, password etc
        include_once('database_handler.php'); // Database handler
        include_once('filter.php'); // Filter

        $header = new Header; // Crate new header
        $header->get_header_content(); // Get the headers from the database

    } else { // Else check that the file is included and not accessed directly

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }
        
    }

    class Header {

        private $db_conn;
        private $filter;

        function __construct() {

            $this->db_conn = new Database(); // connect to database
            $this->filter = new Filter(); // Start filter
            
        }

        function get_header_content() {

            $stmt = $this->db_conn->connect->prepare("SELECT IMAGE, TITLE, SUB_TITLE, BUTTON_TEXT, LINK FROM `HEADER` ORDER BY `ID` DESC"); // prepare statement
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