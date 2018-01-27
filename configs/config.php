<?php

    ############################################################################
    #          A Project of Raymond Johannessen Webutvikling
    ############################################################################
    #                          WWW.RAJOHAN.NO
    ############################################################################
    #   Project:    rajohan.no
    #   Page:       config.php
    #   Modules:    (in order top->bottom) Startup commands,
    #               Global variables, Debug settings, The end.
    #
    #   Version:    1.0 - 2018-01-26
    #   Authors:    Raymond Johannessen <mail@rajohan.no>
    #               Raymond Johannessen Webutvikling.
    #   Copyright:  (c) 2018 Raymond Johannessen Webutvikling.
    #
    #   Purpose:
    #    Config for rajohan.no
    #
    #   License:
    #     None yet.
    #
    #
    ############################################################################
    # WARNINGS: DEBUG MODE IS ON!!!
    ############################################################################
    # RUN STARTUP COMMANDS
    ############################################################################
    if(!defined('INCLUDE')) {
        
        die('Direct access is not permitted.'); // Check that the file is included and not accessed directly
    
    }

    ob_start(); // start output buffering
    mysqli_report(MYSQLI_REPORT_STRICT); // Set mysqli reporting to strict

    if (session_status() == PHP_SESSION_NONE) { 
        
        session_start(); // start a new session, if its not allready started
        
    }
    ############################################################################
    # GLOBAL VARIABLES
    ############################################################################
    $GLOBALS['program']         =   'Rajohan.no'; // Website name
    $GLOBALS['version']         =   'v1.0 - 06.12.2017'; // Version of the site
    $GLOBALS['company']         =   'Raymond Johannessen Webutvikling'; // Company that made this
    $GLOBALS['org_link']        =   'https://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=998619335';
    $GLOBALS['author']          =   'Raymond Johannessen'; // Person that made this
    $GLOBALS['copyright_link']  =   'https://www.copyrighted.com/website/uSpDm4NTL5wPLq0d?url=https%3A%2F%2Frajohan.no%2F';
    $GLOBALS['copyright']       =   '<a href="'.$GLOBALS['copyright_link'].'" target="_blank">Copyrighted.com</a> registered &amp; protected&nbsp;&copy;&nbsp;2017-'.date('Y').'&nbsp;'; // Copyright
    $GLOBALS['authorweb']       =   'https://rajohan.no'; // Authors website
    $GLOBALS['self']            =    htmlentities( substr($_SERVER['PHP_SELF'], 0, strcspn( $_SERVER['PHP_SELF'] , "\n\r") ), ENT_QUOTES );
    $GLOBALS['url']             =   'https://rajohan.no'; // Url to the page
    $GLOBALS['mail']            =   'mail@rajohan.no'; // Mail adress to site owner
    $GLOBALS['webmaster']       =   'webmaster@rajohan.no'; // Webmaster mail address
    $GLOBALS['timezone']        =   'Europe/Oslo'; // Timezone
    $GLOBALS['language']        =   'en'; // Set language page is meant for
    $GLOBALS['homepage']        =   '/'; // Path to index.php
    $GLOBALS['page_title']      =   'Rajohan.no'; // Page title
    $GLOBALS['twitter']         =   'https://twitter.com/Rajohan'; // Path to twitter
    $GLOBALS['facebook']        =   'https://www.facebook.com/raymond.johannessen.5'; // Path to facebook profile
    $GLOBALS['linkedin']        =   'https://www.linkedin.com/in/rajohan/'; // Path to linkedin profile
    $GLOBALS['github']          =   'https://github.com/rajohan'; // Path to github profile
    $GLOBALS['charset']         =   'UTF-8'; // Charset to be used
    $GLOBALS['bot']             =   'index, follow'; // Choose how to be indexed by spider/crawler/bot
    $GLOBALS['desc']            =   'Web development, Programming tutorials, Computer guides'; // Page description for meta tags
    $GLOBALS['keywords']        =   'Web development, Web design, Programming, Coding, Tutorials, Guides, Computer, Blog, HTML, CSS, JavaScript, jQuery, PHP, MYSQL, Linux, Ubuntu'; // Page keywords for meta tags
    $GLOBALS['gwebmaster']      =   'googlef02d6c3d5697c444'; // google-site-verification ID
    $GLOBALS['csvmaster']       =   '2c138698bdd758f3'; // copyrighted site verification ID
    $GLOBALS['font']            =   'https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900'; // Link to selected main font
    $GLOBALS['error']           =   'Beklager en feil har oppst&aring;tt!'; // Set default error message
    $GLOBALS['debug']           =   'true'; // Toggle debug mode on = true, off = false
    ############################################################################
    # DEBUG SETTINGS
    ############################################################################
    if($GLOBALS['debug'] == 'true') {
        
        ini_set('error_reporting', E_ALL); // Report all errors
        ini_set('display_errors', 1); // Toggle showing error on
        ini_set('display_startup_errors', 1); // Toggle showing startup errors on
        ini_set('track_errors', 1); // Toggle tracking of errors on
        ini_set('docref_root', '/var/www/rajohan.no/'); // Set root to docref file to enable it.
        // phpinfo(); // Echo phpinfo();
    
    } else {
        
        ini_set('display_startup_errors', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); // Dont report Notice, Strict or Deprecated.
        ini_set('display_errors', 0); // Toggle showing error off.
        ini_set('display_startup_errors', 0); // Toggle showing startup errors off.
        ini_set('track_errors', 1); // Toggle tracking of errors off.
        ini_set('docref_root', ''); // Remove root to docref file to disable it.
    
    }
    
    // ini_set('log_errors', 1); // Toggle log errors
    // ini_set('error_log', '/home/2/r/rajohan/log/php_errors.log'); // Set dir to log file
    ###########################################################################
    # THE END. Run final commands
    ###########################################################################
    ob_end_flush(); // We are done and are ending the output buffering

?>