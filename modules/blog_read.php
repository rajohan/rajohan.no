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
            <?php echo "<img src='img/icons/write.svg' alt='posted' class='blog__by__img'> ".$publish_date."  <img src='img/icons/user.svg' alt='user' class='blog__by__img'> <a href='user/".$published_by."'>".$published_by."</a>"; ?>
        </div>
        <?php 
            if(!empty($update_date) && !empty($updated_by)) {
        ?>
        <div class="blog__updated-by">
            <?php echo "<img src='img/icons/refresh.svg' alt='updated' class='blog__by__img'> ".$update_date." <img src='img/icons/user.svg' alt='user' class='blog__updated-by__img'> <a href='user/".$updated_by."'>".$updated_by."</a>"; ?>
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
        <?php
            if(isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {
        ?>
        <div class="text-editor u-margin-top-small">
            <div class="text-editor__message"></div>
            <div class="text-editor__toolbox u-margin-top-small">
                <img src="img/icons/bold.svg" alt="bold" id="toolbox__bold" class="text-editor__toolbox__icon" onClick="execCmd('bold');">
                <img src="img/icons/italic.svg" alt="italic" id="toolbox__italic" class="text-editor__toolbox__icon" onClick="execCmd('italic');">
                <img src="img/icons/underline.svg" alt="underline" id="toolbox__underline" class="text-editor__toolbox__icon" onClick="execCmd('underline');">
                <img src="img/icons/strikethrough.svg" alt="strikethrough" id="toolbox__strikethrough" class="text-editor__toolbox__icon" onClick="execCmd('strikethrough');">
                <div class="text-editor__toolbox__separator"></div>
                <img src="img/icons/list.svg" alt="list" id="toolbox__list" class="text-editor__toolbox__icon" onClick="execCmd('insertUnorderedList');">
                <img src="img/icons/list-numbered.svg" alt="list-numbered" id="toolbox__list-numbered" class="text-editor__toolbox__icon" onClick="execCmd('insertOrderedList');">
                <div class="text-editor__toolbox__separator"></div>
                <img src="img/icons/link.svg" alt="link" id="toolbox__link" class="text-editor__toolbox__icon" onClick="execCmd('createLink');">
                <img src="img/icons/envelop.svg" alt="envelop" id="toolbox__envelop" class="text-editor__toolbox__icon" onClick="execCmd('createMail');">
                <img src="img/icons/image.svg" alt="image" id="toolbox__image" class="text-editor__toolbox__icon" onClick="execCmd('insertImage');">
                <div class="text-editor__toolbox__separator"></div>
                <img src="img/icons/quotes-right.svg" alt="quotes-right" id="toolbox__quotes-right" class="text-editor__toolbox__icon" onClick="execCmd('insertQuote');">
                <img src="img/icons/embed2.svg" alt="embed2" id="toolbox__embed2" class="text-editor__toolbox__icon" onClick="execCmd('insertCode');">
                <img src="img/icons/smile.svg" alt="smile" id="toolbox__emoticons" class="text-editor__toolbox__icon">
                <div id="toolbox__emoticons__box" class="text-editor__toolbox__emoticons__box">
                    <div id="toolbox__emoticons__box__close" class="text-editor__toolbox__emoticons__box__close">
                        x
                    </div>
                    <img src="img/icons/emoticons/smile.svg" alt="bold" id="emoticon__smile" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'smile.svg');">
                    <img src="img/icons/emoticons/wink.svg" alt="wink" id="emoticon__wink" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'wink.svg');">
                    <img src="img/icons/emoticons/tongue.svg" alt="tongue" id="emoticon__tongue" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'tongue.svg');">
                    <img src="img/icons/emoticons/grin.svg" alt="grin" id="emoticon__grin" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'grin.svg');">
                    <img src="img/icons/emoticons/laugh.svg" alt="laugh" id="emoticon__laugh" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'laugh.svg');">
                    <img src="img/icons/emoticons/frowny.svg" alt="frowny" id="emoticon__frowny" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'frowny.svg');">
                    <img src="img/icons/emoticons/unsure.svg" alt="unsure" id="emoticon__unsure" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'unsure.svg');">
                    <img src="img/icons/emoticons/cry.svg" alt="cry" id="emoticon__cry" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'cry.svg');">
                    <img src="img/icons/emoticons/grumpy.svg" alt="grumpy" id="emoticon__grumpy" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'grumpy.svg');">
                    <img src="img/icons/emoticons/angry.svg" alt="angry" id="emoticon__angry" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'angry.svg');">
                    <img src="img/icons/emoticons/astonished.svg" alt="astonished" id="emoticon__astonished" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'astonished.svg');">
                    <img src="img/icons/emoticons/afraid.svg" alt="afraid" id="emoticon__afraid" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'afraid.svg');">
                    <img src="img/icons/emoticons/nerd.svg" alt="nerd" id="emoticon__nerd" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'nerd.svg');">
                    <img src="img/icons/emoticons/dejected.svg" alt="dejected" id="emoticon__dejected" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'dejected.svg');">
                    <img src="img/icons/emoticons/big_eyes.svg" alt="big_eyes" id="emoticon__big_eyes" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'big_eyes.svg');">
                    <img src="img/icons/emoticons/sunglasses.svg" alt="sunglasses" id="emoticon__sunglasses" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'sunglasses.svg');">
                    <img src="img/icons/emoticons/confused.svg" alt="confused" id="emoticon__confused" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'confused.svg');">
                    <img src="img/icons/emoticons/silent.svg" alt="silent" id="emoticon__silent" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'silent.svg');">
                    <img src="img/icons/emoticons/love.svg" alt="love" id="emoticon__love" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'love.svg');">
                    <img src="img/icons/emoticons/kiss.svg" alt="kiss" id="emoticon__kiss" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'kiss.svg');">
                </div>
                <div class="text-editor__toolbox__separator"></div>
                <img src="img/icons/embed.svg" alt="embed" id="toolbox__embed" class="text-editor__toolbox__icon">
            </div>
            <div id="text-editor__box" class="text-editor__box" data-placeholder="Your comment..." contenteditable="true"></div>
            <div id="text-editor__code-heading" class="text-editor__code-heading">
                Source code
            </div>
            <div id="text-editor__code" class="text-editor__code">
            </div>
            <div id="text-editor__status" data-reply-to="0" data-blog-id="<?php echo $blog_id; ?>" class="text-editor__status u-margin-bottom-small">
                Reply to:&nbsp;<span id="text-editor__reply-to">none</span><span class="text-editor__status__cancel"><img class="text-editor__status__cancel__img" src="img/icons/cancel.svg" alt="cancel"></span>
            </div>
            <button type="submit" id="post__comment" class="btn btn--primary btn--white u-margin-top-small u-margin-bottom-small">Send comment</button>
        </div>
        <?php
            } else {
        ?>
        <div class="not__logged-in__error u-margin-top-medium">
            <span>You have to be signed in to post a comment. <a href="register/">Register</a> or <a href="login/">sign in</a>.</span>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<!-- SECTION BLOG READ END -->