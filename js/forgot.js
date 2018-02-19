//-------------------------------------------------
//  Resend email verification code
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#forgot__password__form").validate({
           
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
                
                "forgot__password__username": {
               
                    required: true,
                    regex: /^[\w\-]{5,15}$/,

                },

                "forgot__password__mail": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,

                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "forgot__password__username": {
               
                    required: "This field is required, your username is missing.",
                    regex: "Invalid username.",
               
                },

                "forgot__password__mail": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
               
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
                
                var username = $("#forgot__password__username").val();
                var mail = $("#forgot__password__mail").val();
                
                $("#forgot__password__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                            
                            username: username,
                            mail: mail,
                            forgot_password: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/register.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            $("#forgot__password").html(data);

                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#forgot__password__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});

//-------------------------------------------------
//  Verify password reset
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#forgot__password__verify__form").validate({
           
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
                
                "forgot__password__verify__username": {
               
                    required: true,
                    regex: /^[\w\-]{5,15}$/,

                },

                "forgot__password__verify__code": {
               
                    required: true,
                    regex: /^[a-z A-Z 0-9]{8,8}$/,
                    
                },

                "forgot__password__verify__password": {
               
                    required: true,
                    regex: /^.{6,}$/
                },

                "forgot__password__verify__password-repeat": {
               
                    required: true,
                    equalTo: "#forgot__password__verify__password"
                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "forgot__password__verify__username": {
               
                    required: "This field is required, your username is missing.",
                    regex: "Invalid username.",
               
                },

                "forgot__password__verify__code": {
               
                    required: "This field is required, your verification code is missing.",
                    regex: "Invalid verification code.",
               
                },

                "forgot__password__verify__password": {
               
                    required: "This field is required, password is missing.",
                    regex: "Invalid password. Minimum 6 characters.",
               
                },

                "forgot__password__verify__password-repeat": {
               
                    required: "This field is required, password is missing.",
                    equalTo: "The password fields does not match.",
               
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
                
                var username = $("#forgot__password__verify__username").val();
                var code = $("#forgot__password__verify__code").val();
                var password = $("#forgot__password__verify__password").val();
                var password_repeat = $("#forgot__password__verify__password-repeat").val();
                
                $("#forgot__password__verify__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                            
                            username: username,
                            code: code,
                            password: password,
                            password_repeat: password_repeat,
                            forgot_password_verify: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/register.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            $("#forgot__password__verify").html(data);

                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#forgot__password__verify__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});