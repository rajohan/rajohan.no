<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- ABOUT PAGE START -->

<?php

    //-------------------------------------------------
    // Require layout/module parts
    //-------------------------------------------------

    require_once('layout/back_to_top_button.php');     // BACK TO TOP BUTTON
    require_once('layout/navigation.php');             // NAVIGATION
    require_once('modules/about.php');                 // ABOUT
    require_once('modules/social_media.php');          // SOCIAL MEDIA
    require_once('modules/cv.php');                    // CV
    require_once('modules/computer_setup.php');        // COMPUTER SETUP
    require_once('layout/footer.php');                 // FOOTER

?>

<!-- ABOUT PAGE END -->