<?php
    
    //-------------------------------------------------
    // Direct access check
    //-------------------------------------------------

    if(!defined('INCLUDE')) {

        die('Direct access is not permitted.');
        
    }
    
?>
<div class="text-editor u-margin-top-small">
    <div class="text-editor__message"></div>
    <div class="text-editor__toolbox u-margin-top-small">
        <div class="text-editor__toolbox__group">
            <img src="img/icons/bold.svg" alt="bold" class="toolbox__bold text-editor__toolbox__icon" onClick="execCmd(this, 'bold');">
            <img src="img/icons/italic.svg" alt="italic" class="toolbox__italic text-editor__toolbox__icon" onClick="execCmd(this, 'italic');">
            <img src="img/icons/underline.svg" alt="underline" class="toolbox__underline text-editor__toolbox__icon" onClick="execCmd(this, 'underline');">
            <img src="img/icons/strikethrough.svg" alt="strikethrough" class="toolbox__strikethrough text-editor__toolbox__icon" onClick="execCmd(this, 'strikethrough');">
            <div class="text-editor__toolbox__separator"></div>
            <img src="img/icons/list.svg" alt="list" class="toolbox__list text-editor__toolbox__icon" onClick="execCmd(this, 'insertUnorderedList');">
            <img src="img/icons/list-numbered.svg" alt="list-numbered" class="toolbox__list-numbered text-editor__toolbox__icon" onClick="execCmd(this, 'insertOrderedList');">
            <div class="text-editor__toolbox__separator"></div>
            <img src="img/icons/link.svg" alt="link" class="toolbox__link text-editor__toolbox__icon" onClick="execCmd(this, 'createLink');">
            <img src="img/icons/envelop.svg" alt="envelop" class="toolbox__envelop text-editor__toolbox__icon" onClick="execCmd(this, 'createMail');">
            <img src="img/icons/image.svg" alt="image" class="toolbox__image text-editor__toolbox__icon" onClick="execCmd(this, 'insertImage');">
            <div class="text-editor__toolbox__separator"></div>
        </div>
        <div class="text-editor__toolbox__group">
            <img src="img/icons/quotes-right.svg" alt="quotes-right" class="toolbox__quotes-right text-editor__toolbox__icon" onClick="execCmd(this, 'insertQuote');">
            <img src="img/icons/embed2.svg" alt="embed2" class="toolbox__embed2 text-editor__toolbox__icon" onClick="execCmd(this, 'insertCode');">
            <img src="img/icons/smile.svg" alt="smile" class="toolbox__emoticons text-editor__toolbox__icon">
            <div class="toolbox__emoticons__box text-editor__toolbox__emoticons__box">
                <div class="toolbox__emoticons__box__close text-editor__toolbox__emoticons__box__close">
                    x
                </div>
                <img src="img/icons/emoticons/smile.svg" alt="bold" class="emoticon__smile text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'smile.svg');">
                <img src="img/icons/emoticons/wink.svg" alt="wink" class="emoticon__wink text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'wink.svg');">
                <img src="img/icons/emoticons/tongue.svg" alt="tongue" class="emoticon__tongue text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'tongue.svg');">
                <img src="img/icons/emoticons/grin.svg" alt="grin" class="emoticon__grin text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'grin.svg');">
                <img src="img/icons/emoticons/laugh.svg" alt="laugh" class="emoticon__laugh text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'laugh.svg');">
                <img src="img/icons/emoticons/frowny.svg" alt="frowny" class="emoticon__frowny text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'frowny.svg');">
                <img src="img/icons/emoticons/unsure.svg" alt="unsure" class="emoticon__unsure text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'unsure.svg');">
                <img src="img/icons/emoticons/cry.svg" alt="cry" class="emoticon__cry text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'cry.svg');">
                <img src="img/icons/emoticons/grumpy.svg" alt="grumpy" class="emoticon__grumpy text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'grumpy.svg');">
                <img src="img/icons/emoticons/angry.svg" alt="angry" class="emoticon__angry text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'angry.svg');">
                <img src="img/icons/emoticons/astonished.svg" alt="astonished" class="emoticon__astonished text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'astonished.svg');">
                <img src="img/icons/emoticons/afraid.svg" alt="afraid" class="emoticon__afraid text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'afraid.svg');">
                <img src="img/icons/emoticons/nerd.svg" alt="nerd" class="emoticon__nerd text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'nerd.svg');">
                <img src="img/icons/emoticons/dejected.svg" alt="dejected" class="emoticon__dejecte text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'dejected.svg');">
                <img src="img/icons/emoticons/big_eyes.svg" alt="big_eyes" class="emoticon__big_eyes text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'big_eyes.svg');">
                <img src="img/icons/emoticons/sunglasses.svg" alt="sunglasses" class="emoticon__sunglasses text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'sunglasses.svg');">
                <img src="img/icons/emoticons/confused.svg" alt="confused" class="emoticon__confused text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'confused.svg');">
                <img src="img/icons/emoticons/silent.svg" alt="silent" class="emoticon__silent text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'silent.svg');">
                <img src="img/icons/emoticons/love.svg" alt="love" class="emoticon__love text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'love.svg');">
                <img src="img/icons/emoticons/kiss.svg" alt="kiss" class="emoticon__kiss text-editor__emoticons__icon" onClick="execCmd(this, 'insertEmoticon', 'kiss.svg');">
            </div>
            <div class="text-editor__toolbox__separator"></div>
            <img src="img/icons/embed.svg" alt="embed" class="toolbox__embed text-editor__toolbox__icon">
        </div>
    </div>
    <div class="text-editor__box" <?php if(isset($textEditorId)) { echo 'id="'.$textEditorId.'"'; } ?> data-placeholder="<?php if(isset($placeholder)) { echo $placeholder; } ?>" contenteditable="true"><?php if(isset($content)) { echo $content; } ?></div>
    <div class="text-editor__code-heading">
        Source code
    </div>
    <div class="text-editor__code">
    </div>
    <div <?php if(isset($statusData)) { echo $statusData; } ?> class="text-editor__status u-margin-bottom-small">
        <?php 

            if(isset($status)) { 

                echo $status; 
                
            }

        ?>
    </div>
</div>