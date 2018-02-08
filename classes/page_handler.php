<?php 
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Page handler
    //-------------------------------------------------

    class Page_handler {

        private $allowed_pages = [];
        private $filter;
        private $converter;
        private $base_param_num;
        public $page;
        public $url;
        public $blog_id;

        //-----------------------------------------------
        // Construct
        //-----------------------------------------------

        function __construct() {

            //-----------------------------------------------
            // Allowed pages
            //-----------------------------------------------
            
            $db_conn = new Database;
            $this->filter = new Filter;
            $this->converter = new Converter;

            $base_param_num = 2; // What parameter number website base is on

            $stmt = $db_conn->connect->prepare("SELECT `PAGE`, `URL` FROM `PAGES` ORDER BY `ID` DESC"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result
           
            while ($row = $result->fetch_assoc()) {
                
                $this->allowed_pages[$this->filter->sanitize(strtolower($row['PAGE']))] = $this->filter->sanitize($row['URL']); // Push rows to array
        
            }

            $db_conn->free_close($result, $stmt); // Free result and close database connection
            

            //-----------------------------------------------
            // Url handler
            //-----------------------------------------------

            $params = $this->split_url(); // Split the url at each '/' 
            $params_count = count($params); // Count parameters

            // Set the $page variable
            if(!empty($params[$base_param_num])) {
                // Only allow word characters (a-z, A-Z, 0-9 and _.)
                if (preg_match('~\W~', $params[$base_param_num])) {

                    $this->page = 'home'; // Value in url parameter is invalid. Setting $page to home

                } else {
                    
                    // Check if the first paramater is blog and that second parameter is set
                    if(($params[$base_param_num] === "blog") && (!empty($params[$base_param_num+1]))) {

                        // Check if parameter 2 is set and is valid
                        if((($params[$base_param_num+1]) === "read") && (!preg_match('~\W~', $params[$base_param_num+1]))) {

                            // Check if parameter 3 is set and is valid
                            if((!empty($params[$base_param_num+2])) && preg_match('/^[1-9][0-9]*$/', $params[$base_param_num+2])) {

                                $db_conn = new Database;
                                
                                $count = $db_conn->count('BLOG', $sort = 'WHERE `ID` = "'.$params[$base_param_num+2].'"');

                                // Check that the blog post exist
                                if($count > 0) {

                                    $this->blog_id = $params[$base_param_num+2]; // Set blog id
                                    $this->page = $params[$base_param_num+1]; // Value in url parameter 2 is valid. Setting $page equal to url parameter 2

                                } else {

                                    $this->page = $params[$base_param_num]; // Blog post does not exist. Setting $page equal to first url parameter

                                }

                            } else {

                                $this->page = $params[$base_param_num]; // Value in second url parameter is invalid. Setting $page equal to first url parameter

                            }

                        
                        } else {

                            $this->page = $params[$base_param_num]; // Value in second url parameter is invalid. Setting $page equal to first url parameter

                        }

                    } else {

                        $this->page = $params[$base_param_num]; // Value in url parameter is valid. Settting $page equal to url parameter

                    }

                    $this->url = $this->current_url(); // Set current url
                    
                }

            } else {

                $this->page = 'home'; // Url parameter is empty. Setting $page to home
            }     
         
        }

        //-----------------------------------------------
        // Method to check if $page is valid
        //-----------------------------------------------

        private function valid_page() {

            return array_key_exists($this->page, $this->allowed_pages);

        }

        //-----------------------------------------------
        // Method to split the url
        //-----------------------------------------------

        function split_url($url = '') {
            
            if(empty($url)) {
                $url = strtolower($_SERVER['REQUEST_URI']);
            }

            $url = $this->filter->sanitize($url);
            $params = rtrim($url, " /");
            $params = preg_split("/\//", $params); // Split url at each '/' 
            return $params;

        }

        //-----------------------------------------------
        // Method to get current url without page number
        //-----------------------------------------------

        function current_url() {

            $current_url = strtolower($this->filter->sanitize($_SERVER['REQUEST_URI']));
            $replace = '/\/[0-9]\/$/';
            return rtrim(preg_replace($replace, '', $current_url), " /"); // Remove trailing slash and pagination number from url 

        }

        //-----------------------------------------------
        // Method to generate page title
        //-----------------------------------------------

        function page_title() {

            if($this->valid_page()) {

                // Check if page is read and if it is set title equal to blog title
                if($this->page === "read") { 

                    $db_conn = new Database;

                    $count = $db_conn->count('BLOG', $sort = 'WHERE `ID` = "'.$this->blog_id.'"');

                    // Check that the blog post exist
                    if($count > 0) {

                        $db_conn = new Database;

                        $stmt = $db_conn->connect->prepare('SELECT `TITLE` FROM `BLOG` WHERE `ID` = "'.$this->blog_id.'"'); // prepare statement
                        $stmt->execute(); // select from database
                        $result = $stmt->get_result(); // Get the result

                        while ($row = $result->fetch_assoc()) {
                
                            $blog_title = $this->converter->generate_slug($this->filter->sanitize($row['TITLE']), ' '); // Push rows to array
                    
                        }
            
                        $db_conn->free_close($result, $stmt); // Free result and close database connection

                        $title = ucfirst($GLOBALS['page_title'])." - ".ucfirst($blog_title);

                    } else {

                        $title = ucfirst($GLOBALS['page_title'])." - ".ucfirst($this->page); 

                    }

                } else {

                    $title = ucfirst($GLOBALS['page_title'])." - ".ucfirst($this->page); 

                }

            } else {

                $title = ucfirst($GLOBALS['page_title']);

            }

            echo $title;

        }

        //-----------------------------------------------
        // Method to include the correct page
        //-----------------------------------------------

        function get_page() {

            if($this->valid_page()) {

                require_once("pages/".$this->allowed_pages[$this->page]);

            } else {

                require_once('pages/home.php');

            }

        }

        //-----------------------------------------------
        // Method to get current page number for pagination etc
        //-----------------------------------------------

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

        //-----------------------------------------------
        // Method to add active page class to button equivalent to $page
        //-----------------------------------------------

        function set_active($button) {

            if($this->valid_page() && $this->page === $button) {

                return "navigation__link--active";

            }
            
        }

    }

?>