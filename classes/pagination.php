<?php
    
    // Class for the pagination
    class Pagination {

        private $page;
        private $max_nav_pages;

        function __construct() {

            $this->page = new Page_handler(); // Request new page

            // Max numbers of pages in the page navigation 
            // Page number 1 and last page do NOT count. 
            // 2 x "..." count as 1 number. 
            // If you want ex: 6 numbers outputed in total this value should be 4.
            // If "..." is shown on start and end values you will lose 1 number to keep the pagination size consistent
            $this->max_nav_pages = 4;

        }

        // Method to count the table rows
        private function count_table_rows($table) {

            $db_conn = new Database(); // connect to database
            return $db_conn->count($table); // return count value
            
        }

        // Metod to generate the output
        private function output($number, $value) {
            echo "<a href='".$this->page->page."/".($number)."/'>".$value."</a>";
        }

        // Method to output current active page number
        private function current($i) {

            echo "<a class='active' href='".$this->page->page."/".$i."/'>".$i."</a>";

        }

        // Method to output the first page arrow and prev arrow 
        private function start_arrow($page_number) {

            $this->output($page_number-1, "&LT;");

        }

        // Method to output last page arrow end arrow
        private function end_arrow($page_number) {

            $this->output($page_number+1, "&GT;");

        }

        // Method to output value of $i as page number
        private function number($i) {

            $this->output($i, $i);
            
        }

        // Method to output last page number
        private function last_page($num_pages) {

            $this->output($num_pages, $num_pages);

        }

        // Method to output '...'
        private function dots() {

            echo " <div class='pagination__dots'>...</div>";

        }


        // Method to get the page number
        function get_page_number() {
           
            return $this->page->get_page_number(); // Get the current page number

        }

        // Metod to check if page number is valid
        function valid_page_number($page_number, $table) {

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
            
            $max_nav_pages = $this->max_nav_pages;
            
            $start = $page_number-$max_nav_pages; // Value to start the loop on

            // Set start to 1 if it equals 0
            if($start <= 0) {

                $start = 1;
                
            }

            // Keep loop going until $i no longer is greater or equal to number of pages
            for($i = $start; $i <= $num_pages; $i++) {

                // Output start arrows + '...' + number 1 if its the start of the pagination and page number not equals 1
                if(($i === $start) && ($page_number > 1)) {

                    $this->start_arrow($page_number); // Output the first page arrow and prev arrow 

                    // Check if number of pages are greater then max allowed in navigation and if page number not is less then or equal to 3. 
                    // And that max allowed pages + 2 not is equal to total pages.
                    if(($num_pages > $max_nav_pages) && !($page_number <= 3) && ($max_nav_pages + 2 !== $num_pages)) {

                        $this->number(1); // Output page number 1
                        $this->dots(); // Output "..."
                        $i++;

                    } else {

                        $this->number($i); // Output $i
                        
                    }

                }

                // Output current active page number if $i equals or are greater then $start and page number equals $i
                else if (($i >= $start) && ($page_number === $i)) {

                    $this->current($i); // Output current active page number

                }
                
                // Output "...", last page number and next page arrow if we have reached max nav pages. Then break the loop. We are done.
                else if((($i >= $start + $max_nav_pages+1) || ($i === $num_pages)) && ($num_pages > $max_nav_pages)) {
                    
                    // Check if page number equals number of pages - 1 or - 2
                    if(($page_number === $num_pages-1) || ($page_number === $num_pages-2)) {

                        $this->number($i); // Output $i
                        
                        // if page number equals total number of pages and $i not equals total number of pages output last page number
                        if(($page_number === $num_pages-2) && ($i !== $num_pages)) {

                            $this->last_page($num_pages); // Output last page number

                        }
                    
                    } else {

                        // Output "..." if max nav pages + 2 not equals number of pages
                        if($max_nav_pages + 2 !== $num_pages) {

                            $this->dots(); // Output "..."

                        }

                        $this->last_page($num_pages); // Output last page number

                    }

                    $this->end_arrow($page_number); // Output last page arrow and end arrow
                    break;

                }

                // Output next page number if $i is greater then $start and $i is less or equal to $start + max nav pages 
                // And $i are not equal to total number of pages
                else if(($i > $start) && ($i <= $start + $max_nav_pages) && ($i !== $num_pages)) {

                    $this->number($i); // Output $i

                } else { // Output last page number and next page arrow. We are done.

                    $this->number($i); // Output $i
                    $this->end_arrow($page_number); // Output last page arrow end arrow

                }

            }

        }

    }

?>