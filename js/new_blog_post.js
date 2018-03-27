//-------------------------------------------------
//  Auto complete tags
//-------------------------------------------------
$(document).ready(function () {

    var element = $("#new_post_tags").parent().children().next(".suggestions__box");

    $("#new_post_tags").on("keyup", function () {

        if($("#new_post_tags").val().length < 1) {
            element.text("");
            element.css("display", "none");
            return false;
        } 

        // Ajax request for auto complete tags
        $.ajax({
                
            url: "classes/ajax.php",
            type: "post",
            data: {
                new_post_tag: $("#new_post_tags").val()
            },
            dataType: "json",

            success: function(data) {

                element.text("");

                if(data.new_post_tags.length > 0) {
                    
                    for(var i = 0; i < data.new_post_tags.length; i++) {

                        element.append("<span class='suggestions__box__item'>"+data.new_post_tags[i]+"</span>");

                    }

                    element.css("display", "flex");
                    
                } else {

                    element.text("");
                    element.css("display", "none");

                }

            },

            error: function() {

                element.text("");
                element.css("display", "none");

            }

        });

    });

    // On tag click in suggestion box
    $(document).on("click", ".suggestions__box__item", function () {

        var old_tags = $.trim($("#new_post_tags").attr("data-tags")).split(/\s+/); // Split words on whitespace
        var new_tag = $.trim($(this).text()); // Remove whitespace on new tag

        // Add tag to the list of tags if it dont already exist and tag count is below 5
        if((!old_tags.includes(new_tag)) && (old_tags.length < 5)) {

            $("#new_post_tags_selected").html($("#new_post_tags_selected").html() + "<span class='tags'>" + new_tag + "<span id='"+ new_tag +"' class='tags__remove'>x</span></span>");
            $("#new_post_tags").attr("data-tags", $("#new_post_tags").attr("data-tags") + new_tag + " ");
        
        }
        
        $("#new_post_tags").val("");
        element.text("");
        element.css("display", "none");

    });

    // When spacebar/return key is pressed. Add tag to selected tags
    $("#new_post_tags").on("keyup", function (event) {

        if((event.keyCode == 32) || (event.keyCode == 13)) {

            var old_tags = $.trim($("#new_post_tags").attr("data-tags")).split(/\s+/); // Split words on whitespace
            var new_tag = $.trim($("#new_post_tags").val()); // Remove whitespace on new tag
            
            // Add tag to the list of tags if it dont already exist and tag count is below 5
            if((!old_tags.includes(new_tag)) && (old_tags.length < 5)) {

                $("#new_post_tags_selected").html($("#new_post_tags_selected").html() + "<span class='tags'>" + new_tag + "<span id='"+ new_tag +"' class='tags__remove'>x</span></span>");
                $("#new_post_tags").attr("data-tags", $("#new_post_tags").attr("data-tags") + new_tag + " ");

            }

            $("#new_post_tags").val("");
            element.text("");
            element.css("display", "none");

        }

    });

    // When remove tag is clicked
    $(document).on("click", ".tags__remove", function () {
        
        $("#new_post_tags").attr("data-tags", $("#new_post_tags").attr("data-tags").replace(new RegExp($(this).attr("id")+" "), "")); // Remove tag from data-tags
        $(this).parent().remove(); // Remove tag

    });

});

//-------------------------------------------------
//  Create blog post
//-------------------------------------------------
$("#create_post").on("click", function (e) {

    // Prevent double submit
    if (!$("#create_post").hasClass("posting")) {

        $("#create_post").addClass("posting"); // Add uploading class
        e.preventDefault(); // Prevent default behavior

        var image = $(".uploaded_image").attr("id");
        var title = $("#new_post_title").val();
        var tags = $("#new_post_tags").attr("data-tags");
        var shortStory = $("#new_post_short_story").html();
        var fullStory = $("#new_post_full_story").html();
        var statusBox = $(".admin__status-box");

        if(image == null) {

            image = "";

        }

        statusBox.html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output loading image

        // Ajax request for auto complete tags
        $.ajax({
                    
            url: "classes/ajax.php",
            type: "post",
            data: {
                image: image,
                title: title,
                tags: tags,
                shortStory: shortStory,
                fullStory: fullStory,
                create_new_post: true
            },
            dataType: "json",

            complete: function() {

                $("#create_post").removeClass("posting");

            },

            success: function(data) {

                statusBox.html("");

                if(data.status === "error"){

                    statusBox.append("<ul>");

                    for(var i = 0; i < data.errors.length; i++) {

                        statusBox.append("<li>"+data.errors[i]+"</li>");

                    }

                    statusBox.append("</ul>");

                } 

                if(data.status === "success"){ 

                    for(var x = 0; x < data.output.length; x++) {

                        statusBox.append(data.output[x]);

                    }

                } 

            },

            error: function() {

                statusBox.html("Sorry, an error has occurred. Please try again.");

            }

        });

    }

});