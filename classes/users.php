<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    //-------------------------------------------------
    //  Users
    //-------------------------------------------------

    class Users {

        private $filter;

        //-------------------------------------------------
        // Construct
        //-------------------------------------------------
        
        function __construct() {

            $this->filter = new Filter;
            
        }

        //-------------------------------------------------
        // Method to check if username is taken
        //-------------------------------------------------

        function username_check($username) {
            
            $username = $this->filter->sanitize($username);

            $db_conn = new Database;
            $count = $db_conn->count("USERS", "WHERE USERNAME = ?", "s", array($username));

            return $count;

        }

        //-------------------------------------------------
        // Method to verify username's password and rehash password if needed
        //-------------------------------------------------

        function verify_password($username, $password) {

            $username = $this->filter->sanitize($username);
            $password = $this->filter->sanitize($password);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `PASSWORD` FROM `USERS` WHERE `USERNAME` = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $db_password = $this->filter->sanitize($row['PASSWORD']);    

            }

            $db_conn->free_close($result, $stmt);

            $verify = password_verify($password, $db_password);

            if($verify) {

                if(password_needs_rehash($db_password, PASSWORD_DEFAULT)) {

                    $new_hash = password_hash($password, PASSWORD_DEFAULT);

                    // Update password with new hash
                    $db_conn = new Database;
                    $db_conn->db_update("USERS", "PASSWORD", "USERNAME", "ss", array($new_hash, $username));

                }

            }

            return $verify;

        }

        //-------------------------------------------------
        //  Method to get user data from id/username/mail
        //-------------------------------------------------
        function get_user($identifier, $user) {

            $user = $this->filter->sanitize($user);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT * FROM `USERS` WHERE $identifier=?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $user_data = [];

            while ($row = $result->fetch_assoc()) {

                foreach($row as $key => $value) {

                    $user_data[$key] = $this->filter->sanitize($value);
    
                }

            }

            $db_conn->free_close($result, $stmt);   

            if(empty($user_data['ID'])) {

                $user_data['ID'] = 0;
                
            }

            return $user_data;

        }

    }

?>