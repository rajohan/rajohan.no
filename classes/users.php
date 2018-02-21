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
        //  Get username from id
        //-------------------------------------------------

        function get_username($id) {

            $id = $this->filter->sanitize($id);
            
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `USERNAME` FROM `USERS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $username = $this->filter->sanitize($row['USERNAME']);    

            }

            $db_conn->free_close($result, $stmt);   

            return $username;

        }

        //-------------------------------------------------
        //  Get user id from username
        //-------------------------------------------------

        function get_user_id($username) {

            $username = $this->filter->sanitize($username);
            
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `ID` FROM `USERS` WHERE `USERNAME`=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $user_id = $this->filter->sanitize($row['ID']);    

            }

            if(!isset($user_id)) {

                $user_id = 0;

            }

            $db_conn->free_close($result, $stmt);   

            return $user_id;

        }

        //-------------------------------------------------
        //  Get user id from email
        //-------------------------------------------------

        function get_user_id_email($mail) {

            $mail = $this->filter->sanitize($mail);
            
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `ID` FROM `USERS` WHERE `EMAIL`=?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $user_id = $this->filter->sanitize($row['ID']);    

            }

            if(!isset($user_id)) {

                $user_id = 0;

            }

            $db_conn->free_close($result, $stmt);   

            return $user_id;

        }

        //-------------------------------------------------
        //  Get email from user id
        //-------------------------------------------------

        function get_mail($id) {

            $id = $this->filter->sanitize($id);
            
            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `EMAIL` FROM `USERS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $mail = $this->filter->sanitize($row['EMAIL']);    

            }

            $db_conn->free_close($result, $stmt);   

            return $mail;

        }

        //-------------------------------------------------
        //  Get reg date from id
        //-------------------------------------------------

        function get_reg_date($id) {

            $id = $this->filter->sanitize($id);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `REG_DATE` FROM `USERS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $reg_date = $this->filter->sanitize($row['REG_DATE']);    

            }

            $db_conn->free_close($result, $stmt);   

            return $reg_date;

        }

        //-------------------------------------------------
        //  Get admin level from id
        //-------------------------------------------------

        function get_admin_level($id) {

            $id = $this->filter->sanitize($id);

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `ADMIN` FROM `USERS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $admin = $this->filter->sanitize($row['ADMIN']);    

            }

            $db_conn->free_close($result, $stmt);   

            return $admin;

        }

    }

?>