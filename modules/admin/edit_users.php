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
<!-- SECTION EDIT USERS START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
    &nbsp;Edit users
</h1>
<div class="table">
    <div class="table__row table__header">
        <div class="table__column">
            ID
        </div>
        <div class="table__column">
            USERNAME
        </div>
        <div class="table__column">
            EMAIL
        </div>
        <div class="table__column">
            VERIFIED
        </div>
        <div class="table__column">
            REG DATE
        </div>
        <div class="table__column">
            IP
        </div>
        <div class="table__column">
            RATING (VOTES)
        </div>
        <div class="table__column">
            ACCESS LEVEL
        </div>
    </div>
    <?php

        //-------------------------------------------------
        //  Get all tags
        //-------------------------------------------------

        $db_conn = new Database;
        $stmt = $db_conn->connect->prepare("SELECT * FROM `USERS` ORDER BY `ID` DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {

            $id = $filter->sanitize($row['ID']);
            $username = $filter->sanitize($row['USERNAME']);
            $mail = $filter->sanitize($row['EMAIL']);
            $verified = $converter->yes_no($filter->sanitize($row['EMAIL_VERIFIED']));
            $reg_date = $converter->date_time($filter->sanitize($row['REG_DATE']));
            $user_ip = $filter->sanitize($row['IP']);
            $access_level = $converter->admin($filter->sanitize($row['ADMIN']));
            $ratio = $user->rating($id);

            // Total number of votes
            $comment_votes = $user->comment_votes($id);
            $blog_votes = $user->blog_votes($id);
            $total_votes = $comment_votes['upvotes'] + $comment_votes['downvotes'] + $blog_votes['upvotes'] + $blog_votes['downvotes'];

            echo 
            '<div class="table__row">
                <div class="table__column">
                    '.$id.'
                </div>
                <div class="table__column">
                    '.$username.'
                </div>
                <div class="table__column">
                    '.$mail.'
                </div>
                <div class="table__column">
                    '.$verified.'
                </div>
                <div class="table__column">
                    '.$reg_date.'
                </div>
                <div class="table__column">
                    '.$user_ip.'
                </div>
                <div class="table__column">
                    '.$ratio.' ('.$total_votes.')
                </div>
                <div class="table__column">
                    '.$access_level.'
                </div>
            </div>';


        }

        $db_conn->free_close($result, $stmt);

    ?>
</div>
<!-- SECTION EDIT USERS END -->
<?php
    } else {

        header('Location: /user/');
        exit;

    }
?>