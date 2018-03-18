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
    $tag = new Tags;

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
    // Output new tag page if user is admin
    //-------------------------------------------------

    if((isset($user_data['ADMIN'])) && ($user_data['ADMIN'] > 0)) {

?>
<!-- SECTION NEW TAGS START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text">
    &nbsp;New tags
</h1>
<form method="post" id="new_tags">
    <div class="input__box">    
        <input type="text" id="new_tags" name="new_tags" placeholder="Tags separated by space...">
    </div>
    <button type="submit" class="btn-flat u-margin-top-small">
        Create tags
    </button>
</form>
<!-- SECTION NEW TAGS END -->
<?php

        if((isset($_POST['new_tags'])) && (!empty($_POST['new_tags']))) {

            $create_tag = $tag->create_tags($_POST['new_tags']);

            if(!empty($create_tag['errors'])) {

                echo implode(", ",$create_tag['errors'])." already exist or is invalid.<br>";

            }

            if(!empty($create_tag['success'])) {

                echo implode(", ",$create_tag['success'])." successfully created.";
                
            }

        }

    } else {

        header('Location: /user/');
        exit;
        
    }
?>