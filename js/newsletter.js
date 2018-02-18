//-------------------------------------------------
//  Newsletter subscribe
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#newsletter__subscribe__form").validate({
           
            onkeyup: function (element) {
            
                $(element).valid();
           
            },
          
            errorElement: "div", // Error box element type

            errorPlacement: function(error, element) {

                error.appendTo( element.parent().next() ); // Error box placement

            },

            errorClass: "error", // Error class
            validClass: "valid", // Valid class

            //-------------------------------------------------
            // Rules
            //-------------------------------------------------

            rules: {
              
                "newsletter__subscribe__mail": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,
                    remote: {
                        url: "classes/newsletter.php",
                        type: "post",
                        data: {
                            mail_subscribed_check: true,
                            mail: function() {
                                return $("#newsletter__subscribe__mail").val();
                            }
                        }

                    }

                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "newsletter__subscribe__mail": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
                    remote: "The email address you entered is already subscribed to my newsletters."
               
                },

            },
            
            //-------------------------------------------------
            // Highlight error
            //-------------------------------------------------

            highlight: function (element, errorClass, validClass) {

                $(element).addClass(errorClass).removeClass(validClass);

            },
           
            //-------------------------------------------------
            // Unhighlight error
            //-------------------------------------------------

            unhighlight: function (element, errorClass, validClass) {
                   
                $(element).removeClass(errorClass).addClass(validClass);

            },

            //-------------------------------------------------
            // Submit handler
            //-------------------------------------------------
            
            submitHandler: function () {
               
                var mail = $("#newsletter__subscribe__mail").val();
                
                $("#newsletter__subscribe").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            mail: mail,
                            subscribe: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/newsletter.php",
                       
                        // On success output the requested site.
                        success: function (data) {
                         
                            $("#newsletter__subscribe").html(data);
                        
                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#newsletter__subscribe").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;
                
            }

        });

    });

});

//-------------------------------------------------
//  Newsletter unsubscribe
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#newsletter__unsubscribe__form").validate({
           
            onkeyup: function (element) {
            
                $(element).valid();
           
            },
          
            errorElement: "div", // Error box element type

            errorPlacement: function(error, element) {

                error.appendTo( element.parent().next() ); // Error box placement

            },

            errorClass: "error", // Error class
            validClass: "valid", // Valid class

            //-------------------------------------------------
            // Rules
            //-------------------------------------------------

            rules: {
              
                "newsletter__unsubscribe__mail": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,
                    remote: {
                        url: "classes/newsletter.php",
                        type: "post",
                        data: {
                            mail_unsubscribe_check: true,
                            mail: function() {
                                return $("#newsletter__unsubscribe__mail").val();
                            }
                        }

                    }

                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "newsletter__unsubscribe__mail": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
                    remote: "The email address you entered is not in the subscription list."

                },

            },
            
            //-------------------------------------------------
            // Highlight error
            //-------------------------------------------------

            highlight: function (element, errorClass, validClass) {

                $(element).addClass(errorClass).removeClass(validClass);

            },
           
            //-------------------------------------------------
            // Unhighlight error
            //-------------------------------------------------

            unhighlight: function (element, errorClass, validClass) {
                   
                $(element).removeClass(errorClass).addClass(validClass);

            },

            //-------------------------------------------------
            // Submit handler
            //-------------------------------------------------
            
            submitHandler: function () {
               
                var mail = $("#newsletter__unsubscribe__mail").val();
                
                $("#newsletter__unsubscribe").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            mail: mail,
                            unsubscribe: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/newsletter.php",
                       
                        // On success output the requested site.
                        success: function (data) {
                         
                            $("#newsletter__unsubscribe").html(data);
                        
                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#newsletter__unsubscribe").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});

//-------------------------------------------------
//  Newsletter unsubscribe verification code
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#newsletter__verify").validate({
           
            onkeyup: function (element) {
            
                $(element).valid();
           
            },
          
            errorElement: "div", // Error box element type

            errorPlacement: function(error, element) {

                error.appendTo( element.parent().next() ); // Error box placement

            },

            errorClass: "error", // Error class
            validClass: "valid", // Valid class

            //-------------------------------------------------
            // Rules
            //-------------------------------------------------

            rules: {
              
                "newsletter__verify__mail": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,
                    remote: {
                        url: "classes/newsletter.php",
                        type: "post",
                        data: {
                            mail_unsubscribe_check: true,
                            mail: function() {
                                return $("#newsletter__verify__mail").val();
                            }
                        }

                    }

                },

                "newsletter__verify__code": {
               
                    required: true,
                    regex: /^[a-z A-Z 0-9]{6,6}$/,
               
                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "newsletter__verify__mail": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
                    remote: "The email address you entered is not in the subscription list."
               
                },

                "newsletter__verify__code": {
               
                    required: "This field is required, verification code is missing.",
                    regex: "Invalid verification code.",
                    
                },

            },
            
            //-------------------------------------------------
            // Highlight error
            //-------------------------------------------------

            highlight: function (element, errorClass, validClass) {

                $(element).addClass(errorClass).removeClass(validClass);

            },
           
            //-------------------------------------------------
            // Unhighlight error
            //-------------------------------------------------

            unhighlight: function (element, errorClass, validClass) {
                   
                $(element).removeClass(errorClass).addClass(validClass);

            },

            //-------------------------------------------------
            // Submit handler
            //-------------------------------------------------
            
            submitHandler: function () {
               
                var mail = $("#newsletter__verify__mail").val();
                var code = $("#newsletter__verify__code").val();
                
                $("#newsletter__verify").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            mail: mail,
                            code: code,
                            unsubscribe_code: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/newsletter.php",
                       
                        // On success output the requested site.
                        success: function (data) {
                         
                            $("#newsletter__verify").html(data);
                        
                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#newsletter__verify").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});