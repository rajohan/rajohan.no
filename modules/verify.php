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

        $filter = new Filter;

        if(isset($_GET['email']) && !isset($mail)) {
            $mail = $filter->sanitize($_GET['email']);
        }
        
        if(isset($_GET['code'])) {
            $verification_code = $filter->sanitize($_GET['code']);
        }

?>

<!-- SECTION EMAIL VERIFY START -->
<div class="container">
    <form method="post" id="verify__mail__form">
        <div class="input__box">    
            <input type="text" id="verify__mail__mail" name="verify__mail__mail" value="<?php if(isset($mail)) { echo $mail; } ?>" placeholder="Your email address...">
        </div>
        <div class="error__box"></div>
        <div class="input__box">    
            <input type="text" id="verify__mail__code" name="verify__mail__code" value="<?php if(isset($verification_code)) { echo $verification_code; } ?>" placeholder="Verification code...">
        </div>
        <div class="error__box u-margin-bottom-small"></div>
        <button type="submit" class="btn btn--primary btn--white u-margin-top-small">
            Verify email
        </button>
        <div class="u-margin-top-small">
        <a href="resend/">Resend email verification code</a>
    </div>
    </form>
</div>
<!-- SECTION EMAIL VERIFY END -->
<?php
    }
?>