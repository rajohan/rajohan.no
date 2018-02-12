<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------
    
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SECTION REGISTER START -->
<div class="register__box u-margin-bottom-medium">
    <h1 class="heading-secondary letter-spacing-medium u-center-text">
        Register today
    </h1>
    <h1 class="heading-tertiary u-center-text u-margin-bottom-small">
        Take part in the blog discussions and much more
    </h1>
    <div class="register__fields">
        <form method="post" class="register__form">
            <div class="register__form__box">
                <input type="text" id="register__username" name="register__username" class="register__form__box__input" placeholder="Username...">
            </div>
            <div class="register__form__error"></div>
            <div class="register__form__box">
                <input type="text" id="register__email" name="register__email" class="register__form__box__input" placeholder="Email...">
            </div>
            <div class="register__form__error"></div>
            <div class="register__form__box">
                <input type="password" id="register__password" name="register__password" class="register__form__box__input" placeholder="Password...">
            </div>
            <div class="register__form__error"></div>
            <div class="register__form__box">
                <input type="password" id="register__password__repeat" name="register__password__repeat" class="register__form__box__input" placeholder="Repeat password...">
            </div>
            <div class="register__form__error"></div>
            <button type="submit" name="" class="btn btn--primary btn--white u-margin-top-small">
                Register    
            </button>
        </form>
        <div class="register__legal u-margin-top-small">
            By registering, you agree to my <a href="legal/" target="_blank">legal policies</a>.
        </div>
    </div>
</div>
<!-- SECTION REGISTER END -->