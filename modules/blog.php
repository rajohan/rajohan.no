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
    $bbcode = new Bbcode;
    $pagination = new Pagination;
    $tag = new Tags;
    $converter = new Converter;
    $sort_data = new Sort;
    $users = new Users;

    //-------------------------------------------------
    //  Set offset and sort values
    //-------------------------------------------------

    $offset = ($pagination->valid_page_number($pagination->get_page_number(), "BLOG") - 1) * 1; // Set the page number to generate offset (* + number of items per site)
    $sort = $sort_data->by_tag(); // Set sort value 

    //-------------------------------------------------
    //  Get the blog posts
    //-------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT `ID`, `IMAGE`, `TITLE`, `PUBLISH_DATE`, `PUBLISHED_BY_USER`, `UPDATE_DATE`, `UPDATED_BY_USER`, `SHORT_BLOG` FROM `BLOG` $sort ORDER BY `ID` DESC LIMIT $offset, 1");
    $stmt->execute();
    $result = $stmt->get_result();

?>
<!-- SECTION BLOG SHORT START -->
<div class="blog-short__container">
    <?php

        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $img = $filter->sanitize($row['IMAGE']);
            $title = $filter->sanitize($row['TITLE']);
            $publish_date = $filter->sanitize($row['PUBLISH_DATE']);
            $published_by = $filter->sanitize($row['PUBLISHED_BY_USER']);
            $update_date = $filter->sanitize($row['UPDATE_DATE']);
            $updated_by = $filter->sanitize($row['UPDATED_BY_USER']);
            $short_blog = $bbcode->replace($filter->sanitize($row['SHORT_BLOG']));

            $published_by = $users->get_username($published_by);

            if(!empty($updated_by)) {
                $updated_by = $users->get_username($updated_by);
            }

            $publish_date = $converter->date($publish_date);

            if(!empty($update_date)) {
                $update_date = $converter->date($update_date);
            }

            echo
            '<div class="blog-short__box">
            <div class="blog-short__img" >
                <img src="img/blog/'.$img.'" alt="'.$title.'">
            </div>
            <div class="blog-short__title">
                '.ucfirst($title).'
            </div>
            <div class="blog-short__by">
                <img src="img/icons/write.svg" alt="posted" class="blog-short__by__img"> '.$publish_date.'  <img src="img/icons/user.svg" alt="user" class="blog-short__by__img">'.ucfirst($published_by).'
            </div>';
            
            if(!empty($update_date) && !empty($updated_by)) {

                echo
                '<div class="blog-short__updated-by">
                    <img src="img/icons/refresh.svg" alt="updated" class="blog-short__by__img"> '.$update_date.' <img src="img/icons/user.svg" alt="user" class="blog-short__updated-by__img">'.ucfirst($updated_by).'
                </div>';

            }

            echo
            '<div class="blog-short__tags">';
            
                $tag_name = $tag->get_blog_tags($id);
                $tag->output_tags($tag_name);

            echo    
            '</div>
            <div class="blog-short__story">
                '.ucfirst($short_blog).'
            </div>
            <div class="blog-short__read">
                <a href="blog/read/'.$id.'/'.$converter->generate_slug($title).'/">Read more <span>&roarr;</span></a>
            </div>
            </div>';

        }

        $db_conn->free_close($result, $stmt);
        
        //-------------------------------------------------
        // Pagination
        //-------------------------------------------------

        echo '<div class="pagination u-margin-bottom-medium">';
        $pagination->output_pagination(1, "BLOG", $sort);
        echo '</div>';

    ?>
</div>
<!-- SECTION BLOG SHORT END -->