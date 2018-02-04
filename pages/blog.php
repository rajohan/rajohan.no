<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
?>

<!-- BLOG PAGE START -->
<?php
    
    require_once('layout/back_to_top_button.php');              // BACK TO TOP BUTTON
    require_once('layout/navigation.php');                      // NAVIGATION
    echo '<section class="blog-short u-margin-top-medium">';    // SECTION START
    require_once('modules/blog.php');                           // BLOG
    require_once('layout/blog_nav.php');                       // BLOG NAV
    echo '</section>';                                          // SECTION END
    require_once('layout/footer.php');                          // FOOTER

?>
<!-- BLOG PAGE END -->