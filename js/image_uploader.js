//-------------------------------------------------
// Image uploader
//-------------------------------------------------
var imageUploader = function() {

    //-------------------------------------------------
    // Global variables
    //-------------------------------------------------

    var form = $(".image-uploader__box"); 
    var input = $("#image-uploader__file");
    var statusBox = $(".image-uploader__box__status");
    var droppedFiles = false;

    //-------------------------------------------------
    // Event handlers
    //-------------------------------------------------

    // Prevent default behavior on dragover, drop etc
    form.on("drag dragstart dragend dragover dragenter dragleave drop", function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Add dragover class on dragover
    form.on("dragover dragenter", function() {
        form.addClass("image-uploader__box__dragover");
    });

    // Remove dragover class on drop
    form.on("dragleave dragend drop", function() {
        form.removeClass("image-uploader__box__dragover");
    });

    // Trigger submit on drop
    form.on("drop", function(e) {
        droppedFiles = e.originalEvent.dataTransfer.files;
        form.trigger("submit");
    });

    // Trigger submit on files input field change    
    input.on("change", function() {
        form.trigger("submit");
    });

    //-------------------------------------------------
    // Submit handler
    //-------------------------------------------------

    form.on("submit", function(e) {

        // Prevent double submit
        if (form.hasClass("uploading")) {

            return false;

        }
        
        form.addClass("uploading"); // Add uploading class
        e.preventDefault(); // Prevent default behavior
        statusBox.html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output loading image

        var ajaxData = new FormData(form.get(0)); // collect data from all the form inputs

        // loop through the dragged & dropped files and add them to the data stack
        if (droppedFiles) {
            $.each( droppedFiles, function(i, file) {
                ajaxData.append( input.attr("name"), file );
            }); 
        }

        // Ajax request for image upload
        $.ajax({
            url: "classes/image_uploader.php",
            type: "post",
            data: ajaxData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,

            complete: function() {

                form.removeClass("uploading");

            },

            success: function(data) {

                statusBox.html(""); // Empty status box
                form.removeClass("uploading"); // Remove uploading class

                if(data.status === "error"){

                    statusBox.append("<ul>");

                    for(var i = 0; i < data.errors.length; i++) {

                        statusBox.append("<li>"+data.errors[i]+"</li>");

                    }

                    statusBox.append("</ul>");

                } 

                else if(data.status === "success"){ 

                    statusBox.html(""); // Empty status box
                    statusBox.html(data.output);

                } else {

                    form.removeClass("uploading"); // Remove uploading class
                    statusBox.html("Sorry, an error has occurred. Please try again.");
                    
                }

            },

            error: function() {

                form.removeClass("uploading"); // Remove uploading class
                statusBox.html("Sorry, an error has occurred. Please try again.");

            }

        });

    });

}();