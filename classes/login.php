<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    // Check for ajax calls to check if username exist
    if((isset($_POST['login_check_username'])) && ($_POST['login_check_username'] === "true") && (isset($_POST['login_username']))) {
       
        $login = new Login;
        $login->require_files();

        $user = new Users;

        if($user->username_check($_POST['login_username']) < 1) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    }
    
    // Check for ajax calls to register user
    else if((isset($_POST['login_user'])) && ($_POST['login_user'] === "true") && (isset($_POST['login_username'])) && (isset($_POST['login_password'])) && (isset($_POST['login_remember']))) {
        
        $login = new Login;
        $login->require_files();
        $login->login($_POST['login_username'], $_POST['login_password'], $_POST['login_remember']);

    } else {

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }

    }

    //-------------------------------------------------
    // Login
    //-------------------------------------------------

    class Login {

        private $ip;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR'];;
            
        }

        //-------------------------------------------------
        // Method to require the files needed for ajax calls
        //-------------------------------------------------

        function require_files() {

            define('INCLUDE','true'); // Define INCLUDE to get access to the files needed
            require_once('../configs/db.php'); // Get database username, password etc
            require_once('database_handler.php'); // Database handler
            require_once('filter.php'); // Filter
            require_once('validator.php'); // Validator
            require_once('users.php'); // Users
            require_once('tokens.php'); // Tokens

        }

        //-------------------------------------------------
        // Method to generate tokens and set remember me cookie
        //-------------------------------------------------

        function remember($user_id) {

            $token = new Tokens;

            $token_array = $token->generate_token(32);
            $selector_array =  $token->generate_selector(16);
            $expire_array = $token->generate_expire_time(30); // 30 days
            $user_id_encoded = $token->encode_user_id($user_id);

            $value = $selector_array[1]."|".$token_array[1];

            $db_conn = new Database;
            $db_conn->db_insert("AUTH_TOKENS", "SELECTOR, USER, TOKEN, 	EXPIRES, IP", "sssss", array($selector_array[0], $user_id_encoded, $token_array[0], $expire_array[0], $this->ip));

            setcookie('REMEMBER_ME_TOKEN', $value, $expire_array[1], '/', $_SERVER['SERVER_NAME'], true, true);

        }

        //-------------------------------------------------
        // Method to login user
        //-------------------------------------------------

        function login($username, $password, $remember) {

            $filter = new Filter;
            $validator = new Validator;
            $user = new Users;

            $username = $filter->sanitize($username);
            $password = $filter->sanitize($password);
            $remember = $filter->sanitize($remember);

            // Check that username is valid
            if (!$validator->validate_username($username)) {

                echo "Invalid username.";

            }

            // Check that username exist
            else if($user->username_check($_POST['login_username']) < 1) {

                echo "The username you entered does not exist.";

            }

            // Check that password is valid
            else if(!$validator->validate_password($password)) {

                echo "Invalid password.";

            }

            // Check that password equals username password
            elseif(!$user->verify_password($username, $password)) {

                echo "The password you entered is incorrect.";

            }

            // Login
            else {

                $user_id = $user->get_user_id($username);

                // Check if remember me is checked
                if($remember === "1") {
                    
                    $this->remember($user_id);

                }
                    
                $_SESSION['LOGGED_IN'] = true;
                $_SESSION['USER']['ID'] = $user_id;
                $_SESSION['USER']['USERNAME'] = $username;
                $_SESSION['USER']['ACCESS_LEVEL'] = $user->get_admin_level($user_id);

                echo "Logged in";

            }

        }

    }

?>