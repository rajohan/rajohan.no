//-------------------------------------------------
//  New comment
//-------------------------------------------------

$(document).ready(function () {
   
    $("#post__comment").on("click", function () {
        
        var comment = $("#text-editor__box")[0].innerHTML;
        var reply_to = $("#text-editor__status").attr("data-reply-to");
        var blog_id = $("#text-editor__status").attr("data-blog-id");

        if((reply_to == null) || (reply_to == "")) {
            reply_to = "0";
        }

        if((comment == null) || (comment == "") || (comment == "Your comment...")) {

            $(".text-editor__message").html("The comment field can not be empty.");

        } else {

            $(".text-editor__message").html("<img alt=\"loading\" src=\"img/loading.gif\">");
                
            // Set timer for the loading image.
            setTimeout(function () {
                    
                // Run the ajax request.
                $.ajax({
                       
                    data: {
                            
                        comment: comment,
                        blog_id: blog_id,
                        reply_to: reply_to,
                        post_comment: "true",
                       
                    },
                       
                    type: "post",
                    url: "classes/ajax.php",
                       
                    // On success reload comments
                    success: function (data) {

                        $(".text-editor__message").html("");
                        $("#text-editor__box")[0].innerHTML = "";

                        if($("#message_id_"+reply_to).length > 0) { // Comment is a reply

                            // Check if blog reply container exist
                            if ($("#message_id_"+reply_to).parent(".blog__comment__reply").length > 0) {

                                $("#message_id_"+reply_to).parent().append(data);

                            } else { // Create blog reply container and append data

                                $("#message_id_"+reply_to).parent().append("<div class='blog__comment__reply'>"+data+"</div>");

                            }

                        } else { // Comment is not a reply, append after all other comments

                            $(".blog__comment__message__box:last").append(data);

                        }

                        highlight($("#new_comment pre"));

                        scroll($("#new_comment"), -50); // Scroll to posted comment

                    },
                       
                    // On error output a error message.
                    error: function () {
                      
                        $(".text-editor__message").html("Sorry, an error has occurred. Please try again.");
                      
                    }

                });

            }, 500);

        }

    });

});