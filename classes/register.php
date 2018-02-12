<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    // Check for ajax calls to check if username is taken
    if((isset($_POST['register_username_check'])) && ($_POST['register_username_check'] === "true") && (isset($_POST['register_username']))) {
       
        $register = new Register;
        $register->require_files();

        if($register->username_check($_POST['register_username']) > 0) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    }

    // Check for ajax calls to check if email is already registered
    else if((isset($_POST['register_mail_check'])) && ($_POST['register_mail_check'] === "true") && (isset($_POST['register_mail']))) {
        
        $register = new Register;
        $register->require_files();

        if($register->email_check($_POST['register_mail']) > 0) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    }
    
    // Check for ajax calls to check if email is already registered
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

        }

        //-------------------------------------------------
        // Method to check if username is taken
        //-------------------------------------------------

        function username_check($username) {

            $db_conn = new Database;
            $filter = new Filter;
            $username = $filter->sanitize($username);

            $count = $db_conn->count("USERS", "WHERE USERNAME = '".$username."'");

            return $count;

        }

        //-------------------------------------------------
        // Method to check if email is already registered
        //-------------------------------------------------

        function email_check($mail) {

            $db_conn = new Database;
            $filter = new Filter;
            $mail = $filter->sanitize($mail);

            $count = $db_conn->count("USERS", "WHERE EMAIL = '".$mail."'");

            return $count;

        }

        //-------------------------------------------------
        // Method to register a new user
        //-------------------------------------------------

        function register_user($username, $mail, $password, $password_repeat) {

            $filter = new Filter;
            $validator = new Validator;
            $send_mail = new Mail;

            $username = $filter->sanitize($username);
            $mail = $filter->sanitize($mail);
            $password = $filter->sanitize($password);
            $password_repeat = $filter->sanitize($password_repeat);
            
            // Invalid username
            if(!$validator->validate_username($username)) {

                echo "Invalid username. Minimum 5 and max 15 characters. Only letters and numbers are allowed.";

            }

            // Invalid email
            elseif(!$validator->validate_mail($mail)) {

                echo "Invalid email address.";

            }

            // Username taken
            elseif($this->username_check($username) > 0) {

                echo "Username is already taken.";

            }

            // Email already registered
            elseif($this->email_check($mail) > 0) {

                echo "The email address you entered is already registered.";

            }

            // Password fields does not match
            elseif($password !== $password_repeat) {

                echo "The password fields does not match.";

            }

            // Invalid password
            elseif(!$validator->validate_password($password)) {

                echo "Invalid password. Minimum 6 characters.";

            } else { // Register user

                $ip = $_SERVER['REMOTE_ADDR'];
                $code = substr(md5(uniqid(rand(), true)), 6, 6); // Generate 6 char long verification code
                $password = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password

                $db_conn = new Database;
                $db_conn->db_insert("USERS", "USERNAME, PASSWORD, EMAIL, CODE, IP", "sssss", array($username, $password, $mail, $code, $ip));

                $from = "webmaster@rajohan.no";
                $from_name = "Rajohan.no";
                $reply_to = "mail@rajohan.no";
                $subject = "Email verification code";

                $body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code."<br><br>Your verification code: ".$code."<br><br>If this registration was not made by you this email can be ignored.<br><br>The registration was made from IP ".$ip.".";
                $alt_body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code."\r\n\r\nYour verification code: ".$code."\r\n\r\nIf this registration was not made by you this email can be ignored.\r\n\r\nThe registration was made from IP ".$ip.".";
                
                $send_mail->send_mail($from, $from_name, $mail, $reply_to, $subject, $body, $alt_body);

                echo "Almost done! To confirm your email address a verification code is sent to the email address you entered. Input the verification code in the field underneath or click on the link provided in the email.";

            }

        }

    }

?>