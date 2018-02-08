<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Initialize classes
    //-------------------------------------------------
 
    $db_conn = new Database;
    $filter = new Filter;
    $bbcode = new Bbcode;
    
    //-------------------------------------------------
    // Get the why me page
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT `TITLE`, `WHY_ME` FROM `WHY_ME` ORDER BY `ID` DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
 
    while ($row = $result->fetch_assoc()) {

        $title = $filter->sanitize($row['TITLE']);
        $why_me = $bbcode->replace($filter->sanitize($row['WHY_ME']));
 
    }

    $db_conn->free_close($result, $stmt);
    
?>


<!-- SECTION WHY ME START -->
<section class="why-me u-margin-top-medium">
    <h1 class="heading-primary heading-primary--sub2 u-center-text">
        <?php echo $title; ?>
    </h1>
    <p class="why-me__text u-margin-top-small">
        <?php echo $why_me; ?>
    </p>
    <a href="contact/" class="btn btn--primary u-margin-top-medium">Contact me today!</a>  
</section>
<!-- SECTION WHY ME END -->