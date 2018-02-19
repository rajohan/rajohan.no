<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SECTION FORGOT PASSWORD VERIFY START -->
<div class="container">
    <div id="forgot__password__verify" class="form__box">
        <form method="post" id="forgot__password__verify__form">
            <div class="input__box">    
                <input type="text" id="forgot__password__verify__username" name="forgot__password__verify__username" placeholder="Your username...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">    
                <input type="text" id="forgot__password__verify__code" name="forgot__password__verify__code" placeholder="Verification code...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">    
                <input type="text" id="forgot__password__verify__password" name="forgot__password__verify__password" placeholder="New password...">
            </div>
            <div class="error__box"></div>
            <div class="input__box">    
                <input type="text" id="forgot__password__verify__password-repeat" name="forgot__password__verify__password-repeat" placeholder="Repeat new password...">
            </div>
            <div class="error__box u-margin-bottom-small"></div>
            <button type="submit" class="btn btn--primary btn--white u-margin-top-small">
                Confirm
            </button>
        </form>
    </div>
</div>
<!-- SECTION FORGOT PASSWORD VERIFY END -->