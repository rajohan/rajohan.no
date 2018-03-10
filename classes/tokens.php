<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Tokens
    //-------------------------------------------------

    class Tokens {

        //-------------------------------------------------
        // Method to generate tokens
        //-------------------------------------------------

        function generate_token($length) {

            $token = bin2hex(random_bytes($length));
            $token_encoded = password_hash($token, PASSWORD_DEFAULT);
            
            return array($token_encoded, $token);

        }

        //-------------------------------------------------
        // Method to generate selectors
        //-------------------------------------------------

        function generate_selector($length) {

            $selector_encoded = base64_encode(bin2hex(random_bytes($length)));

            $db_conn = new Database;
            $count = $db_conn->count("AUTH_TOKENS", "WHERE SELECTOR = ?", "s", array($selector_encoded));

            // Make sure selector is unique
            if($count > 0) {

                $this->generate_selector($length);

            } else {

                $selector = base64_decode($selector_encoded);
                
                return array($selector_encoded, $selector);

            }

        }

        //-------------------------------------------------
        // Method to generate session token
        //-------------------------------------------------
        function generate_session_token($length) {

            $token = base64_encode(bin2hex(random_bytes($length)));
            
            return $token;
            
        }
        
        //-------------------------------------------------
        // Method to generate expire date
        //-------------------------------------------------

        function generate_expire_time($days) {

            $expire = time() + 3600 * 24 * $days;
            $expire_encoded = base64_encode($expire);

            return array($expire_encoded, $expire);

        }

        //-------------------------------------------------
        // Method to encode data
        //-------------------------------------------------

        function encode_data($data) {

            $data = base64_encode($data);

            return $data;

        }

        //-------------------------------------------------
        // Method to decode data
        //-------------------------------------------------

        function decode_data($data) {

            $data = base64_decode($data);

            return $data;

        }

    }

?>