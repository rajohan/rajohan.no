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
    <form class="box" method="post" action="" enctype="multipart/form-data">
        <img src="img/icons/upload.svg" class="box__img">
        <div class="box__input">
            <input class="box__file" type="file" name="files[]" id="file" data-multiple-caption="{count} files selected" multiple />
            <label class="box__file__label" for="file">
                <strong>Choose a file</strong>
                <span class="box__dragndrop"> or drag it here</span>.
            </label>
        </div>
        <div class="box__uploading">
            Uploading&hellip;
        </div>
        <div class="box__success">
            Done!
        </div>
        <div class="box__error">
            Error! 
            <span></span>
            .
        </div>
    </form>
</div>
<!-- IMAGE UPLOADER END -->