<?php 
    
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    // Class for the tags
    class Tags {

        // Method to add count value to the tags
        function add_count($tags) {
            
            $tags_count = [];

            // Count how many times a tag is used
            foreach($tags as $key => $value) {

                $db_conn = new Database(); // connect to database

                $sort = 'WHERE TAG_ID="'.$key.'"';
                $count = $db_conn->count("TAGS_LINK_BLOG", $sort);
                $tags_count[$value] = $count;
                
            }

            arsort($tags_count); // Sort the array highest count first
            $tags_with_count = []; // Crate array

            // Merge the array
            foreach ($tags_count as $key => $value) {

              array_push($tags_with_count, $key."<span class='tags__count'>".$value."</span>");

            }

            return $tags_with_count;
            
        }

        // Method to get the tags
        function get_all_tags() {

            $db_conn = new Database(); // connect to database
            $filter = new Filter(); // Start filter

            $stmt = $db_conn->connect->prepare("SELECT * FROM `TAGS`"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result

            $all_tags = []; // Crate array

            // Get all tag names
            while ($row = $result->fetch_assoc()) {
                
                $id = $filter->sanitize($row['ID']);
                $tags = $filter->sanitize($row['TAG']);
                $all_tags[$id] = strtoupper($tags);

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

            $all_tags = $this->add_link($all_tags); // Add link to the tags
            return $all_tags;

        }

        // Method to get the tags associated with the blog post
        function get_blog_tags($id) {
            
            $db_conn = new Database(); // connect to database
            
            $stmt = $db_conn->connect->prepare("SELECT TAG_ID FROM `TAGS_LINK_BLOG` WHERE BLOG_ID = $id"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result
            $tag_id = [];

            // Get the tag id
            while ($row = $result->fetch_assoc()) {

                array_push($tag_id, $row['TAG_ID']);

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection
            
            $tag_name = []; // Crate array

            // Get the tag name based on the tag id
            foreach($tag_id as $tags) {

                $db_conn = new Database(); // connect to database
                
                $stmt = $db_conn->connect->prepare("SELECT TAG FROM `TAGS` WHERE ID = $tags"); // prepare statement
                $stmt->execute(); // select from database
                $result = $stmt->get_result(); // Get the result
                
                // Push tag names to the array
                while ($row = $result->fetch_assoc()) {

                    array_push($tag_name, strtoupper($row['TAG']));

                }
                
                $db_conn->free_close($result, $stmt); // free result and close db connection

            }

            $tag_name = $this->add_link($tag_name); // Add link to the tag
            return $tag_name;

        }
        
        // Method to add link to the tags
        function add_link($tags) {

            $page = new Page_handler(); // Request new page

            // Add the links to the tags
            foreach($tags as $key => $tags_with_link) {

              $tags[$key] = '<a href="'.$page->page.'/sort/tag/'.strtolower($tags_with_link).'">'.$tags_with_link.'</a>';

            }

            return $tags;

        }

        // Method to output the tags
        function output_tags($tags) {

            for ($i = 0; $i < count($tags); $i++) {
                
                echo '<span class="tags">'.$tags[$i].'</span>';

            } 

        }

    }

?>