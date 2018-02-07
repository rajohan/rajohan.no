<?php

    //-------------------------------------------------
    //  Get comments
    //-------------------------------------------------

    class Comments {

        private $comments;
        private $blog_id;

        function __construct() {

            $this->comments = [];

        }

        //-------------------------------------------------
        //  Count replys
        //-------------------------------------------------

        function count_replys($id) {

            $db_conn2 = new Database;
            $reply_count = $db_conn2->count('COMMENTS', $sort = 'WHERE REPLY_TO = "'.$id.'"');

            return $reply_count;

        }

        function get_author($id) {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `COMMENTS` WHERE ID=?");
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
        //  Get reply childs
        //-------------------------------------------------

        private function get_reply_childs($id) {
            
            if($this->count_replys($id) > 0) {
                
                $db_conn = new Database;
                $stmt = $db_conn->connect->prepare("SELECT * FROM `COMMENTS` WHERE BLOG_ID=?  AND REPLY_TO=? ORDER BY `ID`");
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
                $stmt = $db_conn->connect->prepare("SELECT * FROM `COMMENTS` WHERE BLOG_ID=?  AND REPLY_TO=? ORDER BY `ID`");
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
        //  Get the comments
        //-------------------------------------------------

        function get_comments($blog_id) {

            $this->blog_id = $blog_id;

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `COMMENTS` WHERE BLOG_ID=?  AND REPLY_TO < 1 ORDER BY `ID`");
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

    }

?>