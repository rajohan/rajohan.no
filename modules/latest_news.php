<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 
    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    
    $stmt = $db_conn->connect->prepare("SELECT IMAGE, TITLE, SHORT_NEWS, ID FROM `BLOG` ORDER BY `ID` DESC LIMIT 3"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
    
?>

<!-- SECTION LATEST NEWS START -->
<section class="latest-news">
    <h1 class="heading-secondary letter-spacing-medium u-margin-top-medium">LATEST</h1>
    <h1 class="heading-tertiary">News &amp; tutorials </h1>
    <div class="latest-news__wrapper">
        <?php 
            while ($row = $result->fetch_assoc()) {

                $img = $filter->sanitize($row['IMAGE']);
                $title = $filter->sanitize($row['TITLE']);
                $short_news = $filter->sanitize($row['SHORT_NEWS']);
                $id = $filter->sanitize($row['ID']);

                echo '<div class="latest-news__box">';
                echo '<img src="img/blog/'.$img.'" alt="'.$title.'" class="latest-news__img">';
                echo '<div class="latest-news__text">';
                echo '<h3>'.ucfirst($title).'</h3>';
                echo $short_news;
                echo '<span class="u-margin-top-small">';
                echo '<a href="blog/'.$id.'/" class="latest-news__read-more">Read more <span>&roarr;</span></a>';
                echo '</h3>';
                echo '</div>';
                echo '</div>';

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection
        ?>
    </div>
    <a href="blog/" class="btn btn--secondary u-margin-top-medium u-margin-bottom-medium">See all news/tutorials</a> 
</section>
<!-- SECTION LATEST NEWS END -->