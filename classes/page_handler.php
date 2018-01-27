<?php 
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {
        
        die('Direct access is not permitted.');
        
    }

    ###########################################################################
    # Page handler. Include the correct page and set active button.
    ###########################################################################
    class Page_handler {

        private $allowed_pages;
        private $page;

        function __construct() {

            // Array containing allowed pages
            $this->allowed_pages = array(

                'home'     => 'landing_page.php', 
                'about'    => 'about.php',
                'services' => 'services.php',
                'projects' => 'projects.php',
                'blog'     => 'blog.php',
                'contact'  => 'contact.php',
                'legal'    => 'legal.php',
                'sitemap'  => 'sitemap.php'

            );

            $params = preg_split("/\//", $_SERVER['REQUEST_URI']); // Split url at each '/' 

            // Set the $page variable
            if(!empty($params[2])) {
                // Only allow word characters (a-z, A-Z, 0-9 and _.)
                if (preg_match('~\W~', $params[2])) {

                    $this->page = 'home'; // Value in url parameter is invalid. Setting $page to home

                } else {

                    $this->page = $params[2]; // Value in url parameter is valid. Settting $page equal to url parameter

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

                $title = $GLOBALS['page_title']." - ".ucfirst($this->page);

            } else {

                $title = $GLOBALS['page_title'];

            }

            echo $title;

        }

        // Metod to include the correct page
        function get_page() {

            if($this->valid_page()) {

                require_once("pages/".$this->allowed_pages[$this->page]);

            } else {

                require_once('pages/landing_page.php');

            }

        }

        // Metod to add active page class to button equivalent to $page
        function set_active($button) {

            if($this->valid_page() && $this->page === $button) {

                echo "navigation__link--active";

            }
            
        }

    }

?>