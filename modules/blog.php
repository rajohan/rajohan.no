<?php
    
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    $db_conn = new Database; // connect to database
    $filter = new Filter; // Start filter
    $bbcode = new Bbcode; // Start bbcode parser
    $pagination = new Pagination; // Crate new pagination
    $tag = new Tags; // Start the tag handler
    $converter = new Converter; // Start the converter
    $sort_data = new Sort; // Start sorting

    $offset = ($pagination->valid_page_number($pagination->get_page_number(), "BLOG") - 1) * 1; // Get the page number to generate offset

    $sort = $sort_data->by_tag();

    $stmt = $db_conn->connect->prepare("SELECT ID, IMAGE, TITLE, PUBLISH_DATE, PUBLISHED_BY_USER, UPDATE_DATE, UPDATED_BY_USER, SHORT_BLOG FROM `BLOG` $sort ORDER BY `ID` DESC LIMIT $offset, 1"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result

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

            // Dates
            $publish_date = $converter->date($publish_date);
            $update_date = $converter->date($update_date);

            echo
            '<div class="blog-short__box">
            <div class="blog-short__img" >
                <img src="img/blog/'.$img.'" alt="'.$title.'">
            </div>
            <div class="blog-short__title">
                '.ucfirst($title).'
            </div>
            <div class="blog-short__by">
                Posted '.$publish_date.' by '.ucfirst($published_by).'
            </div>
            <div class="blog-short__updated-by">
                Updated '.$update_date.' by '.ucfirst($updated_by).'
            </div>
            <div class="blog-short__tags">';
            
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

        $db_conn->free_close($result, $stmt); // free result and close db connection

        echo '<div class="pagination u-margin-bottom-medium">';
        $pagination->output_pagination(1, "BLOG", $sort); // Output the pagination
        echo '</div>';

    ?>
</div>
<!-- SECTION BLOG SHORT END -->