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
<!-- SECTION AUTH LOG START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
    &nbsp;Auth log
</h1>
<div class="table">
    <div class="table__row table__header">
        <div class="table__column">
            ID
        </div>
        <div class="table__column">
            USER (ID)
        </div>
        <div class="table__column">
            TOKEN
        </div>
        <div class="table__column">
            SUCCESS
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
        $stmt = $db_conn->connect->prepare("SELECT * FROM `AUTH_LOG` ORDER BY `ID` DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $user_id = $filter->sanitize($row['USER']);
            $token = $converter->yes_no($filter->sanitize($row['TOKEN']));
            $success = $converter->yes_no($filter->sanitize($row['SUCCESS']));
            $user_ip = $filter->sanitize($row['IP']);
            $date = $converter->date_time($filter->sanitize($row['DATE']));

            // Check if user id exsist
            $db_conn2 = new Database;
            $count = $db_conn2->count("USERS", "WHERE ID= ?", "s", array($user_id));

            if($count > 0) {

                // Get username from id
                $username = $user->get_user("ID", $user_id)['USERNAME'];

            } else {

                $username = "N/A";

            }

            echo 
            '<div class="table__row">
                <div class="table__column">
                    '.$id.'
                </div>
                <div class="table__column">
                    '.$username.' ('.$user_id.')
                </div>
                <div class="table__column">
                    '.$token.'
                </div>
                <div class="table__column">
                    '.$success.'
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
<!-- SECTION AUTH LOG END -->
<?php
    } else {

        header('Location: /user/');
        exit;

    }
?>