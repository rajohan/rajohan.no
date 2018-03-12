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
    require_once('classes/autoloader.php');        // Autoload classes needed
    require_once('configs/config.php');            // Config
    

    //-------------------------------------------------
    // Initialize classes
    //-------------------------------------------------
    
    $page = new Page_handler;
    $login = new Login;
    $traffic = new Traffic;

    //-------------------------------------------------
    // Check session token and generate new token & logout user if its incorrect
    //-------------------------------------------------

    if($login->login_check()) {

        if(!$login->session_check()) {

            $login->logout();
            header('Location: /home/');

        }

    }

    //-------------------------------------------------
    // Add traffic to db
    //-------------------------------------------------

    $traffic->add_traffic();

    //-------------------------------------------------
    // Login user if cookie is set and valid
    //-------------------------------------------------

    if((isset($_COOKIE['REMEMBER_ME_TOKEN'])) && (!isset($_SESSION['LOGGED_IN']))) {
        
        $login->check_remember(); // Try to login with cookie
        
    }

?>

<!DOCTYPE html>
<html lang="<?php echo $GLOBALS['language']; ?>">
    <head>
        <meta charset="<?php echo $GLOBALS['charset']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
        <script src="js/forgot.js"></script>
        <script src="js/text_editor.js"></script>
        <script src="js/syntax_highlighting.js"></script>
        <script src="js/comment.js"></script>
        <script src="js/settings.js"></script>
        <script src="js/image_uploader.js"></script>
    </body>
  </head>
</html>

<?php

    //-------------------------------------------------
    // End output buffering
    //-------------------------------------------------

    ob_end_flush();

?>
