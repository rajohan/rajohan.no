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
    $blog_votes_like = $db_conn->count('BLOG_VOTES', $sort = 'WHERE BLOG_ID = "'.$blog_id.'" AND VOTE = 1');

    $db_conn = new Database;
    $blog_votes_dislike = $db_conn->count('BLOG_VOTES', $sort = 'WHERE BLOG_ID = "'.$blog_id.'" AND VOTE = 0');

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
        $update_date = $converter->date($update_date);   
        $published_by = $users->get_username($published_by);
        $updated_by = $users->get_username($updated_by);

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
            <?php echo "Posted ".$publish_date." by ".ucfirst($published_by); ?>
        </div>
        <div class="blog__updated-by">
            <?php echo "Updated ".$update_date." by ".ucfirst($updated_by); ?>
        </div>
        <div id="blog__votes" class="blog__stats">
            <img src="img/icons/seen.svg" alt="seen" class="blog__stats__img">
            <?php echo $view_count; ?>
            <img src="img/icons/like.svg" alt="like" id="blog__like" data-id="<?php echo $blog_id; ?>" class="blog__stats__img">
            <span id="blog__like__count">
                <?php echo $blog_votes_like; ?>
            </span>
            <img src="img/icons/dislike.svg" alt="dislike" id="blog__dislike" data-id="<?php echo $blog_id; ?>" class="blog__stats__img">
            <span id="blog__dislike__count">
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
        <div class="blog__comment__sort">
            <div class="blog__comment__sort__by">
                Oldest first | Newest first | Best comments
            </div>
            <div class="blog__comment__sort__pagination">
                Page 1 2 3 4 5 6 Next
            </div>
        </div>

        <?php 

            $comment = $comments->get_comments($blog_id);

            for($i = 0; $i  < count($comment); $i++) {
                
                $id = $filter->sanitize($comment[$i]['ID']);
                $message = $bbcode->replace($filter->sanitize($comment[$i]['COMMENT']));
                $reply_to = $filter->sanitize($comment[$i]['REPLY_TO']);
                $posted_date = $filter->sanitize($comment[$i]['POSTED_BY_DATE']);
                $posted_by = $filter->sanitize($comment[$i]['POSTED_BY_USER']);
                $update_date = $filter->sanitize($comment[$i]['UPDATE_DATE']);
                $updated_by = $filter->sanitize($comment[$i]['UPDATED_BY_USER']);
                
                // Date
                $posted_date = $converter->date_time($posted_date);
                $update_date = $converter->date_time($update_date);

                // User admin level
                $admin = $users->get_admin_level($posted_by);
                $reg_date = $converter->date($users->get_reg_date($posted_by));

                // Comment count for user
                $db_conn = new Database;
                $comment_count = $db_conn->count('COMMENTS', $sort = 'WHERE POSTED_BY_USER = "'.$posted_by.'"');

                // Comment votes
                $db_conn = new Database;
                $comment_votes_like = $db_conn->count('COMMENT_VOTES', $sort = 'WHERE COMMENT_ID = "'.$id.'" AND VOTE = 1');
            
                $db_conn = new Database;
                $comment_votes_dislike = $db_conn->count('COMMENT_VOTES', $sort = 'WHERE COMMENT_ID = "'.$id.'" AND VOTE = 0');

                // Username from id
                $posted_by = $users->get_username($posted_by);
                $updated_by = $users->get_username($updated_by);
                
                
                //-------------------------------------------------
                // Output comment
                //-------------------------------------------------

                if($reply_to > 0) {

                    echo "<div class='blog__comment__reply'>";
                    
                }

                else {

                    $root_id = $id;
                    
                }
                
                echo
                '<div class="blog__comment__user">
                    <div class="blog__comment__user__box">
                        <span class="blog__comment__user__name">'.ucfirst($posted_by).'</span>';
                        
                        if($admin === 1) {
                        echo '<span class="blog__comment__user__admin">MODERATOR</span>';
                        }
                        elseif($admin ===2) {
                            echo '<span class="blog__comment__user__admin">SITE OWNER</span>';
                        }

                    echo
                    '</div>
                    <div id="'.$id.'" class="blog__comment__date-reply">
                        '.$posted_date.'
                        <img src="img/icons/reply.svg" alt="reddit" class="blog__comment__date-reply__img">
                    </div>
                </div>';

                if(($reply_to > 0) && (!empty($root_id)) && ($root_id !== $reply_to)) {

                    $reply_author_name = $users->get_username($comments->get_author($reply_to));
                    echo "<span class='blog__comment__reply-to'><span class='blog__comment__reply-to__arrow'>&ltrif;</span> In reply to ".ucfirst($reply_author_name)."</span>";

                }

                echo 

                '<div class="blog__comment__message">
                '.$message.'
                </div>
                <div class="blog__comment__message__stats">
                    <div class="blog__comment__message__vote">
                        <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img" onclick="add_vote('.$id.', 1);">
                        <span id="comment__like__count__'.$id.'">
                            '.$comment_votes_like.'
                        </span>
                        <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img" onclick="add_vote('.$id.', 0);">
                        <span id="comment__dislike__count__'.$id.'">
                            '.$comment_votes_dislike.'
                        </span>
                    </div>';

                    if($reply_to < 1 && ($comments->count_replys($id) > 0)) {
                        echo
                        '<div class="blog__comment__message__hide">
                            Hide answers &dtrif; 
                        </div>';
                    }
                    
                    echo
                    '<div class="blog__comment__user__stats">
                        '.$comment_count; 

                        if($comment_count === 1) {

                            echo " comment ";

                        } else {

                            echo " comments ";

                        }
                        
                        echo
                        '| Registered '.$reg_date.'
                    </div>
                </div>';

                if($reply_to > 0) {

                    echo "</div>";

                }

            }

        ?> 

        <fieldset>
            <textarea placeholder="Din kommentar..." class="blog__comment__textarea" tabindex="1"></textarea>
        </fieldset>
        <fieldset>
            <button name="submit" type="submit" class="blog__comment__submit">Send kommentar</button>
        </fieldset>
    </div>
</div>
<!-- SECTION BLOG READ END -->