<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    $filter = new Filter;

    if(isset($_GET['email']) && !isset($mail)) {
        $mail = $filter->sanitize($_GET['email']);
    }
    
    if(isset($_GET['code'])) {
        $verification_code = $filter->sanitize($_GET['code']);
    }

?>

<!-- SECTION EMAIL VERIFY START -->
<div class="verify__email">
    <form method="post" class="verify__email__form">
        <div class="verify__email__form__box">    
            <input type="text" id="verify__email__mail" name="verify__email__mail" value="<?php if(isset($mail)) { echo $mail; } ?>" class="verify__email__form__box__input" placeholder="Your email address...">
        </div>
        <div class="verify__email__error"></div>
        <div class="verify__email__form__box">    
            <input type="text" id="verify__email__code" name="verify__email__code" value="<?php if(isset($verification_code)) { echo $verification_code; } ?>" class="verify__email__form__box__input" placeholder="Verification code...">
        </div>
        <div class="verify__email__error"></div>
        <button type="submit" name="unsubscribe__code__submit" class="btn btn--primary btn--white u-margin-top-small">
            Verify email
        </button>
    </form>
</div>
<!-- SECTION EMAIL VERIFY END -->