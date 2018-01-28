<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $bbcode = new Bbcode(); // Start bbcode parser
    
    $stmt = $db_conn->connect->prepare("SELECT TITLE, WHY_ME FROM `WHY_ME` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
    while ($row = $result->fetch_assoc()) {

        $title = $filter->sanitize($row['TITLE']);
        $why_me = $bbcode->replace($filter->sanitize($row['WHY_ME']));
 
    }

    $db_conn->free_close($result, $stmt); // free result and close db connection
    
?>


<!-- SECTION WHY ME START -->
<section class="section-why-me u-margin-top-medium">
    <h1 class="heading-primary heading-primary--sub2 u-center-text">
        <?php echo $title; ?>
    </h1>
    <p class="section-why-me__text u-margin-top-small">
        <?php echo $why_me; ?>
    </p>
    <a href="contact/" class="btn btn--primary u-margin-top-medium">Contact me today!</a>  
</section>
<!-- SECTION WHY ME END -->