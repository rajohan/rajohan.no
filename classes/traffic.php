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

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------
        
        function __construct() {

            $this->filter = new Filter;
            $this->login = new Login;
            
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
        // Method to get user agent
        //-------------------------------------------------

        private function agent() {

            if(isset($_SERVER['HTTP_USER_AGENT'])) {

                $agent = $this->filter->sanitize($_SERVER['HTTP_USER_AGENT']);

            } else {

                $agent = "N/A";

            }

            return $agent;

        }

        //-------------------------------------------------
        // Method to get reguested page
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
        // Method to get current url
        //-------------------------------------------------

        private function url() {

            if(isset($_SERVER['REQUEST_URI'])) {

                $url = $this->filter->sanitize($_SERVER['REQUEST_URI']);

            } else {

                $url = "N/A";

            }

            return $url;

        }

        //-------------------------------------------------
        // Insert traffic to db
        //-------------------------------------------------

        function add_traffic() {

            $ip = $this->ip();
            $user = $this->user();
            $referrer = $this->referrer();
            $agent = $this->agent();
            $page = $this->page();
            $script = $this->script();
            $path = $this->path();
            $url = $this->url();

            $db_conn = new Database;
            $db_conn->db_insert('TRAFFIC_LOG', 'USER, IP, REFERRER, AGENT, PAGE, SCRIPT, PATH, URL', 'isssssss', array($user, $ip, $referrer, $agent, $page, $script, $path, $url)); // Add traffic to db

        }

    }

?>