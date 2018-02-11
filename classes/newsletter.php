<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    if((isset($_POST['subscribe'])) && ($_POST['subscribe'] === "true") && (isset($_POST['mail']))) {

        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed

        require_once('../configs/db.php'); // Get database username, password etc
        require_once('database_handler.php'); // Database handler
        require_once('filter.php'); // Filter
        require_once('validator.php'); // Validator
       
        $newsletter = new Newsletter;
        $newsletter->subscribe($_POST['mail']);

    }

    else if((isset($_POST['unsubscribe'])) && ($_POST['unsubscribe'] === "true") && (isset($_POST['mail']))) {

        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed

        require_once('../configs/db.php'); // Get database username, password etc
        require_once('database_handler.php'); // Database handler
        require_once('filter.php'); // Filter
        require_once('validator.php'); // Validator
       
        $newsletter = new Newsletter;
        $newsletter->unsubscribe_code($_POST['mail']);

    } 
    
    else if((isset($_POST['unsubscribe_code'])) && ($_POST['unsubscribe_code'] === "true") && (isset($_POST['mail'])) && (isset($_POST['code']))) {

        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed

        require_once('../configs/db.php'); // Get database username, password etc
        require_once('database_handler.php'); // Database handler
        require_once('filter.php'); // Filter
        require_once('validator.php'); // Validator
       
        $newsletter = new Newsletter;
        $newsletter->unsubscribe($_POST['mail'], $_POST['code']);

    } else {

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }

    }

    //-------------------------------------------------
    // Newsletter
    //-------------------------------------------------

    class Newsletter {

        //-------------------------------------------------
        // Method to add email to subscription list
        //-------------------------------------------------

        function subscribe($mail) {

            $filter = new Filter;
            $validator = new Validator;

            $mail = $filter->sanitize($mail);

            // Validate email
            if($validator->validate_mail($mail)) {

                $db_conn = new Database;
                $count = $db_conn->count("NEWSLETTER", "WHERE EMAIL = '".$mail."'");

                // Check if the email is already subscribed
                if($count > 0) {

                    echo "The email address you entered is already subscribed to my newsletters.";

                } else { // Insert to database

                    $ip = $_SERVER['REMOTE_ADDR'];

                    $db_conn = new Database;
                    $db_conn->db_insert("NEWSLETTER", "EMAIL, IP", "ss", array($mail, $ip));
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

            $mail = $filter->sanitize($mail);

            // Validate email
            if($validator->validate_mail($mail)) {

                $db_conn = new Database;
                $count = $db_conn->count("NEWSLETTER", "WHERE EMAIL = '".$mail."'");

                // Check if the email is subscribed
                if($count < 1) {

                    echo "The email address you entered is not in the subscription list.";

                } else { // Insert to database

                    $ip = $_SERVER['REMOTE_ADDR'];
                    $code = substr(md5(uniqid(rand(), true)), 6, 6); // Generate 6 char long verification code
                    $date = date('Y-m-d H:i:s');

                    $db_conn = new Database;
                    $db_conn->db_update("NEWSLETTER", "CODE, IP, DATE", "EMAIL", "ssss", array($code, $ip, $date, $mail));

                    echo "To confirm your unsubscription an email with a verification code is sent to the email address you entered. Input the verification code in the field underneath or click on the link provided in the email and input the verification code.";
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

            $mail = $filter->sanitize($mail);
            $code = $filter->sanitize($code);

            // Validate email
            if($validator->validate_mail($mail)) {

                $db_conn = new Database;
                $count_email = $db_conn->count("NEWSLETTER", "WHERE EMAIL = '".$mail."'");

                $db_conn = new Database;
                $count_with_code = $db_conn->count("NEWSLETTER", "WHERE EMAIL = '".$mail."' AND CODE = '".$code."'");

                // Check if the email is subscribed
                if($count_email < 1) {

                    echo "The email address you entered is not in the subscription list.";

                } 

                // Check if the code is correct
                else if ($count_with_code < 1) {

                    echo "The verification code you entered is incorrect.";
                
                } else { // Insert to database

                    $db_conn = new Database;
                    $db_conn->db_delete("NEWSLETTER", "EMAIL", "s", $mail);
                    echo "You are now unsubscribed from my newsletters.";

                }

            } else { // Something went wrong

                echo "Sorry, an error has occurred. Please try again.";

            }

        }

    }

?>