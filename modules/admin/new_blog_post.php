<!-- SECTION NEW BLOG POST START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text">
    &nbsp;New blog post
</h1>
<!-- IMAGE UPLOADER START -->
<div class="admin__image-upload u-margin-top-small">
    <h1 class="heading-tertiary__black">Header image</h1>
    <form class="image-uploader__box u-margin-top-small" method="post" action="" enctype="multipart/form-data">
        <img src="img/icons/upload.svg" class="image-uploader__box__img">
        <div class="image-uploader__box__input">
            <input class="image-uploader__box__file" type="file" name="new_post_image[]" id="image-uploader__file">
            <div class="image-uploader__box__cta">
                <span class="image-uploader__box__cta__text">Drag your image here</span>
                <span>or</span>
                <label class="btn-flat" for="image-uploader__file">
                    Select one
                </label>
            </div>
        </div>
    </form>
    <div class="image-uploader__box__status">
    </div>
</div>
<!-- IMAGE UPLOADER END -->
<div class="admin__input-box">
    <label class="admin__label" for="new_post_title">Title</label>
    <input type="text" class="admin__input" id="new_post_title" name="new_post_blog_title" placeholder="Title...">
</div>
<div class="admin__input-box">   
    <label class="admin__label" for="new_post_tags">Tags<span class="small-text">(max 5)</span><div class="new__post__tags__selected" id="new_post_tags_selected"></div></label>
    <input type="text" class="admin__input" data-tags="" id="new_post_tags" name="new_post_blog_tags" placeholder="Tags separated by space...">
    <div class="suggestions__box"></div>
</div>
<div class="admin__input-box"> 
    <h1 class="heading-tertiary__black">Short story</h1>
    <?php

        $textEditorId = "new_post_short_story";
        $placeholder = "Short story...";
        require('modules/text_editor.php');

    ?>
</div>
<div class="admin__input-box">
    <h1 class="heading-tertiary__black">Full story</h1>
    <?php

        $textEditorId = "new_post_full_story";
        $placeholder = "Full story...";
        require('modules/text_editor.php');

    ?>
</div>
<button type="submit" id="create_post" class="btn-flat u-margin-top-small">
    Submit blog post
</button>
<div class="admin__status-box u-margin-top-small">
</div>
<!-- SECTION NEW BLOG POST START -->