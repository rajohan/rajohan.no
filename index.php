<?php

    if (!defined('INCLUDE')) {

        define('INCLUDE','true'); // Define INCLUDE to be able to show/use the files

    }

    require_once('configs/db.php');                // Get database username, password etc
    require_once('classes/database_handler.php');  // DATABASE HANDLER
    require_once('classes/filter.php');            // FILTER
    require_once('classes/bbcode.php');            // BBCODE
    require_once('configs/config.php');            // CONFIG
    require_once('classes/page_handler.php');      // PAGE HANDLER
    require_once('classes/ssl_seal.php');          // SSL SEAL

    ob_start(); // start output buffering

    $page = new Page_handler(); // Request new page

    if (session_status() == PHP_SESSION_NONE) {
     
        session_start(); // start a new session, if its not allready started
   
    }
    
?>

<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['language']; ?>">
    <head>
        <meta charset="<?php echo $GLOBALS['charset']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="<?php echo $GLOBALS['bot']; ?>">
        <meta name="description" content="<?php echo $GLOBALS['desc']; ?>">
        <meta name="keywords" content="<?php echo $GLOBALS['keywords']; ?>">
        <meta name="author" content="<?php echo $GLOBALS['author'].", ".$GLOBALS['company']; ?>">
        <meta name="google-site-verification" content="<?php echo $GLOBALS['gwebmaster'] ?>">
        <meta name="copyrighted-site-verification" content="<?php echo $GLOBALS['csvmaster']; ?>">
        <title><?php $page->page_title(); ?></title>
        <link href="<?php echo $GLOBALS['font']; ?>">
        <base href="/designv2/">
        <link rel="shortcut icon" type="image/png" href="img/favicon/favicon.png">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php

            $page->get_page(); // Include page equal to 'page' parameter in url

        ?>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/img_carousel.js"></script>
        <script src="js/contact_me.js"></script>
    </body>
  </head>
</html>

<?php
    ob_end_flush(); // We are done and are ending the output buffering
?>
