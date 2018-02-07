<?php

    //--------------------------------------------------------------------------
    //          A Project of Raymond Johannessen Webutvikling
    //--------------------------------------------------------------------------
    //                          WWW.RAJOHAN.NO
    //--------------------------------------------------------------------------
    //   Project:    rajohan.no
    //   Page:       config.php
    //   Modules:    (in order top->bottom) Startup commands,
    //               Global variables, Debug settings, The end.
    //
    //   Version:    1.0 - 2018-01-26
    //   Authors:    Raymond Johannessen <mail@rajohan.no>
    //               Raymond Johannessen Webutvikling.
    //   Copyright:  (c) 2018 Raymond Johannessen Webutvikling.
    //
    //   Purpose:
    //    Config for rajohan.no
    //
    //   License:
    //     None yet.
    //
    //
    //--------------------------------------------------------------------------
    // WARNINGS: DEBUG MODE IS ON!!!
    //--------------------------------------------------------------------------
    // Direct access check
    //--------------------------------------------------------------------------
    
    if(!defined('INCLUDE')) {
        
        die('Direct access is not permitted.');
    
    }

    //--------------------------------------------------------------------------
    // Start output buffering & start a new session
    //--------------------------------------------------------------------------

    ob_start();

    if (session_status() == PHP_SESSION_NONE) { 
        
        session_start();
        
    }

    //--------------------------------------------------------------------------
    // Set mysqli report mode
    //--------------------------------------------------------------------------

    mysqli_report(MYSQLI_REPORT_STRICT);

    //--------------------------------------------------------------------------
    // Initialize classes
    //--------------------------------------------------------------------------

    $db_conn = new Database;
    $filter = new Filter;

    //--------------------------------------------------------------------------
    // Global variables
    //--------------------------------------------------------------------------

    $stmt = $db_conn->connect->prepare("SELECT * FROM `CONFIG` ORDER BY `ID` DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {

        $GLOBALS['program']         =   $filter->sanitize($row['PROGRAM']); // Website name
        $GLOBALS['version']         =   $filter->sanitize($row['VERSION']); // Version of the site
        $GLOBALS['company']         =   $filter->sanitize($row['COMPANY']); // Company that made this
        $GLOBALS['org_link']        =   $filter->sanitize($row['ORG_LINK']); // Organization link
        $GLOBALS['author']          =   $filter->sanitize($row['AUTHOR']); // Person that made this
        $GLOBALS['authorweb']       =   $filter->sanitize($row['AUTHOR_WEB']); // Authors website
        $GLOBALS['copyright_link']  =   $filter->sanitize($row['COPYRIGHT_LINK']); // Link to copyright certificate
        $GLOBALS['copyright']       =   '<a href="'.$GLOBALS['copyright_link'].'" target="_blank">Copyrighted.com</a> registered &amp; protected&nbsp;&copy;&nbsp;2017-'.date('Y').'&nbsp;'; // Copyright
        $GLOBALS['self']            =    htmlentities( substr($_SERVER['PHP_SELF'], 0, strcspn( $_SERVER['PHP_SELF'] , "\n\r") ), ENT_QUOTES ); // Set self
        $GLOBALS['url']             =   $filter->sanitize($row['URL']); // Url to the page
        $GLOBALS['mail']            =   $filter->sanitize($row['MAIL']); // Mail adress to site owner
        $GLOBALS['webmaster']       =   $filter->sanitize($row['WEBMASTER']); // Webmaster mail address
        $GLOBALS['timezone']        =   $filter->sanitize($row['TIMEZONE']); // Timezone
        $GLOBALS['language']        =   $filter->sanitize($row['LANGUAGE']); // Set language page is meant for
        $GLOBALS['homepage']        =   $filter->sanitize($row['BASE_PATH']); // Path to index.php
        $GLOBALS['page_title']      =   $filter->sanitize($row['PAGE_TITLE']); // Page title
        $GLOBALS['twitter']         =   $filter->sanitize($row['TWITTER_PATH']); // Path to twitter
        $GLOBALS['facebook']        =   $filter->sanitize($row['FACEBOOK_PATH']); // Path to facebook profile
        $GLOBALS['linkedin']        =   $filter->sanitize($row['LINKEDIN_PATH']); // Path to linkedin profile
        $GLOBALS['github']          =   $filter->sanitize($row['GITHUB_PATH']); // Path to github profile
        $GLOBALS['charset']         =   $filter->sanitize($row['CHARSET']); // Charset to be used
        $GLOBALS['bot']             =   $filter->sanitize($row['BOT']); // Choose how to be indexed by spider/crawler/bot
        $GLOBALS['desc']            =   $filter->sanitize($row['DESCRIPTION']); // Page description for meta tags
        $GLOBALS['keywords']        =   $filter->sanitize($row['KEYWORDS']); // Page keywords for meta tags
        $GLOBALS['gwebmaster']      =   $filter->sanitize($row['GWEB_MASTER']); // google-site-verification ID
        $GLOBALS['csvmaster']       =   $filter->sanitize($row['CSV_MASTER']); // copyrighted site verification ID
        $GLOBALS['font']            =   $filter->sanitize($row['FONT']); // Link to selected main font
        $GLOBALS['error']           =   $filter->sanitize($row['GLOBAL_ERROR']); // Set default error message
        $GLOBALS['debug']           =   $filter->sanitize($row['DEBUG']); // Toggle debug mode on = true, off = false

    }

    $db_conn->free_close($result, $stmt);

    //--------------------------------------------------------------------------
    // DEBUG SETTINGS
    //--------------------------------------------------------------------------

    if($GLOBALS['debug'] == 'true') {
        
        ini_set('error_reporting', E_ALL); // Report all errors
        ini_set('display_errors', 1); // Toggle showing error on
        ini_set('display_startup_errors', 1); // Toggle showing startup errors on
        ini_set('track_errors', 1); // Toggle tracking of errors on
        ini_set('docref_root', '/var/www/rajohan.no/'); // Set root to docref file to enable it.
    
    } else {
        
        ini_set('display_startup_errors', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); // Dont report Notice, Strict or Deprecated.
        ini_set('display_errors', 0); // Toggle showing error off.
        ini_set('display_startup_errors', 0); // Toggle showing startup errors off.
        ini_set('track_errors', 1); // Toggle tracking of errors off.
        ini_set('docref_root', ''); // Remove root to docref file to disable it.
    
    }

    //--------------------------------------------------------------------------
    // End output buffering
    //--------------------------------------------------------------------------

    ob_end_flush();

?>