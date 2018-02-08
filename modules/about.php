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
    // Get the about page
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT `TITLE`, `SUB_TITLE`, `ABOUT` FROM `ABOUT` ORDER BY `ID` DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
 
    while ($row = $result->fetch_assoc()) {

        $title = $filter->sanitize($row['TITLE']);
        $sub_title = $filter->sanitize($row['SUB_TITLE']);
        $about = $bbcode->replace($filter->sanitize($row['ABOUT']));
 
    }

    $db_conn->free_close($result, $stmt);
    
?>

<!-- SECTION ABOUT START -->
<section class="about u-margin-top-medium">
    <h1 class="heading-secondary letter-spacing-medium"><?php echo $title; ?></h1>
    <h1 class="heading-tertiary"><?php echo $sub_title; ?></h1>
    <p class="about__text u-margin-top-medium">
        <?php
            echo $about;
        ?>
    </p>
</section>
<!-- SECTION ABOUT END -->