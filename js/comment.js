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
                    success: function () {

                        $.ajax({
        
                            url: "blog/read/"+blog_id+"/1/",
                            type: "post",
                            data: {sort_comments: "true", blog_id: blog_id, order: "newest"},
                        
                            // On success output comments
                            success: function (data) {
                    
                                $("body").html(data);
                    
                                $(".blog__comment__sort__by__link").removeClass("blog__comment__sort__by__link__active");
                                $("#blog__comment__sort__by__newest").addClass("blog__comment__sort__by__link__active");
                                scroll($(".blog__comment"), 0); // Scroll text editor

                            }
                    
                        });

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