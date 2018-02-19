<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SECTION FORGOT PASSWORD START -->
<div class="container">
    <h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
        &nbsp;Forgot password
    </h1>
    <div id="forgot__password" class="form__box">
        To request a password reset please fill out the fields below. You should then receive a email with a verification code that can be used to change your password. The email address have to be the same as the one registered with the username entered.
        <form method="post" id="forgot__password__form">
            <div class="input__box">    
                <input type="text" id="forgot__password__username" name="forgot_password__username" placeholder="Your username...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">    
                <input type="text" id="forgot__password__mail" name="forgot_password__mail" placeholder="Your email address...">
            </div>
            <div class="error__box u-margin-bottom-small"></div>
            <button type="submit" class="btn btn--primary btn--white u-margin-top-small">
                Confirm
            </button>
        </form>
    </div>
</div>
<!-- SECTION FORGOT PASSWORD END -->