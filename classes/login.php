<?php

    //-------------------------------------------------
    // Login
    //-------------------------------------------------

    class Login {

        private $ip;
        private $token;
        private $filter;
        private $user;
        private $validator;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->token = new Tokens;
            $this->filter = new Filter;
            $this->user = new Users;
            $this->validator = new Validator;

        }

        //-------------------------------------------------
        // Method to generate tokens and set remember me cookie
        //-------------------------------------------------

        function remember($user_id) {

            $token_array = $this->token->generate_token(32);
            $selector_array =  $this->token->generate_selector(16);
            $expire_array = $this->token->generate_expire_time(30); // 30 days
            $user_id_encoded = $this->token->encode_data($user_id);

            $value = $selector_array[1]."|".$token_array[1];

            $db_conn = new Database;
            $db_conn->db_insert("AUTH_TOKENS", "SELECTOR, USER, TOKEN, EXPIRES, IP", "sssss", array($selector_array[0], $user_id_encoded, $token_array[0], $expire_array[0], $this->ip));

            setcookie('REMEMBER_ME_TOKEN', $value, $expire_array[1], '/', $_SERVER['SERVER_NAME'], true, true);

        }

        //-------------------------------------------------
        // Method to check remember cookie
        //-------------------------------------------------

        function check_remember() {
            
            $cookie = $this->filter->sanitize($_COOKIE['REMEMBER_ME_TOKEN']);
            $tokens = explode('|', $cookie); // Split remember me cookie

            $selector = $this->token->encode_data($tokens[0]); // Encode selector
            $token = $tokens[1];

            // Get token and user id
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `TOKEN`, `USER` FROM `AUTH_TOKENS` WHERE `SELECTOR` = ? LIMIT 1");
            $stmt->bind_param("s", $selector);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $db_token = $this->filter->sanitize($row['TOKEN']);
                $user_id = $this->token->decode_data($this->filter->sanitize($row['USER']));

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

                $user_id_encoded = $this->token->encode_data($user_id);
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

            $user_id = $this->filter->sanitize($user_id);

            $_SESSION['LOGGED_IN'] = true;
            $_SESSION['USER']['ID'] = $user_id;
            $_SESSION['USER']['USERNAME'] = $this->user->get_user("ID", $user_id)['USERNAME'];
            $_SESSION['USER']['ACCESS_LEVEL'] = $this->user->get_user("ID", $user_id)['ADMIN'];

        }

        //-------------------------------------------------
        // Method to logout user
        //-------------------------------------------------

        function logout() {

            $user_id = $this->filter->sanitize($_SESSION['USER']['ID']);

            session_destroy();

            // Delete token if it exists
            $user_id_encoded = $this->token->encode_data($user_id);
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

            $username = $this->filter->sanitize($username);
            $password = $this->filter->sanitize($password);
            $remember = $this->filter->sanitize($remember);

            // Check that username is valid
            if (!$this->validator->validate_username($username)) {

                echo "Invalid username.";

            }

            // Check that username exist
            else if($this->user->username_check($_POST['login_username']) < 1) {

                echo "The username you entered does not exist.";

            }

            // Check that password is valid
            else if(!$this->validator->validate_password($password)) {

                echo "Invalid password.";

            }

            // Check that password equals username password
            elseif(!$this->user->verify_password($username, $password)) {

                echo "The password you entered is incorrect.";
                require_once('../modules/login.php');

                $user_id = $this->user->get_user("USERNAME", $username)['ID']; // Get user id from username
                
                // Log to auth log
                $db_conn = new Database;
                $db_conn->db_insert("AUTH_LOG", "USER, IP", "is", array($user_id, $this->ip));

            }

            // Login
            else {

                $user_id = $this->user->get_user("USERNAME", $username)['ID']; // Get user id from username

                // Check if remember me is checked
                if($remember === "1") {
                    
                    $user_id_encoded = $this->token->encode_data($user_id);
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