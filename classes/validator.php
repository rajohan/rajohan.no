<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Validator
    //-------------------------------------------------

    class Validator {

        //-------------------------------------------------
        // Username validator
        //-------------------------------------------------

        function validate_username($data) {

            $pattern = '/^[\w\-]{5,15}$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Username/id validator
        //-------------------------------------------------

        function validate_username_id($data) {

            $pattern = '/^[\w\-]{1,15}$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Password validator
        //-------------------------------------------------

        function validate_password($data) {

            $pattern = '/^.{6,}$/';
            return preg_match($pattern, $data);

        }


        //-------------------------------------------------
        // Email validator
        //-------------------------------------------------

        function validate_mail($data) {

            $pattern = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Name validator
        //-------------------------------------------------

        function validate_name($data) {

            $pattern = '/^[a-zÀ-ʫ\'´`-]+?\.?\s?([a-zÀ-ʫ\'´`-]+\.?\s?)+$/i';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Gender validator
        //-------------------------------------------------

        function validate_gender($data) {

            $pattern = '/^(male|female)$/i';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Url validator
        //-------------------------------------------------

        function validate_url($data) {

            $pattern = '/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Spesific page url validator
        //-------------------------------------------------

        function validate_page_url($data, $page) {

            $pattern = '/^(http:\/\/www\.|www\.|https:\/\/www\.|http:\/\/|https:\/\/)?('.$page.')(\.[a-z]{2,5})(.*)$/i';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Telephone validator
        //-------------------------------------------------

        function validate_tel($data) {

            $pattern = '/^(?:[0-9-+()\s]){0,6}(?:[0-9-+()\s]){0,6}([0-9\s]){4,15}$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Firmname validator
        //-------------------------------------------------
        
        function validate_firmname($data) {

            $pattern = '/^[A-å0-9À-ʫ\'\.\-\s\,&@]{2,}$/i';
            return preg_match($pattern, $data);
            
        }

        //-------------------------------------------------
        // Country validator
        //-------------------------------------------------
        
        function validate_country($data) {

            $pattern = '/^[A-åÀ-ʫ ,\.()\'-]{2,}$/i';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Country validator
        //-------------------------------------------------
        
        function validate_address($data) {

            $pattern = '/^[A-å0-9À-ʫ\'\.\-\s\,&@]{2,}$/i';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Tag validator
        //-------------------------------------------------
        
        function validate_tag($data) {

            $pattern = '/^[\w\-\.]{1,}$/i';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Token code validator
        //-------------------------------------------------

        function validate_token_code($data) {

            $pattern = '/^[A-z0-9]{6,6}$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Forgot password token code validator
        //-------------------------------------------------

        function validate_forgot_password_code($data) {

            $pattern = '/^[A-z0-9]{8,8}$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Number validator
        //-------------------------------------------------

        function validate_number($data) {

            $pattern = '/^[0-9]{1,}$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Id validator
        //-------------------------------------------------

        function validate_id($data) {

            $pattern = '/^[1-9][0-9]*$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // Page validator
        //-------------------------------------------------

        function validate_page($data) {

            $pattern = '/^[\w]{1,}$/';
            return preg_match($pattern, $data);

        }

        //-------------------------------------------------
        // File validator
        //-------------------------------------------------

        function validate_file($data) {

            $pattern = '/^[\w]{1,}[.][A-z]{1,}$/';
            return preg_match($pattern, $data);

        }

    }

  ?>