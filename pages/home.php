<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- LANDING PAGE START -->

<?php
    
    //-------------------------------------------------
    // Require layout/module parts
    //-------------------------------------------------
    
    require_once('layout/back_to_top_button.php');     // BACK TO TOP BUTTON
    require_once('layout/header.php');                 // HEADER
    require_once('layout/navigation.php');             // NAVIGATION
    require_once('modules/about.php');                 // ABOUT
    require_once('modules/about_cta.php');             // ABOUT CTA
    require_once('modules/social_media.php');          // SOCIAL MEDIA
    require_once('modules/why_me.php');                // WHY ME
    require_once('modules/projects_short.php');        // PROJECTS
    require_once('modules/services.php');              // SERVICES
    require_once('modules/services_cta.php');          // SERVICES CTA
    require_once('modules/latest_blog.php');           // LATEST BLOG
    require_once('modules/contact_me.php');            // CONTACT ME
    require_once('layout/footer.php');                 // FOOTER

?>

<!-- LANDING PAGE END -->