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
 
    
    $filter = new Filter;
    $page = new Page_handler;
    
    //-------------------------------------------------
    // Get the navigation
    //-------------------------------------------------

    $db_conn = new Database;
    $stmt = $db_conn->connect->prepare("SELECT `NAME`, `URL` FROM `NAVIGATION` ORDER BY `ID` ASC");
    $stmt->execute();
    $result = $stmt->get_result();

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
                echo '<a href="'.$url.'/" class="navigation__link '.$page->set_active($url).'">';
                echo $name;
                echo '</a>';

            }

            $db_conn->free_close($result, $stmt);
            
        ?>
    </ul>
    <div class="navigation__hamburger-menu">
        <button class="navigation__button">
        </button>
    </div>
    <div class ="navigation__user-menu">
        <a href="login/"><img src="img/icons/login.svg">Sign in</a>
        <a href="register/"><img src="img/icons/register.svg">Register</a>
    </div>
</nav>
<!-- NAVIGATION END -->