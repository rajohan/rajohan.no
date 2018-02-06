<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>
<!-- SECTION SOCIAL MEDIA START -->
<section class="social-media u-margin-top-small">
    <a href="<?php echo $GLOBALS['facebook']; ?>" target="_blank" class="social-media__link">
        <img src="img/icons/facebook.svg" alt="Facebook" class="social-media__img">
    </a>
    <a href="<?php echo $GLOBALS['twitter']; ?>" target="_blank" class="social-media__link">
        <img src="img/icons/twitter.svg" alt="Twitter" class="social-media__img">
    </a>
    <a href="<?php echo $GLOBALS['linkedin']; ?>" target="_blank" class="social-media__link">
        <img src="img/icons/linkedin.svg" alt="LinkedIn" class="social-media__img">
    </a>
    <a href="<?php echo $GLOBALS['github']; ?>" target="_blank" class="social-media__link">
        <img src="img/icons/github.svg" alt="Github" class="social-media__img">
    </a>
    <a href="mailto:<?php echo $GLOBALS['mail']; ?>" class="social-media__link">
        <img src="img/icons/mail.svg" alt="Mail" class="social-media__img">
    </a>
</section>
<!-- SECTION SOCIAL MEDIA END -->