<?php 
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
                'services' => 'services.php'

            );

            // Set the $page variable
            if(isset($_GET['page']) && !empty($_GET['page'])) {

                $this->page = filter_var($_GET['page'], FILTER_SANITIZE_URL);

            } else {

                $this->page = 'home';

            }   

        }
        
        // Metod to check if $page is valid
        private function valid_page() {

            return array_key_exists($this->page, $this->allowed_pages);

        }

        // Metod to include the correct page
        function get_page() {

            if($this->valid_page()) {

                include_once("pages/".$this->allowed_pages[$this->page]);

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