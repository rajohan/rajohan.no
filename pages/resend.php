<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- RESEND PAGE START -->

<?php
    
    //-------------------------------------------------
    // Require layout/module parts
    //-------------------------------------------------
    
    require_once('layout/back_to_top_button.php');              // BACK TO TOP BUTTON
    require_once('layout/navigation.php');                      // NAVIGATION
    echo '<section class="wrapper u-margin-top-medium">';       // SECTION START
    require_once('modules/resend.php');                         // RESEND
    require_once('layout/blog_nav.php');                        // BLOG NAV
    echo '</section>';                                          // SECTION END
    require_once('layout/footer.php');                          // FOOTER

?>

<!-- RESEND PAGE END -->