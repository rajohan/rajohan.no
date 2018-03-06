<div class="text-editor u-margin-top-small">
    <div class="text-editor__message"></div>
    <div class="text-editor__toolbox u-margin-top-small">
        <img src="img/icons/bold.svg" alt="bold" id="toolbox__bold" class="text-editor__toolbox__icon" onClick="execCmd('bold');">
        <img src="img/icons/italic.svg" alt="italic" id="toolbox__italic" class="text-editor__toolbox__icon" onClick="execCmd('italic');">
        <img src="img/icons/underline.svg" alt="underline" id="toolbox__underline" class="text-editor__toolbox__icon" onClick="execCmd('underline');">
        <img src="img/icons/strikethrough.svg" alt="strikethrough" id="toolbox__strikethrough" class="text-editor__toolbox__icon" onClick="execCmd('strikethrough');">
        <div class="text-editor__toolbox__separator"></div>
        <img src="img/icons/list.svg" alt="list" id="toolbox__list" class="text-editor__toolbox__icon" onClick="execCmd('insertUnorderedList');">
        <img src="img/icons/list-numbered.svg" alt="list-numbered" id="toolbox__list-numbered" class="text-editor__toolbox__icon" onClick="execCmd('insertOrderedList');">
        <div class="text-editor__toolbox__separator"></div>
        <img src="img/icons/link.svg" alt="link" id="toolbox__link" class="text-editor__toolbox__icon" onClick="execCmd('createLink');">
        <img src="img/icons/envelop.svg" alt="envelop" id="toolbox__envelop" class="text-editor__toolbox__icon" onClick="execCmd('createMail');">
        <img src="img/icons/image.svg" alt="image" id="toolbox__image" class="text-editor__toolbox__icon" onClick="execCmd('insertImage');">
        <div class="text-editor__toolbox__separator"></div>
        <img src="img/icons/quotes-right.svg" alt="quotes-right" id="toolbox__quotes-right" class="text-editor__toolbox__icon" onClick="execCmd('insertQuote');">
        <img src="img/icons/embed2.svg" alt="embed2" id="toolbox__embed2" class="text-editor__toolbox__icon" onClick="execCmd('insertCode');">
        <img src="img/icons/smile.svg" alt="smile" id="toolbox__emoticons" class="text-editor__toolbox__icon">
        <div id="toolbox__emoticons__box" class="text-editor__toolbox__emoticons__box">
            <div id="toolbox__emoticons__box__close" class="text-editor__toolbox__emoticons__box__close">
                x
            </div>
            <img src="img/icons/emoticons/smile.svg" alt="bold" id="emoticon__smile" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'smile.svg');">
            <img src="img/icons/emoticons/wink.svg" alt="wink" id="emoticon__wink" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'wink.svg');">
            <img src="img/icons/emoticons/tongue.svg" alt="tongue" id="emoticon__tongue" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'tongue.svg');">
            <img src="img/icons/emoticons/grin.svg" alt="grin" id="emoticon__grin" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'grin.svg');">
            <img src="img/icons/emoticons/laugh.svg" alt="laugh" id="emoticon__laugh" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'laugh.svg');">
            <img src="img/icons/emoticons/frowny.svg" alt="frowny" id="emoticon__frowny" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'frowny.svg');">
            <img src="img/icons/emoticons/unsure.svg" alt="unsure" id="emoticon__unsure" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'unsure.svg');">
            <img src="img/icons/emoticons/cry.svg" alt="cry" id="emoticon__cry" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'cry.svg');">
            <img src="img/icons/emoticons/grumpy.svg" alt="grumpy" id="emoticon__grumpy" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'grumpy.svg');">
            <img src="img/icons/emoticons/angry.svg" alt="angry" id="emoticon__angry" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'angry.svg');">
            <img src="img/icons/emoticons/astonished.svg" alt="astonished" id="emoticon__astonished" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'astonished.svg');">
            <img src="img/icons/emoticons/afraid.svg" alt="afraid" id="emoticon__afraid" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'afraid.svg');">
            <img src="img/icons/emoticons/nerd.svg" alt="nerd" id="emoticon__nerd" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'nerd.svg');">
            <img src="img/icons/emoticons/dejected.svg" alt="dejected" id="emoticon__dejected" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'dejected.svg');">
            <img src="img/icons/emoticons/big_eyes.svg" alt="big_eyes" id="emoticon__big_eyes" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'big_eyes.svg');">
            <img src="img/icons/emoticons/sunglasses.svg" alt="sunglasses" id="emoticon__sunglasses" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'sunglasses.svg');">
            <img src="img/icons/emoticons/confused.svg" alt="confused" id="emoticon__confused" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'confused.svg');">
            <img src="img/icons/emoticons/silent.svg" alt="silent" id="emoticon__silent" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'silent.svg');">
            <img src="img/icons/emoticons/love.svg" alt="love" id="emoticon__love" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'love.svg');">
            <img src="img/icons/emoticons/kiss.svg" alt="kiss" id="emoticon__kiss" class="text-editor__emoticons__icon" onClick="execCmd('insertEmoticon', 'kiss.svg');">
        </div>
        <div class="text-editor__toolbox__separator"></div>
        <img src="img/icons/embed.svg" alt="embed" id="toolbox__embed" class="text-editor__toolbox__icon">
    </div>
    <div id="text-editor__box" class="text-editor__box" data-placeholder="<?php if(isset($placeholder)) { echo $placeholder; } ?>" contenteditable="true"></div>
    <div id="text-editor__code-heading" class="text-editor__code-heading">
        Source code
    </div>
    <div id="text-editor__code" class="text-editor__code">
    </div>
    <div id="text-editor__status" <?php if(isset($status_data)) { echo $status_data; } ?> class="text-editor__status u-margin-bottom-small">
        <?php 

            if(isset($status)) { 

                echo $status; 
                
            }

        ?>
    </div>
</div>