<?php 

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------
    if(!empty($_POST['sort_comments']) && $_POST['sort_comments'] === "true") {

        session_start();
        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed 
        require_once('../configs/db.php'); // Get database username, password etc
        include_once('../classes/database_handler.php'); // Database handler
        include_once('../classes/filter.php'); // Filter
        include_once('../classes/bbcode.php'); // Bbcode
        include_once('../classes/converter.php'); // Converter
        include_once('../classes/users.php'); // Users
        include_once('../classes/sort.php'); // Sort
        include_once('../classes/comments.php'); // Comments
        include_once('../classes/page_handler.php'); // Page handler
        include_once('../classes/pagination.php'); // Pagination
        
        $filter = new Filter;
        $bbcode = new Bbcode;
        $converter = new Converter;
        $users = new Users;
        $comments = new Comments;
        $sort_data = new Sort;
        $pagination = new Pagination;

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

    } else {

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }

        if(empty($_SESSION['order'])) {

            $_SESSION['order'] = "`ID` ASC";
            $_SESSION['comment_sort'] = "oldest";

        }

    }

    $max = 1;

    $offset = ($pagination->valid_page_number($pagination->get_page_number(), "COMMENTS") - 1) * $max; // Set the page number to generate offset (* + number of items per site)
    $comment = $comments->get_comments($blog_id, $_SESSION['order'], $offset, $max);

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
        $comment_votes_like = $db_conn->count('COMMENT_VOTES', $sort = 'WHERE ITEM_ID = "'.$id.'" AND VOTE = 1');
    
        $db_conn = new Database;
        $comment_votes_dislike = $db_conn->count('COMMENT_VOTES', $sort = 'WHERE ITEM_ID = "'.$id.'" AND VOTE = 0');

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
                echo '<span class="blog__comment__user__admin">Moderator</span>';
                }
                elseif($admin ===2) {
                    echo '<span class="blog__comment__user__admin">Site owner</span>';
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