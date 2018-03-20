//-------------------------------------------------
//  Auto complete tags
//-------------------------------------------------
$(document).ready(function () {

    var element = $("#new_post_tags").parent().children().next(".suggestions__box");

    $("#new_post_tags").on("keyup", function () {

        if($("#new_post_tags").val().length < 1) {
            element.html("");
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

                element.html("");

                if(data.new_post_tags.length > 0) {
                    
                    for(var i = 0; i < data.new_post_tags.length; i++) {

                        element.append("<span class='suggestions__box__item'>"+data.new_post_tags[i]+"</span>");

                    }

                    element.css("display", "flex");
                    
                } else {

                    element.html("");
                    element.css("display", "none");

                }

            },

            error: function() {

                element.html("");
                element.css("display", "none");

            }

        });

    });

    // On tag click in suggestion box
    $(document).on("click", ".suggestions__box__item", function () {

        $("#new_post_tags").val($(this).html());
        element.html("");
        element.css("display", "none");

    });

});