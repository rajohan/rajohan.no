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
    $user = new Users;
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
    $view_count = $db_conn->count('BLOG_VIEWS', 'WHERE BLOG_ID = ?', 'i', array($blog_id));

    //-------------------------------------------------
    //  Get blog vote count
    //-------------------------------------------------

    $db_conn = new Database;
    $blog_votes_like = $db_conn->count('BLOG_VOTES', 'WHERE ITEM_ID = ? AND VOTE = 1', 'i', array($blog_id));

    $db_conn = new Database;
    $blog_votes_dislike = $db_conn->count('BLOG_VOTES', 'WHERE ITEM_ID = ? AND VOTE = 0', 'i', array($blog_id));

    //-------------------------------------------------
    //  Get comment count
    //-------------------------------------------------

    $db_conn = new Database;
    $comment_count = $db_conn->count('COMMENTS', 'WHERE BLOG_ID = ?', 'i', array($blog_id));

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

        $published_by = $user->get_user("ID", $published_by)['USERNAME'];

        if(!empty($updated_by)) {
            $updated_by = $user->get_user("ID", $updated_by)['USERNAME'];
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
        <form method="post" id="blog__add-comment__form">
            <div class="toolbox">
                <img src="img/icons/bold.svg" alt="bold" id="toolbox__bold" class="toolbox__icon">
                <img src="img/icons/italic.svg" alt="italic" id="toolbox__italic" class="toolbox__icon">
                <img src="img/icons/underline.svg" alt="underline" id="toolbox__underline" class="toolbox__icon">
                <img src="img/icons/strikethrough.svg" alt="strikethrough" id="toolbox__strikethrough" class="toolbox__icon">
                <div class="toolbox__separator"></div>
                <img src="img/icons/list.svg" alt="list" id="toolbox__list" class="toolbox__icon">
                <img src="img/icons/list2.svg" alt="list2" id="toolbox__list2" class="toolbox__icon">
                <img src="img/icons/list-numbered.svg" alt="list-numbered" id="toolbox__list-numbered" class="toolbox__icon">
                <div class="toolbox__separator"></div>
                <img src="img/icons/link.svg" alt="link" id="toolbox__link" class="toolbox__icon">
                <img src="img/icons/envelop.svg" alt="envelop" id="toolbox__envelop" class="toolbox__icon">
                <img src="img/icons/image.svg" alt="image" id="toolbox__image" class="toolbox__icon">
                <div class="toolbox__separator"></div>
                <img src="img/icons/quotes-right.svg" alt="quotes-right" id="toolbox__quotes-right" class="toolbox__icon">
                <img src="img/icons/embed2.svg" alt="embed2" id="toolbox__embed2" class="toolbox__icon">
                <img src="img/icons/smile.svg" alt="smile" id="toolbox__smile" class="toolbox__icon">
            </div>
            <textarea placeholder="Your comment..." id="blog__add-comment__comment" name="blog__add-comment__comment" tabindex="1"></textarea>
            <div class="blog__comment__status u-margin-bottom-small">
                Reply to: none 
            </div>
            <button type="submit" class="btn btn--primary btn--white u-margin-top-small u-margin-bottom-small">Send comment</button>
        </form>
    </div>
</div>
<!-- SECTION BLOG READ END -->