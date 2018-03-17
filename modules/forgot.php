<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    $login = new Login;
    
    if($login->login_check()) {

        header('Location: /user/');
        exit;
        
    } else {

?>

<!-- SECTION FORGOT PASSWORD START -->
<div class="container">
    <div id="forgot__password" class="form__box">
        <h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
            &nbsp;Forgot password
        </h1>
        To request a password reset please fill out the fields below. You should then receive a email with a verification code that can be used to change your password. The email address have to be the same as the one registered with the username entered.
        <form method="post" id="forgot__password__form">
            <div class="input__box">    
                <input type="text" id="forgot__password__username" name="forgot__password__username" placeholder="Your username...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">    
                <input type="text" id="forgot__password__mail" name="forgot__password__mail" placeholder="Your email address...">
            </div>
            <div class="error__box u-margin-bottom-small"></div>
            <button type="submit" class="btn btn--primary btn--white u-margin-top-small">
                Confirm
            </button>
        </form>
    </div>
</div>
<!-- SECTION FORGOT PASSWORD END -->
<?php 
    }
?>