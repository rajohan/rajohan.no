<?php

    $ajax = new Ajax;
    $ajax->login();
    $ajax->header();
    $ajax->newsletter();
    $ajax->register();
    $ajax->vote();

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Ajax handler
    //-------------------------------------------------

    class Ajax {

        private $user;
        private $header;
        private $login;
        private $newsletter;
        private $register;
        private $filter;
        private $votes;

        //-------------------------------------------------
        // Require files
        //-------------------------------------------------

        private function require_files() {

            session_start();
            define('INCLUDE','true'); // Define INCLUDE to get access to the files needed

            require_once('../configs/db.php');        // Get database username, password etc
            require_once('autoloader.php');           // Autoload classes needed
            require_once('../configs/config.php');    // Config

        }

        //-------------------------------------------------
        // Initialize classes
        //-------------------------------------------------

        private function init() {

            $this->user = new Users;
            $this->newsletter = new Newsletter;
            $this->login = new Login;
            $this->header = new Header;
            $this->register = new Register;
            $this->filter = new Filter;
            $this->votes = new Vote;

        }

        //-------------------------------------------------
        // True/false check
        //-------------------------------------------------

        private function true_false($statement) {

            if($statement) {

                echo "false";

            } else {

                echo "true";

            }

        }

        //-------------------------------------------------
        // Login
        //-------------------------------------------------

        function login() {

            // Check if username exist
            if((isset($_POST['login_check_username'])) && ($_POST['login_check_username'] === "true") && (isset($_POST['login_username']))) {
            
                $this->require_files();
                $this->init();
                $this->true_false($this->user->username_check($_POST['login_username']) < 1); // Username check

            }
            
            // Login user
            else if((isset($_POST['login_user'])) && ($_POST['login_user'] === "true") && (isset($_POST['login_username'])) && (isset($_POST['login_password'])) && (isset($_POST['login_remember']))) {

                $this->require_files();
                $this->init();
                $this->login->login($_POST['login_username'], $_POST['login_password'], $_POST['login_remember']); // Try to login

            }

        }

        //-------------------------------------------------
        // Header
        //-------------------------------------------------

        function header() {

            if(!empty($_POST['get_headers']) && $_POST['get_headers'] === "true") {

                $this->require_files();
                $this->init();
                $this->header->get_header_content(); // Get the headers from the database
        
            }

        }

        //-------------------------------------------------
        // Newsletter
        //-------------------------------------------------

        function newsletter() {

            // Add new email to subscription list
            if((isset($_POST['subscribe'])) && ($_POST['subscribe'] === "true") && (isset($_POST['mail']))) {
                
                $this->require_files();
                $this->init();
                $this->newsletter->subscribe($_POST['mail']);

            }

            // Generate verification code
            else if((isset($_POST['unsubscribe'])) && ($_POST['unsubscribe'] === "true") && (isset($_POST['mail']))) {

                $this->require_files();
                $this->init();
                $this->newsletter->unsubscribe_code($_POST['mail']);

            } 

            // Unsubscribe with verification code
            else if((isset($_POST['unsubscribe_code'])) && ($_POST['unsubscribe_code'] === "true") && (isset($_POST['mail'])) && (isset($_POST['code']))) {
                
                $this->require_files();
                $this->init();
                $this->newsletter->unsubscribe($_POST['mail'], $_POST['code']);

            }

            // Check if mail address already is in subscription list
            else if ((isset($_POST['mail_subscribed_check'])) && ($_POST['mail_subscribed_check'] === "true") && (isset($_POST['mail']))) {
                
                $this->require_files();
                $this->init();
                $this->true_false($this->newsletter->check_email($_POST['mail']) > 0);

            } 

            // Check if mail address entered dont exist in the subscription list
            else if ((isset($_POST['mail_unsubscribe_check'])) && ($_POST['mail_unsubscribe_check'] === "true") && (isset($_POST['mail']))) {
                
                $this->require_files();
                $this->init();
                $this->true_false($this->newsletter->check_email($_POST['mail']) < 1);

            }

        }

        //-------------------------------------------------
        // Register
        //-------------------------------------------------

        function register() {

            // Check if username is taken
            if((isset($_POST['register_username_check'])) && ($_POST['register_username_check'] === "true") && (isset($_POST['register_username']))) {
                
                $this->require_files();
                $this->init();
                $this->true_false($this->user->username_check($_POST['register_username']) > 0);

            }

            // Check if email is already registered (when registering)
            else if((isset($_POST['register_mail_check'])) && ($_POST['register_mail_check'] === "true") && (isset($_POST['register_mail']))) {
                
                $this->require_files();
                $this->init();
                $this->true_false($this->register->mail_check($_POST['register_mail']) > 0);

            }

            // Check if email is registered and not verified (when verifying)
            else if((isset($_POST['verify_check_mail'])) && ($_POST['verify_check_mail'] === "true") && (isset($_POST['verify_mail']))) {
                
                $this->require_files();
                $this->init();
                $this->true_false($this->register->check_mail_verified($_POST['verify_mail']) < 1);

            }

            // Check if email is registered and not verified (when resending verification code)
            else if((isset($_POST['resend_check_mail'])) && ($_POST['resend_check_mail'] === "true") && (isset($_POST['resend_mail']))) {
                
                $this->require_files();
                $this->init();
                $this->true_false($this->register->check_mail_verified($_POST['resend_mail']) < 1);

            }

            // Resend verification code
            else if((isset($_POST['resend_code'])) && ($_POST['resend_code'] === "true") && (isset($_POST['resend_mail']))) {

                $this->require_files();
                $this->init();
                $this->register->resend_code($_POST['resend_mail']);

            }

            // Verify email
            else if ((isset($_POST['verify_email'])) && ($_POST['verify_email'] === "true") && (isset($_POST['verify_mail'])) && (isset($_POST['verify_code']))) {

                $this->require_files();
                $this->init();
                $this->register->verify_user($_POST['verify_mail'], $_POST['verify_code']);

            }

            // Generate token for forgot password
            else if ((isset($_POST['forgot_password'])) && ($_POST['forgot_password'] === "true") && (isset($_POST['username'])) && (isset($_POST['mail']))) {

                $this->require_files();
                $this->init();
                $this->register->forgot_password($_POST['username'], $_POST['mail']);

            }

            // Reset password for forgot password
            else if ((isset($_POST['forgot_password_verify'])) && ($_POST['forgot_password_verify'] === "true") && (isset($_POST['username'])) && (isset($_POST['code'])) && (isset($_POST['password'])) && (isset($_POST['password_repeat']))) {

                $this->require_files();
                $this->init();
                $this->register->forgot_password_verify($_POST['username'], $_POST['code'], $_POST['password'], $_POST['password_repeat']);

            }
            
            // Register user
            else if((isset($_POST['register'])) && ($_POST['register'] === "true") && (isset($_POST['register_username'])) && (isset($_POST['register_mail'])) && (isset($_POST['register_password'])) && (isset($_POST['register_password_repeat']))) {
                
                $this->require_files();
                $this->init();
                $this->register->register_user($_POST['register_username'], $_POST['register_mail'], $_POST['register_password'], $_POST['register_password_repeat']);

            } 

        }

        //-------------------------------------------------
        // Vote
        //-------------------------------------------------

        function vote() {

            if(!empty($_POST['add_vote']) && $_POST['add_vote'] === "true") {

                $this->require_files();
                $this->init();

                $vote = $this->filter->sanitize($_POST['vote']);
                $id = $this->filter->sanitize($_POST['id']);
                $type = $this->filter->sanitize($_POST['type']);
                
                if($type === "blog") {
                    
                    $this->votes->add_blog_vote($vote, $id);
                    $table = "BLOG_VOTES";

                }

                else if($type === "comment") {
            
                    $this->votes->add_comment_vote($vote, $id);
                    $table = "COMMENT_VOTES";
                    
                }

                // Get new likes count
                $db_conn = new Database;
                $votes_like = $db_conn->count($table, 'WHERE ITEM_ID = ? AND VOTE = 1', "i", array($id));
                
                // Get new dislike count
                $db_conn = new Database;
                $votes_dislike = $db_conn->count($table, 'WHERE ITEM_ID = ? AND VOTE = 0', "i", array($id));

                // Crate like/dislike arrays
                $vote_array['like'] = $votes_like;
                $vote_array['dislike'] = $votes_dislike;

                echo json_encode($vote_array);
            
            }

        }

    }

?>