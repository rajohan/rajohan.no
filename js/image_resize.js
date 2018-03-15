(function () {

    $(document).ready(function () {

        //-------------------------------------------------
        // Image  resizer
        //-------------------------------------------------

        var imageResize = function() {
                
            //-------------------------------------------------
            // Global variables
            //-------------------------------------------------

            var dragging = null;
            var resize = null;
            var pos;
            var height;
            var width;
            var crop = $(".image-resize__box__crop");
            var resizeBox = $(".image-resize__box");

            //-------------------------------------------------
            // Event handlers
            //-------------------------------------------------

            // Set dragging active on mouse down
            $(".image-resize__box__crop__box").on("mousedown", null, function () {

                dragging = crop;

            });

            // Set resize active on mouse down
            $(".image-resize__box__handle").on("mousedown", null, function () {
                
                // Resize crop box
                if($(this).parent().hasClass("image-resize__box__crop")) {
                
                    resize = crop;
                
                } else { // Resize image
                
                    resize = resizeBox;
                
                }
                
                pos = $(this).attr("data-pos"); // Resize handler used
                height = resize.height(); // Height of element resize
                width = resize.width(); // Width of element to resize

            }); 

            // Deactivate resize/dragging
            $(document.body).on("mouseup", function () {

                resize = null;
                dragging = null;

            });

            //-------------------------------------------------
            // Drag (crop box)
            //-------------------------------------------------

            resizeBox.on("mousemove", function (e) {

                if (dragging) {
                    
                    dragging.offset({

                        top: e.pageY - (crop.height()/ 2),
                        left: e.pageX - (crop.width()/ 2),

                    });

                }

            });
            
            //-------------------------------------------------
            // Resize image
            //-------------------------------------------------

            $(document.body).on("mousemove", null, function (e) {

                if (resize) {

                    var relX = e.pageX - resize.offset().left; // Mouse position in element left
                    var relY = e.pageY - resize.offset().top; // Mouse position in element top

                    //-------------------------------------------------
                    // Resize handlers
                    //-------------------------------------------------

                    if(pos === "top-left") {

                        resize.css({

                            "width" : width - relX,
                            "height" : height - relY, 

                        });

                    }

                    if(pos === "top-mid") {

                        resize.css({ 

                            "width" : width,
                            "height" : height - relY, 

                        });

                    }
                    
                    if(pos === "top-right") {

                        resize.css({ 

                            "width" : width + (relX - width),
                            "height" : height - relY, 

                        });

                    }

                    if(pos === "mid-right") {

                        resize.css({ 

                            "width" : width + (relX - width),
                            "height" : height, 

                        });

                    }

                    if(pos === "mid-left") {

                        resize.css({ 

                            "width" : width - relX,
                            "height" : height, 

                        });

                    }

                    if(pos === "bottom-left") {

                        resize.css({ 

                            "width" : width - relX,
                            "height" : height + (relY - height), 

                        });

                    }

                    if(pos === "bottom-mid") {
                        resize.css({ 

                            "width" : width,
                            "height" : height - (height - relY),

                        });
                    }
                    
                    if(pos === "bottom-right") {

                        resize.css({ 

                            "width" : width + (relX - width),
                            "height" : height + (relY - height), 

                        });

                    }

                }

            });

        }();

        //-------------------------------------------------
        // Submit the image edits
        //-------------------------------------------------

        var submitEdit = function () {
            
            $("#image-resize__confirm").on("click", function () {

                var statusBox = $("#image-resize__status");
                var resize = $(".image-resize");
                
                // Prevent double submit
                if (resize.hasClass("editing")) {

                    return false;

                }
            
                resize.addClass("editing"); // Add editing class
                statusBox.html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output loading image

                var details = { 
                    
                    "imageId" : $("#image-resize__image").attr("data-id"),
                    "imageWidth" : $(".image-resize__box").width(),
                    "imageHeight" : $(".image-resize__box").height(),
                    "cropWidth" : $(".image-resize__box__crop").width(),
                    "cropHeight" : $(".image-resize__box__crop").height(),
                    "cropOffsetTop" : $(".image-resize__box__crop").position().top,
                    "cropOffsetLeft" : $(".image-resize__box__crop").position().left,
                    "crop" : true,

                };
                
                // Ajax request for image editing
                $.ajax({

                    url: "classes/ajax.php",
                    type: "post",
                    data: {

                        image:  details,
                        editImage: "true"
                        
                    },
                    dataType: "json",

                    success: function(data) { 

                        statusBox.html(""); // Empty status box
                        resize.removeClass("editing"); // Remove editing class

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

                        resize.removeClass("editing"); // Remove editing class
                        statusBox.html("Sorry, an error has occurred. Please try again.");

                    }

                });
            
            });
            
        }();

    });

}());