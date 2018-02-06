<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SERVICES PAGE START -->

<?php
    
    //-------------------------------------------------
    // Require layout/module parts
    //-------------------------------------------------
    
    require_once('layout/back_to_top_button.php');     // BACK TO TOP BUTTON
    require_once('layout/navigation.php');             // NAVIGATION
    require_once('modules/services.php');              // SERVICES
    require_once('modules/services_extended.php');     // SERVICES EXTENDED
    require_once('modules/contact_me.php');            // CONTACT
    require_once('layout/footer.php');                 // FOOTER

?>

<!-- SERVICES PAGE END -->