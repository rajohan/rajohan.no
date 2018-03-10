<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Contact me
    //-------------------------------------------------
    
    class Contact {

        private $ip;
        private $filter;
        private $validator;
        private $send_mail;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR']; // User ip
            $this->filter = new Filter;
            $this->validator = new Validator;
            $this->send_mail = new Mail;

        }

        function send($name, $mail, $firmname, $tel, $webpage, $subject, $message) {

            $name = $this->filter->sanitize($name);
            $mail = $this->filter->sanitize($mail);
            $firmname = $this->filter->sanitize($firmname);
            $tel = $this->filter->sanitize($tel);
            $webpage = $this->filter->sanitize($webpage);
            $subject = $this->filter->sanitize($subject);
            $message = $this->filter->sanitize($message);
            $date = date('d.m.Y');
            $time = date('H:i');

            if(!$this->validator->validate_name($name)) {

                echo "Invalid name.";

            }
            
            else if(!$this->validator->validate_mail($mail)) {

                echo "Invalid email address.";

            }

            else if((!empty($firmname)) && (!$this->validator->validate_firmname($firmname))) {

                echo "Invalid company name.";

            } 

            else if((!empty($tel)) && (!$this->validator->validate_tel($tel))) {

                echo "Invalid phone number.";

            } 

            else if((!empty($webpage)) && (!$this->validator->validate_url($webpage))) {

                echo "Invalid website address.";

            }

            else if(empty($subject)) {

                echo "Subject is missing.";

            }

            else if(empty($message)) {
                
                echo "Message is missing.";

            } else {

                $db_conn = new Database;
                $db_conn->db_insert("CONTACT", "NAME, EMAIL, FIRMNAME, PHONE, WEBPAGE, SUBJECT, MESSAGE, IP", "ssssssss", array($name, $mail, $firmname, $tel, $webpage, $subject, $message, $this->ip));
                
                $to = "webmaster@rajohan.no";
                $from_name = "Rajohan.no";
                $reply_to = "mail@rajohan.no";
                
                $body = $message."<br><br>From: ".$name."<br>Email: ".$mail."<br>Firm name: ".$firmname."<br>Phone number: ".$tel."<br>Webpage: ".$webpage."<br>Date: ".$date."<br>Time: ".$time."<br>Ip: ".$this->ip;
                $alt_body = $message."\r\n\r\nFrom: ".$name."\r\nEmail: ".$mail."\r\nFirm name: ".$firmname."\r\nPhone number: ".$tel."\r\nWebpage: ".$webpage."\r\nDate: ".$date."\r\nTime: ".$time."\r\nIp: ".$this->ip;
                $this->send_mail->send_mail($mail, $from_name, $to, $reply_to, $subject, $body, $alt_body); 
                
                echo "Your message has been sent, you will receive a response within 24 hours.";
            }

        }

    }

?>
