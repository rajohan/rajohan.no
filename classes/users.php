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

        //-------------------------------------------------
        //  Get username from id
        //-------------------------------------------------

        function get_username($id) {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `USERNAME` FROM `USERS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $username = $row['USERNAME'];    

            }

            $db_conn->free_close($result, $stmt);   

            return $username;

        }

        //-------------------------------------------------
        //  Get admin level from id
        //-------------------------------------------------

        function get_admin_level($id) {

            $db_conn = new Database;
            $stmt = $db_conn->connect->prepare("SELECT `ADMIN` FROM `USERS` WHERE `ID`=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {

                $admin = $row['ADMIN'];    

            }

            $db_conn->free_close($result, $stmt);   

            return $admin;

        }

    }

?>