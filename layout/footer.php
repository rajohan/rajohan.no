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
    
    //-------------------------------------------------
    // Get footer nav
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT NAME, URL FROM `FOOTER_NAVIGATION` ORDER BY `ID` ASC");
    $stmt->execute();
    $result = $stmt->get_result();
 
?>

<?php

    //-------------------------------------------------
    // Generate new ssl seal link
    //-------------------------------------------------

    $ssl_seal = new Ssl_seal;
    
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

        $db_conn->free_close($result, $stmt); // free result and close db connection

    ?>
    <br> 
    <?php echo $GLOBALS['copyright']; ?><a href="<?php echo$GLOBALS['url']; ?>"><?php echo ucfirst($GLOBALS['program']); ?></a>, <a href="<?php echo $GLOBALS['org_link']; ?>" target="_blank"><?php echo $GLOBALS['company']; ?>.</a>
</footer>
<!-- SECTION FOOTER END -->