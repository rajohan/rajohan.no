<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {
        
        die('Direct access is not permitted.');
        
    }

    // Class to sort data
    class Sort {

        private $filter;
        private $db_conn;
        private $page;
        private $params;
        private $params_count;

        function __construct() {

            $this->filter = new Filter(); // Start filter
            $this->db_conn = new Database(); // connect to database
            $this->page = new Page_handler(); // Start page handler

            $this->params = $this->page->split_url($this->page->current_url()); // Split the url at each '/' 
            $this->params_count = count($this->params); // Count parameters

        }

        // Method to get the tag id
        private function get_tag_id($tag) {

            $db_conn = new Database(); // connect to database
            
            $stmt = $db_conn->connect->prepare('SELECT ID FROM `TAGS` WHERE TAG = "'.$tag.'" LIMIT 1'); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result

            while ($row = $result->fetch_assoc()) {
                
                $tag_id = $row['ID'];

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

            return $tag_id;
        }

        // Method to get blog id
        private function get_blog_id($tag_id) {
            $db_conn = new Database(); // connect to database
            
            $stmt = $db_conn->connect->prepare('SELECT BLOG_ID FROM `TAGS_LINK_BLOG` WHERE TAG_ID = "'.$tag_id.'"'); // prepare statement
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

        // Method to sort by tag
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
                                $sort = 'WHERE TAG = "'.$tag.'"';

                                // Check that tag exists in the database
                                if($this->db_conn->count("TAGS", $sort) > 0) {

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

    }

?>