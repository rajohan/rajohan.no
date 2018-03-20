<?php 
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Tags
    //-------------------------------------------------

    class Tags {

        private $filter;
        private $page;
        private $user;
        private $login;
        private $validator;
        private $ip;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->filter = new Filter;
            $this->page = new Page_handler;
            $this->user = new Users;
            $this->login = new Login;
            $this->validator = new Validator;
            $this->ip = $_SERVER['REMOTE_ADDR'];

        }

        //-------------------------------------------------
        // Method to add count value to the tags
        //-------------------------------------------------

        function add_count($tags) {
            
            $tags_count = [];

            // Count how many times a tag is used
            foreach($tags as $key => $value) {

                $db_conn = new Database;

                $count = $db_conn->count("TAGS_LINK_BLOG", "WHERE TAG_ID= ?", "s", array($key));
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

        //-------------------------------------------------
        // Method to get the tags
        //-------------------------------------------------

        function get_all_tags() {

            $db_conn = new Database;

            $stmt = $db_conn->connect->prepare("SELECT * FROM `TAGS`"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result

            $all_tags = []; // Crate array

            // Get all tag names
            while ($row = $result->fetch_assoc()) {
                
                $id = $this->filter->sanitize($row['ID']);
                $tags = $this->filter->sanitize($row['TAG']);
                $all_tags[$id] = strtoupper($tags);

            }

            $db_conn->free_close($result, $stmt); // free result and close db connection

            $all_tags = $this->add_link($all_tags); // Add link to the tags
            return $all_tags;

        }

        //-------------------------------------------------
        // Method to get the tags associated with the blog post
        //-------------------------------------------------

        function get_blog_tags($id) {
            
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `TAG_ID` FROM `TAGS_LINK_BLOG` WHERE `BLOG_ID` = ?"); // prepare statement
            $stmt->bind_param("i", $id);
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

                $db_conn = new Database;
                $stmt = $db_conn->connect->prepare("SELECT `TAG` FROM `TAGS` WHERE `ID` = ?"); // prepare statement
                $stmt->bind_param("i", $tags);
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

        //-------------------------------------------------
        // Method to add link to the tags
        //-------------------------------------------------

        function add_link($tags) {

            $tag_page = $this->page->page;

            if($tag_page === "read") {
                $tag_page = "blog";
            }

            // Add the links to the tags
            foreach($tags as $key => $tags_with_link) {
                
                $tags[$key] = '<a href="'.$tag_page.'/sort/tag/'.strtolower($tags_with_link).'">'.$tags_with_link.'</a>';

            }

            return $tags;

        }

        //-------------------------------------------------
        // Method to output the tags
        //-------------------------------------------------
        
        function output_tags($tags) {

            for ($i = 0; $i < count($tags); $i++) {
                
                echo '<span class="tags">'.$tags[$i].'</span>';

            } 

        }

        //-------------------------------------------------
        // Method to create new tags
        //-------------------------------------------------

        function create_tags($tags) {

            $tags = $this->filter->sanitize($tags);

            // Split the tags at every whitespace
            $tags = preg_split('/\s+/', $tags, -1, PREG_SPLIT_NO_EMPTY);

            $success = []; // success array
            $errors = []; // errors array

            // Get user details
            if ($this->login->login_check()) {

                $user_data = $this->user->get_user("ID", $_SESSION['USER']['ID']);
        
            }

            // Create tag if user is admin
            if((isset($user_data['ADMIN'])) && ($user_data['ADMIN'] > 0)) {

                foreach($tags as $key => $value) {

                    $db_conn = new Database;
                    $count = $db_conn->count("TAGS", "WHERE TAG = ?", "s", array($value));

                    // Tag do not already exist
                    if(($count < 1) && ($this->validator->validate_tag($value))) {

                        // Add tag to database
                        $db_conn = new Database;
                        $db_conn->db_insert("TAGS", "TAG, CREATED_BY_USER, CREATED_BY_IP", "sis", array($value, $user_data['ID'], $this->ip));

                        $success[] = $value;


                    } else {

                        $errors[] = $value;

                    }

                }

                // Output errors
                if(!empty($errors)) {

                    $output['errors'] = $errors;

                }

                // Output success
                if(!empty($success)) {

                    $output['success'] = $success;

                }

                if(!empty($output)) { 

                    return $output;
                    
                }

            } else { // User not logged in or are not a admin

                $output['errors'] = "You do not have access to create new tags.";

            }

        }

        function suggest_tags($tag) {

            $tag = $this->filter->sanitize($tag);
            $tag = "%".$tag."%";
            
            $tags = [];

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `TAGS` WHERE TAG LIKE ? ORDER BY `TAG` ASC LIMIT 5");
            $stmt->bind_param("s", $tag);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {

                array_push($tags, ucfirst($row['TAG']));

            }

            $db_conn->free_close($result, $stmt);

            echo json_encode(["new_post_tags" => $tags]);

        }

    }

?>