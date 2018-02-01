<?php
    
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    $db_conn = new Database(); // connect to database
    $filter = new Filter(); // Start filter
    $bbcode = new Bbcode(); // Start bbcode parser

    $stmt = $db_conn->connect->prepare("SELECT ID, IMAGE, TITLE, PUBLISH_DATE, PUBLISHED_BY_USER, UPDATE_DATE, UPDATED_BY_USER, SEEN, LIKES, DISLIKES, TAGS, SHORT_BLOG FROM `BLOG` ORDER BY `ID` DESC LIMIT 5"); // prepare statement
    $stmt->execute(); // select from database
    $result = $stmt->get_result(); // Get the result
    
    while ($row = $result->fetch_assoc()) {
        $id = $filter->sanitize($row['ID']);
        $img = $filter->sanitize($row['IMAGE']);
        $title = $filter->sanitize($row['TITLE']);
        $publish_date = $filter->sanitize($row['PUBLISH_DATE']);
        $published_by = $filter->sanitize($row['PUBLISHED_BY_USER']);
        $update_date = $filter->sanitize($row['UPDATE_DATE']);
        $updated_by = $filter->sanitize($row['UPDATED_BY_USER']);
        $seen = $filter->sanitize($row['SEEN']);
        $likes = $filter->sanitize($row['LIKES']);
        $dislikes = $filter->sanitize($row['DISLIKES']);
        $tags = $filter->sanitize($row['TAGS']);
        $short_blog = $bbcode->replace($filter->sanitize($row['SHORT_BLOG']));
    }

    $db_conn->free_close($result, $stmt); // free result and close db connection

    $publish_date = strtotime($publish_date);
    $publish_date = date('d.m.Y', $publish_date);
    $update_date = strtotime($update_date);
    $update_date = date('d.m.Y', $update_date);

    $tags = strtoupper($tags);
    $string = $tags;
    $pattern = '/[ ,]+/';
    $replacement = '</span><span class="blog-short__tags__item">';
    $replacement2 = '</span><span class="blog-navigation__tags__box__item">';
    $tags = preg_replace($pattern, $replacement, $string);
    $tags2 = preg_replace($pattern, $replacement2, $string);

?>
<!-- SECTION BLOG SHORT START -->
<section class="blog-short u-margin-top-medium">
    <div class="blog-short__box">
        <div class="blog-short__img" >
            <img src="img/blog/<?php echo $img; ?>" alt="<?php echo $title; ?>">
        </div>
        <div class="blog-short__title">
            <?php echo $title; ?>
        </div>
        <div class="blog-short__by">
            <?php echo "Posted ".$publish_date." by ".ucfirst($published_by); ?>
        </div>
        <div class="blog-short__updated-by">
            <?php echo "Updated ".$update_date." by ".ucfirst($updated_by); ?>
        </div>
        <div class="blog-short__tags">
            <span class="blog-short__tags__item"><?php echo $tags; ?></span>
        </div>
        <div class="blog-short__story">
            <?php echo $short_blog; ?>
        </div>
        <div class="blog-short__read">
            <a href="blog/<?php echo $id;?>/">Read more <span>&roarr;</span></a>
        </div>
    </div>
    <div class="blog-navigation">
        <div class="blog-navigation__sort">
            <div class="blog-navigation__sort__buttons">
                <div class="blog-navigation__sort__buttons__item blog-navigation__sort__buttons__item__active">Recent</div>
                <div class="blog-navigation__sort__buttons__item">Popular</div>
                <div class="blog-navigation__sort__buttons__item">Comments</div>
            </div>
            <div class="blog-navigation__sort__content">
                <img src="img/blog/<?php echo $img; ?>" alt="<?php echo $title; ?>">
                <div class="blog-navigation__sort__content__text">
                    <?php echo "<span class='u-bold-text'>".$title."</span><br>"; ?>
                    <?php echo "<h6>".$publish_date." by ".ucfirst($published_by)."</h6>"; ?>
                </div>
            </div>
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
        <div class="blog-navigation__archive">
        <span class="blog-navigation__heading">Blog archive</span>
        <div class="blog-navigation__archive__item">
            <select class="blog-navigation__archive__dropdown">
                <option value="">Blog archive</option>
                <option value="">Value 1</option>
                <option value="">Value 2</option>
                <option value="">Value 3</option>
            </select>
        </div>
        </div>
        <div class="blog-navigation__tags">
            <span class="blog-navigation__heading">Tags</span>
            <div class="blog-navigation__tags__box">
                <span class="blog-navigation__tags__box__item"><?php echo $tags2; ?></span>
            </div>
        </div>
    </div>
</section>
<!-- SECTION BLOG SHORT END -->
<?php 

$pagination = new Pagination(); // Crate new pagination
$pagination->output_pagination(1, "BLOG"); // Output the pagination

?>