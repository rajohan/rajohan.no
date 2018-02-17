<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SECTION LOGOUT START -->
<div class="container">
    <?php
        if (isset($_SESSION['LOGGED_IN'])) {

            $login = new Login;
            $login->logout();

            echo "You are now logged out.";

        } else {

            echo "You are already logged out";

        }
    ?>
</div>
<!-- SECTION LOGOUT END -->