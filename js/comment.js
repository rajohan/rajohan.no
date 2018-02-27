//-------------------------------------------------
//  New comment
//-------------------------------------------------

$(document).ready(function () {
   
    $("#post__comment").on("click", function () {
        
        var comment = $("#text-editor__box")[0].innerHTML;
        
        if((comment == null) || (comment == "") || (comment == "Your comment...")) {

            $(".error__box").html("Comment missing");

        } else {

            $(".error__box").html("Ok!");

        }

    });

});