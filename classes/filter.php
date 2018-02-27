<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
    //-------------------------------------------------
    // Filter
    //-------------------------------------------------

    class Filter {

        //-------------------------------------------------
        // Method to sanitize strings
        //-------------------------------------------------

        function sanitize($data) {

            $data = trim($data);
            $data = strip_tags($data);
            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            return $data;
            
        }
        
        //-------------------------------------------------
        // Method to be able to pass in arguments to htmlspecialchars before running array_map
        //-------------------------------------------------

        function htmlspecialchars_array($data) {

            $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
            return $data;
            
        }

        //-------------------------------------------------
        // Method to sanitize arrays
        //-------------------------------------------------
        
        function sanitize_array($data) {

            $data = array_map('trim', $data);
            $data = array_map('strip_tags', $data);
            $data = array_map(array($this, 'htmlspecialchars_array'), $data);
            return $data;

        }

        //-------------------------------------------------
        // Method to sanitize code blocks and surrounding data
        //-------------------------------------------------
        
        function sanitize_code($data) {

            $data = preg_split('/(\[code\])|(\[\/code\])/i', $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY); // Split comment
   
            foreach($data as $key => $value) {

                if(($value === "[code]") || ($value === "[CODE]")) {

                    $data[$key] = $value.$this->htmlspecialchars_array($data[$key+1]).$this->htmlspecialchars_array($data[$key+2]); // Create key with code block and sanitize it 
                    unset($data[$key+1]); // Unset old key with content inside [code] tags
                    unset($data[$key+2]); // Unset old key with [/code] tag

                }

            }

            $data = array_values ($data); // Reorder array

            foreach($data as $key => $value) {

                if(!preg_match("/\[code\][\s\S]*?\[\/code\]/i", $value)) {

                    $data[$key] = $this->sanitize($value); // Sanitize everything outside [code] tags

                }

            }
            
            $data = implode(" ", $data); // Convert array to string

            return $data;

        }

    }

?>