<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- ADMIN PAGE START -->

<?php
    
    //-------------------------------------------------
    // Require layout/module parts
    //-------------------------------------------------
    
    require_once('layout/back_to_top_button.php');              // BACK TO TOP BUTTON
    require_once('layout/navigation.php');                      // NAVIGATION
    echo '<section class="wrapper u-margin-top-medium">';       // SECTION START
    require_once('modules/admin.php');                          // ADMIN
    require_once('layout/admin_nav.php');                       // ADMIN NAV
    echo '</section>';                                          // SECTION END
    require_once('layout/footer.php');                          // FOOTER

?>

<!-- ADMIN PAGE END -->