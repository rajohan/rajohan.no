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

            // Set the $page variable
            if(isset($_GET['page']) && !empty($_GET['page'])) {
                
                // Only allow word characters (a-z, A-Z, 0-9 and _.)
                if (preg_match('~\W~', $_GET['page'])) {
                    
                    $this->page = 'home'; // Value in url parameter page is invalid. Set $page to home

                } else {
                   
                    $this->page = $_GET['page']; // Value in url parameter is valid. Set $page equal to url parameter page

                }

            } else {

                $this->page = 'home'; // Page does not exist or is empty. Set $page to home

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

                echo $GLOBALS['error'];

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