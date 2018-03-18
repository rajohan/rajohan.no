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
<!-- SECTION CONTACT ME MESSAGES START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
    &nbsp;CONTACT ME MESSAGES
</h1>
<div class="table">
    <div class="table__row table__header">
        <div class="table__column">
            ID
        </div>
        <div class="table__column">
            NAME
        </div>
        <div class="table__column">
            EMAIL
        </div>
        <div class="table__column">
            SUBJECT
        </div>
        <div class="table__column">
            SEEN
        </div>
        <div class="table__column">
            ANSWERED
        </div>
        <div class="table__column">
            IP
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
        $stmt = $db_conn->connect->prepare("SELECT * FROM `CONTACT` ORDER BY `ID` DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $name = $filter->sanitize($row['NAME']);
            $mail = $filter->sanitize($row['EMAIL']);
            $subject = $filter->sanitize($row['SUBJECT']);
            $seen = $converter->yes_no($filter->sanitize($row['SEEN']));
            $answered = $converter->yes_no($filter->sanitize($row['ANSWERED']));
            $ip = $filter->sanitize($row['IP']);
            $date = $converter->date_time($filter->sanitize($row['DATE']));

            echo 
            '<div class="table__row">
                <div class="table__column">
                    '.$id.'
                </div>
                <div class="table__column">
                    '.$name.'
                </div>
                <div class="table__column">
                    '.$mail.'
                </div>
                <div class="table__column">
                    '.$subject.'
                </div>
                <div class="table__column">
                    '.$seen.'
                </div>
                <div class="table__column">
                    '.$answered.'
                </div>
                <div class="table__column">
                    '.$ip.'
                </div>
                <div class="table__column">
                    '.$date.'
                </div>
            </div>';


        }

        $db_conn->free_close($result, $stmt);

    ?>
</div>
<!-- SECTION CONTACT ME MESSAGES END -->
<?php
    } else {

        header('Location: /user/');
        exit;

    }
?>