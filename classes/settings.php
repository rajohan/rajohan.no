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
        
        private $ip;
        private $username;
        private $user_id;
        private $mail;
        private $user;
        private $filter;
        private $validator;
        private $login;
        private $register;
        private $token;
        private $send_mail;
        private $newsletter;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR']; // User ip
            $this->user = new Users;
            $this->filter = new Filter;
            $this->validator = new Validator;
            $this->login = new Login;
            $this->register = new Register;
            $this->token = new Tokens;
            $this->send_mail = new Mail;
            $this->newsletter = new Newsletter;

            if(isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {

                $this->user_id = $this->filter->sanitize($_SESSION['USER']['ID']);
                $this->username = $this->filter->sanitize($_SESSION['USER']['USERNAME']);
                $this->mail = $this->filter->sanitize($this->user->get_user("ID", $this->user_id)['EMAIL']);

            }

        }

        //-------------------------------------------------
        // Method to check if email is already registered
        //-------------------------------------------------

        function mail_check($new_mail) {
            
            if($new_mail !== $this->mail) {

                $new_mail = $this->filter->sanitize($new_mail);

                $db_conn = new Database;
                $count = $db_conn->count("USERS", "WHERE EMAIL = ?", "s", array($new_mail));
                return $count;

            } else {

                return 0;

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

        //-------------------------------------------------
        // Change mail
        //-------------------------------------------------

        function change_mail($new_mail, $mail_hide, $newsletters) {
            
            $new_mail = $this->filter->sanitize($new_mail);
            $mail_hide = $this->filter->sanitize($mail_hide);
            $newsletters = $this->filter->sanitize($newsletters);
            $mail_verified = 1;
            $code[0] = "";

            // Validate mail
            if(!$this->validator->validate_mail($new_mail)) {

                echo "Invalid email address.";

            }

            // Check if mail address already exist if its a new mail address
            else if($this->mail_check($new_mail) > 0) {

                echo "The email address you entered is already registered.";

            } else {

                if($mail_hide === "true") {

                    $mail_hide = 1;

                } else {

                    $mail_hide = 0;
                }

                if($newsletters === "true") {

                    if($this->newsletter->check_email($new_mail) < 1) {

                        // Insert to database
                        $db_conn = new Database;
                        $db_conn->db_insert("NEWSLETTER", "EMAIL, USER, IP", "sis", array($new_mail, $this->user_id, $this->ip));

                    }

                } else {

                    if($this->newsletter->check_email($new_mail) > 0) {

                        // Delete email from newsletter table
                        $db_conn = new Database;
                        $db_conn->db_delete("NEWSLETTER", "EMAIL", "s", $new_mail);

                    }

                }

                if($new_mail !== $this->mail) {

                    $mail_verified = 0;
                    $code = $this->token->generate_token(3); // Generate 6 char long verification code

                    $action = "create";
                    $function = "verify email";

                    // Log to verification log
                    $db_conn = new Database;
                    $db_conn->db_insert("VERIFICATION_LOG", "ACTION, FUNCTION, EMAIL, SUCCESS, USER, IP", "sssiis", array($action, $function, $new_mail, 1, $this->user_id, $this->ip));

                    $from = "webmaster@rajohan.no";
                    $from_name = "Rajohan.no";
                    $reply_to = "mail@rajohan.no";
                    $subject = "Email verification code";
    
                    $body = "To complete your email change on rajohan.no please confirm your email address by typing in the verification code underneath on the verification page or click this link https://rajohan.no/verify/?email=".$new_mail."&code=".$code[1]."<br><br>Your verification code: ".$code[1]."<br><br>The email change was made from IP ".$this->ip.".";
                    $alt_body = "To complete your email change on rajohan.no please confirm your email address by typing in the verification code underneath on the verification page or click on this link https://rajohan.no/verify/?email=".$new_mail."&code=".$code[1]."\r\n\r\nYour verification code: ".$code[1]."\r\n\r\nThe email change was made from IP ".$this->ip.".";
                    
                    $this->send_mail->send_mail($from, $from_name, $new_mail, $reply_to, $subject, $body, $alt_body);

                }

                $db_conn = new Database;
                $db_conn->db_update("USERS", "EMAIL, HIDE_EMAIL, EMAIL_VERIFIED, CODE", "ID", "siisi", array($new_mail, $mail_hide, $mail_verified, $code[0], $this->user_id));

                if($mail_verified === 0) {

                    // Logout user
                    $this->login->logout();
                    echo "Email changed";

                } else {

                    echo "Email settings updated.";

                }

            }

        }

        //-------------------------------------------------
        // Social media
        //-------------------------------------------------

        function social_media($facebook, $twitter, $linkedin, $github) {
            
            $facebook = $this->filter->sanitize($facebook);
            $twitter = $this->filter->sanitize($twitter);
            $linkedin = $this->filter->sanitize($linkedin);
            $github = $this->filter->sanitize($github);

            // Validate social media links
            if((!empty($facebook)) && (!$this->validator->validate_page_url($facebook, "facebook"))) {

                echo "Invalid Facebook link.";

            }
            else if((!empty($twitter)) && (!$this->validator->validate_page_url($twitter, "twitter"))) {

                echo "Invalid Twitter link.";

            }
            else if((!empty($linkedin)) && (!$this->validator->validate_page_url($linkedin, "linkedin"))) {

                echo "Invalid LinkedIn link.";

            }
            else if((!empty($github)) && (!$this->validator->validate_page_url($github, "github"))) {

                echo "Invalid Github link.";

            } else {

                // Update email row with code
                $db_conn = new Database;
                $db_conn->db_update("USERS", "FACEBOOK, TWITTER, LINKEDIN, GITHUB", "ID", "ssssi", array($facebook, $twitter, $linkedin, $github, $this->user_id));
                echo "Your social media links have been saved.";

            }
            
        }
    
    }

?>