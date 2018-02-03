<?php 
    
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    // Class for the tags
    class Tags {

        // Method to set tags to uppercase and split the tags by whitespace and ','
        function split($tags) {

            $tags = strtoupper($tags);
            $tags = preg_split('/[ ,]+/', $tags);
            $tags = $this->add_link($tags);
            return $tags;

        }

        // Method to add count value to the tags
        function add_count($tags) {
            
            $tags = array_reduce($tags, 'array_merge', array()); // Convert multi dimensional array into single array
            $tags_count = array_count_values($tags); // Count array values that match
            arsort($tags_count); // Sort array based on count values
            $tags_with_count = []; // Crate array

            // Add the count value to corresponding tags
            foreach ($tags_count as $key => $value) {

               array_push($tags_with_count, $key."<span class='tags__count'>".$value."</span>");

            }

            return $tags_with_count;
            
        }

        // Method to get the tags
        function get_tags($table) {

            $db_conn = new Database(); // connect to database
            $filter = new Filter(); // Start filter

            $stmt = $db_conn->connect->prepare("SELECT TAGS FROM `$table`"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result

            $all_tags = [];

            while ($row = $result->fetch_assoc()) {

                $tags = $filter->sanitize($row['TAGS']);
                $tags = $this->split($tags);
                array_push($all_tags, $tags);

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

            return $all_tags;

        }
        
        function add_link($tags) {


            foreach($tags as $key => $tags_with_link) {

              $tags[$key] = '<a href="blog/sort/tag/'.strtolower($tags_with_link).'">'.$tags_with_link.'</a>';

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