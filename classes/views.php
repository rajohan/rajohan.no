<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    // Class for views
    class Views {

        private $ip; // User ip

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR']; // User ip

        }

        // Method to check for earlier views on item from the same user
        private function check_views($table, $id_col_name, $item_id, $user) {
            
            $db_conn = new Database(); // connect to database
            $sort = 'WHERE '.$id_col_name.' = "'.$item_id.'" AND (VIEW_BY_IP = "'.$this->ip.'" OR VIEW_BY_USER = "'.$user.'")'; // What to search for
            $count = $db_conn->count($table, $sort); // Count row's in db
            return $count;

        }

        // Method to add a new view
        private function add_view($table, $id_col_name, $blog_id, $user) {

            $db_conn = new Database(); // connect to database
            $db_conn->db_insert($table, ''.$id_col_name.', VIEW_BY_USER, VIEW_BY_IP', 'iis', array($blog_id, $user, $this->ip)); // Add view to db

        }

        // Method to add blog views
        function add_blog_view() {
        
            $user = 3423;
            $blog_id = 1;

            $count = $this->check_views("BLOG_VIEWS", "BLOG_ID", $blog_id, $user); // Check for old view on item by user

            if($count <= 0) {

                $this->add_view("BLOG_VIEWS", "BLOG_ID", $blog_id, $user); // Add view to db

            }

        }

    }

?>