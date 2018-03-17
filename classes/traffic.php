<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Traffic
    //-------------------------------------------------

    class Traffic {

        private $filter;
        private $login;
        private $details;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------
        
        function __construct() {

            $this->filter = new Filter;
            $this->login = new Login;
            $this->details = get_browser(null, true);
            
        }

        //-------------------------------------------------
        // Method to get user ip
        //-------------------------------------------------

        private function ip() {

            if(isset($_SERVER['REMOTE_ADDR'])) {

                $ip = $this->filter->sanitize($_SERVER['REMOTE_ADDR']);

            } else {

                $ip = "N/A";

            }

            return $ip;

        }

        //-------------------------------------------------
        // Method to get current user
        //-------------------------------------------------

        private function user() {

            if($this->login->login_check()) {

                $user = $this->filter->sanitize($_SESSION['USER']['ID']);

            } else {

                $user = 0;

            }

            return $user;

        }

        //-------------------------------------------------
        // Method to get user referrer
        //-------------------------------------------------

        private function referrer() {

            if(isset($_SERVER['HTTP_REFERER'])) {

                $referrer = $this->filter->sanitize($_SERVER['HTTP_REFERER']);

            } else {

                $referrer = "N/A";

            }

            return $referrer;

        }

        //-------------------------------------------------
        // Method to get user browser
        //-------------------------------------------------

        private function browser() {

            if(isset($this->details['browser'])) {

                $browser = $this->filter->sanitize($this->details['browser']);

            } else {

                $browser = "N/A";

            }

            return $browser;

        }

        //-------------------------------------------------
        // Method to get user platform
        //-------------------------------------------------

        private function platform() {

            if(isset($this->details['platform'])) {

                $platform = $this->filter->sanitize($this->details['platform']);

            } else {

                $platform = "N/A";

            }

            return $platform;

        }

        //-------------------------------------------------
        // Method to get user platform description
        //-------------------------------------------------

        private function platform_description() {

            if(isset($this->details['platform_description'])) {

                $platform_description = $this->filter->sanitize($this->details['platform_description']);

            } else {

                $platform_description = "N/A";

            }

            return $platform_description;

        }

        //-------------------------------------------------
        // Method to get requested page
        //-------------------------------------------------

        private function page() {

            if(isset($_SERVER['REDIRECT_URL'])) {

                $page = $this->filter->sanitize($_SERVER['REDIRECT_URL']);

            } else {

                $page = "N/A";

            }

            return $page;

        }

        //-------------------------------------------------
        // Method to get current page script
        //-------------------------------------------------

        private function script() {

            if(isset($_SERVER['SCRIPT_NAME'])) {

                $script = $this->filter->sanitize($_SERVER['SCRIPT_NAME']);

            } else {

                $script = "N/A";

            }

            return $script;

        }

        //-------------------------------------------------
        // Method to get path to current page script
        //-------------------------------------------------

        private function path() {

            if(isset($_SERVER['SCRIPT_FILENAME'])) {

                $path = $this->filter->sanitize($_SERVER['SCRIPT_FILENAME']);

            } else {

                $path = "N/A";

            }

            return $path;

        }

        //-------------------------------------------------
        // Insert traffic to db
        //-------------------------------------------------

        function add_traffic() {

            $ip = $this->ip();
            $user = $this->user();
            $referrer = $this->referrer();
            $browser = $this->browser();
            $platform = $this->platform();
            $platform_description = $this->platform_description();
            $page = $this->page();
            $script = $this->script();
            $path = $this->path();

            $db_conn = new Database;
            $db_conn->db_insert('TRAFFIC_LOG', 'USER, IP, REFERRER, BROWSER, PLATFORM, PLATFORM_DESCRIPTION, PAGE, SCRIPT, PATH', 'issssssss', array($user, $ip, $referrer, $browser, $platform, $platform_description, $page, $script, $path)); // Add traffic to db

        }

    }

?>