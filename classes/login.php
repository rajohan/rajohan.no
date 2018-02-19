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

            session_start();
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
            $db_conn->db_insert("AUTH_TOKENS", "SELECTOR, USER, TOKEN, EXPIRES, IP", "sssss", array($selector_array[0], $user_id_encoded, $token_array[0], $expire_array[0], $this->ip));

            setcookie('REMEMBER_ME_TOKEN', $value, $expire_array[1], '/', $_SERVER['SERVER_NAME'], true, true);

        }

        //-------------------------------------------------
        // Method to check remember cookie
        //-------------------------------------------------

        function check_remember() {
            
            $filter = new Filter;
            $cookie = $filter->sanitize($_COOKIE['REMEMBER_ME_TOKEN']);
            $tokens = explode('|', $cookie); // Split remember me cookie

            $selector = base64_encode($tokens[0]); // Encode selector
            $token = $tokens[1];

            // Get token and user id
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `TOKEN`, `USER` FROM `AUTH_TOKENS` WHERE `SELECTOR` = ? LIMIT 1");
            $stmt->bind_param("s", $selector);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $db_token = $filter->sanitize($row['TOKEN']);
                $user_id = base64_decode($filter->sanitize($row['USER']));

            }

            $db_conn->free_close($result, $stmt);

            // If cookie exists but token dont exist in db
            if(!isset($db_token)) {

                // Log to auth log
                $db_conn = new Database;
                $db_conn->db_insert("AUTH_LOG", "USER, TOKEN, SUCCESS, IP", "iiis", array(0, 1, 0, $this->ip));

                setcookie('REMEMBER_ME_TOKEN', '', time() - 3600, '/', $_SERVER['SERVER_NAME'], true, true); // empty value and old timestamp

                return false;
            }

            $verify = password_verify($token, $db_token); // Verify token

            if($verify) {

                $user_id_encoded = base64_encode($user_id);
                $db_conn = new Database;
                $db_conn->db_delete('AUTH_TOKENS', 'USER', 's', $user_id_encoded); // Delete old token

                $this->remember($user_id); // Create new token
                $this->create_sessions($user_id); // Create sessions

                // Log to auth log
                $db_conn = new Database;
                $db_conn->db_insert("AUTH_LOG", "USER, TOKEN, SUCCESS, IP", "iiis", array($user_id, 1, 1, $this->ip));

            } else {

                // Log to auth log
                $db_conn = new Database;
                $db_conn->db_insert("AUTH_LOG", "USER, TOKEN, SUCCESS, IP", "iiis", array(0, 1, 0, $this->ip));

            }

            return $verify;

        }

        //-------------------------------------------------
        // Method to create sessions
        //-------------------------------------------------

        function create_sessions($user_id) {

            $user = new Users;
            $filter = new Filter;

            $user_id = $filter->sanitize($user_id);

            $_SESSION['LOGGED_IN'] = true;
            $_SESSION['USER']['ID'] = $user_id;
            $_SESSION['USER']['USERNAME'] = $user->get_username($user_id);
            $_SESSION['USER']['ACCESS_LEVEL'] = $user->get_admin_level($user_id);

        }

        //-------------------------------------------------
        // Method to logout user
        //-------------------------------------------------

        function logout() {

            $filter = new Filter;

            $user_id = $filter->sanitize($_SESSION['USER']['ID']);

            session_destroy();

            // Delete token if it exists
            $user_id_encoded = base64_encode($user_id);
            $db_conn = new Database;
            $db_conn->db_delete('AUTH_TOKENS', 'USER', 's', $user_id_encoded);

            // Delete cookie if it exists
            if (isset($_COOKIE['REMEMBER_ME_TOKEN'])) {

                unset($_COOKIE['REMEMBER_ME_TOKEN']);
                setcookie('REMEMBER_ME_TOKEN', '', time() - 3600, '/', $_SERVER['SERVER_NAME'], true, true); // empty value and old timestamp
            
            }

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
                require_once('../modules/login.php');

                $user_id = $user->get_user_id($username); // Get user id from username
                
                // Log to auth log
                $db_conn = new Database;
                $db_conn->db_insert("AUTH_LOG", "USER, IP", "is", array($user_id, $this->ip));

            }

            // Login
            else {

                $user_id = $user->get_user_id($username); // Get user id from username

                // Check if remember me is checked
                if($remember === "1") {
                    
                    $user_id_encoded = base64_encode($user_id);
                    $db_conn = new Database;
                    $db_conn->db_delete('AUTH_TOKENS', 'USER', 's', $user_id_encoded); // Delete old token

                    $this->remember($user_id);

                }

                // Log to auth log
                $db_conn = new Database;
                $db_conn->db_insert("AUTH_LOG", "USER, SUCCESS, IP", "iis", array($user_id, 1, $this->ip));
                    
                $this->create_sessions($user_id); // Create sessions

                echo "Logged in";

            }

        }

    }

?>