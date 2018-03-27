<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // New blog post
    //-------------------------------------------------
    
    class New_post {

        private $ip;
        private $filter;
        private $userData;
        private $user;
        private $validator;
        private $success;
        private $errors;
        private $login;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------

        function __construct() {

            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->filter = new Filter;
            $this->user = new Users;
            $this->validator = new Validator;
            $this->login = new Login;
            $this->success = []; // success array
            $this->errors = []; // errors array

            
            // Get user data if user is logged in
            if($this->login->login_check()) {

                $userId = $this->filter->sanitize($_SESSION['USER']['ID']);
                $this->userData = $this->user->get_user("ID", $userId);

            }
            
        }

        //-------------------------------------------------
        // Method to create blog post
        //-------------------------------------------------

        function create_post($image, $title, $tags, $shortStory, $fullStory) {

            $image = $this->filter->sanitize($image);
            $title = $this->filter->sanitize($title);
            $tags = $this->filter->sanitize($tags);
            $tags = preg_split('/\s+/', $tags, -1, PREG_SPLIT_NO_EMPTY); // Split the tags at every whitespace
            $shortStory = $this->filter->strip($shortStory);
            $fullStory = $this->filter->strip($fullStory);

            // User logged in and is admin
            if((isset($this->userData['ADMIN'])) && ($this->userData['ADMIN'] > 0)) {

                // Image missing
                if(empty($image)) {

                    $this->errors[] = "Image missing.";

                }

                // Invalid image id
                if((!empty($image)) && (!$this->validator->validate_id($image))) {

                    $this->errors[] = "Invalid image id.";

                }

                // Title missing
                if(empty($title)) {

                    $this->errors[] = "Title is missing.";

                }

                // Tag missing
                if(empty($tags)) {

                    $this->errors[] = "Tag is missing.";

                }
                
                // More then 5 tags 
                if(count($tags) > 5) {

                    $this->errors[] = "Max 5 tags allowed.";
                    
                }

                // Short story missing
                if(empty($shortStory)) {

                    $this->errors[] = "Short story is missing.";

                }

                // Full story missing
                if(empty($fullStory)) {

                    $this->errors[] = "Full story is missing.";

                }

                // No errors so far
                if(empty($this->errors)) {

                    // Create tags not already existing
                    foreach($tags as $key => $value) {

                        $db_conn = new Database;
                        $count = $db_conn->count("TAGS", "WHERE TAG = ?", "s", array($value));

                        if($this->validator->validate_tag($value)) {

                            if($count < 1) {

                                // Add tag to database
                                $db_conn = new Database;
                                $db_conn->db_insert("TAGS", "TAG, CREATED_BY_USER, CREATED_BY_IP", "sis", array($value, $this->userData['ID'], $this->ip));
                            
                            }
                        
                        } else {

                            $this->errors[] = $value." is not a valid tag.";

                        }

                    }

                    // Create the blog post
                    if(empty($this->errors)) {

                        $tagId = [];

                        // Get tag id's
                        foreach($tags as $key => $value) {

                            $db_conn = new Database;
                            $stmt = $db_conn->connect->prepare("SELECT ID FROM `TAGS` WHERE TAG = ? LIMIT 1");
                            $stmt->bind_param("s", $value);
                            $stmt->execute();
                            $result = $stmt->get_result();
            
                            while ($row = $result->fetch_assoc()) {

                                $tagId[$key] = $this->filter->sanitize($row['ID']);

                            }

                            $db_conn->free_close($result, $stmt);

                        }

                        // Insert post
                        $db_conn = new Database;
                        $db_conn->db_insert("BLOG", "IMAGE, TITLE, SHORT_BLOG, BLOG, PUBLISHED_BY_USER, PUBLISHED_BY_IP", "isssis", array($image, $title, $shortStory, $fullStory, $this->userData['ID'], $this->ip));

                        // Get id of new blog post
                        $db_conn = new Database;
                        $stmt = $db_conn->connect->prepare("SELECT ID FROM `BLOG` WHERE PUBLISHED_BY_USER = ? ORDER BY ID DESC LIMIT 1");
                        $stmt->bind_param("i", $this->userData['ID']);
                        $stmt->execute();
                        $result = $stmt->get_result();
        
                        while ($row = $result->fetch_assoc()) {

                            $blogId = $this->filter->sanitize($row['ID']);

                        }

                        $db_conn->free_close($result, $stmt);                        

                        // Link tags to blog post
                        foreach($tagId as $key => $value) {

                            // Insert link
                            $db_conn = new Database;
                            $db_conn->db_insert("TAGS_LINK_BLOG", "TAG_ID, BLOG_ID", "ii", array($value, $blogId));

                        }

                        $this->success[] = "Blog post successfully created";

                    }

                }

            } else { // User not logged in or is not a admin

                $this->errors[] = "You do not have access to create new tags.";

            }

            // Output errors
            if(!empty($this->errors)) {

                echo json_encode(["status" => "error", "errors" => $this->errors]);

            }

            // Output success message
            if(!empty($this->success)) {

                echo json_encode(["status" => "success", "output" => $this->success]);

            }

        }

    }
    
?>