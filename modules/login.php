<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>
<!-- SECTION LOGIN START -->
<div class="container">
    <?php
        if (isset($_SESSION['LOGGED_IN']) && ($_SESSION['LOGGED_IN'] === true)) {

            echo "Already logged in.";

        } else {
    ?>
    <h1 class="heading-secondary letter-spacing-medium u-center-text">
        &nbsp;Sign in
    </h1>
    <form method="post" id="login__form">
        <div class="input__box">    
            <input type="text" id="login__username" name="login__username" placeholder="Username...">
        </div>
        <div class="error__box"></div>
        <div class="input__box">    
            <input type="password" id="login__password" name="login__password" placeholder="Password...">
        </div>
        <div class="error__box"></div>
        <div class="checkbox__box u-margin-top-small u-margin-bottom-small">    
            <input type="checkbox" id="login__remember" value="1" name="login__remember">
            <label for="login__remember">I trust this device. Keep me logged in.</label>
        </div>
        <div class="error__box"></div>
        <button type="submit" class="btn btn--primary btn--white u-margin-top-small">
            Sign in
        </button>
    </form>
    <div class="u-margin-top-small">
        <a href="forgot/">Forgot password</a>
        -
        <a href="resend/">Resend email verification code</a>
    </div>
    <?php
        }
    ?>
</div>
<!-- SECTION LOGIN END -->