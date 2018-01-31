<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {
        
        die('Direct access is not permitted.');
        
    }
    
    ###########################################################################
    # INPUT DATA FILTER
    ###########################################################################
    class Filter {

        // Metod to sanitize strings
        function sanitize($data) {

            $data = trim($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            return $data;
            
        }
        
        // Method to be able to pass in arguments to htmlspecialchars before running array_map
        function htmlspecialchars_array($data) {
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            return $data;
        }

        // Metod to sanitize arrays
        function sanitize_array($data) {

            $data = array_map('trim', $data);
            $data = array_map('strip_tags', $data);
            $data = array_map(array($this, 'htmlspecialchars_array'), $data);
            return $data;

        }

    }

?>