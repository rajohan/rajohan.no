<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    //-------------------------------------------------
    // Mail
    //-------------------------------------------------

    class mail {

        function send_mail($from, $from_name, $recipient, $reply_to, $subject, $body, $alt_body) {
            require('../phpmailer/PHPMailerAutoload.php');
            $mail = new PHPMailer;
            ###########################################################################
            # Mail function
            ###########################################################################
            // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->CharSet="UTF-8";  // Charset used
            $mail->Host = 'mail.rajohan.no'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'webmaster@rajohan.no'; // SMTP username
            $mail->Password = '12sofie12'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to
            $mail->From = $from; // The mail address the mail is from
            $mail->FromName = $from_name; // The name mail is from
            $mail->addAddress($recipient); // Add a recipient
            $mail->addReplyTo($reply_to); // Reply to
            //$mail->addCC('webmaster@rajohan.no');
            //$mail->addBCC('mail@rajohan.no');
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject =  $subject; // The subject
            $mail->Body    = $body; // The body
            $mail->AltBody = $alt_body; // The alt body
            if(!$mail->send()) {
            echo $GLOBALS['error'];
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
            }
        }
        
    }

?>