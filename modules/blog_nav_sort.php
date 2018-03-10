<?php
    
    //-------------------------------------------------
    // Check for ajax calls / direct access check
    //-------------------------------------------------

    if(!empty($_POST['blog_nav_sort']) && $_POST['blog_nav_sort'] === "true") {

        session_start();
        define('INCLUDE','true'); // Define INCLUDE to get access to the files needed

        require_once('../configs/db.php');           // Get database username, password etc
        require_once('../classes/autoloader.php');   // Autoload classes needed
        require_once('../configs/config.php');       // Config

        $filter = new Filter;
        $user = new Users;
        $converter = new Converter;
        $sort_data = new Sort;

        if($_POST['sort'] === "views") {

            // Crate sort and order variables
            $blog_sort_id = $sort_data->blog_sort("BLOG_ID", "BLOG_VIEWS");

            if(!empty($blog_sort_id[0]) && !empty($blog_sort_id[1]) && !empty($blog_sort_id[2])) {

                $sort = "WHERE `ID` IN ($blog_sort_id[0], $blog_sort_id[1], $blog_sort_id[2])";
                $order = "FIELD (ID, ".$blog_sort_id[0].",".$blog_sort_id[1].",".$blog_sort_id[2].")";

            } else {

                $sort = '';
                $order = "`ID` DESC";

            }

        }

        else if($_POST['sort'] === "votes") {

            // Crate sort and order variables
            $blog_sort_id = $sort_data->blog_sort("ITEM_ID", "BLOG_VOTES");

            if(!empty($blog_sort_id[0]) && !empty($blog_sort_id[1]) && !empty($blog_sort_id[2])) {
                
            $sort = "WHERE `ID` IN ($blog_sort_id[0], $blog_sort_id[1], $blog_sort_id[2])";
            $order = "FIELD (ID, ".$blog_sort_id[0].",".$blog_sort_id[1].",".$blog_sort_id[2].")";
            
            } else {

                $sort = '';
                $order = "`ID` DESC";

            }

        } else {

            $sort = '';
            $order = "`ID` DESC";

        }

    } else {
    // Else check that the file is included and not accessed directly

        if(!defined('INCLUDE')) {

            die('Direct access is not permitted.');
            
        } else {

            $sort = '';
            $order = "`ID` DESC";

        }

    }

    $filter = new Filter;
    $user = new Users;
    $converter = new Converter;
    $sort_data = new Sort;
    
    $db_conn = new Database;
    $stmt = $db_conn->connect->prepare("SELECT `ID`, `IMAGE`, `TITLE`, `PUBLISH_DATE`, `PUBLISHED_BY_USER` FROM `BLOG` $sort ORDER BY $order LIMIT 3");

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {

        $id = $filter->sanitize($row['ID']);
        $img = $filter->sanitize($row['IMAGE']);
        $title = $filter->sanitize($row['TITLE']);
        $publish_date = $filter->sanitize($row['PUBLISH_DATE']);
        $published_by = $filter->sanitize($row['PUBLISHED_BY_USER']);

        $published_by = $user->get_user("ID", $published_by)['USERNAME'];
        $publish_date = $converter->date($publish_date);
        
        echo
        
        '<div class="blog-navigation__sort__content">
            <a href="blog/read/'.$id.'/'.$converter->generate_slug($title).'/"">
                <img class="blog-navigation__sort__content__img" src="img/blog/'.$img.'" alt="'.$title.'">
            </a>
            <div class="blog-navigation__sort__content__text">
                <a class="blog-navigation__sort__content__title" href="blog/read/'.$id.'/'.$converter->generate_slug($title).'/"">'.ucfirst($filter->cut_string($title, 20)).'</a>
                <span class="blog-navigation__sort__content__text__by">
                    <img src="img/icons/write.svg" alt="posted" class="blog-navigation__sort__content__text__img">
                    '.$publish_date.'
                    <img src="img/icons/user.svg" alt="user" class="blog-navigation__sort__content__text__img">
                    <a href="user/'.$published_by.'">'.$published_by.'</a>
                </span>
            </div>
        </div>';


    }

    $db_conn->free_close($result, $stmt);

?>