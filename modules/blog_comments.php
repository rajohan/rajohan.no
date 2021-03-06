<?php 

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------
    if(!empty($_POST['sort_comments']) && $_POST['sort_comments'] === "true") {

        $blog_id = $filter->sanitize($_POST['blog_id']);
        
        if($_POST['order'] === "oldest") {

            $_SESSION['order'] = "`ID` ASC";
            $_SESSION['comment_sort'] = "oldest";

        }

        else if ($_POST['order'] === "newest") {

            $_SESSION['order'] = "`ID` DESC";
            $_SESSION['comment_sort'] = "newest";

        }

        else if ($_POST['order'] === "best") {

            $comment_id = $sort_data->comment_sort($blog_id);

            $_SESSION['order'] = 'FIELD (ID, '.$comment_id.')';
            $_SESSION['comment_sort'] = "best";

        } else {

            if(empty($_SESSION['order'])) {

                $_SESSION['order'] = "`ID` ASC";
                $_SESSION['comment_sort'] = "oldest";

            }

        }
    }

    else if(!empty($_POST['reload_comments']) && $_POST['reload_comments'] === "true") { 
        
        $blog_id = $filter->sanitize($_POST['blog_id']);

    } else {

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }

        if(empty($_SESSION['order'])) {

            $_SESSION['order'] = "`ID` ASC";
            $_SESSION['comment_sort'] = "oldest";

        } 

        if($_SESSION['comment_sort'] === "best") {

            $comment_id = $sort_data->comment_sort($blog_id);
            $_SESSION['order'] = 'FIELD (ID, '.$comment_id.')';
            $_SESSION['comment_sort'] = "best";

        }

    }

?>
    
<div class="blog__comment__sort">
    <div class="blog__comment__sort__by">
        <a href="javascript:void(0);" id="blog__comment__sort__by__oldest" class="blog__comment__sort__by__link <?php if(($_SESSION['comment_sort'] === "oldest") || (empty($_SESSION['comment_sort']))) { echo "blog__comment__sort__by__link__active"; } ?>" onclick="sort_comments('<?php echo $blog_id; ?>','oldest')">Oldest first</a>  
        <a href="javascript:void(0);" id="blog__comment__sort__by__newest" class="blog__comment__sort__by__link <?php if($_SESSION['comment_sort'] === "newest") { echo "blog__comment__sort__by__link__active"; } ?>" onclick="sort_comments('<?php echo $blog_id; ?>','newest')">Newest first</a> 
        <a href="javascript:void(0);" id="blog__comment__sort__by__best" class="blog__comment__sort__by__link <?php if($_SESSION['comment_sort'] === "best") { echo "blog__comment__sort__by__link__active"; } ?>" onclick="sort_comments('<?php echo $blog_id; ?>','best')">Best comments</a>
    </div>
    <div class="blog__comment__sort__pagination">

        <?php 

            if(empty($_SESSION['order'])) {
                
                $_SESSION['order'] = "`ID` ASC";

            }  

            $order = $filter->sanitize($_SESSION['order']);
            
            $sort = "WHERE `BLOG_ID`= $blog_id  AND `REPLY_TO` < 1 ORDER BY $order";

            echo '<div class="comments__pagination">';
            $pagination->output_pagination(2, "COMMENTS", $sort); 
            echo '</div>';

        ?>

    </div>
</div>

