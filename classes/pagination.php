<?php
    
    // Class for the pagination
    class Pagination {

        private $page;

        function __construct() {

            $this->page = new Page_handler(); // Request new page

        }

        // Method to get the page number
        function get_page_number() {
           
            return $this->page->get_page_number(); // Get the current page number

        }

        // Method to count the table rows
        private function count_table_rows($table) {

            $db_conn = new Database(); // connect to database
            return $db_conn->count($table); // return count value
            
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
            $max_nav_pages = 10; // Max numbers of pages in the page navigation
            $start = $page_number-$max_nav_pages; // Value to start the loop on

            // Set start to 1 if it equals 0
            if($start <= 0) {

                $start = 1;
                
            }

            // Keep loop going until $i no longer is greater or equal to number of pages
            for($i = $start; $i <= $num_pages; $i++) {

                // Output prev arrow + '...' + 1 if its the start of the pagination and page number not equals 1
                if(($i === $start) && ($page_number > 1)) {

                    echo "<a href='".$this->page->page."/1/'> << </a> ";
                    echo "<a href='".$this->page->page."/".($page_number-1)."/'> < </a>";

                    // Check if number of pages are greater then max allowed in navigation and if page number not equals 2
                    if(($num_pages > $max_nav_pages) && ($page_number !== 2)) {

                        echo "<a href='".$this->page->page."/1/'> 1 </a> ";
                        echo " ... ";
                        $i++;

                    } else {

                        echo "<a href='".$this->page->page."/".$i."/'>".$i."</a>";
                        
                    }

                }

                // Output current page in bold text if $i equals or are greater then $start and page number equals $i
                else if (($i >= $start) && ($page_number === $i)) {

                    echo " <b>[<a href='".$this->page->page."/".$i."/'>".$i."</a>"."]</b> ";

                }
                
                // Output "...", last page number and next page arrow. if we have 10 pages or more. Then break the loop. We are done.
                else if(($i >= $start + $max_nav_pages+1) || ($i === $num_pages)) {
                    
                    // Check if page number equals number of pages - max allowed nav pages
                    if(($page_number === $num_pages-1 || $num_pages-2)) {

                        echo "<a href='".$this->page->page."/".$i."/'>".$i."</a>";

                    } else {

                        echo " ... ";
                        echo "<a href='".$this->page->page."/".($num_pages)."/'> ".$num_pages." </a>";

                    }

                    echo "<a href='".$this->page->page."/".($page_number+1)."/'> > </a>";
                    echo "<a href='".$this->page->page."/".($num_pages)."/'> >> </a>";
                    break;

                }

                // Output next page number if $i is greater then $start and $i + 1 is equal or greater then number of total pages
                else if(($i > $start) && ($i <= $start + $max_nav_pages)) {

                    echo " <a href='".$this->page->page."/".$i."/'>".$i."</a> ";

                } else { // Output last page number and next page arrow. We are done.

                    echo $i;
                    echo "<a href='".$this->page->page."/".($page_number+1)."/'> > </a>";;
                    echo "<a href='".$this->page->page."/".($num_pages)."/'> >> </a>";

                }

            }

        }

    }

?>