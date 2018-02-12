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
<div class="newsletter__code__box u-margin-bottom-medium">
    <div class="newsletter__code__unsubscribe">
        <form method="post" class="newsletter__code__form__unsubscribe">
            <div class="newsletter__form__unsubscribe__box">    
                <input type="text" id="newsletter__code__unsubscribe__mail" name="newsletter__code__unsubscribe__mail" value="<?php if(isset($mail)) { echo $mail; } ?>" class="newsletter__code__form__unsubscribe__box__input" placeholder="Your email address...">
            </div>
            <div class="newsletter__code__form__unsubscribe__error"></div>
            <div class="newsletter__code__form__unsubscribe__box">    
                <input type="text" id="newsletter__code__unsubscribe__code" name="newsletter__code__unsubscribe__code" value="<?php if(isset($verification_code)) { echo $verification_code; } ?>" class="newsletter__code__form__unsubscribe__box__input" placeholder="Verification code...">
            </div>
            <div class="newsletter__code__form__unsubscribe__error"></div>
            <button type="submit" name="unsubscribe__code__submit" class="btn btn--primary btn--white u-margin-top-small">
                Unsubscribe
            </button>
        </form>
    </div>
</div>
<!-- SECTION NEWSLETTER UNSUBSCRIBE END -->