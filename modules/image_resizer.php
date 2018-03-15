<?php

    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }

?>

<!-- IMAGE RESIZER START -->
<div class="container">
    <div class="image-resize u-margin-bottom-small">
        <div class="image-resize__box__handle image-resize__box__handle__top-left" data-pos="top-left"></div>
        <div class="image-resize__box__handle image-resize__box__handle__top-mid" data-pos="top-mid"></div>
        <div class="image-resize__box__handle image-resize__box__handle__top-right" data-pos="top-right"></div>
        <div class="image-resize__box__handle image-resize__box__handle__mid-left" data-pos="mid-left"></div>
        <div class="image-resize__box__handle image-resize__box__handle__mid-right" data-pos="mid-right"></div>
        <div class="image-resize__box__handle image-resize__box__handle__bottom-left" data-pos="bottom-left"></div>
        <div class="image-resize__box__handle image-resize__box__handle__bottom-mid" data-pos="bottom-mid"></div>
        <div class="image-resize__box__handle image-resize__box__handle__bottom-right" data-pos="bottom-right"></div>
        <div class="image-resize__box">
            <img src="image/22/" data-id="22" id="image-resize__image" class="image-resize__box__image">
            <div class="image-resize__box__crop">
                <div class="image-resize__box__crop__box">
                </div>
                <div class="image-resize__box__handle image-resize__box__handle__top-left" data-pos="top-left"></div>
                <div class="image-resize__box__handle image-resize__box__handle__top-mid" data-pos="top-mid"></div>
                <div class="image-resize__box__handle image-resize__box__handle__top-right" data-pos="top-right"></div>
                <div class="image-resize__box__handle image-resize__box__handle__mid-left" data-pos="mid-left"></div>
                <div class="image-resize__box__handle image-resize__box__handle__mid-right" data-pos="mid-right"></div>
                <div class="image-resize__box__handle image-resize__box__handle__bottom-left" data-pos="bottom-left"></div>
                <div class="image-resize__box__handle image-resize__box__handle__bottom-mid" data-pos="bottom-mid"></div>
                <div class="image-resize__box__handle image-resize__box__handle__bottom-right" data-pos="bottom-right"></div>
            </div>
        </div>
    </div>
    <span id="image-resize__confirm" class="btn-flat">Confirm edit</span>
    <div id="image-resize__status">
    </div>
</div>
<!-- IMAGE RESIZER END -->