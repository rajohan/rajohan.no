<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    // Check for ajax calls to check if username is taken
    if((isset($_POST['register_username_check'])) && ($_POST['register_username_check'] === "true") && (isset($_POST['register_username']))) {
       
        $register = new Register;
        $register->require_files();

        $user = new Users;

        if($user->username_check($_POST['register_username']) > 0) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    }

    // Check for ajax calls to check if email is already registered (when registering)
    else if((isset($_POST['register_mail_check'])) && ($_POST['register_mail_check'] === "true") && (isset($_POST['register_mail']))) {
        
        $register = new Register;
        $register->require_files();

        if($register->mail_check($_POST['register_mail']) > 0) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    }

    // Check for ajax calls to check if email is registered and not verified (when verifying)
    else if((isset($_POST['verify_check_mail'])) && ($_POST['verify_check_mail'] === "true") && (isset($_POST['verify_mail']))) {
        
        $register = new Register;
        $register->require_files();

        if($register->check_mail_verified($_POST['verify_mail']) < 1) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    }

    // Check for ajax calls to check if email is registered and not verified (when resending verification code)
    else if((isset($_POST['resend_check_mail'])) && ($_POST['resend_check_mail'] === "true") && (isset($_POST['resend_mail']))) {
        
        $register = new Register;
        $register->require_files();

        if($register->check_mail_verified($_POST['resend_mail']) < 1) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    }

    // Check for ajax calls to resend verification code
    else if((isset($_POST['resend_code'])) && ($_POST['resend_code'] === "true") && (isset($_POST['resend_mail']))) {

        $register = new Register;
        $register->require_files();
        $register->resend_code($_POST['resend_mail']);

    }

    // Check for ajax calls to verify email
    else if ((isset($_POST['verify_email'])) && ($_POST['verify_email'] === "true") && (isset($_POST['verify_mail'])) && (isset($_POST['verify_code']))) {

        $register = new Register;
        $register->require_files();

        $register->verify_user($_POST['verify_mail'], $_POST['verify_code']);

    }
    
    // Check for ajax calls to register user
    else if((isset($_POST['register'])) && ($_POST['register'] === "true") && (isset($_POST['register_username'])) && (isset($_POST['register_mail'])) && (isset($_POST['register_password'])) && (isset($_POST['register_password_repeat']))) {
        
        $register = new Register;
        $register->require_files();

        $register->register_user($_POST['register_username'], $_POST['register_mail'], $_POST['register_password'], $_POST['register_password_repeat']);

    } else {

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }

    }

    //-------------------------------------------------
    // Register
    //-------------------------------------------------

    class Register {

        private $ip;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR'];
            
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
            require_once('mail.php'); // Mail
            require_once('users.php'); // Users
            require_once('tokens.php'); // Tokens

        }

        //-------------------------------------------------
        // Method to check if email is already registered
        //-------------------------------------------------

        function mail_check($mail) {

            $db_conn = new Database;
            $filter = new Filter;
            $mail = $filter->sanitize($mail);

            $count = $db_conn->count("USERS", "WHERE EMAIL = '".$mail."'");

            return $count;

        }

        //-------------------------------------------------
        // Method to check if email/username not are verified
        //-------------------------------------------------

        function check_mail_verified($mail) {

            $filter = new Filter;
            $mail = $filter->sanitize($mail);
            
            $db_conn = new Database;
            $count = $db_conn->count("USERS", "WHERE EMAIL = '".$mail."' AND EMAIL_VERIFIED < 1");

            return $count;

        }

        //-------------------------------------------------
        // Method to check if code matches the assigned code to email/username
        //-------------------------------------------------

        function check_code($mail, $code) {

            $filter = new Filter;
            $mail = $filter->sanitize($mail);
            $code = $filter->sanitize($code);

            // Get token
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `CODE` FROM `USERS` WHERE `EMAIL` = ? LIMIT 1");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $db_code = $filter->sanitize($row['CODE']);

            }

            $db_conn->free_close($result, $stmt);

            if(!isset($db_code)) {

                return false;

            } else {

                $verify = password_verify($code, $db_code); // Verify token

                return $verify;

            }

        }

        //-------------------------------------------------
        // Method to register a new user
        //-------------------------------------------------

        function register_user($username, $mail, $password, $password_repeat) {

            $filter = new Filter;
            $validator = new Validator;
            $send_mail = new Mail;
            $user = new Users;
            $token = new Tokens;

            $username = $filter->sanitize($username);
            $mail = $filter->sanitize($mail);
            $password = $filter->sanitize($password);
            $password_repeat = $filter->sanitize($password_repeat);
            
            // Invalid username
            if(!$validator->validate_username($username)) {

                echo "Invalid username. Minimum 5 and max 15 characters. Only letters and numbers are allowed.";

            }

            // Invalid email
            else if(!$validator->validate_mail($mail)) {

                echo "Invalid email address.";

            }

            // Username taken
            else if($user->username_check($username) > 0) {

                echo "Username is already taken.";

            }

            // Email already registered
            else if($this->mail_check($mail) > 0) {

                echo "The email address you entered is already registered.";

            }

            // Password fields does not match
            else if($password !== $password_repeat) {

                echo "The password fields does not match.";

            }

            // Invalid password
            else if(!$validator->validate_password($password)) {

                echo "Invalid password. Minimum 6 characters.";

            } else { // Register user

                $code = $token->generate_token(3); // Generate 6 char long verification code
                $password = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password

                // Create user
                $db_conn = new Database;
                $db_conn->db_insert("USERS", "USERNAME, PASSWORD, EMAIL, CODE, IP", "sssss", array($username, $password, $mail, $code[0], $this->ip));

                $action = "create";
                $function = "verify email";
                $user_id = $user->get_user_id_email($mail);

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));

                $from = "webmaster@rajohan.no";
                $from_name = "Rajohan.no";
                $reply_to = "mail@rajohan.no";
                $subject = "Email verification code";

                $body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code[1]."<br><br>Your verification code: ".$code[1]."<br><br>If this registration was not made by you this email can be ignored.<br><br>The registration was made from IP ".$this->ip.".";
                $alt_body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code[1]."\r\n\r\nYour verification code: ".$code[1]."\r\n\r\nIf this registration was not made by you this email can be ignored.\r\n\r\nThe registration was made from IP ".$this->ip.".";
                
                $send_mail->send_mail($from, $from_name, $mail, $reply_to, $subject, $body, $alt_body);

                echo "Almost done! To confirm your email address a verification code is sent to the email address you entered. Input the verification code in the field underneath or click on the link provided in the email.";
                
                require_once("../modules/verify.php");

            }

        }

        //-------------------------------------------------
        // Method to resend email verification code
        //-------------------------------------------------

        function resend_code($mail) {

            $filter = new Filter;
            $validator = new Validator;
            $send_mail = new Mail;
            $user = new Users;
            $token = new Tokens;
            
            $mail = $filter->sanitize($mail);

            if(!$validator->validate_mail($mail)) {

                echo "Invalid email.";

            }

            else if($this->mail_check($mail) < 1) {

                echo "The email address you entered is not registered";

            }

            else if($this->check_mail_verified($mail) < 1) {

                echo "The email address you entered is already verified";

            } else {
                
                $code = $token->generate_token(3); // Generate 6 char long verification code                

                $action = "create";
                $function = "verify email resend";
                $user_id = $user->get_user_id_email($mail);

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));

                // Update verification code
                $db_conn = new Database;
                $db_conn->db_update("USERS", "CODE", "EMAIL", "ss", array($code[0], $mail));

                $from = "webmaster@rajohan.no";
                $from_name = "Rajohan.no";
                $reply_to = "mail@rajohan.no";
                $subject = "Email verification code";

                $body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code[1]."<br><br>Your verification code: ".$code[1]."<br><br>If this registration was not made by you this email can be ignored.<br><br>The registration was made from IP ".$this->ip.".";
                $alt_body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code[1]."\r\n\r\nYour verification code: ".$code[1]."\r\n\r\nIf this registration was not made by you this email can be ignored.\r\n\r\nThe registration was made from IP ".$this->ip.".";
                
                $send_mail->send_mail($from, $from_name, $mail, $reply_to, $subject, $body, $alt_body);

                echo "Almost done! To confirm your email address a verification code is sent to the email address you entered. Input the verification code in the field underneath or click on the link provided in the email.";
                
                require_once("../modules/verify.php");

            }

        }


        //-------------------------------------------------
        // Method to verify the user
        //-------------------------------------------------
        
        function verify_user($mail, $code) {

            $filter = new Filter;
            $validator = new Validator;
            $user = new Users;

            $mail = $filter->sanitize($mail);
            $code = $filter->sanitize($code);

            $action = "use";
            $function = "verify email";
            $user_id = $user->get_user_id_email($mail);

            if(!$validator->validate_mail($mail)) {

                echo "Invalid email.";

            }

            else if($this->mail_check($mail) < 1) {

                echo "The email address you entered is not registered";

            }

            else if($this->check_mail_verified($mail) < 1) {

                echo "The email address you entered is already verified";

            }

            else if(!$validator->validate_token_code($code)) {

                echo "The verification code you entered is invalid.";

            }

            else if(!$this->check_code($mail, $code)) {

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 0, $user_id, $this->ip));

                echo "The verification code you entered is incorrect."; 

                require_once('../modules/verify.php');

            } else {

                // Set user to verified
                $db_conn = new Database;
                $db_conn->db_update("USERS", "EMAIL_VERIFIED", "EMAIL", "is", array(1, $mail));

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));

                echo "Thanks for registering! You can now proceed to sign in.";

                require_once("../modules/login.php");

            }

        }

    }

?>