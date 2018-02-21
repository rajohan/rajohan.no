<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
 

    //-------------------------------------------------
    // Sort
    //-------------------------------------------------

    class Sort {

        private $filter;
        private $page;
        private $params;
        private $params_count;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->filter = new Filter;
            $this->page = new Page_handler;

            $this->params = $this->page->split_url($this->page->current_url()); // Split the url at each '/' 
            $this->params_count = count($this->params); // Count parameters

        }
        
        //-------------------------------------------------
        // Method to get the tag id
        //-------------------------------------------------

        private function get_tag_id($tag) {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare('SELECT `ID` FROM `TAGS` WHERE `TAG` = ? LIMIT 1'); // prepare statement
            $stmt->bind_param("s", $tag);
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result

            while ($row = $result->fetch_assoc()) {
                
                $tag_id = $row['ID'];

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

            return $tag_id;
        }

        //-------------------------------------------------
        // Method to get blog id
        //-------------------------------------------------

        private function get_blog_id($tag_id) {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare('SELECT `BLOG_ID` FROM `TAGS_LINK_BLOG` WHERE `TAG_ID` = ?'); // prepare statement
            $stmt->bind_param("i", $tag_id);
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result

            $blog_id = [];

            while ($row = $result->fetch_assoc()) {
                
                array_push($blog_id, $row['BLOG_ID']);

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

            $sort = 'WHERE ID = "'.$blog_id[0].'"';

            for($i = 1; $i < count($blog_id); $i++) {

                $sort = $sort.' OR ID = "'.$blog_id[$i].'"';
                
            }

            return $sort;

        }

        //-------------------------------------------------
        // Method to sort by tag
        //-------------------------------------------------
        
        function by_tag() {

            // Check if sort parameter is set
            if(isset($this->params[$this->params_count-4]) && isset($this->params[$this->params_count-3])) {
                
                // Check that parameters equals blog / sort
                if(($this->params[$this->params_count-4] === "blog") && ($this->params[$this->params_count-3]) === "sort") {
                    
                    // Check if tag parameter is set
                    if ($this->params[$this->params_count-2] === "tag") {
                        
                        // Check that the parameter to sort by exists
                        if (!empty($this->params[$this->params_count-1])) {

                            // Check that the parameter to sort by is valid
                            if(!preg_match('[a-z0-9.\-_#@!+?]', $this->params[$this->params_count-1])) {

                                $tag = $this->filter->sanitize(strtolower($this->params[$this->params_count-1]));

                                // Check that tag exists in the database
                                $db_conn = new Database;
                                if($db_conn->count("TAGS", "WHERE TAG = ?", "s", array($tag)) > 0) {

                                    $tag_id = $this->get_tag_id($tag);
                                    $sort = $this->get_blog_id($tag_id);

                                    return $sort; 

                                }

                            }

                        }

                    }

                }

            }

        }

        //-------------------------------------------------
        // Method to sort blog by views/votes
        //-------------------------------------------------

        function blog_sort($id_row_name, $table) {

            // Select BLOG_ID from BLOG_VIEWS
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT $id_row_name FROM $table");
            $stmt->execute();
            $result = $stmt->get_result();
        
            $blog_sort_count = [];
        
            // Crate array with blog ids
            while ($row = $result->fetch_assoc()) {

                $blog_id = $this->filter->sanitize($row[$id_row_name]);
                array_push($blog_sort_count, $blog_id);
                
            }
            
            $db_conn->free_close($result, $stmt);
        
            // Count views on each blog id and add value to blog ids
            $blog_sort_count = array_count_values($blog_sort_count);
            
            // Sort array by views
            arsort($blog_sort_count);
        
            // Create array with the blog id's
            $blog_sort_id = [];

            foreach($blog_sort_count as $key => $value) {

                array_push($blog_sort_id, $key);

            }
        
            return $blog_sort_id;

        }

        //-------------------------------------------------
        // Method to sort blog by views/votes
        //-------------------------------------------------

        function comment_sort($blog_id) {

            // Get all root comments
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT ID FROM `COMMENTS` WHERE `BLOG_ID`=?  AND `REPLY_TO` < 1");
            $stmt->bind_param("i", $blog_id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $comment_root_id = [];
        
            // Crate array with root comments
            while ($row = $result->fetch_assoc()) {

                $comment_ids = $this->filter->sanitize($row['ID']);
                array_push($comment_root_id, $comment_ids);
                
            }
            
            $db_conn->free_close($result, $stmt);
            
            // Make a string from array to use in mysqli query
            $comment_ids = implode(",",$comment_root_id);

            // Get comment count for each root comment
            if(empty($comment_ids)) {

                $comment_ids = 0;

            }

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `ITEM_ID` FROM `COMMENT_VOTES` WHERE VOTE > 0 AND `ITEM_ID` IN ($comment_ids)");
            $stmt->execute();
            $result = $stmt->get_result();
            
            $comment_vote_count = [];
            
            // Crate array with comment count
            while ($row = $result->fetch_assoc()) {

                $comment_id = $this->filter->sanitize($row['ITEM_ID']);
                array_push($comment_vote_count, $comment_id);
                
            }

            $db_conn->free_close($result, $stmt);

            // Merge array with comment count + id with array containing all root comment id's 
            // To account for comments with a vote count of 0
            $output = array_merge($comment_vote_count, $comment_root_id);

            // Put comment id's as key value and count value as value for the associated key (merge equal values and add 1 to count value)
            $comment_vote_count = array_count_values($output);
            
            // Sort the array key with highest count value first
            arsort($comment_vote_count);
        
            $comment_vote_id = [];

             // Create array with only comment id's (key)
            foreach($comment_vote_count as $key => $value) {

                array_push($comment_vote_id, $key);

            }

            // Make a string from array to use in mysqli query
            $output = implode(",",$comment_vote_id);

            if(empty($output)) {

                $output = 0;
                
            }

            return $output;

        }

    }

?>