<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SECTION RESEND START -->
<div class="container u-margin-bottom-medium">
    <h1 class="heading-secondary letter-spacing-medium">
        &nbsp;Resend
    </h1>
    <h1 class="heading-tertiary u-margin-bottom-small">
    &nbsp;&nbsp;&nbsp;Email verification code
    </h1>
    <div id="resend" class="form__box">
        <form method="post" id="resend__form" class="u-margin-top-small">
            <div class="input__box">
                <input type="text" id="resend__mail" name="resend__mail" placeholder="Your email address...">
                <button type="submit" id="resend__button" name="resend__submit" class="input__button">
                    <img class="input__button__icon" src="img/icons/arrow_right.svg" alt="search">
                </button>
            </div>
            <div class="error__box"></div>
        </form>
    </div>
</div>
<!-- SECTION RESEND END -->