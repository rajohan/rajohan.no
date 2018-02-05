<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database; // connect to database
    $filter = new Filter; // Start filter
    
    $stmt = $db_conn->connect->prepare("SELECT TITLE, SUB_TITLE, OVERVIEW_1_IMAGE, OVERVIEW_1_TITLE, OVERVIEW_1_DESCRIPTION, OVERVIEW_2_IMAGE, OVERVIEW_2_TITLE, OVERVIEW_2_DESCRIPTION, OVERVIEW_3_IMAGE, OVERVIEW_3_TITLE, OVERVIEW_3_DESCRIPTION, OVERVIEW_4_IMAGE, OVERVIEW_4_TITLE, OVERVIEW_4_DESCRIPTION  FROM `SERVICES` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
    while ($row = $result->fetch_assoc()) {

        $title = $filter->sanitize($row['TITLE']);
        $sub_title = $filter->sanitize($row['SUB_TITLE']);
        $overview_1_image = $filter->sanitize($row['OVERVIEW_1_IMAGE']);
        $overview_1_title = $filter->sanitize($row['OVERVIEW_1_TITLE']);
        $overview_1_description = $filter->sanitize($row['OVERVIEW_1_DESCRIPTION']);
        $overview_2_image = $filter->sanitize($row['OVERVIEW_2_IMAGE']);
        $overview_2_title = $filter->sanitize($row['OVERVIEW_2_TITLE']);
        $overview_2_description = $filter->sanitize($row['OVERVIEW_2_DESCRIPTION']);
        $overview_3_image = $filter->sanitize($row['OVERVIEW_3_IMAGE']);
        $overview_3_title = $filter->sanitize($row['OVERVIEW_3_TITLE']);
        $overview_3_description = $filter->sanitize($row['OVERVIEW_3_DESCRIPTION']);
        $overview_4_image = $filter->sanitize($row['OVERVIEW_4_IMAGE']);
        $overview_4_title = $filter->sanitize($row['OVERVIEW_4_TITLE']);
        $overview_4_description = $filter->sanitize($row['OVERVIEW_4_DESCRIPTION']);

    }

    $db_conn->free_close($result, $stmt); // free result and close db connection
    
?>

<!-- SECTION SERVICES START -->
<section class="services u-margin-top-medium">
    <h1 class="heading-secondary letter-spacing-medium"><?php echo $title; ?></h1>
    <h1 class="heading-tertiary  u-margin-bottom-medium"><?php echo $sub_title; ?></h1>
    <div class="services__container">
        <div class="services__box">
            <img src="img/icons/<?php echo $overview_1_image; ?>" alt="<?php echo $overview_1_title; ?>" class="services__icon">
            <h3><?php echo ucfirst($overview_1_title); ?></h3>
            <p class="services__text">
                <?php echo $overview_1_description; ?>
            </p>
        </div>
        <div class="services__box">
        <img src="img/icons/<?php echo $overview_2_image; ?>" alt="<?php echo $overview_2_title; ?>" class="services__icon">
        <h3><?php echo ucfirst($overview_2_title); ?></h3>
            <p class="services__text">
                <?php echo $overview_2_description; ?>
            </p>
        </div>
        <div class="services__box">
        <img src="img/icons/<?php echo $overview_3_image; ?>" alt="<?php echo $overview_3_title; ?>" class="services__icon">
        <h3><?php echo ucfirst($overview_3_title); ?></h3>
            <p class="services__text">
                <?php echo $overview_3_description; ?>
            </p>
        </div>
        <div class="services__box">
        <img src="img/icons/<?php echo $overview_4_image; ?>" alt="<?php echo $overview_4_title; ?>" class="services__icon">
        <h3><?php echo ucfirst($overview_4_title); ?></h3>
            <p class="services__text">
                <?php echo $overview_4_description; ?>  
            </p>
        </div>
    </div>
</section>
<!-- SECTION SERVICES END -->