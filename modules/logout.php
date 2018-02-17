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
        if (isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {

            $user_id = $_SESSION['USER']['ID'];

            session_destroy();

            $user_id_encoded = base64_encode($user_id);
            $db_conn = new Database;
            $db_conn->db_delete('AUTH_TOKENS', 'USER', 's', $user_id_encoded); // Delete token

            echo "You are now logged out.";

        } else {

            echo "You are already logged out";

        }
    ?>
</div>
<!-- SECTION LOGOUT END -->