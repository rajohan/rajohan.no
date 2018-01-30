<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $stmt = $db_conn->connect->prepare("SELECT IMAGE, TITLE, SUB_TITLE, BUTTON_TEXT, LINK FROM `HEADER` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result

    while ($row = $result->fetch_assoc()) {

        $img = $filter->sanitize($row['IMAGE']);
        $title = $filter->sanitize($row['TITLE']);
        $sub_title = $filter->sanitize($row['SUB_TITLE']);
        $button_text = $filter->sanitize($row['BUTTON_TEXT']);
        $url = $filter->sanitize($row['LINK']);
 
    }

    $db_conn->free_close($result, $stmt); // free result and close db connection
    
?>

<!-- HEADER START -->
<div class="header__placeholder">
    <header class="header" style="background-image:linear-gradient(to right bottom,rgba(0, 0, 0, 0.8),rgba(0, 0, 0, 0.8)),url(img/header/<?php echo $img; ?>);">
        <div class="header__logo-box">
            <img src="img/logo_white.png" alt="Logo" class="header__logo">
        </div>
        <div class="header__text-box">
            <h1 class="heading-primary u-center-text">
                <span id="header__title" class="heading-primary--main">
                    <?php echo $title; ?>
                </span>
                <span id="header__text" class="heading-primary--sub">
                    <?php echo $sub_title; ?>
                </span>
            </h1>
            <a href="<?php echo $url."/"; ?>" id="header__button" class="btn btn--primary u-margin-top-medium"><?php echo $button_text; ?></a>
        </div>
        <button class="header__img-switcher header__img-switcher--prev">
            <svg viewBox="0 0 100 100">
                <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow"></path>
            </svg>
        </button>
        <button class="header__img-switcher header__img-switcher--next">
            <svg viewBox="0 0 100 100">
                <path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" class="arrow" transform="translate(100, 100) rotate(180)"></path>
            </svg>
        </button>
        <div class="header__circles">
        <?php

            // Crate circle buttons
            $db_conn = new Database(); // connect to database
            $stmt = $db_conn->connect->prepare("SELECT ID FROM `HEADER`"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result
            $num_of_rows = $result->num_rows; // Get the number of rows

            // Crate the buttons based on num rows
            for($i=1; $i <= $num_of_rows; $i++) {
                
                // if its the first circle give it the active class
                if($i === 1) {

                    echo '<div id="header__switcher-'.$i.'" data="'.$i.'" class="header__circle-switcher header__circle-switcher--active">';
                
                } else { // else give it the normal class
                 
                    echo '<div id="header__switcher-'.$i.'" data="'.$i.'" class="header__circle-switcher">';
               
                }
                echo '&nbsp;';
                echo '</div>';

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

        ?>
        </div>
    </header>
</div>
<!-- HEADER END -->