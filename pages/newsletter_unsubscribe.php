<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- NEWSLETTER UNSUBSCRIBE PAGE START -->

<?php
    
    //-------------------------------------------------
    // Require layout/module parts
    //-------------------------------------------------
    
    require_once('layout/back_to_top_button.php');                    // BACK TO TOP BUTTON
    require_once('layout/navigation.php');                            // NAVIGATION
    echo '<section class="newsletter__code u-margin-top-medium">';    // SECTION START
    require_once('modules/newsletter_unsubscribe.php');               // NEWSLETTER UNSUBSCRIBE
    require_once('layout/blog_nav.php');                              // BLOG NAV
    echo '</section>';                                                // SECTION END
    require_once('layout/footer.php');                                // FOOTER

?>

<!-- NEWSLETTER UNSUBSCRIBE PAGE END -->