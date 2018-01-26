<?php
    ###########################################################################
    # INPUT DATA FILTER
    ###########################################################################
    class Filter {

        function sanitize() {
            $data = trim($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        }

    }
?>