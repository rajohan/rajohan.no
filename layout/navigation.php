<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $active = new Page_handler(); // Get active page to set active button 
    
    $stmt = $db_conn->connect->prepare("SELECT NAME, URL FROM `NAVIGATION` ORDER BY `ID` ASC"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result

?>

<!-- NAVIGATION START -->
<nav class="navigation">
    <a href="home/"><img src="img/logo_white.png" alt="Logo" class="navigation__logo"></a>
    <ul class="navigation__list">
        <?php
            while ($row = $result->fetch_assoc()) {

                $name = $filter->sanitize($row['NAME']);
                $url = $filter->sanitize($row['URL']);

                echo '<li class="navigation__item">';
                echo '<a href="'.$url.'/" class="navigation__link '.$active->set_active($url).'">';
                echo $name;
                echo '</a>';

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection
        ?>
    </ul>
    <div class="navigation__hamburger-menu">
        <button class="navigation__button">
        </button>
    </div>
</nav>
<!-- NAVIGATION END -->