//-------------------------------------------------
//  New comment
//-------------------------------------------------

$(document).ready(function () {
   
    $("#post__comment").on("click", function () {
        
        var comment = $(".text-editor__box")[0].innerHTML;
        var reply_to = $(".text-editor__status").attr("data-reply-to");
        var blog_id = $(".text-editor__status").attr("data-blog-id");

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
                    dataType: "json",   
                    type: "post",
                    url: "classes/ajax.php",
                       
                    // On success reload comments
                    success: function (data) {

                        if(data.status === "error"){

                            $(".text-editor__message").html(data.errors[0]);

                        } else {

                            $(".text-editor__message").html("");
                            $(".text-editor__box")[0].innerHTML = "";
                            $(".text-editor__reply-to").text("none");
                            $(".text-editor__status").attr("data-reply-to", "0");
                            $(".text-editor__status__cancel").css("display", "none");

                            if($("#message_id_"+reply_to).length > 0) { // Comment is a reply

                                // Check if blog reply container exist
                                if ($("#message_id_"+reply_to).parent(".blog__comment__reply").length > 0) {

                                    $("#message_id_"+reply_to).parent().append(data.output[0]);

                                } else { // Create blog reply container and append data

                                    $("#message_id_"+reply_to).parent().append("<div class='blog__comment__reply'>"+data.output[0]+"</div>");

                                }

                            } 

                            else if($(".no__comment").length > 0) { // No comments previously exist

                                $(".no__comment").remove();
                                $("<div class='blog__comment__message__box'>"+data.output[0]+"</div>").insertAfter(".blog__comment__sort");

                            } else { // Comment is not a reply, append after all other comments

                                $(".blog__comment__message__box:last").append(data.output[0]);

                            }

                            highlight($("#new_comment pre"));

                            scroll($("#new_comment"), -50); // Scroll to posted comment

                        }

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