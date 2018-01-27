<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
?>

<?php

    $ssl_seal = new Ssl_seal(); // GENERATE NEW SSL SEAL LINK
    
?>
<!-- SECTION FOOTER START -->
<footer class="footer">
    <a href="<?php $ssl_seal->generate_url(); ?>" target="_blank">SSL Certificate</a> &ndash; <a href="index.php?page=legal">Legal policies</a> &ndash; <a href="index.php?page=sitemap">Sitemap</a>
    <br> 
    <?php echo $GLOBALS['copyright']; ?><a href="<?php echo$GLOBALS['url']; ?>"><?php echo $GLOBALS['program']; ?></a>, <a href="<?php echo $GLOBALS['org_link']; ?>" target="_blank"><?php echo $GLOBALS['company']; ?>.</a>
</footer>
<!-- SECTION FOOTER END -->