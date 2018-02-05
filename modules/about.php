<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database; // connect to database
    $filter = new Filter; // Start filter
    $bbcode = new Bbcode; // Start bbcode parser
    
    $stmt = $db_conn->connect->prepare("SELECT TITLE, SUB_TITLE, ABOUT FROM `ABOUT` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
    while ($row = $result->fetch_assoc()) {

        $title = $filter->sanitize($row['TITLE']);
        $sub_title = $filter->sanitize($row['SUB_TITLE']);
        $about = $bbcode->replace($filter->sanitize($row['ABOUT']));
 
    }

    $db_conn->free_close($result, $stmt); // free result and close db connection
    
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