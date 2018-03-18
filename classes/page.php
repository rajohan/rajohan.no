<?php 
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Create new page and edit pages
    //-------------------------------------------------

    class Page {

        private $ip;
        private $filter;
        private $validator;
        private $login;
        private $user;
        private $success;
        private $errors;
        private $user_data;

        //-----------------------------------------------
        // Construct
        //-----------------------------------------------

        function __construct() {
            
            $this->ip = $_SERVER['REMOTE_ADDR'];
            $this->filter = new Filter;
            $this->validator = new Validator;
            $this->login = new Login;
            $this->user = new Users;
            $this->success = []; // success array
            $this->errors = []; // errors array

            // Get user details
            if ($this->login->login_check()) {

                $this->user_data = $this->user->get_user("ID", $_SESSION['USER']['ID']);
        
            }

        }
        
        //-----------------------------------------------
        // Method to create new page
        //-----------------------------------------------

        function create_page($page, $file) {

            $page = $this->filter->sanitize($page);
            $file = $this->filter->sanitize($file);

            // Create tag if user is admin
            if((isset($this->user_data['ADMIN'])) && ($this->user_data['ADMIN'] > 0)) {

                // Validate page
                if(!$this->validator->validate_page($page)) {

                    $this->errors[] =  $page." Is not a valid page name.";

                }

                // Validate file
                if(!$this->validator->validate_file($file)) {

                    $this->errors[] = $file." Is not a valid file name.";

                }

                // Page and file is valid
                if(empty($this->errors)) {

                    $db_conn = new Database;
                    $count = $db_conn->count("PAGES", "WHERE PAGE = ?", "s", array($page));

                    // Create page
                    if($count < 1) { 

                        // Add tag to database
                        $db_conn = new Database;
                        $db_conn->db_insert("PAGES", "PAGE, FILE, CREATED_BY_USER, CREATED_BY_IP", "ssis", array($page, $file, $this->user_data['ID'], $this->ip));

                        $this->success[] = $page." successfully created.";

                    } else { // Page already exist

                        $this->errors[] = $page." already exist.";

                    }

                }
            
            } else { // User not logged in or are not a admin

                $this->errors = "You do not have access to create new pages.";

            }

            // Output errors
            if(!empty($this->errors)) {

                $output['errors'] = $this->errors;

            }

            // Output success
            if(!empty($this->success)) {

                $output['success'] = $this->success;

            }

            if(!empty($output)) { 

                return $output;
                
            }

        }

    }

?>