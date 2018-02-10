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
    $bbcode = new Bbcode;
    $tag = new Tags;
    $converter = new Converter;
    $vote = new Vote;
    $view = new Views;
    $page = new Page_handler;
    $comments = new Comments;
    $users = new Users;
    $pagination = new Pagination;
    $sort_data = new Sort;

    //-------------------------------------------------
    //  Set the blog id
    //-------------------------------------------------
    
    $blog_id = $page->blog_id;

    //-------------------------------------------------
    // Add blog view to db to db if its a new user
    //-------------------------------------------------

    $view->add_blog_view($blog_id);

    //-------------------------------------------------
    //  Get views count
    //-------------------------------------------------

    $db_conn = new Database;
    $view_count = $db_conn->count('BLOG_VIEWS', $sort = 'WHERE BLOG_ID = "'.$blog_id.'"');

    //-------------------------------------------------
    //  Get blog vote count
    //-------------------------------------------------

    $db_conn = new Database;
    $blog_votes_like = $db_conn->count('BLOG_VOTES', $sort = 'WHERE ITEM_ID = "'.$blog_id.'" AND VOTE = 1');

    $db_conn = new Database;
    $blog_votes_dislike = $db_conn->count('BLOG_VOTES', $sort = 'WHERE ITEM_ID = "'.$blog_id.'" AND VOTE = 0');

    //-------------------------------------------------
    //  Get comment count
    //-------------------------------------------------

    $db_conn = new Database;
    $comment_count = $db_conn->count('COMMENTS', $sort = 'WHERE BLOG_ID = "'.$blog_id.'"');

    //-------------------------------------------------
    //  Get the blog post
    //-------------------------------------------------

    $db_conn = new Database;
    $stmt = $db_conn->connect->prepare("SELECT * FROM `BLOG` WHERE ID=? ORDER BY `ID` DESC LIMIT 1");
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {

        $id = $filter->sanitize($row['ID']);
        $img = $filter->sanitize($row['IMAGE']);
        $title = $filter->sanitize($row['TITLE']);
        $publish_date = $filter->sanitize($row['PUBLISH_DATE']);
        $published_by = $filter->sanitize($row['PUBLISHED_BY_USER']);
        $update_date = $filter->sanitize($row['UPDATE_DATE']);
        $updated_by = $filter->sanitize($row['UPDATED_BY_USER']);
        $short_blog = $bbcode->replace($filter->sanitize($row['SHORT_BLOG']));
        $blog = $bbcode->replace($filter->sanitize($row['BLOG']));
        
        $publish_date = $converter->date($publish_date);

        if(!empty($update_date)) {
            $update_date = $converter->date($update_date);   
        }

        $published_by = $users->get_username($published_by);

        if(!empty($updated_by)) {
            $updated_by = $users->get_username($updated_by);
        }

    }

    $db_conn->free_close($result, $stmt);

?>

<!-- SECTION BLOG READ START -->
<div class="blog__container u-margin-bottom-medium">
    <div class="blog__box">
        <div class="blog__img" >
            <img src="img/blog/<?php echo $img; ?>" alt="<?php echo $title; ?>">
        </div>
        <div class="blog__title">
            <?php echo ucfirst($title); ?>
        </div>
        <div class="blog__by">
            <?php echo "<img src='img/icons/write.svg' alt='posted' class='blog__by__img'> ".$publish_date."  <img src='img/icons/user.svg' alt='user' class='blog__by__img'> ".ucfirst($published_by); ?>
        </div>
        <?php 
            if(!empty($update_date) && !empty($updated_by)) {
        ?>
        <div class="blog__updated-by">
            <?php echo "<img src='img/icons/refresh.svg' alt='updated' class='blog__by__img'> ".$update_date." <img src='img/icons/user.svg' alt='user' class='blog__updated-by__img'> ".ucfirst($updated_by); ?>
        </div>
        <?php
            }
        ?>
        <div id="blog__votes" class="blog__stats">
            <img src="img/icons/seen.svg" alt="seen" class="blog__stats__img">
            <?php echo $view_count; ?>
            <img src="img/icons/like.svg" alt="like" id="blog__like" class="blog__stats__img" onclick="add_vote(<?php echo $id; ?>, 'blog', 1);">
            <span id="blog__like__count__<?php echo $id; ?>">
                <?php echo $blog_votes_like; ?>
            </span>
            <img src="img/icons/dislike.svg" alt="dislike" id="blog__dislike" class="blog__stats__img" onclick="add_vote(<?php echo $id; ?>, 'blog', 0);">
            <span id="blog__dislike__count__<?php echo $id; ?>">
                <?php echo $blog_votes_dislike; ?>
            </span>
        </div>
        <div class="blog__tags">
            <?php 
                $tag_name = $tag->get_blog_tags($blog_id);
                $tag->output_tags($tag_name); 
            ?>
        </div>
        <div class="blog__short">
            <?php echo ucfirst($short_blog); ?>
        </div>
        <div class="blog__full">
            <?php echo ucfirst($blog); ?>
        </div>
        <div class="blog__comment__stats">
            <div class="blog__comment__stats__count">
                <div class="blog__comment__stats__count__text">
                    COMMENTS
                </div>
                <div class="blog__comment__stats__count__img">
                    <div class="blog__comment__stats__count__img__text">
                        <?php echo $comment_count; ?>
                    </div>
                </div>
            </div>
            <div class="blog__comment__stats__social_media">
                SHARE
                <img src="img/icons/facebook.svg" alt="facebook" class="blog__comment__stats__social_media__img">
                <img src="img/icons/twitter.svg" alt="twitter" class="blog__comment__stats__social_media__img">
                <img src="img/icons/reddit.svg" alt="reddit" class="blog__comment__stats__social_media__img">
            </div>
        </div>
        <div id="<?php echo $blog_id; ?>" class="blog__comment">
            
            <?php 

                //-------------------------------------------------
                //  Get the blog comments
                //-------------------------------------------------

                require_once('blog_comments.php');            

            ?> 
            
        </div>
        <fieldset>
            <textarea placeholder="Din kommentar..." class="blog__comment__textarea" tabindex="1"></textarea>
        </fieldset>
        <fieldset>
            <button name="submit" type="submit" class="blog__comment__submit">Send kommentar</button>
        </fieldset>
    </div>
</div>
<!-- SECTION BLOG READ END -->