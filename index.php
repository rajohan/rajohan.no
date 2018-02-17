<?php

    //-------------------------------------------------
    // Define INCLUDE (Allow to include other pages)
    //-------------------------------------------------

    if (!defined('INCLUDE')) {

        define('INCLUDE','true');

    }

    //-------------------------------------------------
    //  Start output buffering & start a new session
    //-------------------------------------------------
    
    ob_start();

    if (session_status() == PHP_SESSION_NONE) {
     
        session_start();
   
    }

    //-------------------------------------------------
    // Require classes
    //-------------------------------------------------

    require_once('configs/db.php');                // Get database username, password etc
    require_once('classes/database_handler.php');  // DATABASE HANDLER
    require_once('classes/filter.php');            // FILTER
    require_once('classes/bbcode.php');            // BBCODE
    require_once('configs/config.php');            // CONFIG
    require_once('classes/page_handler.php');      // PAGE HANDLER
    require_once('classes/pagination.php');        // PAGINATION
    require_once('classes/tags.php');              // TAGS
    require_once('classes/converter.php');         // CONVERTER
    require_once('classes/sort.php');              // SORTER
    require_once('classes/vote.php');              // VOTE
    require_once('classes/views.php');             // VIEWS
    require_once('classes/comments.php');          // COMMENTS
    require_once('classes/users.php');             // USERS
    require_once('classes/validator.php');         // VALIDATOR
    require_once('classes/newsletter.php');        // NEWSLETTER
    require_once('classes/mail.php');              // MAIL
    require_once('classes/register.php');          // REGISTER
    require_once('classes/tokens.php');            // TOKENS
    require_once('classes/login.php');             // LOGIN
    require_once('classes/ssl_seal.php');          // SSL SEAL

    //-------------------------------------------------
    // Initialize classes
    //-------------------------------------------------
    
    $page = new Page_handler;
    $login = new Login;

    if((isset($_COOKIE['REMEMBER_ME_TOKEN'])) && (!isset($_SESSION['LOGGED_IN']))) {
        
        $login->check_remember(); // Try to login with cookie
        
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
        <base href="/">
        <link rel="shortcut icon" type="image/png" href="img/favicon/favicon.png">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <?php

            //-------------------------------------------------
            // Include page equal to 'page' parameter in url
            //-------------------------------------------------

            $page->get_page();

        ?>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/img_carousel.js"></script>
        <script src="js/contact_me.js"></script>
        <script src="js/newsletter.js"></script>
        <script src="js/register.js"></script>
        <script src="js/login.js"></script>
    </body>
  </head>
</html>

<?php

    //-------------------------------------------------
    // End output buffering
    //-------------------------------------------------

    ob_end_flush();

?>
