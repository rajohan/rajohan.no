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

        // Method to generate slug
        function generate_slug($title) {

            setlocale(LC_ALL, 'en_US.UTF8'); // Set charset

            $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $title); // Convert all letters to UTF-8
            $clean = str_replace("',*,`", " ", $clean); // Replace ', *, `, with a whitespace
            $clean = preg_replace("/[^a-zA-Z0-9_|+ -]/", ' ', $clean); // Replace everything that's not characters, numbers or _ | + - with a whitespace
            $clean = strtolower(trim($clean, '-')); // Make all characters lowercase and trim all whitespaces replacing them with -
            $clean = preg_replace("/[_|+ -]+/", "-", $clean); // Finaly replace _ | + - with -

            return $clean;

        }

    }

?>