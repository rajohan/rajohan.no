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

<!-- SECTION NEWSLETTER UNSUBSCRIBE START -->
<div class="container u-margin-bottom-medium">
    <form method="post" id="newsletter__verify">
        <div class="input__box">    
            <input type="text" id="newsletter__verify__mail" name="newsletter__verify__mail" value="<?php if(isset($mail)) { echo $mail; } ?>" placeholder="Your email address...">
        </div>
        <div class="error__box"></div>
        <div class="input__box">    
            <input type="text" id="newsletter__verify__code" name="newsletter__verify__code" value="<?php if(isset($verification_code)) { echo $verification_code; } ?>" placeholder="Verification code...">
        </div>
        <div class="error__box u-margin-bottom-small"></div>
        <button type="submit" name="newsletter__verify__submit" class="btn btn--primary btn--white u-margin-top-small">
            Unsubscribe
        </button>
    </form>
</div>
<!-- SECTION NEWSLETTER UNSUBSCRIBE END -->