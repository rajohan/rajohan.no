<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    $login = new Login;

    if ($login->login_check()) {

        $login->logout();

        header('Location: /home/');
        exit;

    } else {

        header('Location: /home/');
        exit;

    }

?>