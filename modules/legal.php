<?php

    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
?>
<!-- SECTION LEGAL START -->
<section class="legal">
    <div class="legal__box">
        
        <u><span style="font-size:30px;"><b>Legal policies</b></span></u>

        <span id="legal__disclaimer" class="legal__navigation">1. Disclaimer</span>
        <span id="legal__privacy" class="legal__navigation">2. Privacy policy</span>
        <span id="legal__cookies" class="legal__navigation">3. Cookies</span>
        <span id="legal__refund" class="legal__navigation">4. Refund policy</span>
        <span id="legal__tos" class="legal__navigation">5. Terms and conditions</span>

        <div class="legal__contact">If you require any more information or have any questions about my legal policies, please feel free to <a href="contact/">contact me</a>.</div>
        
        <?php
            $db_conn = new Database(); // connect to database
            $filter = new Filter(); // Start filter
            $bbcode = new Bbcode(); // Start bbcode parser
            $stmt = $db_conn->connect->prepare("SELECT * FROM `LEGAL` ORDER BY `ID` DESC LIMIT 1"); // prepare statement
            $stmt->execute(); // select from database
            $result = $stmt->get_result(); // Get the result

            while ($row = mysqli_fetch_assoc($result)) {
                $disclaimer = $bbcode->replace($filter->sanitize($row['DISCLAIMER']));
                $privacy_part1 = $bbcode->replace($filter->sanitize($row['PRIVACY_PART1']));
                $cookies = $bbcode->replace($filter->sanitize($row['COOKIES']));
                $privacy_part2 = $bbcode->replace($filter->sanitize($row['PRIVACY_PART2']));
                $refund = $bbcode->replace($filter->sanitize($row['REFUND']));
                $tos = $bbcode->replace($filter->sanitize($row['TOS']));
                $user = $filter->sanitize($row['USER']);
                $date = $filter->sanitize($row['DATE']);
            }
            
            $db_conn->free_close($result, $stmt); // free result and close db connection

            $date = strtotime($date); // convert date/time to unix timestap
            $date = date('d.m.Y', $date); // convert date/time back to desired format

            echo '<div id="legal__disclaimer-target">'.$disclaimer.'</div>';
            echo '<div id="legal__privacy-target">'.$privacy_part1.'</div>';
            echo '<div id="legal__cookies-target">'.$cookies.'</div>';
            echo '<div id="legal__privacy-target">'.$privacy_part2.'</div>';
            echo '<div id="legal__refund-target">'.$refund.'</div>';
            echo '<div id="legal__tos-target">'.$tos.'</div>';
            echo "<h6 class='legal__update'>This legal policies was last updated ".$date." by ".ucfirst($user).".</h6></div>";

        ?>
    </div>
</section>
<!-- SECTION LEGAL END -->