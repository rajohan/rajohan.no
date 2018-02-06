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
            
            $db_conn = new Database(); // connect to database
            $sort = 'WHERE '.$id_col_name.' = "'.$item_id.'" AND (VOTE_BY_IP = "'.$this->ip.'" OR VOTE_BY_USER = "'.$user.'")'; // What to search for
            $count = $db_conn->count($table, $sort); // Count row's in db
            return $count;

        }

        //-------------------------------------------------
        // Method to check if old vote on item is of opposite value
        //-------------------------------------------------

        private function check_vote_value($table, $id_col_name, $item_id, $vote, $user) {

            $db_conn = new Database(); // connect to database
            $sort = 'WHERE '.$id_col_name.' = "'.$item_id.'" AND VOTE = "'.$vote.'" AND (VOTE_BY_IP = "'.$this->ip.'" OR VOTE_BY_USER = "'.$user.'")'; // What to search for
            $count = $db_conn->count($table, $sort); // Count row's in db
            return $count;

        }

        //-------------------------------------------------
        // Method to add a new vote
        //-------------------------------------------------

        private function add_vote($table, $id_col_name, $blog_id, $vote, $user) {

            $db_conn = new Database(); // connect to database
            $db_conn->db_insert($table, ''.$id_col_name.', VOTE, VOTE_BY_USER, VOTE_BY_IP', 'iiis', array($blog_id, $vote, $user, $this->ip)); // Add vote to db
            
            echo "added your vote!";

        }

        //-------------------------------------------------
        // Method to delete a vote
        //-------------------------------------------------

        private function delete_vote($table, $user) {

            $db_conn = new Database(); // connect to database

            $stmt = $db_conn->connect->prepare('DELETE FROM '.$table.' WHERE VOTE_BY_IP = ? OR VOTE_BY_USER = ?'); // prepare statement
            $stmt->bind_param("si", $this->ip, $user); // Bind variables to the prepared statement as parameters
            $stmt->execute(); // delete from database
            $db_conn->close_connection($stmt); // Close connection

            echo "deleted old vote and added your new vote!";

        }

        //-------------------------------------------------
        // Method to add blog votes
        //-------------------------------------------------

        function add_blog_vote() {
        
            $user = 3423;
            $vote = 0;
            $blog_id = 1;

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

                    echo "you already voted!"; // User allready voted

                }

            }

        }

        //-------------------------------------------------
        // Method to add comment votes
        //-------------------------------------------------
        
        function add_comment_vote() {

            $user = 3423;
            $vote = 1;
            $comment_id = 1;

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

                    echo "you already voted!"; // User allready voted

                }

            }

        }

    }

?>