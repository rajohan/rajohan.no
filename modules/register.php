<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------
    
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SECTION REGISTER START -->
<div class="container u-margin-bottom-medium">
    <h1 class="heading-secondary letter-spacing-medium">
        &nbsp;Register today
    </h1>
    <h1 class="heading-tertiary u-margin-bottom-small">
    &nbsp;&nbsp;&nbsp;Take part in the blog discussions and much more
    </h1>
    <div class="form__box">
        <form method="post" id="register__form">
            <div class="input__box">
                <input type="text" id="register__username" name="register__username" placeholder="Username...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">
                <input type="text" id="register__email" name="register__email" placeholder="Email...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">
                <input type="password" id="register__password" name="register__password" placeholder="Password...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">
                <input type="password" id="register__password__repeat" name="register__password__repeat" placeholder="Repeat password...">
            </div>
            <div class="error__box u-margin-bottom-small"></div>
            <button type="submit" class="btn btn--primary btn--white u-margin-top-small u-margin-bottom-small">
                Register    
            </button>
        </form>
        <div class="register__legal u-margin-top-small">
            By registering, you agree to my <a href="legal/" target="_blank">legal policies</a>.
        </div>
    </div>
</div>
<!-- SECTION REGISTER END -->