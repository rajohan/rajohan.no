<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------
    
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- SECTION NEWSLETTER START -->
<div class="container u-margin-bottom-medium">
    <h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
        &nbsp;Newsletters
    </h1>
    <h1 class="heading-tertiary u-center-text u-margin-bottom-small">
        &nbsp;Subscribe
    </h1>
    <div id="newsletter__subscribe" class="form__box">
        Subscribe to my newsletters and stay updated on the latest developments and tutorials/guides!
        <form method="post" id="newsletter__subscribe__form" class="u-margin-top-small">
            <div class="input__box">
                <input type="text" id="newsletter__subscribe__mail" name="newsletter__subscribe__mail" placeholder="Your email address...">
                <button type="submit" id="newsletter__subscribe__button" name="subscribe__submit" class="input__button">
                    <img class="input__button__icon" src="img/icons/arrow_right.svg" alt="search">
                </button>
            </div>
            <div class="error__box"></div>
        </form>
    </div>
    <h1 class="heading-tertiary u-center-text u-margin-bottom-small u-margin-top-small">
        &nbsp;Unsubscribe
    </h1>
    <div id="newsletter__unsubscribe" class="form__box">
        To unsubscribe from my newsletters, input your email address in the field underneath or simply click the 'unsubscribe' link at the bottom of your latest newsletter.
        You should then recive a email with a verification code. Click on the link provided in the email or use the field that appers underneath after submitting your email. Input the verification code and you will no longer be on my mailing list.
        <form method="post" id="newsletter__unsubscribe__form" class="u-margin-top-small">
            <div class="input__box">    
                <input type="text" id="newsletter__unsubscribe__mail" name="newsletter__unsubscribe__mail" placeholder="Your email address...">
                <button type="submit" name="unsubscribe__submit" class="input__button">
                    <img class="input__button__icon" src="img/icons/arrow_right.svg" alt="search">
                </button>
            </div>
            <div class="error__box"></div>
        </form>
    </div>
</div>
<!-- SECTION NEWSLETTER END -->