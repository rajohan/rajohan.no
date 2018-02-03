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
        private $filter;
        public $page; // Current page
        public $url;

        function __construct() {

            //-----------------------------------------------
            // ALLOWED PAGES
            //-----------------------------------------------
            
            $db_conn = new Database(); // connect to database
            $this->filter = new Filter(); // Start filter
            $stmt = $db_conn->connect->prepare("SELECT PAGE, URL FROM `PAGES` ORDER BY `ID` DESC"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result
           
            while ($row = $result->fetch_assoc()) {
                
                $this->allowed_pages[$this->filter->sanitize(strtolower($row['PAGE']))] = $this->filter->sanitize($row['URL']); // Push rows to array
        
            }

            $db_conn->free_close($result, $stmt); // Free result and close database connection
            

            //-----------------------------------------------
            // URL HANDLER
            //-----------------------------------------------

            $params = $this->split_url(); // Split the url at each '/' 
            $params_count = count($params); // Count parameters

            // Set the $page variable
            if(!empty($params[2])) {
                // Only allow word characters (a-z, A-Z, 0-9 and _.)
                if (preg_match('~\W~', $params[2])) {

                    $this->page = 'home'; // Value in url parameter is invalid. Setting $page to home

                } else {
                    
                    $this->page = strtolower($params[2]); // Value in url parameter is valid. Settting $page equal to url parameter
                    $this->url = $this->current_url(); // Set current url
                }

            } else {

                $this->page = 'home'; // Url parameter is empty. Setting $page to home
            }     
         
        }


        // Method to check if $page is valid
        private function valid_page() {

            return array_key_exists($this->page, $this->allowed_pages);

        }

        // Method to split the url
        function split_url($url = '') {
            
            if(empty($url)) {
                $url = $_SERVER['REQUEST_URI'];
            }

            $params = rtrim($url, " /");
            $params = preg_split("/\//", $params); // Split url at each '/' 
            return $params;

        }

        // Method to get current url without page number
        function current_url() {

            $current_url = $_SERVER['REQUEST_URI'];
            $replace = '/\/[0-9]\/$/';
            return rtrim(preg_replace($replace, '', $current_url), " /"); // Remove trailing slash and pagination number from url 

        }

        // Method to generate page title
        function page_title() {

            if($this->valid_page()) {

                $title = ucfirst($GLOBALS['page_title'])." - ".ucfirst($this->page);

            } else {

                $title = ucfirst($GLOBALS['page_title']);

            }

            echo $title;

        }

        // Method to include the correct page
        function get_page() {

            if($this->valid_page()) {

                require_once("pages/".$this->allowed_pages[$this->page]);

            } else {

                require_once('pages/home.php');

            }

        }

        // Method to get current page number for pagination etc
        function get_page_number() {

            $params = $this->split_url(); // Split the url at each '/' 
            $last_param = $params[count($params)-1]; // Select the last parameter

            // Set the $page variable
            if(!empty($last_param)) {

                // Only allow word numbers (0-9)
                if (!preg_match('/^[0-9]+$/', $last_param)) {

                    return 1; // Value in url parameter is invalid. Returning 1 as page.

                } else {

                    return (int)$last_param; // Value in url parameter is valid. Settting $last_param equal to url parameter

                }

            } else {

                return 1; // Last parameter is empty. Returning 1 as page.

            }

        }

        // Method to add active page class to button equivalent to $page
        function set_active($button) {

            if($this->valid_page() && $this->page === $button) {

                return "navigation__link--active";

            }
            
        }

    }

?>