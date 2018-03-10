<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    if(isset($_GET['user']) && !isset($username)) {
        $username = $filter->sanitize($_GET['user']);
    }

    $login = new Login;
    
    if($login->login_check()) {

        header('Location: /user/');

    } else {

?>

<!-- SECTION CHANGE EMAIL START -->
<div class="container">
    <h1 class="heading-secondary letter-spacing-medium u-center-text">
        &nbsp;Change email
    </h1>
    <div id="change__email" class="form__box">
        <form method="post" id="change__email__form">
            <div class="input__box">    
                <input type="text" id="change__email__username" name="change__email__username" value="<?php if(isset($username)) { echo $username; } ?>" placeholder="Your username...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">    
                <input type="password" id="change__email__password" name="change__email__password" placeholder="Your password...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">    
                <input type="text" id="change__email__mail" name="change__email__mail" placeholder="New email...">
            </div>
            <div class="error__box u-margin-bottom-small"></div>
            <button type="submit" class="btn btn--primary btn--white u-margin-top-small">
                Confirm
            </button>
        </form>
        <div class="small-bold-text u-margin-top-small">
           You will have to verify your new email address to be able to sign in to your account again.
        </div>
    </div>
</div>
<!-- SECTION CHANGE EMAIL END -->
<?php
    }
?>