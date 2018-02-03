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
                            if(!preg_match('~\W~', $this->params[$this->params_count-1])) {

                                $tag = $this->filter->sanitize(strtolower($this->params[$this->params_count-1]));
                                $sort = 'WHERE TAGS = "'.$tag.'" OR TAGS LIKE "% '.$tag.'" OR TAGS LIKE "'.$tag.' %" OR TAGS LIKE "% '.$tag.' %" OR TAGS LIKE "'.$tag.', %" OR TAGS LIKE "% '.$tag.', %" OR TAGS LIKE ",'.$tag.'%" OR TAGS LIKE "%,'.$tag.' %"'; 
                                
                                // Check that tag exists in the database
                                if($this->db_conn->count("BLOG", $sort) > 0) {
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