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