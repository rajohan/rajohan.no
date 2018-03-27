<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- IMAGE UPLOADER START -->
<div class="container">
    <form class="image-uploader__box" method="post" action="" enctype="multipart/form-data">
        <img src="img/icons/upload.svg" class="image-uploader__box__img">
        <div class="image-uploader__box__input">
            <input class="image-uploader__box__file" type="file" name="files[]" id="image-uploader__file" multiple>
            <div class="image-uploader__box__cta">
                <span class="image-uploader__box__cta__text">Drag your images here</span>
                <span>or</span>
                <label class="btn-flat" for="image-uploader__file">
                    Select one
                </label>
            </div>
        </div>
        <div class="image-uploader__box__status">
        </div>
    </form>
</div>
<!-- IMAGE UPLOADER END -->