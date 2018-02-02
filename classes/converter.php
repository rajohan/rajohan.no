<?php
    
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    class Converter {

        // Method to convert date format
        function date($date) {
               
            $date = strtotime($date);
            $date = date('d.m.Y', $date);
              
            return $date;

        }

        // Method to calculate age
        function age($date) {

            $birth = explode("-", $date);
            $age = date("Y") - $birth[0];

            if(($birth[1] > date("m")) || ($birth[1] == date("m") && date("d") < $birth[2])) {

                $age = $age - 1;

            }

            return $age;

        }

    }

?>