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
<!-- SECTION VERIFICATION LOG START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
    &nbsp;Verification log
</h1>
<div class="table">
    <div class="table__row table__header">
        <div class="table__column">
            ID
        </div>
        <div class="table__column">
            ACTION
        </div>
        <div class="table__column">
            FUNCTION
        </div>
        <div class="table__column">
            SUCCESS
        </div>
        <div class="table__column">
            EMAIL
        </div>
        <div class="table__column">
            USER (ID)
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
        $stmt = $db_conn->connect->prepare("SELECT * FROM `VERIFICATION_LOG` ORDER BY `ID` DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $action = $filter->sanitize($row['ACTION']);
            $function = $filter->sanitize($row['FUNCTION']);
            $success = $converter->yes_no($filter->sanitize($row['SUCCESS']));
            $mail = $filter->sanitize($row['EMAIL']);
            $user_id = $filter->sanitize($row['USER']);
            $user_ip = $filter->sanitize($row['IP']);
            $date = $converter->date_time($filter->sanitize($row['DATE']));
            $username = $user->get_user("ID", $user_id)['USERNAME'];

            echo 
            '<div class="table__row">
                <div class="table__column">
                    '.$id.'
                </div>
                <div class="table__column">
                    '.$action.'
                </div>
                <div class="table__column">
                    '.$function.'
                </div>
                <div class="table__column">
                    '.$success.'
                </div>
                <div class="table__column">
                    '.$mail.'
                </div>
                <div class="table__column">
                    '.$username.' ('.$user_id.')
                </div>
                <div class="table__column">
                    '.$user_ip.'
                </div>
                <div class="table__column">
                    '.$date.'
                </div>
            </div>';


        }

        $db_conn->free_close($result, $stmt);

    ?>
</div>
<!-- SECTION VERIFICATION LOG END -->
<?php
    } else {

        header('Location: /user/');
        exit;

    }
?>