<?php

    $max = 3;

    $offset = ($pagination->valid_page_number($pagination->get_page_number(), "COMMENTS") - 1) * $max; // Set the page number to generate offset (* + number of items per site)
    $comment = $comments->get_comments($blog_id, $_SESSION['order'], $offset, $max);
    
    if(count($comment) < 1) {

        echo "<div class='no__comment u-margin-top-small'>No comments yet. Be the first to comment!</div>";

    }

    for($i = 0; $i < count($comment); $i++) {
        
        $id = $filter->sanitize($comment[$i]['ID']);
        $message = $bbcode->replace($filter->sanitize_code($comment[$i]['COMMENT']));
        $reply_to = $filter->sanitize($comment[$i]['REPLY_TO']);
        $posted_date = $filter->sanitize($comment[$i]['POSTED_BY_DATE']);
        $posted_by = $filter->sanitize($comment[$i]['POSTED_BY_USER']);
        $update_date = $filter->sanitize($comment[$i]['UPDATE_DATE']);
        $updated_by = $filter->sanitize($comment[$i]['UPDATED_BY_USER']);
        
        // Date
        $posted_date = $converter->date_time($posted_date);
        $update_date = $converter->date_time($update_date);

        // User admin level
        $admin = $user->get_user("ID", $posted_by)['ADMIN'];
        $reg_date = $converter->date($user->get_user("ID", $posted_by)['REG_DATE']);

        // Comment count for user
        $db_conn = new Database;
        $comment_count = $db_conn->count('COMMENTS', 'WHERE POSTED_BY_USER = ?', 's', array($posted_by));

        // Comment votes
        $db_conn = new Database;
        $comment_votes_like = $db_conn->count('COMMENT_VOTES', 'WHERE ITEM_ID = ? AND VOTE = 1', 'i', array($id));
    
        $db_conn = new Database;
        $comment_votes_dislike = $db_conn->count('COMMENT_VOTES', 'WHERE ITEM_ID = ? AND VOTE = 0', 'i', array($id));

        // Username from id
        $posted_by = $user->get_user("ID", $posted_by)['USERNAME'];

        if(!empty($updated_by)) {

            $updated_by = $user->get_user("ID", $updated_by)['USERNAME'];
            
        }
        
        //-------------------------------------------------
        // Create a comment container
        //-------------------------------------------------
        if($i === 0) {

            echo "<div class='blog__comment__message__box'>";

        }

        else if (($i > 0) && ($reply_to === "0")) {

            echo "</div>";
            echo "<div class='blog__comment__message__box'>";

        }

        //-------------------------------------------------
        // Crate indentation box for child comments and set root id for root comments
        //-------------------------------------------------

        if($reply_to > 0) {

            echo "<div class='blog__comment__reply'>";
            
        }

        else {

            $root_id = $id;
            
        }

        //-------------------------------------------------
        // Output comment
        //-------------------------------------------------

        echo
        '<div class="blog__comment__user">
            <div class="blog__comment__user__box">
                <span class="blog__comment__user__name"><a href="user/'.$posted_by.'">'.$posted_by.'</a></span>';
                
                if($admin > 0) {

                    echo '<span class="blog__comment__user__admin">'.$converter->admin($admin).'</span>';

                }

            echo
            '</div>
            <div id="'.$id.'" class="blog__comment__date-reply">
                '.$posted_date.'
                <img src="img/icons/reply.svg" alt="reply" data-id="'.$id.'" data-user="'.$posted_by.'" class="blog__comment__date-reply__img">
            </div>
        </div>';

        if(($reply_to > 0) && (!empty($root_id)) && ($root_id !== $reply_to)) {

            $reply_author_name = $user->get_user("ID", $comments->get_author($reply_to))['USERNAME'];
            echo "<span id='message_top_id_".$id."' class='blog__comment__reply-to'><span data-reply-id='".$reply_to."' class='blog__comment__reply-to__text'><span class='blog__comment__reply-to__arrow'>&ltrif;</span> In reply to ".$reply_author_name."</span></span>";

        }

        echo 

        '<div id="message_id_'.$id.'" class="blog__comment__message">
            <div class="blog__comment__message__content">'.$message.'</div>
        </div>
        <div class="blog__comment__message__stats">
            <div class="blog__comment__message__vote">
                <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img" onclick="add_vote('.$id.', \'comment\', 1);">
                <span id="comment__like__count__'.$id.'">
                    '.$comment_votes_like.'
                </span>
                <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img" onclick="add_vote('.$id.', \'comment\', 0);">
                <span id="comment__dislike__count__'.$id.'">
                    '.$comment_votes_dislike.'
                </span>
            </div>';

            if($reply_to < 1 && ($comments->count_replys($id) > 0)) {

                echo
                '<div class="blog__comment__message__hide">
                    Hide answers <span>&utrif;</span> 
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

        //-------------------------------------------------
        // End indentation box for child comments
        //------------------------------------------------- 

        if($reply_to > 0) {

            echo "</div>";

        }

        //-------------------------------------------------
        // End comment container
        //------------------------------------------------- 

        if ($i === count($comment) - 1) {

            echo "</div>";

        }

    }
    
?>