<?php
    
    // Class for the pagination
    class Pagination {

        // Method to get the page number
        private function get_page_number() {

            $page = new Page_handler(); // Request new page
            return $page->get_page_number(); // Get the current page number

        }

        // Method to count the table rows
        private function count_table_rows($table) {

            $db_conn = new Database(); // connect to database
            $filter = new Filter(); // Start filter
            $table = $filter->sanitize($table); // Sanitize table name

            $stmt = $db_conn->connect->prepare("SELECT COUNT(ID) FROM $table"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result
            $number_of_rows = $result->fetch_row(); // Get the result
            $db_conn->free_close($result, $stmt); // free result and close db connection

            return $number_of_rows[0]; // Return number of rows
            
        }

        // Metod to check if page number is valid
        private function valid_page_number($page_number, $table) {

            if($page_number > $this->count_table_rows($table)) {

                return 1; // Page number is invalid. Return 1 as page number.

            } else {

                return $page_number; // Page number is valid. Return $page_number as page number.

            }

        }
        
        // Method to output the pagination
        function output_pagination($max_per_page, $table) {
            
            $page_number = $this->valid_page_number($this->get_page_number(), $table); // Get current page number
            $num_pages = $this->count_table_rows($table) / $max_per_page; // Set the number of pages

            // Keep loop going until $i no longer is greater or equal to total of pages
            for($i = 1; $i <= $num_pages; $i++) {

                // Output prev arrow + 1 if its the start of the pagination and page number not equals 1 ($i = 1 and page number is > $i)
                if(($i === 1) && ($page_number > $i)) {

                    echo "<- ";
                    echo $i;

                }

                // Output current page in bold text if $i equals or are equal or greater then 1 and page number equals $i
                else if (($i >= 1) && ($page_number === $i)) {

                    echo "<b>[".$i."]</b> ";

                }

                // Output next page number if $i is greater then 1 and $i + 1 is equal or greater then number of total pages
                else if(($i > 1) && ($i + 1 <= $num_pages)) {

                    echo " ".$i." ";
                
                } else { // Output last page number and next page arrow. We are done.

                    echo $i;
                    echo " ->"; 

                }
            }

        }

    }

?>