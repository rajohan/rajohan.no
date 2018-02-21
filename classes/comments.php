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

        function __construct() {

            $this->comments = [];

        }
        
        //-------------------------------------------------
        //  Get reply childs
        //-------------------------------------------------

        private function get_reply_childs($id) {
            
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

            $db_conn2 = new Database;
            $reply_count = $db_conn2->count('COMMENTS', 'WHERE `REPLY_TO` = ?', 'i', array($id));

            return $reply_count;

        }

        //-------------------------------------------------
        //  Get comment author
        //-------------------------------------------------

        function get_author($id) {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `POSTED_BY_USER` FROM `COMMENTS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
                
            while ($row = $result->fetch_assoc()) {
                
               $author = $row['POSTED_BY_USER'];

            }

            $db_conn->free_close($result, $stmt);   

            return $author;

        }

        //-------------------------------------------------
        //  Get the comments
        //-------------------------------------------------

        function get_comments($blog_id, $order, $offset = 0, $max = 1000000) {

            $this->blog_id = $blog_id;

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
        //  Add new comment
        //-------------------------------------------------

        function add_comment($blog_id, $user_id, $reply_to, $comment) {

            // Check that user is logged in

            // Check that comment field not is empty
            
                // Check if comment is a reply

                // Insert comment

        }

    }

?>