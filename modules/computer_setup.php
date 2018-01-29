<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $bbcode = new Bbcode(); // Start bbcode parser
    
    $stmt = $db_conn->connect->prepare("SELECT TITLE, SUB_TITLE, PRIMARY_COMPUTER, SECONDARY_COMPUTER, GEAR FROM `COMPUTER_SETUP` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
    while ($row = $result->fetch_assoc()) {

        $title = $filter->sanitize($row['TITLE']);
        $sub_title = $filter->sanitize($row['SUB_TITLE']);
        $primary_computer = $bbcode->replace($filter->sanitize($row['PRIMARY_COMPUTER']));
        $secondary_computer = $bbcode->replace($filter->sanitize($row['SECONDARY_COMPUTER']));
        $gear = $bbcode->replace($filter->sanitize($row['GEAR']));
 
    }

    $db_conn->free_close($result, $stmt); // free result and close db connection
    
?>

<!-- SECTION COMPUTER SETUP START -->
<section class="computer-setup u-margin-top-medium">
    <h1 class="heading-secondary letter-spacing-medium"><?php echo $title; ?></h1>
    <h1 class="heading-tertiary"><?php echo $sub_title; ?></h1>  
    <div class="computer-setup__box u-margin-top-medium">
            <h3>Primary computer (stationary)</h3>
            <p class="computer-setup__text">
                <?php echo $primary_computer; ?>
            </p>
            <h3>Secondary computer (laptop)</h3>
            <p class="computer-setup__text">
                <?php echo $secondary_computer; ?>
            </p>
            <h3>Gear</h3>
            <p class="computer-setup__text">
                <?php echo $gear; ?>
            </p>
    </div> 
</section>
<!-- SECTION COMPUTER SETUP END -->