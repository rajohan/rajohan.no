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
<!-- SECTION EDIT HEADERS START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
    &nbsp;Edit headers
</h1>
<div class="table">
    <div class="table__row table__header">
        <div class="table__column">
            ID
        </div>
        <div class="table__column">
            IMAGE
        </div>
        <div class="table__column">
            FILE
        </div>
        <div class="table__column">
            TITLE
        </div>
        <div class="table__column">
            SUB TITLE
        </div>
        <div class="table__column">
            BUTTON TEXT
        </div>
        <div class="table__column">
            LINK
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
        $stmt = $db_conn->connect->prepare("SELECT * FROM `HEADER` ORDER BY `ID` DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $file = $filter->sanitize($row['IMAGE']);
            $title = $filter->cut_string($filter->sanitize($row['TITLE']), 15);
            $sub_title = $filter->cut_string($filter->sanitize($row['SUB_TITLE']), 20);
            $button_text = $filter->sanitize($row['BUTTON_TEXT']);
            $link = $filter->sanitize($row['LINK']);
            $user_id = $filter->sanitize($row['CREATED_BY_USER']);
            $date = $converter->date($filter->sanitize($row['CREATED_DATE']));
            $username = $user->get_user("ID", $user_id)['USERNAME'];

            echo 
            '<div class="table__row">
                <div class="table__column">
                    '.$id.'
                </div>
                <div class="table__column">
                    <img src="img/header/'.$file.'" alt="'.$file.'">
                </div>
                <div class="table__column">
                    '.$file.'
                </div>
                <div class="table__column">
                    '.$title.'
                </div>
                <div class="table__column">
                    '.$sub_title.'
                </div>
                <div class="table__column">
                    '.$button_text.'
                </div>
                <div class="table__column">
                    '.$link.'
                </div>
                <div class="table__column">
                    '.$username.' ('.$user_id.')
                </div>
                <div class="table__column">
                    '.$date.'
                </div>
            </div>';


        }

        $db_conn->free_close($result, $stmt);

    ?>
</div>
<!-- SECTION EDIT HEADERS END -->
<?php
    } else {

        header('Location: /user/');
        exit;

    }
?>