<?php
    // Check that the file is included and not accessed directly
    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

    $page = new Page_handler; // Request new page
?>

<!-- SECTION CONTACT ME START -->
<section class="contact-me <?php if ($page->page === "contact") { echo "contact-me__bg-color-white"; } else { echo "contact-me__bg-color-primary"; } ?>">
    <h1 class="heading-secondary <?php if ($page->page === "contact") { echo "heading-secondary"; } else { echo "heading-secondary--white"; } ?> letter-spacing-medium u-margin-top-medium">Contact me</h1>
    <h1 class="heading-tertiary">And get answer within 24 hours!</h1>
    <div class="contact-me__container">
        <form class="contact-me__form" method="post">
            <fieldset class="required required__grey">
                <div id="contact-me__name-img" class="contact-me__input-img">
                </div>
                <input placeholder="Your name" name="contact-me__name"  id="contact-me__name" class="contact-me__input" type="text" tabindex="1">
            </fieldset>
            <fieldset class="required required__grey">
                <div id="contact-me__mail-img" class="contact-me__input-img">
                </div>
                <input placeholder="Your email address" name="contact-me__mail" id="contact-me__mail" class="contact-me__input" type="text" tabindex="2">
            </fieldset>
            <fieldset class="not-required not-required__grey">
                <div id="contact-me__firmname-img" class="contact-me__input-img">
                </div>
                <input placeholder="Company name (optional)" name="contact-me__firmname" id="contact-me__firmname" class="contact-me__input" type="text" tabindex="3">
            </fieldset>
            <fieldset class="not-required not-required__grey">
                <div id="contact-me__tel-img" class="contact-me__input-img">
                </div>
                <input placeholder="Your telephone number (optional)" name="contact-me__tel" id="contact-me__tel" class="contact-me__input" type="text" tabindex="4">
            </fieldset>
            <fieldset class="not-required not-required__grey">
                <div id="contact-me__webpage-img" class="contact-me__input-img">
                </div>
                <input placeholder="Your web page (optional)" name="contact-me__webpage" id="contact-me__webpage" class="contact-me__input" type="text" tabindex="5">
            </fieldset>
            <fieldset class="required required__grey">
                <div id="contact-me__subject-img" class="contact-me__input-img">
                </div>
                <input placeholder="Subject" id="contact-me__subject" name="contact-me__subject" class="contact-me__input" type="text" tabindex="6">
            </fieldset>
            <fieldset class="required required__grey">
                <div id="contact-me__message-img" class="contact-me__input-img"> 
                </div>
                <textarea placeholder="Your message..." id="contact-me__message" class="contact-me__textarea" name="contact-me__message" tabindex="7"></textarea>
            </fieldset>
            <fieldset>
                <button type="submit" name="contact-me__submit" class="btn <?php if ($page->page === "contact") { echo "btn--primary btn--white"; } else { echo "btn--tertiary"; } ?> u-margin-top-medium">Send message</button>
            </fieldset>
        </form>
    </div>
</section>
<!-- SECTION CONTACT ME END -->