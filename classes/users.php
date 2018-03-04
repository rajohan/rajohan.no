<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    //-------------------------------------------------
    //  Users
    //-------------------------------------------------

    class Users {

        private $filter;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------
        
        function __construct() {

            $this->filter = new Filter;
            
        }

        //-------------------------------------------------
        // Method to check if username is taken
        //-------------------------------------------------

        function username_check($username) {
            
            $username = $this->filter->sanitize($username);

            $db_conn = new Database;
            $count = $db_conn->count("USERS", "WHERE USERNAME = ?", "s", array($username));

            return $count;

        }

        //-------------------------------------------------
        // Method to verify username's password and rehash password if needed
        //-------------------------------------------------

        function verify_password($username, $password) {

            $username = $this->filter->sanitize($username);
            $password = $this->filter->sanitize($password);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `PASSWORD` FROM `USERS` WHERE `USERNAME` = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $db_password = $this->filter->sanitize($row['PASSWORD']);    

            }

            $db_conn->free_close($result, $stmt);

            $verify = password_verify($password, $db_password);

            if($verify) {

                if(password_needs_rehash($db_password, PASSWORD_DEFAULT)) {

                    $new_hash = password_hash($password, PASSWORD_DEFAULT);

                    // Update password with new hash
                    $db_conn = new Database;
                    $db_conn->db_update("USERS", "PASSWORD", "USERNAME", "ss", array($new_hash, $username));

                }

            }

            return $verify;

        }

        //-------------------------------------------------
        //  Method to get user data from id/username/mail
        //-------------------------------------------------

        function get_user($identifier, $user) {

            $user = $this->filter->sanitize($user);
            $identifier = $this->filter->sanitize($identifier);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `USERS` WHERE $identifier=?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $user_data = [];

            while ($row = $result->fetch_assoc()) {

                foreach($row as $key => $value) {

                    $user_data[$key] = $this->filter->sanitize($value);
    
                }

            }

            $db_conn->free_close($result, $stmt);   

            if(empty($user_data['ID'])) {

                $user_data['ID'] = 0;
                
            }

            return $user_data;

        }

        //-------------------------------------------------
        //  Method to get comment votes for user
        //-------------------------------------------------

        function comment_votes($user) {
             
            $user = $this->filter->sanitize($user);

            // Get id of comments by user
             $db_conn = new Database;
             $stmt = $db_conn->connect->prepare("SELECT ID FROM `COMMENTS` WHERE `POSTED_BY_USER` = ?");
             $stmt->bind_param("i", $user);
             $stmt->execute();
             $result = $stmt->get_result();
 
             $comments = [];
 
             while ($row = $result->fetch_assoc()) { 
 
                 $comment_id = $this->filter->sanitize($row['ID']);
                 array_push($comments, $comment_id);
 
             }
 
             $db_conn->free_close($result, $stmt);
 
             $comments = implode(",",$comments);
 
             // If 0 comments set comments to 0
             if(empty($comments)) {
 
                 $comments = 0;
 
             }
 
             // Get comment up votes
             $db_conn = new Database;
             $stmt = $db_conn->connect->prepare("SELECT COUNT(ID) FROM `COMMENT_VOTES` WHERE VOTE > 0 AND `ITEM_ID` IN ($comments)");
             $stmt->execute();
             $result = $stmt->get_result();
             $upvotes = $result->fetch_row();
             $db_conn->free_close($result, $stmt);
 
             // Get comment down votes
             $db_conn = new Database;
             $stmt = $db_conn->connect->prepare("SELECT COUNT(ID) FROM `COMMENT_VOTES` WHERE VOTE < 1 AND `ITEM_ID` IN ($comments)");
             $stmt->execute();
             $result = $stmt->get_result();
             $downvotes = $result->fetch_row(); // Get the result
             $db_conn->free_close($result, $stmt); // free result and close db connection

             $votes['upvotes'] = $upvotes[0];
             $votes['downvotes'] = $downvotes[0];
             
             return $votes;
             
        }

        //-------------------------------------------------
        //  Method to get blog votes for user
        //-------------------------------------------------

        function blog_votes($user) {
             
            $user = $this->filter->sanitize($user);

            // Get id of comments by user
             $db_conn = new Database;
             $stmt = $db_conn->connect->prepare("SELECT ID FROM `BLOG` WHERE `PUBLISHED_BY_USER` = ?");
             $stmt->bind_param("i", $user);
             $stmt->execute();
             $result = $stmt->get_result();
 
             $blogs = [];
 
             while ($row = $result->fetch_assoc()) { 
 
                 $blog_id = $this->filter->sanitize($row['ID']);
                 array_push($blogs, $blog_id);
 
             }
 
             $db_conn->free_close($result, $stmt);
 
             $blogs = implode(",",$blogs);
 
             // If 0 comments set comments to 0
             if(empty($blogs)) {
 
                 $blogs = 0;
 
             }
 
             // Get comment up votes
             $db_conn = new Database;
             $stmt = $db_conn->connect->prepare("SELECT COUNT(ID) FROM `BLOG_VOTES` WHERE VOTE > 0 AND `ITEM_ID` IN ($blogs)");
             $stmt->execute();
             $result = $stmt->get_result();
             $upvotes = $result->fetch_row();
             $db_conn->free_close($result, $stmt);
 
             // Get comment down votes
             $db_conn = new Database;
             $stmt = $db_conn->connect->prepare("SELECT COUNT(ID) FROM `BLOG_VOTES` WHERE VOTE < 1 AND `ITEM_ID` IN ($blogs)");
             $stmt->execute();
             $result = $stmt->get_result();
             $downvotes = $result->fetch_row(); // Get the result
             $db_conn->free_close($result, $stmt); // free result and close db connection

             $votes['upvotes'] = $upvotes[0];
             $votes['downvotes'] = $downvotes[0];
             
             return $votes;

        }

        //-------------------------------------------------
        //  Method to calculate user rating based on votes
        //-------------------------------------------------

        function rating($user) {

            $votes['comment'] = $this->comment_votes($user);
            $votes['blog'] = $this->blog_votes($user);

            $total_votes = $votes['comment']['upvotes'] + $votes['comment']['downvotes'] + $votes['blog']['upvotes'] + $votes['blog']['downvotes'];

            // If user have no votes set rating to 0
            if ($total_votes === 0) {
                $rating = "0.0";

            } else {

                $rating = number_format(((($votes['comment']['upvotes'] + $votes['blog']['upvotes']) * 10) / $total_votes), 1);

            }

            return $rating;

        }

        //-------------------------------------------------
        //  Method to get users last seen date
        //-------------------------------------------------

        function last_seen($user) {
        
            $user = $this->filter->sanitize($user);

             $db_conn = new Database;
             $stmt = $db_conn->connect->prepare("SELECT `DATE` FROM `TRAFFIC_LOG` WHERE `USER` = ? ORDER BY `ID` DESC LIMIT 1");
             $stmt->bind_param("i", $user);
             $stmt->execute();
             $result = $stmt->get_result();
 
            while ($row = $result->fetch_assoc()) { 
 
                $date = $this->filter->sanitize($row['DATE']);
 
            }
            
            if(!isset($date)) {

                $date = "N/A";
                
            }

            return $date;

        }

    }

?>