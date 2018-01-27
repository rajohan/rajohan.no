<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
?>

<!-- SITEMAP PAGE START -->
<?php
    
    require_once('layout/back_to_top_button.php');     // BACK TO TOP BUTTON
    require_once('layout/navigation.php');             // NAVIGATION
    require_once('modules/sitemap.php');               // SITEMAP
    require_once('layout/footer.php');                 // FOOTER

?>
<!-- SITEMAP PAGE END -->