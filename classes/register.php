<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
            
    }

    //-------------------------------------------------
    // Register
    //-------------------------------------------------

    class Register {

        private $ip;
        private $filter;
        private $validator;
        private $send_mail;
        private $user;
        private $tokens;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->filter = new Filter;
            $this->validator = new Validator;
            $this->send_mail = new Mail;
            $this->user = new Users;
            $this->token = new Tokens;

        }

        //-------------------------------------------------
        // Method to check if email is already registered
        //-------------------------------------------------

        function mail_check($mail) {
            
            $mail = $this->filter->sanitize($mail);

            $db_conn = new Database;
            $count = $db_conn->count("USERS", "WHERE EMAIL = ?", "s", array($mail));

            return $count;

        }

        //-------------------------------------------------
        // Method to check if email is equal to registered username's email
        //-------------------------------------------------

        function username_mail_check($username, $mail) {

            $username = $this->filter->sanitize($username);
            $mail = $this->filter->sanitize($mail);

            $db_conn = new Database;
            $count = $db_conn->count("USERS", "WHERE USERNAME = ? AND EMAIL = ?", "ss", array($username, $mail));

            return $count;

        }

        //-------------------------------------------------
        // Method to check if email not are verified
        //-------------------------------------------------

        function check_mail_verified($mail) {

            $mail = $this->filter->sanitize($mail);
            
            $db_conn = new Database;
            $count = $db_conn->count("USERS", "WHERE EMAIL = ? AND EMAIL_VERIFIED < 1", "s", array($mail));

            return $count;

        }

        //-------------------------------------------------
        // Method to check if code matches the assigned code to email
        //-------------------------------------------------

        function check_code($mail, $code) {

            $mail = $this->filter->sanitize($mail);
            $code = $this->filter->sanitize($code);

            // Get token
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `CODE` FROM `USERS` WHERE `EMAIL` = ? LIMIT 1");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $db_code = $this->filter->sanitize($row['CODE']);

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
        // Method to check if code matches the assigned code to email
        //-------------------------------------------------

        function forgot_password_verify_code($user_id, $code) {

            $user_id = $this->filter->sanitize($user_id);
            $code = $this->filter->sanitize($code);

            // Get token
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `PASSWORD_CODE` FROM `USERS` WHERE `ID` = ? LIMIT 1");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $db_code = $this->filter->sanitize($row['PASSWORD_CODE']);

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

            $username = $this->filter->sanitize($username);
            $mail = $this->filter->sanitize($mail);
            $password = $this->filter->sanitize($password);
            $password_repeat = $this->filter->sanitize($password_repeat);
            
            // Invalid username
            if(!$this->validator->validate_username($username)) {

                echo "Invalid username. Minimum 5 and max 15 characters. Only letters and numbers are allowed.";

            }

            // Invalid email
            else if(!$this->validator->validate_mail($mail)) {

                echo "Invalid email address.";

            }

            // Username taken
            else if($this->user->username_check($username) > 0) {

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
            else if(!$this->validator->validate_password($password)) {

                echo "Invalid password. Minimum 6 characters.";

            } else { // Register user

                $code = $this->token->generate_token(3); // Generate 6 char long verification code
                $password = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password

                // Create user
                $db_conn = new Database;
                $db_conn->db_insert("USERS", "USERNAME, PASSWORD, EMAIL, CODE, IP", "sssss", array($username, $password, $mail, $code[0], $this->ip));

                $action = "create";
                $function = "verify email";
                $user_id = $this->user->get_user("EMAIL", $mail)['ID'];

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));

                $from = "webmaster@rajohan.no";
                $from_name = "Rajohan.no";
                $reply_to = "mail@rajohan.no";
                $subject = "Email verification code";

                $body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code[1]."<br><br>Your verification code: ".$code[1]."<br><br>If this registration was not made by you this email can be ignored.<br><br>The registration was made from IP ".$this->ip.".";
                $alt_body = "To complete your registration on rajohan.no please confirm your email address by typing in the verification code underneath on the registration page or click on this link https://rajohan.no/verify/?email=".$mail."&code=".$code[1]."\r\n\r\nYour verification code: ".$code[1]."\r\n\r\nIf this registration was not made by you this email can be ignored.\r\n\r\nThe registration was made from IP ".$this->ip.".";
                
                $this->send_mail->send_mail($from, $from_name, $mail, $reply_to, $subject, $body, $alt_body);

                echo "Almost done! To confirm your email address a verification code is sent to the email address you entered. Input the verification code in the field underneath or click on the link provided in the email.";
                
                require_once("../modules/verify.php");

            }

        }

        //-------------------------------------------------
        // Method to resend email verification code
        //-------------------------------------------------

        function resend_code($mail) {
            
            $mail = $this->filter->sanitize($mail);

            if(!$this->validator->validate_mail($mail)) {

                echo "Invalid email.";

            }

            else if($this->mail_check($mail) < 1) {

                echo "The email address you entered is not registered";

            }

            else if($this->check_mail_verified($mail) < 1) {

                echo "The email address you entered is already verified";

            } else {
                
                $code = $this->token->generate_token(3); // Generate 6 char long verification code                

                $action = "create";
                $function = "verify email resend";
                $user_id = $this->user->get_user("EMAIL", $mail)['ID'];

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
                
                $this->send_mail->send_mail($from, $from_name, $mail, $reply_to, $subject, $body, $alt_body);

                echo "Almost done! To confirm your email address a verification code is sent to the email address you entered. Input the verification code in the field underneath or click on the link provided in the email.";
                
                require_once("../modules/verify.php");

            }

        }

        //-------------------------------------------------
        // Method to verify the user
        //-------------------------------------------------
        
        function verify_user($mail, $code) {

            $mail = $this->filter->sanitize($mail);
            $code = $this->filter->sanitize($code);

            $action = "use";
            $function = "verify email";
            $user_id = $this->user->get_user("EMAIL", $mail)['ID'];

            if(!$this->validator->validate_mail($mail)) {

                echo "Invalid email.";

            }

            else if($this->mail_check($mail) < 1) {

                echo "The email address you entered is not registered";

            }

            else if($this->check_mail_verified($mail) < 1) {

                echo "The email address you entered is already verified";

            }

            else if(!$this->validator->validate_token_code($code)) {

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

        //-------------------------------------------------
        // Method to create verification code for forgot password
        //-------------------------------------------------
        
        function forgot_password($username, $mail) {
            
            $username = $this->filter->sanitize($username);
            $mail = $this->filter->sanitize($mail);
            $user_id = $this->user->get_user("USERNAME", $username)['ID'];

            $action = "request code";
            $function = "forgot password";

            // Invalid username
            if(!$this->validator->validate_username($username)) {

                echo "Invalid username. Minimum 5 and max 15 characters. Only letters and numbers are allowed.";

            }

            // Invalid email
            else if(!$this->validator->validate_mail($mail)) {

                echo "Invalid email address.";

            }

            // Check that email entered equals username's registered email
            else if($this->username_mail_check($username, $mail) < 1) {

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 0, $user_id, $this->ip));

                echo "Username does not exist or the email address entered is not the same as the one registered with the username entered.";

            } else {

                $code = $this->token->generate_token(4); // Generate 8 char long verification code
                $mail = $this->user->get_user("ID", $user_id)['EMAIL'];

                // Update email row with code
                $db_conn = new Database;
                $db_conn->db_update("USERS", "PASSWORD_CODE", "USERNAME", "ss", array($code[0], $username));

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));

                $from = "webmaster@rajohan.no";
                $from_name = "Rajohan.no";
                $reply_to = "mail@rajohan.no";
                $subject = "Password reset verification code";

                $body = "A request to reset your user accounts password on rajohan.no was made from IP ".$this->ip.".<br><br>To reset your password please type in the verification code underneath on the page you requested the password reset on or click on this link https://rajohan.no/forgot_verify/?user=".$username."&code=".$code[1]."<br><br>Your verification code: ".$code[1]."<br><br>If this password reset was not requested by you this email can be ignored.";
                
                $alt_body = "A request to reset your user accounts password on rajohan.no was made from IP ".$this->ip.".\r\n\r\nTo reset your password please type in the verification code underneath on the page you requested the password reset on or click on this link https://rajohan.no/forgot_verify/?user=".$username."&code=".$code[1]."\r\n\r\nYour verification code: ".$code[1]."\r\n\r\nIf this password reset was not requested by you this email can be ignored.";
                
                $this->send_mail->send_mail($from, $from_name, $mail, $reply_to, $subject, $body, $alt_body);

                echo "To confirm your password reset a email with a verification code is sent to the entered user accounts email address. Input the verification code in the field underneath or click on the link provided in the email and choose a new password.";
                require_once('../modules/forgot_verify.php');

            }

        }

        //-------------------------------------------------
        // Method to reset user password
        //-------------------------------------------------
        
        function forgot_password_verify($username, $code, $password, $password_repeat) {
            
            $username = $this->filter->sanitize($username);
            $code = $this->filter->sanitize($code);
            $password = $this->filter->sanitize($password);
            $password_repeat = $this->filter->sanitize($password_repeat);

            $user_data = $this->user->get_user("USERNAME", $username);
            $user_id = $user_data['ID'];
            $mail = $user_data['EMAIL'];

            $action = "reset password";
            $function = "forgot password";

            // Invalid username
            if(!$this->validator->validate_username($username)) {

                echo "Invalid username. Minimum 5 and max 15 characters. Only letters and numbers are allowed.";

            }

            // Invalid email
            else if(!$this->validator->validate_forgot_password_code($code)) {

                echo "Invalid verification code.";

            }

            // Check that code entered equals username's verification code
            else if(!$this->forgot_password_verify_code($user_id, $code)) {

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 0, $user_id, $this->ip));

                echo "Username does not exist or the code you entered is incorrect.";

                require_once('../modules/forgot_verify.php');
                
            } 
            
            // Password fields does not match
            else if($password !== $password_repeat) {

                echo "The password fields does not match.";

            }

            // Invalid password
            else if(!$this->validator->validate_password($password)) {

                echo "Invalid password. Minimum 6 characters.";

            } else {

                $code = "";
                $password = password_hash($password, PASSWORD_DEFAULT); // Encrypt the password

                // Update email row with code
                $db_conn = new Database;
                $db_conn->db_update("USERS", "PASSWORD, PASSWORD_CODE", "ID", "ssi", array($password, $code, $user_id));

                // Log to verification log
                $db_conn = new Database;
                $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));

                echo "Your password have been successfully changed. You can now proceed to login";

                require_once('../modules/login.php');

            }

        }

    }

?>