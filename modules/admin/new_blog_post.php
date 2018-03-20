<!-- SECTION NEW BLOG POST START -->
<h1 class="heading-secondary letter-spacing-medium u-center-text">
    &nbsp;New blog post
</h1>
<div class="admin__input-box">
    <label class="admin__label" for="new_post_image">Image</label>
    <input type="text" class="admin__input" id="new_post_image" name="new_post_blog_title" placeholder="Image...">
</div>
<div class="admin__input-box">
    <label class="admin__label" for="new_post_title">Title</label>
    <input type="text" class="admin__input" id="new_post_title" name="new_post_blog_title" placeholder="Title...">
</div>
<div class="admin__input-box">   
    <label class="admin__label" for="new_post_tags">Tags</label>
    <input type="text" class="admin__input" id="new_post_tags" name="new_post_blog_tags" placeholder="Tags separated by space...">
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
<button type="submit" class="btn-flat u-margin-top-small">
    Submit blog post
</button>
<!-- SECTION NEW BLOG POST START -->