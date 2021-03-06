//-------------------------------------------------
//  Contact me
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $(".contact-me__form").validate({
           
            onkeyup: function (element) {
            
                $(element).valid();
           
            },
          
            errorElement: "div", // Error box element type
            errorClass: "error", // Error class
            validClass: "valid", // Valid class

            //-------------------------------------------------
            // Rules
            //-------------------------------------------------

            rules: {
              
                "contact-me__name": {
                 
                    required: true,
                    regex: /^[a-zÀ-ʫ\'´`-]+?\.?\s?([a-zÀ-ʫ\'´`-]+\.?\s?)+$/i
              
                },
                "contact-me__mail": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i
               
                },
                "contact-me__firmname": {
                
                    regex: /^[A-å0-9À-ʫ\'\.\-\s\,&@]{2,}$/i
               
                },
                "contact-me__tel": {
               
                    regex: /^(?:[0-9-+()\s]){0,6}(?:[0-9-+()\s]){0,6}([0-9\s]){4,15}$/
               
                },
                "contact-me__webpage": {
               
                    regex: /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i
               
                },
                "contact-me__subject": {
                
                    required: true,
              
                },
                "contact-me__message": {
              
                    required: true,
               
                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "contact-me__name": {
               
                    required: "This field is required, your name is missing.",
                    regex: "Invalid name."
              
                },
                "contact-me__mail": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address."
               
                },
                "contact-me__firmname": {
              
                    regex: "Invalid company name."
               
                },
                "contact-me__tel": {
               
                    regex: "Invalid phone number."
               
                },
                "contact-me__webpage": {
               
                    regex: "Invalid website address."
              
                },
                "contact-me__subject": {
              
                    required: "This field is required, subject is missing."
               
                },
                "contact-me__message": {
                
                    required: "This field is required, message is missing."
              
                }

            },
            
            //-------------------------------------------------
            // Highlight error
            //-------------------------------------------------

            highlight: function (element, errorClass, validClass) {
                
                if ($(element).parent().hasClass("required")) {
                 
                    $(element).addClass(errorClass).removeClass(validClass);
                    $(element).parent().addClass("required__img required__red").removeClass("required__green required__grey");
               
                } else {
                
                    $(element).addClass(errorClass).removeClass(validClass);
                    $(element).parent().addClass("not-required__img not-required__red").removeClass("not-required__green not-required__grey");
               
                }

            },
           
            //-------------------------------------------------
            // Unhighlight error
            //-------------------------------------------------

            unhighlight: function (element, errorClass, validClass) {
            
                if ($(element).parent().hasClass("required")) {
                
                    $(element).removeClass(errorClass).addClass(validClass);
                    $(element).parent().addClass("required__img required__green").removeClass("required__red required__grey");
               
                } else {
                   
                    $(element).removeClass(errorClass).addClass(validClass);
                    $(element).parent().addClass("not-required__img not-required__green").removeClass("not-required__red not-required__grey");
                
                }

            },

            //-------------------------------------------------
            // Submit handler
            //-------------------------------------------------
            
            submitHandler: function () {
               
                var name = $("#contact-me__name").val();
                var mail = $("#contact-me__mail").val();
                var firmname = $("#contact-me__firmname").val();
                var tel = $("#contact-me__tel").val();
                var webpage = $("#contact-me__webpage").val();
                var subject = $("#contact-me__subject").val();
                var message = $("#contact-me__message").val();
                
                $(".contact-me__container").html("<img title=\"loading\" src=\"/img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            contact_name: name,
                            contact_mail: mail,
                            contact_firmname: firmname,
                            contact_tel: tel,
                            contact_webpage: webpage,
                            contact_subject: subject,
                            contact_message: message,
                            contact_send: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/ajax.php",
                       
                        success: function (data) {
                         
                            $(".contact-me__container").html(data);
                        
                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $(".contact-me__container").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;
                
            }

        });

    });

});