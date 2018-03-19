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
<!-- SECTION EDIT TAGS START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
    &nbsp;Edit tags
</h1>
<div class="table">
    <div class="table__row table__header">
        <div class="table__column">
            ID
        </div>
        <div class="table__column">
            TAG
        </div>
        <div class="table__column">
            USED
        </div>
        <div class="table__column">
            USER (ID)
        </div>
        <div class="table__column ">
            DATE
        </div>
    </div>
    <?php

        //-------------------------------------------------
        //  Get all tags
        //-------------------------------------------------

        $db_conn = new Database;
        $stmt = $db_conn->connect->prepare("SELECT * FROM `TAGS` ORDER BY `ID` ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $tag = $filter->sanitize($row['TAG']);
            $created_by_user = $filter->sanitize($row['CREATED_BY_USER']);
            $date = $converter->date($filter->sanitize($row['CREATED_DATE']));
            $username = $user->get_user("ID", $user_id)['USERNAME'];

            // Get tag times used count
            $db_conn2 = new Database;
            $count = $db_conn2->count("TAGS_LINK_BLOG", "WHERE TAG_ID= ?", "s", array($id));

            echo 
            '<div class="table__row">
                <div class="table__column">
                    '.$id.'
                </div>
                <div class="table__column">
                    '.$tag.'
                </div>
                <div class="table__column">
                    '.$count.'
                </div>
                <div class="table__column">
                    '.$username.' ('.$created_by_user.')
                </div>
                <div class="table__column">
                    '.$date.'
                </div>
            </div>';


        }

        $db_conn->free_close($result, $stmt);

    ?>
</div>
<!-- SECTION EDIT TAGS END -->
<?php
    } else {

        header('Location: /user/');
        exit;

    }
?>