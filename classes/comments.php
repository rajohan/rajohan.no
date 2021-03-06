<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    //  Comments
    //-------------------------------------------------

    class Comments {

        private $comments;
        private $blog_id;
        private $validator;
        private $filter;
        private $login;
        private $user;
        private $converter;
        private $bbcode;

        function __construct() {

            $this->comments = [];
            $this->validator = new Validator();
            $this->filter = new Filter;
            $this->login = new Login;
            $this->user = new Users;
            $this->converter = new Converter;
            $this->bbcode = new Bbcode;

        }
        
        //-------------------------------------------------
        //  Get reply childs
        //-------------------------------------------------

        private function get_reply_childs($id) {
            
            $id = $this->filter->sanitize($id);

            if($this->count_replys($id) > 0) {
                
                $db_conn = new Database;
                $stmt = $db_conn->connect->prepare("SELECT * FROM `COMMENTS` WHERE `BLOG_ID`=?  AND `REPLY_TO`=? ORDER BY `ID`");
                $stmt->bind_param("ii", $this->blog_id, $id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {

                    array_push($this->comments, $row);

                    if($this->count_replys($row['ID']) > 0) {

                        $this->get_reply_childs($row['ID']);

                    }                  

                }

                $db_conn->free_close($result, $stmt);   
            
            }

        }

        //-------------------------------------------------
        //  Get root reply's
        //-------------------------------------------------
        
        private function get_root_replys($id) {

            $id = $this->filter->sanitize($id);

            if($this->count_replys($id) > 0) {
                
                $db_conn = new Database;
                $stmt = $db_conn->connect->prepare("SELECT * FROM `COMMENTS` WHERE `BLOG_ID`=?  AND `REPLY_TO`=? ORDER BY `ID`");
                $stmt->bind_param("ii", $this->blog_id, $id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {

                    array_push($this->comments, $row);

                    $this->get_reply_childs($row['ID']);

                }

                $db_conn->free_close($result, $stmt);

            }
        
        }

        //-------------------------------------------------
        //  Count replys
        //-------------------------------------------------

        function count_replys($id) {

            $id = $this->filter->sanitize($id);

            $db_conn2 = new Database;
            $reply_count = $db_conn2->count('COMMENTS', 'WHERE `REPLY_TO` = ?', 'i', array($id));

            return $reply_count;

        }

        //-------------------------------------------------
        //  Get comment author
        //-------------------------------------------------

        function get_author($id) {

            $id = $this->filter->sanitize($id);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `POSTED_BY_USER` FROM `COMMENTS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
                
            while ($row = $result->fetch_assoc()) {
                
               $author = $this->filter->sanitize($row['POSTED_BY_USER']);

            }

            $db_conn->free_close($result, $stmt);   

            return $author;

        }

        //-------------------------------------------------
        //  Get the comments
        //-------------------------------------------------

        function get_comments($blog_id, $order, $offset = 0, $max = 1000000) {

            $this->blog_id = $this->filter->sanitize($blog_id);
            $order = $this->filter->sanitize($order);
            $offset = $this->filter->sanitize($offset);
            $max = $this->filter->sanitize($max);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `COMMENTS` WHERE `BLOG_ID`=?  AND `REPLY_TO` < 1 ORDER BY $order LIMIT $offset , $max");
            $stmt->bind_param("i", $this->blog_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                array_push($this->comments, $row);
                
                $this->get_root_replys($row['ID']);

            }

            $db_conn->free_close($result, $stmt);

            return $this->comments;
        
        }

        //-------------------------------------------------
        //  Generate comment to outout on comment add
        //-------------------------------------------------

        private function generate_comment($reply_to, $user_id, $comment) {

            $reply_to = $this->filter->sanitize($reply_to);
            $user_id = $this->filter->sanitize($_SESSION['USER']['ID']);
            $comment = $this->filter->strip($comment);
            $comment = $this->bbcode->replace($this->filter->sanitize_code($comment));

            // Get id and posted date for comment
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `ID`, `POSTED_BY_DATE` FROM `COMMENTS` WHERE `POSTED_BY_USER`=?  ORDER BY ID DESC LIMIT 1");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                $id = $this->filter->sanitize($row['ID']);
                $posted_date = $this->filter->sanitize($row['POSTED_BY_DATE']);

            }

            $db_conn->free_close($result, $stmt);

            // Comment count for user
            $db_conn = new Database;
            $comment_count = $db_conn->count('COMMENTS', 'WHERE POSTED_BY_USER = ?', 'i', array($user_id));

            if($comment_count === 1) {

                $comment_count = $comment_count." comment";

            } else {

                $comment_count = $comment_count." comments";

            }

            $posted_date = $this->converter->date_time($posted_date);
            $user_data = $this->user->get_user("ID", $user_id);
            $admin = "";
            $reply = "";

            if($user_data['ADMIN'] > 0) {

                echo '<span class="blog__comment__user__admin">'.$this->converter->admin($user_data['ADMIN']).'</span>';

            }

            // Set reply variable if comment is a reply
            if((!empty($reply_to)) && ($reply_to !== "0")) {

                $reply_author_name = $this->user->get_user("ID", $this->get_author($reply_to))['USERNAME'];

                $reply = '<span id="message_top_id_'.$id.'" class="blog__comment__reply-to">
                            <span data-reply-id="'.$reply_to.'" class="blog__comment__reply-to__text">
                                <span class="blog__comment__reply-to__arrow">
                                    &ltrif;
                                </span> 
                                In reply to '.$reply_author_name.'
                            </span>
                        </span>';

            }

            $output = '<div id="new_comment" class="blog__comment__user">
                <div class="blog__comment__user__box">
                    <span class="blog__comment__user__name">
                        <a href="user/'.$user_data['USERNAME'].'">
                            '.$user_data['USERNAME'].'
                        </a>
                    </span>
                    '.$admin.'
                </div>
                <div id="'.$id.'" class="blog__comment__date-reply">
                    '.$posted_date.'
                    <img src="img/icons/reply.svg" alt="reply" data-id="'.$id.'" data-user="'.$user_data['USERNAME'].'" class="blog__comment__date-reply__img">
                </div>
            </div>
            '.$reply.'
            <div id="message_id_'.$id.'" class="blog__comment__message">
                <div class="blog__comment__message__content">
                    '.$comment.'
                </div>
            </div>
            <div class="blog__comment__message__stats">
                <div class="blog__comment__message__vote">
                    <img src="img/icons/like.svg" alt="like" class="blog__comment__message__vote__img" onclick="add_vote('.$id.', \'comment\', 1);">
                    <span id="comment__like__count__'.$id.'">
                        0
                    </span>
                    <img src="img/icons/dislike.svg" alt="dislike" class="blog__comment__message__vote__img" onclick="add_vote('.$id.', \'comment\', 0);">
                    <span id="comment__dislike__count__'.$id.'">
                        0
                    </span>
                </div>
                <div class="blog__comment__user__stats">
                    '.$comment_count.' | Registered '.$this->converter->date($user_data['REG_DATE']).'
                </div>
            </div>';

            return $output;

        }

        //-------------------------------------------------
        //  Add new comment
        //-------------------------------------------------

        function add_comment($blog_id, $reply_to, $comment) {

            
            $blog_id = $this->filter->sanitize($blog_id);
            $reply_to = $this->filter->sanitize($reply_to);
            $user_id = $this->filter->sanitize($_SESSION['USER']['ID']);
            $comment = $this->filter->strip($comment);
            $errors = []; // Create errors array
            $success = []; // Create success array

            // Check that blogpost with current blog id exist
            $db_conn = new Database;
            $count = $db_conn->count("BLOG", "WHERE ID = ?", "i", array($blog_id));

            // Check that user is logged in
            if(!$this->login->login_check()) {

                $errors[] = "You have to be logged in to post a comment.";
                
            }

            // Check that comment field not is empty
            else if(empty($comment)) {

                $errors[] =  "The comment field can not be empty.";

            } 

            // Check that blog id is valid
            else if(!$this->validator->validate_id($blog_id)) {

                $errors[] = "Invalid blog id.";

            }

            else if(empty($errors)) {

                // Check that blog post with current blog id exist
                if($count < 1) {
                    
                    $errors[] = "Invalid blog id.";
                    
                } else {

                    // Check if comment is a reply
                    if(empty($reply_to)) {

                        $reply_to = 0;

                    }

                    $db_conn = new Database;
                    $db_conn->db_insert("COMMENTS", "COMMENT, BLOG_ID, REPLY_TO, POSTED_BY_USER", "siii", array($comment, $blog_id, $reply_to, $user_id));

                    $success[] = $this->generate_comment($reply_to, $user_id, $comment);

                }

            }

            // Output errors
            if(!empty($errors)) {

                echo json_encode(["status" => "error", "errors" => $errors]);

            }

            // Output successfully uploaded images
            if(!empty($success)) {

                echo json_encode(["status" => "success", "output" => $success]);

            }

        }

    }

?>