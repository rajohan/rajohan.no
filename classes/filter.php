<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {
        
        die('Direct access is not permitted.');
        
    }

    ###########################################################################
    # INPUT DATA FILTER
    ###########################################################################
    class Filter {

        function sanitize($data) {

            $data = trim($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            return $data;
            
        }

    }

?>