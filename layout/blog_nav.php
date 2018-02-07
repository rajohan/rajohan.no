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
    $pagination = new Pagination;
    $tag = new Tags;
    $converter = new Converter;

?>
<!-- SECTION BLOG SHORT START -->
<div class="blog-navigation">
    <div class="blog-navigation__sort">
        <div class="blog-navigation__sort__buttons">
            <div class="blog-navigation__sort__buttons__item blog-navigation__sort__buttons__item__active">Recent</div>
            <div class="blog-navigation__sort__buttons__item">Popular</div>
            <div class="blog-navigation__sort__buttons__item">Comments</div>
        </div>
        <?php   

            //-------------------------------------------------
            // Get the blog nav
            //-------------------------------------------------

            $stmt = $db_conn->connect->prepare("SELECT ID, IMAGE, TITLE, PUBLISH_DATE, PUBLISHED_BY_USER FROM `BLOG` ORDER BY `ID` DESC LIMIT 3");
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                $id = $filter->sanitize($row['ID']);
                $img = $filter->sanitize($row['IMAGE']);
                $title = $filter->sanitize($row['TITLE']);
                $publish_date = $filter->sanitize($row['PUBLISH_DATE']);
                $published_by = $filter->sanitize($row['PUBLISHED_BY_USER']);

                $publish_date = $converter->date($publish_date);
                
                echo
                
                '<div class="blog-navigation__sort__content">
                    <a href="blog/read/'.$id.'/'.$converter->generate_slug($title).'/"">
                        <img class="blog-navigation__sort__content__img" src="img/blog/'.$img.'" alt="'.$title.'">
                    </a>
                    <div class="blog-navigation__sort__content__text">
                        <a href="blog/read/'.$id.'/'.$converter->generate_slug($title).'/"">'.ucfirst($title).'</a>
                        <br>
                        <h6>'.$publish_date.' by '.ucfirst($published_by).'</h6>
                    </div>
                </div>';


            }

            $db_conn->free_close($result, $stmt);

        ?>
    </div>
    <div class="blog-navigation__search">
        <span class="blog-navigation__heading">Search</span>
        <div class="blog-navigation__search__item">
            <input placeholder="Search..." class="navigation__search__input" type="text">
        </div>
    </div>
    <div class="blog-navigation__newsletter">
    <span class="blog-navigation__heading">Newsletter</span>
        <div class="blog-navigation__newsletter__item">
            <input placeholder="Email..." class="navigation__newsletter__input" type="text">
        </div>
    </div>
    <div class="blog-navigation__tags">
        <span class="blog-navigation__heading">Tags</span>
        <div class="blog-navigation__tags__box">
                <?php 

                    //-------------------------------------------------
                    // Output tags
                    //-------------------------------------------------

                    $tags = $tag->get_all_tags();
                    $tags = $tag->add_count($tags);
                    $tag->output_tags($tags);

                ?>            
        </div>
    </div>
</div>
<!-- SECTION NAV BLOG END -->