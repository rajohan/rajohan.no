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
    <h1 class="heading-secondary letter-spacing-medium u-center-text">
        &nbsp;Sign in
    </h1>
    <form method="post" id="login__form">
        <div class="input__box">    
            <input type="text" id="login__username" name="login__username" placeholder="Username...">
        </div>
        <div class="error__box"></div>
        <div class="input__box">    
            <input type="text" id="login__password" name="login__password" placeholder="Password...">
        </div>
        <div class="error__box u-margin-bottom-small"></div>
        <button type="submit" class="btn btn--primary btn--white u-margin-top-small">
            Sign in
        </button>
    </form>
</div>
<!-- SECTION LOGIN END -->