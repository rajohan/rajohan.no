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
    $page = new Page;

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
<!-- SECTION NEW PAGE START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text">
    &nbsp;New page
</h1>
<form method="post" id="new_page">
    <div class="input__box">    
        <input type="text" id="new_page_page" name="new_page_page" placeholder="Page (ex. user)">
    </div>
    <div class="error__box"></div>
    <div class="input__box">    
        <input type="text" id="new_page_file" name="new_page_file" placeholder="File (ex. user.php)">
    </div>
    <div class="error__box u-margin-bottom-small"></div>
    <button type="submit" class="btn-flat u-margin-top-small">
        Create page
    </button>
</form>
<!-- SECTION NEW PAGE END -->
<?php

        if((isset($_POST['new_page_page'])) && (isset($_POST['new_page_file'])) && (!empty($_POST['new_page_page'])) && (!empty($_POST['new_page_file']))) {

            $create_page = $page->create_page($_POST['new_page_page'], $_POST['new_page_file']);
            if(!empty($create_page['errors'])) {

                foreach($create_page['errors'] as $key => $value) {

                    echo $value."<br>";

                }


            }

            if(!empty($create_page['success'])) {

                foreach($create_page['success'] as $key => $value) {

                    echo $value."<br>";

                }
                
            }

        } 

    } else {

        header('Location: /user/');
        exit;
        
    }
?>