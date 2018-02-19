<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    // Check for ajax calls to add new email to subscription list
    if((isset($_POST['subscribe'])) && ($_POST['subscribe'] === "true") && (isset($_POST['mail']))) {
       
        $newsletter = new Newsletter;

        $newsletter->require_files();
        $newsletter->subscribe($_POST['mail']);

    }

    // Check for ajax calls to generate validation code
    else if((isset($_POST['unsubscribe'])) && ($_POST['unsubscribe'] === "true") && (isset($_POST['mail']))) {

        $newsletter = new Newsletter;

        $newsletter->require_files();
        $newsletter->unsubscribe_code($_POST['mail']);

    } 
    
    // Check for ajax calls to unsubscribe with validation code
    else if((isset($_POST['unsubscribe_code'])) && ($_POST['unsubscribe_code'] === "true") && (isset($_POST['mail'])) && (isset($_POST['code']))) {
       
        $newsletter = new Newsletter;
        
        $newsletter->require_files();
        $newsletter->unsubscribe($_POST['mail'], $_POST['code']);

    }

    // Check for ajax calls to check if mail address is already subscribed
    else if ((isset($_POST['mail_subscribed_check'])) && ($_POST['mail_subscribed_check'] === "true") && (isset($_POST['mail']))) {
        
        $newsletter = new Newsletter;
        $newsletter->require_files();
        
        if($newsletter->check_email($_POST['mail']) > 0) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    } 

    // Check for ajax calls to check if mail address entered dont exist in the subscription list
    else if ((isset($_POST['mail_unsubscribe_check'])) && ($_POST['mail_unsubscribe_check'] === "true") && (isset($_POST['mail']))) {
        
        $newsletter = new Newsletter;
        $newsletter->require_files();
        
        if($newsletter->check_email($_POST['mail']) < 1) {
                
            echo "false";
        
        } else {

            echo "true";

        }

    } else {

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }

    }

    //-------------------------------------------------
    // Newsletter
    //-------------------------------------------------

    class Newsletter {

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
            require_once('mail.php'); // Mail
            require_once('tokens.php'); // Tokens
            require_once('users.php'); // Users

        }

        //-------------------------------------------------
        // Method to check if email address is in the subscription list
        //-------------------------------------------------

        function check_email($mail) {

            $filter = new Filter;
            $mail = $filter->sanitize($mail);
            
            $db_conn = new Database;
            $count = $db_conn->count("NEWSLETTER", "WHERE EMAIL = ?", "s", array($mail));

            return $count;

        }

        //-------------------------------------------------
        // Method to check if verification code is correct
        //-------------------------------------------------

        function check_code($mail, $code) {

            $filter = new Filter;
            $mail = $filter->sanitize($mail);
            $code = $filter->sanitize($code);

            // Get token
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `CODE` FROM `NEWSLETTER` WHERE `EMAIL` = ? LIMIT 1");
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
        // Method to add email to subscription list
        //-------------------------------------------------

        function subscribe($mail) {

            $filter = new Filter;
            $validator = new Validator;
            $user = new Users;

            $mail = $filter->sanitize($mail);

            // Validate email
            if($validator->validate_mail($mail)) {

                // Check if the email is already subscribed
                if($this->check_email($mail) > 0) {

                    echo "The email address you entered is already subscribed to my newsletters.";

                } else { // Insert to database

                    $user_id = $user->get_user_id_email($mail);

                    $db_conn = new Database;
                    $db_conn->db_insert("NEWSLETTER", "EMAIL, USER, IP", "sis", array($mail, $user_id, $this->ip));
                    echo "Thanks! You are now subscribed to my newsletters.";

                }

            } else { // Something went wrong

                echo "Sorry, an error has occurred. Please try again.";

            }

        }

        //-------------------------------------------------
        // Method to generate verification code and add it to database
        //-------------------------------------------------

        function unsubscribe_code($mail) {
            
            $filter = new Filter;
            $validator = new Validator;
            $send_mail = new Mail;
            $token = new Tokens;
            $user = new Users;

            $mail = $filter->sanitize($mail);

            // Validate email
            if($validator->validate_mail($mail)) {

                // Check if the email is subscribed
                if($this->check_email($mail) < 1) {

                    echo "The email address you entered is not in the subscription list.";

                } else { // Insert to database

                    $code = $token->generate_token(3); // Generate 6 char long verification code
                    $action = "create";
                    $function = "unsubscribe";
                    $user_id = $user->get_user_id_email($mail);

                    // Update email row with code
                    $db_conn = new Database;
                    $db_conn->db_update("NEWSLETTER", "CODE", "EMAIL", "ss", array($code[0], $mail));

                    // Log to verification log
                    $db_conn = new Database;
                    $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));

                    $from = "webmaster@rajohan.no";
                    $from_name = "Rajohan.no";
                    $reply_to = "mail@rajohan.no";
                    $subject = "Newsletter unsubscription verification code";

                    $body = "A request to unsubscribe from rajohan.no's newsletters was made from IP ".$this->ip.".<br><br>To confirm your unsubscription please type in the verification code underneath on the page you requested the unsubscription on or click on this link https://rajohan.no/unsubscribe/?email=".$mail."&code=".$code[1]."<br><br>Your verification code: ".$code[1]."<br><br>If this unsubscription was not requested by you this email can be ignored.";
                    
                    $alt_body = "A request to unsubscribe from rajohan.no's newsletters was made from IP ".$this->ip.".\r\n\r\nTo confirm your unsubscription please type in the verification code underneath on the page you requested the unsubscription on or click on this link https://rajohan.no/unsubscribe/?email=".$mail."&code=".$code[1]."\r\n\r\nYour verification code: ".$code[1]."\r\n\r\nIf this unsubscription was not requested by you this email can be ignored.";
                    
                    $send_mail->send_mail($from, $from_name, $mail, $reply_to, $subject, $body, $alt_body);

                    echo "To confirm your unsubscription an email with a verification code is sent to the email address you entered. Input the verification code in the field underneath or click on the link provided in the email.";
                    require_once('../modules/newsletter_unsubscribe.php');
                    
                }

            } else { // Something went wrong

                echo "Sorry, an error has occurred. Please try again.";

            }

        }

        //-------------------------------------------------
        // Method to remove email from subscription list
        //-------------------------------------------------

        function unsubscribe($mail, $code) {
            
            $filter = new Filter;
            $validator = new Validator;
            $user = new Users;

            $mail = $filter->sanitize($mail);
            $code = $filter->sanitize($code);

            $action = "use";
            $function = "unsubscribe";
            $user_id = $user->get_user_id_email($mail);

            // Validate email
            if($validator->validate_mail($mail)) {

                $db_conn = new Database;
                $count_with_code = $db_conn->count("NEWSLETTER", "WHERE EMAIL = ? AND CODE = ?", "ss", array($mail, $code));

                // Check if the email is subscribed
                if($this->check_email($mail) < 1) {

                    echo "The email address you entered is not in the subscription list.";

                }
                
                // Check if the code is equal to 6 chars 
                else if (!$validator->validate_token_code($code)) {

                    echo "The verification code you entered is invalid.";

                }

                // Check if the code is correct
                else if (!$this->check_code($mail, $code)) {

                    // Log to verification log
                    $db_conn = new Database;
                    $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 0, $user_id, $this->ip));

                    echo "The verification code you entered is incorrect.";

                    require_once('../modules/newsletter_unsubscribe.php');
                
                } else { // Insert to database

                    // Delete email from newsletter table
                    $db_conn = new Database;
                    $db_conn->db_delete("NEWSLETTER", "EMAIL", "s", $mail);

                    // Log to verification log
                    $db_conn = new Database;
                    $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $mail, 1, $user_id, $this->ip));
                    
                    echo "You are now unsubscribed from my newsletters.";

                }

            } else { // Something went wrong

                echo "Sorry, an error has occurred. Please try again.";

            }

        }

    }

?>