<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    
    $stmt = $db_conn->connect->prepare("SELECT NAME, URL FROM `FOOTER_NAVIGATION` ORDER BY `ID` ASC"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
 
?>

<?php

    $ssl_seal = new Ssl_seal(); // GENERATE NEW SSL SEAL LINK
    
?>
<!-- SECTION FOOTER START -->
<footer class="footer">
    <a href="<?php $ssl_seal->generate_url(); ?>" target="_blank">SSL Certificate</a> 
    <?php
        while ($row = $result->fetch_assoc()) {

            $name = $filter->sanitize($row['NAME']);
            $url = $filter->sanitize($row['URL']);

            echo '&ndash; <a href="'.$url.'/">'.ucfirst($name).'</a> ';

        }

        $db_conn->free_close($result, $stmt);

    ?>
    <br> 
    <?php echo $GLOBALS['copyright']; ?><a href="<?php echo$GLOBALS['url']; ?>"><?php echo $GLOBALS['program']; ?></a>, <a href="<?php echo $GLOBALS['org_link']; ?>" target="_blank"><?php echo $GLOBALS['company']; ?>.</a>
</footer>
<!-- SECTION FOOTER END -->