//-------------------------------------------------
// Show/hide code box
//-------------------------------------------------
$(".toolbox__embed").click(function(){

    $(this).parent().parent().siblings().next(".text-editor__code").text($(this).parent().parent().next(".text-editor__box")[0].innerHTML);
    $(this).parent().parent().siblings().next(".text-editor__code-heading").toggle();
    $(this).parent().parent().siblings().next(".text-editor__code").toggle();

});

//-------------------------------------------------
// Insert 2 * <br> on "return" keydown
//-------------------------------------------------
$(".text-editor__box").keydown(function(event) {

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

$(".text-editor__box").focusin(function () {

    placeholder = $(this).attr("data-placeholder");
    $(this).attr("data-placeholder", "");

});

$(".text-editor__box").focusout(function () {

    $(this).attr("data-placeholder", placeholder);

});

//-------------------------------------------------
// Show/hide emoticon box
//-------------------------------------------------
$(".toolbox__emoticons").click(function(){

    $(this).next(".toolbox__emoticons__box").toggle();

});

$(".toolbox__emoticons__box__close").click(function(){

    $(this).parent().hide();

});


//-------------------------------------------------
//  Toolbar icon click
//-------------------------------------------------
function execCmd(event, command, input) {

    var selection = document.getSelection(); // Get selected element
    $(event).parent().parent().next(".text-editor__box").focus(); // Focus the text editor box
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

        if((selection == null) || (selection == "")) {

            selection = "Your quote goes inside these";

        }

        document.execCommand("insertHTML", false, "[QUOTE]"+selection+"[/QUOTE]");

    }

    // insert code
    else if(command === "insertCode") {

        if((selection == null) || (selection == "")) {

            selection = "Your code goes inside these";

        }

        document.execCommand("insertHTML", false, "[CODE]"+selection+"[/CODE]");

    }

    // insert emoticon
    else if(command === "insertEmoticon") {

        document.execCommand("insertHTML", false, "<img src='img/icons/emoticons/"+input+"' class='emoticon' style='margin-bottom: -0.3rem; width: 1.7rem; height: 1.7rem;'>");
        $(".toolbox__emoticons__box").hide();

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

        if((selection == null) || (selection == "")) {
            selection = url;
        }

        document.execCommand("insertHTML", false, "<a href='"+url+"'>"+selection+"</a>");

    }

}

//-------------------------------------------------
//  Create mail
//-------------------------------------------------

function createMail(selection) {

    var mail = prompt("Enter your mail address:", "");

    if ((mail != null) && (mail != "")) {

        if((selection == null) || (selection == "")) {

            selection = mail;

        }

        document.execCommand("insertHTML", false, "<a href='mailto: "+mail+"'>"+selection+"</a>");

    }

}

//-------------------------------------------------
// Insert image
//-------------------------------------------------

function insertImg() {

    var url = prompt("Enter Image URL:", "http://");
    if ((url != null) && (url != "")) {

        document.execCommand("insertHTML", false, "<div class='text-editor__image__box'><img src='"+url+"'></div>");

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
        { "code" : /:-\// , "img" : "unsure.svg" },
        { "code" : /:'\(|:'-\(/ , "img" : "cry.svg" },
        { "code" : /:p|:-p|:P|:-p/ , "img" : "tongue.svg" },
        { "code" : /:D|:-D|:d|:-d/ , "img" : "grin.svg" },
        { "code" : /&gt;:\(|&gt;:-\(/ , "img" : "grumpy.svg" },
        { "code" : /:o|:-o/ , "img" : "astonished.svg" },
        { "code" : /:O|:-O/ , "img" : "afraid.svg" },
        { "code" : /8-\)/ , "img" : "nerd.svg" },
        { "code" : /8\)/ , "img" : "sunglasses.svg" },
        { "code" : /:@|:-@/ , "img" : "angry.svg" },
        { "code" : /:\(|:-\(/ , "img" : "frowny.svg" },
        { "code" : /&lt;3\)|&lt;3-\)/ , "img" : "love.svg" },
        { "code" : /:s|:-s|:S|:-S/ , "img" : "confused.svg" },
        { "code" : /-_-/ , "img" : "dejected.svg" },
        { "code" : /\^\^/ , "img" : "laugh.svg" },
        { "code" : /:\||:-\|/ , "img" : "big_eyes.svg" },
        { "code" : /:x|:X|:-x|:-X/  , "img" : "silent.svg" }
        
    ];

    $(".text-editor__box").on("click keyup focus focusin focusout blur", function () {

        var element = this;
        var content = $(this)[0].innerHTML;
        var changed = false;

        // Check for emoticon matches
        for (var i = 0; i < emoticons.length; i++) {
            
            if(content.match(emoticons[i]["code"])) {

                changed = true;
                content = content.replace(emoticons[i]["code"], "<img src='img/icons/emoticons/"+emoticons[i]["img"]+"' class='emoticon' style='margin-bottom: -0.3rem; width: 1.7rem; height: 1.7rem;'>");
                
            }

        }

        // Change content if content have changed
        if (changed) {

            $(this)[0].innerHTML = content;
            setEndOfContenteditable(element);
            $(this).focus(); // Focus the text editor box

        }

    });

});

//-------------------------------------------------
// User paste handler
//-------------------------------------------------

$(document).on("paste",$(".text-editor__box"),function(event) {

    event.preventDefault();
    var text = (event.originalEvent || event).clipboardData.getData("text/plain"); // get pasted text
    document.execCommand("insertText", false, text); // Insert data

});