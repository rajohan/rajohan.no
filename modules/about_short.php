<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $bbcode = new Bbcode(); // Start bbcode parser
    
    $stmt = $db_conn->connect->prepare("SELECT * FROM `ABOUT` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
    while ($row = $result->fetch_assoc()) {

        $id = $filter->sanitize($row['ID']);
        $title = $filter->sanitize($row['TITLE']);
        $sub_title = $filter->sanitize($row['SUB_TITLE']);
        $about = $bbcode->replace($filter->sanitize($row['ABOUT']));
 
    }

    $db_conn->free_close($result, $stmt);
?>

<!-- SECTION ABOUT START -->
<section class="section-about u-margin-top-medium u-margin-bottom-medium">
    <h1 class="heading-secondary letter-spacing-medium"><?php echo $title; ?></h1>
    <h1 class="heading-tertiary"><?php echo $sub_title; ?></h1>
    <p class="section-about__text u-margin-top-medium">
        <?php
            echo $about;
        ?>
    </p>
    <div class="section-about__cta">
        <a href="index.php?page=about" class="btn btn--secondary u-margin-top-medium">More about me</a>
        <a href="index.php?page=services" class="btn btn--secondary u-margin-sides-medium u-margin-top-medium">View services</a>    
        <a href="index.php?page=contact" class="btn btn--secondary u-margin-top-medium">Contact me</a>  
    </div>
    <div class="section-about__social">
        <a href="<?php echo $GLOBALS['facebook']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/facebook.svg" alt="Facebook" class="section-about__social--img">
        </a>
        <a href="<?php echo $GLOBALS['twitter']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/twitter.svg" alt="Twitter" class="section-about__social--img">
        </a>
        <a href="<?php echo $GLOBALS['linkedin']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/linkedin.svg" alt="LinkedIn" class="section-about__social--img">
        </a>
        <a href="<?php echo $GLOBALS['github']; ?>" target="_blank" class="section-about__social--link">
            <img src="img/icons/github.svg" alt="Github" class="section-about__social--img">
        </a>
        <a href="mailto:<?php echo $GLOBALS['mail']; ?>" class="section-about__social--link">
            <img src="img/icons/mail.svg" alt="Mail" class="section-about__social--img">
        </a>
    </div>
</section>
<!-- SECTION ABOUT END -->