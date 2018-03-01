<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    if (isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {

        $login = new Login;
        $login->logout();

        header('Location: /home/');

    } else {

        header('Location: /home/');

    }

?>