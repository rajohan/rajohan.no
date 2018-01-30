<?php 
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {
        
        die('Direct access is not permitted.');
        
    }

    ###########################################################################
    # Page handler. Include the correct page and set active button.
    ###########################################################################
    class Page_handler {

        private $allowed_pages = []; // Array containing allowed pages
        private $page; // Current page

        function __construct() {

            //-----------------------------------------------
            // ALLOWED PAGES
            //-----------------------------------------------
            
            $db_conn = new Database(); // connect to database
            $filter = new Filter(); // Start filter
            $stmt = $db_conn->connect->prepare("SELECT PAGE, URL FROM `PAGES` ORDER BY `ID` DESC"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result
           
            while ($row = $result->fetch_assoc()) {
                
                $this->allowed_pages[$filter->sanitize(strtolower($row['PAGE']))] = $filter->sanitize($row['URL']); // Push rows to array
        
            }

            $db_conn->free_close($result, $stmt); // Free result and close database connection


            //-----------------------------------------------
            // URL HANDLER
            //-----------------------------------------------

            $params = preg_split("/\//", $_SERVER['REQUEST_URI']); // Split url at each '/' 

            // Set the $page variable
            if(!empty($params[2])) {
                // Only allow word characters (a-z, A-Z, 0-9 and _.)
                if (preg_match('~\W~', $params[2])) {

                    $this->page = 'home'; // Value in url parameter is invalid. Setting $page to home

                } else {

                    $this->page = strtolower($params[2]); // Value in url parameter is valid. Settting $page equal to url parameter

                }

            } else {

                $this->page = 'home'; // Url parameter is empty. Setting $page to home

            }     
         
        }
        
        // Metod to check if $page is valid
        private function valid_page() {

            return array_key_exists($this->page, $this->allowed_pages);

        }

        // Metod to generate page title
        function page_title() {

            if($this->valid_page()) {

                $title = ucfirst($GLOBALS['page_title'])." - ".ucfirst($this->page);

            } else {

                $title = ucfirst($GLOBALS['page_title']);

            }

            echo $title;

        }

        // Metod to include the correct page
        function get_page() {

            if($this->valid_page()) {

                require_once("pages/".$this->allowed_pages[$this->page]);

            } else {

                require_once('pages/home.php');

            }

        }

        // Metod to add active page class to button equivalent to $page
        function set_active($button) {

            if($this->valid_page() && $this->page === $button) {

                return "navigation__link--active";

            }
            
        }

    }

?>