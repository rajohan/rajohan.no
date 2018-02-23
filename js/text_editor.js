//-------------------------------------------------
// Show/hide code box
//-------------------------------------------------
$("#toolbox__embed").click(function(){

    $("#text-editor__code").text($("#text-editor__box")[0].innerHTML);
    $("#text-editor__code-heading").toggle();
    $("#text-editor__code").toggle();

});

//-------------------------------------------------
// Insert 2 * <br> on "return" keydown
//-------------------------------------------------
$("#text-editor__box").keydown(function(event) {

    // trap the return key being pressed
    if (event.keyCode == 13) {

        document.execCommand("insertHTML", false, "<br><br>"); // insert 2 br tags
        return false; // prevent the default behaviour of return key pressed

    }

});

//-------------------------------------------------
// Show/hide placeholder
//-------------------------------------------------
var placeholder;

$("#text-editor__box").focusin(function () {

    placeholder = $("#text-editor__box").attr("data-placeholder");
    $(this).attr("data-placeholder", "");

});

$("#text-editor__box").focusout(function () {

    $(this).attr("data-placeholder", placeholder);

});

//-------------------------------------------------
// Show/hide emoticon box
//-------------------------------------------------
$("#toolbox__emoticons").click(function(){

    $("#toolbox__emoticons__box").toggle();

});

$("#toolbox__emoticons__box__close").click(function(){

    $("#toolbox__emoticons__box").hide();

});


//-------------------------------------------------
//  Toolbar icon click
//-------------------------------------------------
function execCmd(command, input) {

    $("#text-editor__box").focus(); // Focus the text editor box
    var selection = document.getSelection(); // Get selected element

    // run create url function
    if(command === "createLink") {

        createUrl(selection);

    }

    // run create mail function
    else if(command === "createMail") {

        createMail(selection);

    }

    // run insert image function
    else if(command === "insertImage") {

        insertImg();

    }

    // insert quote
    else if(command === "insertQuote") {

        document.execCommand("insertHTML", false, "<span class='quote'>"+document.getSelection()+"</span>");

    }

    // insert code
    else if(command === "insertCode") {

        document.execCommand("insertHTML", false, "<span class='code'>"+document.getSelection()+"</span>");

    }

    // insert emoticon
    else if(command === "insertEmoticon") {

        document.execCommand("insertHTML", false, "<img src='"+input+"' class='emoticon' alt='"+input+"' style='margin-bottom: -0.3rem; width: 1.7rem; height: 1.7rem;'>");
        $("#toolbox__emoticons__box").hide();

    }

    else {

        document.execCommand(command, false, null);

    }

}

//-------------------------------------------------
//  Create url
//-------------------------------------------------

function createUrl(selection) {

    var url = prompt("Enter your URL:", "http://");

    if ((url != null) && (url != "")) {

        document.execCommand("createLink", false, url);
        selection.anchorNode.parentElement.target = "_blank";

    }

}

//-------------------------------------------------
//  Create mail
//-------------------------------------------------

function createMail(selection) {

    var mail = prompt("Enter your mail address:", "");

    if ((mail != null) && (mail != "")) {

        document.execCommand("createLink", false, "mailto:"+mail);
        selection.anchorNode.parentElement.target = "_blank";

    }

}

//-------------------------------------------------
// Insert image
//-------------------------------------------------

function insertImg() {

    var url = prompt("Enter Image URL:", "http://");
    if ((url != null) && (url != "")) {

        document.execCommand("insertHTML", false, "<div class='text-editor__image__box'><img src='"+url+"' alt='"+url+"'></div>");

    }

}

/*

smile.svg - :)
wink.svg - ;)
kiss.svg - :*
unsure.svg - :/
cry.svg - :'(
tongue.svg - :p
grin.svg - :D
grumpy.svg - >:(
astonished.svg - :o
afraid.svg - :O
nerd.svg - 8-)
sunglasses - 8)
angry.svg - :@
frowny.svg - :(
love.svg - <3)
confused.svg - :s
dejected.svg - -_-
laugh.svg - ^^
big_eyes.svg - :|
silent.svg - :x

*/