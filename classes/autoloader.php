<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Autoloader
    //-------------------------------------------------
  
    function autoloader($class) {

        if (is_file(__DIR__ .'/'.strtolower($class).'.php')) {

            require_once(__DIR__ .'/'.strtolower($class).'.php');

        }

    }

    spl_autoload_register("autoloader");

?>