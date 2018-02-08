<?php

    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    if(!empty($_POST['add_vote']) && $_POST['add_vote'] === "true") {

        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed 
        require_once('../configs/db.php'); // Get database username, password etc
        include_once('database_handler.php'); // Database handler
        include_once('filter.php'); // Filter

        $filter = new Filter;
        
        $vote = $filter->sanitize($_POST['vote']);
        $blog_id = $filter->sanitize($_POST['blog_id']);

        $votes = new Vote;
        $votes->add_blog_vote($vote, $blog_id);
        
        $db_conn = new Database;
        $blog_votes_like = $db_conn->count('BLOG_VOTES', $sort = 'WHERE BLOG_ID = "'.$blog_id.'" AND VOTE = 1');

        $db_conn = new Database;
        $blog_votes_dislike = $db_conn->count('BLOG_VOTES', $sort = 'WHERE BLOG_ID = "'.$blog_id.'" AND VOTE = 0');

        $vote_array['like'] = $blog_votes_like;
        $vote_array['dislike'] = $blog_votes_dislike;

        echo json_encode($vote_array);
        
    } 

    else if(!empty($_POST['add_comment_vote']) && $_POST['add_comment_vote'] === "true") {

        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed 
        require_once('../configs/db.php'); // Get database username, password etc
        include_once('database_handler.php'); // Database handler
        include_once('filter.php'); // Filter

        $filter = new Filter;

        $vote = $filter->sanitize($_POST['vote']);
        $comment_id = $filter->sanitize($_POST['comment_id']);

        $votes = new Vote;
        $votes->add_comment_vote($vote, $comment_id);
        
        $db_conn = new Database;
        $comment_votes_like = $db_conn->count('COMMENT_VOTES', $sort = 'WHERE COMMENT_ID = "'.$comment_id.'" AND VOTE = 1');
    
        $db_conn = new Database;
        $comment_votes_dislike = $db_conn->count('COMMENT_VOTES', $sort = 'WHERE COMMENT_ID = "'.$comment_id.'" AND VOTE = 0');

        $vote_array['like'] = $comment_votes_like;
        $vote_array['dislike'] = $comment_votes_dislike;

        echo json_encode($vote_array);
        
    } else { // Else check that the file is included and not accessed directly

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        }
        
    }
    
    //-------------------------------------------------
    // Class for votes
    //-------------------------------------------------

    class Vote {
        
        private $ip; // User ip

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR']; // User ip

        }

        //-------------------------------------------------
        // Method to check for earlier votes on item from the same user
        //-------------------------------------------------

        private function check_old_votes($table, $id_col_name, $item_id, $user) {
            
            $db_conn = new Database;
            $sort = 'WHERE '.$id_col_name.' = "'.$item_id.'" AND (`VOTE_BY_IP` = "'.$this->ip.'" OR (`VOTE_BY_USER` = "'.$user.'" AND `VOTE_BY_USER` != "0"))'; // What to search for
            $count = $db_conn->count($table, $sort); // Count row's in db
            return $count;

        }

        //-------------------------------------------------
        // Method to check if old vote on item is of opposite value
        //-------------------------------------------------

        private function check_vote_value($table, $id_col_name, $item_id, $vote, $user) {

            $db_conn = new Database;
            $sort = 'WHERE '.$id_col_name.' = "'.$item_id.'" AND `VOTE` = "'.$vote.'" AND (`VOTE_BY_IP` = "'.$this->ip.'" OR (`VOTE_BY_USER` = "'.$user.'" AND `VOTE_BY_USER` != "0"))'; // What to search for
            $count = $db_conn->count($table, $sort); // Count row's in db
            return $count;

        }

        //-------------------------------------------------
        // Method to add a new vote
        //-------------------------------------------------

        private function add_vote($table, $id_col_name, $blog_id, $vote, $user) {

            $db_conn = new Database;
            $db_conn->db_insert($table, ''.$id_col_name.', VOTE, VOTE_BY_USER, VOTE_BY_IP', 'iiis', array($blog_id, $vote, $user, $this->ip)); // Add vote to db

        }

        //-------------------------------------------------
        // Method to delete a vote
        //-------------------------------------------------

        private function delete_vote($table, $user) {

            $db_conn = new Database;

            $stmt = $db_conn->connect->prepare('DELETE FROM '.$table.' WHERE `VOTE_BY_IP` = ? OR `VOTE_BY_USER` = ?'); // prepare statement
            $stmt->bind_param("si", $this->ip, $user); // Bind variables to the prepared statement as parameters
            $stmt->execute(); // delete from database
            $db_conn->close_connection($stmt); // Close connection

        }

        //-------------------------------------------------
        // Method to add blog votes
        //-------------------------------------------------

        function add_blog_vote($vote, $blog_id, $user=0) {

            $count = $this->check_old_votes("BLOG_VOTES", "BLOG_ID", $blog_id, $user); // Check for old votes on item by user

            if($count <= 0) {

                $this->add_vote("BLOG_VOTES", "BLOG_ID", $blog_id, $vote, $user); // Add vote to db

            }

            else {

                $count = $this->check_vote_value("BLOG_VOTES", "BLOG_ID", $blog_id, $vote, $user); // Check for old votes on item by user of opposite value
                
                if($count <= 0) {

                    $this->delete_vote("BLOG_VOTES", $user); // Delete old vote from db
                    $this->add_vote("BLOG_VOTES", "BLOG_ID", $blog_id, $vote, $user); // Add new vote to db

                }

                else {

                    return false;

                }

            }

        }

        //-------------------------------------------------
        // Method to add comment votes
        //-------------------------------------------------
        
        function add_comment_vote($vote, $comment_id, $user=0) {

            $count = $this->check_old_votes("COMMENT_VOTES", "COMMENT_ID", $comment_id, $user); // Check for old votes on item by user

            if($count <= 0) {

                $this->add_vote("COMMENT_VOTES", "COMMENT_ID", $comment_id, $vote, $user); // Add vote to db

            }

            else {

                $count = $this->check_vote_value("COMMENT_VOTES", "COMMENT_ID", $comment_id, $vote, $user); // Check for old votes on item by user of opposite value
                
                if($count <= 0) {

                    $this->delete_vote("COMMENT_VOTES", $user); // Delete old vote from db
                    $this->add_vote("COMMENT_VOTES", "COMMENT_ID", $comment_id, $vote, $user); // Add new vote to db

                }

                else {

                    return false;

                }

            }

        }

    }

?>