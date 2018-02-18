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
        // Method to generate verification codes
        //-------------------------------------------------

        function generate_token_code($length) {

            $code = substr(md5(uniqid(rand(), true)), $length, $length);
            return $code;

        }

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
            $count = $db_conn->count("AUTH_TOKENS", "WHERE SELECTOR = '".$selector_encoded."'");

            // Make sure selector is unique
            if($count > 0) {

                $this->generate_selector($length);

            } else {

                $selector = base64_decode($selector_encoded);
                
                return array($selector_encoded, $selector);

            }

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
        // Method to encode user_id
        //-------------------------------------------------

        function encode_user_id($user_id) {

            $user_id_encoded = base64_encode($user_id);

            return $user_id_encoded;

        }

    }

?>