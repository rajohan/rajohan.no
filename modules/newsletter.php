<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    //-------------------------------------------------
    // Initialize classes
    //-------------------------------------------------
    
    $db_conn = new Database;
    $filter = new Filter;
    $validator = new Validator;

    if((isset($_POST['send'])) && ($_POST['send'] === "true") && (isset($_POST['mail']))) {
        
        $mail = $filter->sanitize($_POST['mail']);

        if($validator->validate_mail($mail)) {

            echo "email is valid";

        }

        else {

            echo $GLOBALS['error'];

        }

    }

    else {

?>
    <!-- SECTION NEWSLETTER START -->
    <div class="newsletter__box u-margin-bottom-medium">
        <h1 class="heading-secondary letter-spacing-medium u-center-text u-margin-bottom-small">
            Newsletters
        </h1>
        <h1 class="heading-tertiary u-center-text u-margin-bottom-small">
            Subscribe
        </h1>
        <div class="newsletter__subscribe">
            Subscribe to my newsletters and stay updated on the latest developments and tutorials/guides!
            <form method="post" class="newsletter__form__subscribe u-margin-top-small">
                <div class="newsletter__form__subscribe__box">
                    <input type="text" id="newsletter__subscribe" name="newsletter__subscribe" class="newsletter__form__subscribe__box__input" placeholder="Your email address...">
                    <button type="submit" name="subscribe__submit" class="newsletter__form__subscribe__box__button">
                        <img class="newsletter__form__subscribe__box__icon" src="img/icons/arrow_right.svg" alt="search">
                    </button>
                </div>
                <div class="newsletter__form__subscribe__error"></div>
            </form>
        </div>
        <h1 class="heading-tertiary u-center-text u-margin-bottom-small u-margin-top-small">
            Unsubscribe
        </h1>
        <div class="newsletter__unsubscribe">
            To unsubscribe from my newsletters, input your email address in the field underneath or simply click the 'unsubscribe' link at the bottom of your latest newsletter.
            You should then recive an email with a code. Click on the link provided in the email. Input the code and you will no longer be on my mailing list.
            <form method="post" class="newsletter__form__unsubscribe u-margin-top-small">
                <div class="newsletter__form__unsubscribe__box">    
                    <input type="text" id="newsletter__unsubscribe" name="newsletter__unsubscribe" class="newsletter__form__unsubscribe__box__input" placeholder="Your email address...">
                    <button type="submit" name="unsubscribe__submit" class="newsletter__form__unsubscribe__box__button">
                        <img class="newsletter__form__unsubscribe__box__icon" src="img/icons/arrow_right.svg" alt="search">
                    </button>
                </div>
                <div class="newsletter__form__unsubscribe__error"></div>
            </form>
        </div>
    </div>
    <!-- SECTION NEWSLETTER END -->
<?php 
    }
?>