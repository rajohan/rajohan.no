<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database; // connect to database
    $filter = new Filter; // Start filter
    $bbcode = new Bbcode; // Start bbcode parser
    
    $stmt = $db_conn->connect->prepare("SELECT NEW_WEBPAGE_TITLE, NEW_WEBPAGE_SUB_TITLE, NEW_WEBPAGE, HOSTING_TITLE, HOSTING_SUB_TITLE, HOSTING, BACKUP_TITLE, BACKUP_SUB_TITLE, BACKUP, SEO_TITLE, SEO_SUB_TITLE, SEO, PRICE_TITLE, PRICE_SUB_TITLE, PRICE FROM `SERVICES` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
    while ($row = $result->fetch_assoc()) {
        
        $new_webpage_title = $filter->sanitize($row['NEW_WEBPAGE_TITLE']);
        $new_webpage_sub_title = $filter->sanitize($row['NEW_WEBPAGE_SUB_TITLE']);
        $new_webpage = $bbcode->replace($filter->sanitize($row['NEW_WEBPAGE']));
        $hosting_title = $filter->sanitize($row['HOSTING_TITLE']);
        $hosting_sub_title = $filter->sanitize($row['HOSTING_SUB_TITLE']);
        $hosting = $bbcode->replace($filter->sanitize($row['HOSTING']));
        $backup_title = $filter->sanitize($row['BACKUP_TITLE']);
        $backup_sub_title = $filter->sanitize($row['BACKUP_SUB_TITLE']);
        $backup = $bbcode->replace($filter->sanitize($row['BACKUP']));
        $seo_title = $filter->sanitize($row['SEO_TITLE']);
        $seo_sub_title = $filter->sanitize($row['SEO_SUB_TITLE']);
        $seo = $bbcode->replace($filter->sanitize($row['SEO']));
        $price_title = $filter->sanitize($row['PRICE_TITLE']);
        $price_sub_title = $filter->sanitize($row['PRICE_SUB_TITLE']);
        $price = $bbcode->replace($filter->sanitize($row['PRICE']));

    }

    $db_conn->free_close($result, $stmt); // free result and close db connection
    
?>

<!-- SECTION NEW WEBPAGE START -->
<section class="services__new-webpage u-margin-top-medium">
    <div class="services__new-webpage__box">
        <h1 class="heading-secondary"><?php echo $new_webpage_title; ?></h1>
        <h1 class="heading-tertiary  u-margin-bottom-medium"><?php echo $new_webpage_sub_title; ?></h1>
        <?php echo $new_webpage; ?>
    </div>
</section>
<!-- SECTION NEW WEBPAGE END-->
<!-- SECTION HOSTING START -->
<section class="services__hosting u-margin-top-medium">
    <div class="services__hosting__box">
        <h1 class="heading-secondary"><?php echo $hosting_title; ?></h1>
        <h1 class="heading-tertiary  u-margin-bottom-medium"><?php echo $hosting_sub_title; ?></h1>
        <?php echo $hosting; ?>
    </div>
</section>
<!-- SECTION HOSTING END -->
<!-- SECTION SECURITY_BACKUP START -->
<section class="services__backup u-margin-top-medium">
    <div class="services__backup__box">
        <h1 class="heading-secondary letter-spacing-medium"><?php echo $backup_title; ?></h1>
        <h1 class="heading-tertiary  u-margin-bottom-medium"><?php echo $backup_sub_title; ?></h1>    
        <?php echo $backup; ?>
    </div>
</section>
<!-- SECTION SECURITY_BACKUP END -->
<!-- SECTION SEO START -->
<section class="services__seo u-margin-top-medium">
    <div class="services__seo__box">
        <h1 class="heading-secondary"><?php echo $seo_title; ?></h1>
        <h1 class="heading-tertiary  u-margin-bottom-medium"><?php echo $seo_sub_title; ?></h1>
        <?php echo $seo; ?>
    </div>
</section>
<!-- SECTION SEO END -->
<!-- SECTION PRICE START -->
<section class="services__price u-margin-top-medium">
    <div class="services__price__box">
        <h1 class="heading-secondary"><?php echo $price_title; ?></h1>
        <h1 class="heading-tertiary  u-margin-bottom-medium"><?php echo $price_sub_title; ?></h1>
        <?php echo $price; ?>
    </div>
</section>
<!-- SECTION PRICE END -->