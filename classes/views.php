<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    //-------------------------------------------------
    // Class for views
    //-------------------------------------------------

    class Views {

        private $ip; // User ip

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR']; // User ip

        }

        //-------------------------------------------------
        // Method to check for earlier views on item from the same user
        //-------------------------------------------------

        private function check_views($table, $id_col_name, $item_id, $user) {
            
            $db_conn = new Database;
            $count = $db_conn->count($table, 'WHERE '.$id_col_name.' = ? AND (`VIEW_BY_IP` = ? OR (`VIEW_BY_USER` = ? AND `VIEW_BY_USER` != "0"))', "isi", array($item_id, $this->ip, $user));
            return $count;

        }

        //-------------------------------------------------
        // Method to add a new view
        //-------------------------------------------------

        private function add_view($table, $id_col_name, $blog_id, $user) {

            $db_conn = new Database;
            $db_conn->db_insert($table, ''.$id_col_name.', VIEW_BY_USER, VIEW_BY_IP', 'iis', array($blog_id, $user, $this->ip)); // Add view to db

        }

        //-------------------------------------------------
        // Method to add blog views
        //-------------------------------------------------
        
        function add_blog_view($blog_id) {
            
            if(isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {

                $user = $_SESSION['USER']['ID'];

            } else {
            
                $user = 0;

            }

            $count = $this->check_views("BLOG_VIEWS", "BLOG_ID", $blog_id, $user); // Check for old view on item by user

            if($count <= 0) {

                $this->add_view("BLOG_VIEWS", "BLOG_ID", $blog_id, $user); // Add view to db

            }

        }

        //-------------------------------------------------
        // Method to add user profile views
        //-------------------------------------------------
        
        function add_user_profile_view($user_id) {
            
            if(isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {

                $user = $_SESSION['USER']['ID'];

            } else {
            
                $user = 0;

            }

            $count = $this->check_views("USER_PROFILE_VIEWS", "USER_ID", $user_id, $user); // Check for old view on item by user

            if($count <= 0) {

                $this->add_view("USER_PROFILE_VIEWS", "USER_ID", $user_id, $user); // Add view to db

            }

        }


    }

?>