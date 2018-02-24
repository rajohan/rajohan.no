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

//-------------------------------------------------
// Set cursor to the end of text editor box
//-------------------------------------------------

function setEndOfContenteditable(contentEditableElement) {

    var range,selection;

    range = document.createRange(); // Create a range
    range.selectNodeContents(contentEditableElement); // Select the entire contents of the element with the range
    range.collapse(false); // Collapse the range to the end point. false means collapse to end rather than the start
    selection = window.getSelection(); // Get the selection object
    selection.removeAllRanges(); // Remove any selections already made
    selection.addRange(range); // Make the range visible

}

//-------------------------------------------------
// Replace emoticons with images
//-------------------------------------------------

$(document).ready(function() {

    // Object with emoticons
    var emoticons = [

        { "code" : /:\)|:-\)/ , "img" : "smile.svg" },
        { "code" : /;\)|;-\)/ , "img" : "wink.svg" },
        { "code" : /:\*|:-\*/ , "img" : "kiss.svg" },
        { "code" : /(?<!http|https|mailto):\/|:-\// , "img" : "unsure.svg" },
        { "code" : /:'\(|:'-\(/ , "img" : "cry.svg" },
        { "code" : /(?<!http|https|mailto):p|:-p|(?<!http|https|mailto):P|:-p/ , "img" : "tongue.svg" },
        { "code" : /(?<!http|https|mailto):D|:-D|(?<!http|https|mailto):d|:-d/ , "img" : "grin.svg" },
        { "code" : /&gt;:\(|&gt;:-\(/ , "img" : "grumpy.svg" },
        { "code" : /(?<!http|https|mailto):o|:-o/ , "img" : "astonished.svg" },
        { "code" : /(?<!http|https|mailto):O|:-O/ , "img" : "afraid.svg" },
        { "code" : /8-\)/ , "img" : "nerd.svg" },
        { "code" : /8\)/ , "img" : "sunglasses" },
        { "code" : /:@|:-@/ , "img" : "angry.svg" },
        { "code" : /:\(|:-\(/ , "img" : "frowny.svg" },
        { "code" : /&lt;3\)|&lt;3-\)/ , "img" : "love.svg" },
        { "code" : /(?<!http|https|mailto):s|:-s|(?<!http|https|mailto):S|:-S/ , "img" : "confused.svg" },
        { "code" : /-_-/ , "img" : "dejected.svg" },
        { "code" : /\^\^/ , "img" : "laugh.svg" },
        { "code" : /:\||:-\|/ , "img" : "big_eyes.svg" },
        { "code" : /(?<!http|https|mailto):x|(?<!http|https|mailto):X|:-x|:-X/  , "img" : "silent.svg" }
        
    ];

    $("#text-editor__box").on("click keyup focus focusin focusout blur", function () {

        var element = document.getElementById("text-editor__box");
        var content = $("#text-editor__box")[0].innerHTML;
        var changed = false;

        // Check for emoticon matches
        for (var i = 0; i < emoticons.length; i++) {
            
            if(content.match(emoticons[i]["code"])) {

                changed = true;
                content = content.replace(emoticons[i]["code"], "<img src='img/icons/emoticons/"+emoticons[i]["img"]+"' alt='img/icons/emoticons/"+emoticons[i]["img"]+"' style='margin-bottom: -0.3rem; width: 1.7rem; height: 1.7rem;'>");
                
            }

        }

        // Change content if content have changed
        if (changed) {

            $("#text-editor__box")[0].innerHTML = content;
            setEndOfContenteditable(element);
            $("#text-editor__box").focus(); // Focus the text editor box

        }

    });

});

//-------------------------------------------------
// User paste handler
//-------------------------------------------------

$(document).on("paste",$("#text-editor__box"),function(event) {

    event.preventDefault();
    var text = (event.originalEvent || event).clipboardData.getData("text/plain"); // get pasted text
    document.execCommand("insertText", false, text); // Insert data

});