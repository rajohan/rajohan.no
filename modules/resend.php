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

    } else {

?>

<!-- SECTION RESEND START -->
<div class="container u-margin-bottom-medium">
    <div id="resend" class="form__box">
        <h1 class="heading-secondary letter-spacing-medium">
            &nbsp;Resend
        </h1>
        <h1 class="heading-tertiary u-margin-bottom-small">
        &nbsp;&nbsp;&nbsp;Email verification code
        </h1>
        Input your email address in the field underneath to get a new verification code
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
    <div class="small-bold-text u-margin-top-small">
        If you don't have access to the email address associated with your user account you can change it by clicking <a href="change_email/">here</a>
    </div> 
</div>
<!-- SECTION RESEND END -->
<?php
    }
?>