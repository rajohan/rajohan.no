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
    // Get the blog posts
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT `IMAGE`, `TITLE`, `SHORT_BLOG`, `ID` FROM `BLOG` ORDER BY `ID` DESC LIMIT 3");
    $stmt->execute();
    $result = $stmt->get_result();
    
?>

<!-- SECTION LATEST BLOG POSTS START -->
<section class="latest-blog">
    <h1 class="heading-secondary letter-spacing-medium u-margin-top-medium">LATEST</h1>
    <h1 class="heading-tertiary">Blog posts &amp; guides</h1>
    <div class="latest-blog__wrapper">
        <?php
            while ($row = $result->fetch_assoc()) {

                $img = $filter->sanitize($row['IMAGE']);
                $title = $filter->sanitize($row['TITLE']);
                $short_blog = $filter->sanitize($row['SHORT_BLOG']);
                $id = $filter->sanitize($row['ID']);

                echo '<div class="latest-blog__box">';
                echo '<img src="img/blog/'.$img.'" alt="'.$title.'" class="latest-blog__img">';
                echo '<div class="latest-blog__text">';
                echo '<h3>'.ucfirst($filter->cut_string($title, 28)).'</h3>';
                echo $filter->cut_string($short_blog, 140);
                echo '<span class="u-margin-top-small">';
                echo '<a href="blog/'.$id.'/" class="latest-blog__read-more">Read more <span>&roarr;</span></a>';
                echo '</h3>';
                echo '</div>';
                echo '</div>';

            }

            $db_conn->free_close($result, $stmt);
        ?>
    </div>
    <a href="blog/" class="btn btn--secondary u-margin-top-medium u-margin-bottom-medium">See all blog posts</a> 
</section>
<!-- SECTION BLOG POSTS END -->