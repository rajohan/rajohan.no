<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    //-------------------------------------------------
    // Class for votes
    //-------------------------------------------------

    class Vote {
        
        private $ip; // User ip
        private $login;
        private $filter;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR']; // User ip
            $this->login = new Login;
            $this->filter = new Filter;

        }

        //-------------------------------------------------
        // Method to check for earlier votes on item from the same user
        //-------------------------------------------------

        private function check_old_votes($table, $id_col_name, $item_id, $user) {
            
            $db_conn = new Database;
            $count = $db_conn->count($table, 'WHERE '.$id_col_name.' = ? AND (`VOTE_BY_IP` = ? OR (`VOTE_BY_USER` = ? AND `VOTE_BY_USER` != "0"))', "isi", array($item_id, $this->ip, $user));
            return $count;

        }

        //-------------------------------------------------
        // Method to check if old vote on item is of opposite value
        //-------------------------------------------------

        private function check_vote_value($table, $id_col_name, $item_id, $vote, $user) {

            $db_conn = new Database;
            $count = $db_conn->count($table, 'WHERE '.$id_col_name.' = ? AND `VOTE` = ? AND (`VOTE_BY_IP` = ? OR (`VOTE_BY_USER` = ? AND `VOTE_BY_USER` != "0"))', "iisi", array($item_id, $vote, $this->ip, $user));
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

        private function delete_vote($table, $id, $user) {

            $db_conn = new Database;

            $stmt = $db_conn->connect->prepare('DELETE FROM '.$table.' WHERE `ITEM_ID` = ? AND (`VOTE_BY_IP` = ? OR `VOTE_BY_USER` = ?)'); // prepare statement
            $stmt->bind_param("isi", $id, $this->ip, $user); // Bind variables to the prepared statement as parameters
            $stmt->execute(); // delete from database
            $db_conn->close_connection($stmt); // Close connection

        }

        //-------------------------------------------------
        // Method to add blog votes
        //-------------------------------------------------

        function add_blog_vote($vote, $blog_id) {

            if($this->login->login_check()) {

                $user = $_SESSION['USER']['ID'];

            } else {
            
                $user = 0;

            }

            $count = $this->check_old_votes("BLOG_VOTES", "ITEM_ID", $blog_id, $user); // Check for old votes on item by user

            if($count <= 0) {

                $this->add_vote("BLOG_VOTES", "ITEM_ID", $blog_id, $vote, $user); // Add vote to db

            }

            else {

                $count = $this->check_vote_value("BLOG_VOTES", "ITEM_ID", $blog_id, $vote, $user); // Check for old votes on item by user of opposite value
                
                if($count <= 0) {

                    $this->delete_vote("BLOG_VOTES", $blog_id, $user); // Delete old vote from db
                    $this->add_vote("BLOG_VOTES", "ITEM_ID", $blog_id, $vote, $user); // Add new vote to db

                }

                else {

                    return false;

                }

            }

        }

        //-------------------------------------------------
        // Method to add comment votes
        //-------------------------------------------------

        function add_comment_vote($vote, $comment_id) {

            if($this->login->login_check()) {

                $user = $_SESSION['USER']['ID'];

            } else {
            
                $user = 0;

            }

            $count = $this->check_old_votes("COMMENT_VOTES", "ITEM_ID", $comment_id, $user); // Check for old votes on item by user

            if($count <= 0) {

                $this->add_vote("COMMENT_VOTES", "ITEM_ID", $comment_id, $vote, $user); // Add vote to db

            }

            else {

                $count = $this->check_vote_value("COMMENT_VOTES", "ITEM_ID", $comment_id, $vote, $user); // Check for old votes on item by user of opposite value
                
                if($count <= 0) {

                    $this->delete_vote("COMMENT_VOTES", $comment_id, $user); // Delete old vote from db
                    $this->add_vote("COMMENT_VOTES", "ITEM_ID", $comment_id, $vote, $user); // Add new vote to db

                }

                else {

                    return false;

                }

            }

        }

        function rating($blog_id) {

            $blog_id = $this->filter->sanitize($blog_id);

            // Get vote count
            $db_conn2 = new Database;
            $like_vote_count = $db_conn2->count('BLOG_VOTES', 'WHERE ITEM_ID = ? AND VOTE = 1', 'i', array($blog_id));

            // Get vote count
            $db_conn2 = new Database;
            $dis_like_vote_count = $db_conn2->count('BLOG_VOTES', 'WHERE ITEM_ID = ? AND VOTE = 0', 'i', array($blog_id));

            $total_votes = $like_vote_count + $dis_like_vote_count;

            // If past have no votes set rating to 0
            if ($total_votes === 0) {
                $rating = "0.0";

            } else {

                $rating = number_format((($like_vote_count * 10) / $total_votes), 1);

            }

            return $rating;

        }

    }

?>