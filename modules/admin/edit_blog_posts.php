<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Initialize classes
    //-------------------------------------------------
 
    $filter = new Filter;
    $user = new Users;
    $login = new Login;
    $converter = new Converter;
    $vote = new Vote;

    //-------------------------------------------------
    // Get user data
    //-------------------------------------------------

    if ($login->login_check()) {

        $user_data = $user->get_user("ID", $_SESSION['USER']['ID']);

    } else {

        header('Location: /login/');
        exit;

    }

    //-------------------------------------------------
    // Output tags if user is admin
    //-------------------------------------------------

    if((isset($user_data['ADMIN'])) && ($user_data['ADMIN'] > 0)) {

?>
<!-- SECTION EDIT BLOG POSTS START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
    &nbsp;Edit blog posts
</h1>
<div class="table">
    <div class="table__row table__header">
        <div class="table__column">
            ID
        </div>
        <div class="table__column">
            TITLE
        </div>
        <div class="table__column">
            USER (ID)
        </div>
        <div class="table__column">
            IP
        </div>
        <div class="table__column">
            DATE
        </div>
        <div class="table__column">
            VIEWS
        </div>
        <div class="table__column">
            RATING (VOTES)
        </div>
        <div class="table__column ">
            PUBLISHED
        </div>
        <div class="table__column ">
            FORCE FRONTPAGE
        </div>
    </div>
    <?php

        //-------------------------------------------------
        //  Get all tags
        //-------------------------------------------------

        $db_conn = new Database;
        $stmt = $db_conn->connect->prepare("SELECT * FROM `BLOG` ORDER BY `ID` DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $title = $filter->cut_string($filter->sanitize($row['TITLE']), 15);
            $published_by_user = $filter->sanitize($row['PUBLISHED_BY_USER']);
            $published_by_ip = $filter->sanitize($row['PUBLISHED_BY_IP']);
            $date = $converter->date($filter->sanitize($row['PUBLISH_DATE']));
            $published = $converter->yes_no($filter->sanitize($row['PUBLISHED']));
            $force_frontpage = $converter->yes_no($filter->sanitize($row['FORCE_FRONTPAGE']));

            // Get view count
            $db_conn2 = new Database;
            $view_count = $db_conn2->count('BLOG_VIEWS', 'WHERE BLOG_ID = ?', 'i', array($id));

            // Get vote count
            $db_conn2 = new Database;
            $vote_count = $db_conn2->count('BLOG_VOTES', 'WHERE ITEM_ID = ?', 'i', array($id));

            $rating = $vote->rating($id);

            // Check if user id exsist
            $db_conn2 = new Database;
            $count = $db_conn2->count("USERS", "WHERE ID= ?", "s", array($published_by_user));

            if($count > 0) {

                // Get username from id
                $username = $user->get_user("ID", $published_by_user)['USERNAME'];

            } else {

                $username = "N/A";

            }

            // Get tag times used count
            $db_conn2 = new Database;
            $count = $db_conn2->count("TAGS_LINK_BLOG", "WHERE TAG_ID= ?", "s", array($id));

            echo 
            '<div class="table__row">
                <div class="table__column">
                    '.$id.'
                </div>
                <div class="table__column">
                    '.$title.'
                </div>
                <div class="table__column">
                    '.$username.' ('.$published_by_user.')
                </div>
                <div class="table__column">
                    '.$published_by_ip.'
                </div>
                <div class="table__column">
                    '.$date.'
                </div>
                <div class="table__column">
                    '.$view_count.'
                </div>
                <div class="table__column">
                    '.$rating.' ('.$vote_count.')
                </div>
                <div class="table__column">
                    '.$published.'
                </div>
                <div class="table__column">
                    '.$force_frontpage.'
                </div>
            </div>';


        }

        $db_conn->free_close($result, $stmt);

    ?>
</div>
<!-- SECTION BLOG POSTS END -->
<?php
    } else {

        header('Location: /user/');
        exit;

    }
?>