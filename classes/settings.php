<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
            
    }

    //-------------------------------------------------
    // User settings
    //-------------------------------------------------

    class Settings {
        
        private $ip; // User ip
        private $username;
        private $user_id;
        private $mail;
        private $user;
        private $filter;
        private $validator;
        private $login;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR']; // User ip
            $this->user = new Users;
            $this->filter = new Filter;
            $this->validator = new Validator;
            $this->login = new Login;

            if(isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {

                $this->user_id = $this->filter->sanitize($_SESSION['USER']['ID']);
                $this->username = $this->filter->sanitize($_SESSION['USER']['USERNAME']);
                $this->mail = $this->filter->sanitize($this->user->get_user("ID", $this->user_id)['EMAIL']);

            }

        }

        //-------------------------------------------------
        // Change password
        //-------------------------------------------------

        function change_password($password, $new_password, $new_password_repeat) {

            $password = $this->filter->sanitize($password);
            $new_password = $this->filter->sanitize($new_password);
            $new_password_repeat = $this->filter->sanitize($new_password_repeat);
            $action = "change";
            $function = "change password";

            // Check that password is valid
            if((!$this->validator->validate_password($password)) || (!$this->validator->validate_password($new_password)) || (!$this->validator->validate_password($new_password_repeat))) {

                echo "Invalid password. Minimum 6 characters.";

            }

            // check that new password and repeat new passord match
            else if($new_password !== $new_password_repeat) {

                echo "The new password fields does not match.";

            }

            // Check that current password entered equals username password
            else if(!$this->user->verify_password($this->username, $password)) {

                echo "The password you entered is incorrect.";
                
                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $this->mail, 0, $this->user_id, $this->ip));

            } else {

                $new_password = password_hash($new_password, PASSWORD_DEFAULT); // Encrypt the password

                // Update email row with code
                $db_conn = new Database;
                $db_conn->db_update("USERS", "PASSWORD", "ID", "si", array($new_password, $this->user_id));

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $this->mail, 1, $this->user_id, $this->ip));

                // Logout user
                $this->login->logout();

                echo "Password changed";

            }

        }
    
    }

?>