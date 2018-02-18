//-------------------------------------------------
//  Register new user
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#register__form").validate({
           
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
              
                "register__username": {
               
                    required: true,
                    regex: /^[\w\-]{5,15}$/,
                    remote: {
                        url: "classes/register.php",
                        type: "post",
                        data: {
                            register_username_check: true,
                            register_username: function() {
                                return $("#register__username").val();
                            }
                        }

                    }

                },

                "register__email": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,
                    remote: {
                        url: "classes/register.php",
                        type: "post",
                        data: {
                            register_mail_check: true,
                            register_mail: function() {
                                return $("#register__email").val();
                            }
                        }

                    }

                },

                "register__password": {
               
                    required: true,
                    regex: /^.{6,}$/,

                },

                "register__password__repeat": {
               
                    required: true,
                    equalTo: "#register__password",

                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "register__username": {
               
                    required: "This field is required, username is missing.",
                    regex: "Invalid username. Minimum 5 and max 15 characters. Only letters and numbers are allowed.",
                    remote: "Username is already taken."
               
                },

                "register__email": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
                    remote: "The email address you entered is already registered."
               
                },

                "register__password": {
               
                    required: "This field is required, password is missing.",
                    regex: "Invalid password. Minimum 6 characters.",
               
                },

                "register__password__repeat": {
               
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
                
                var username = $("#register__username").val();
                var mail = $("#register__email").val();
                var password = $("#register__password").val();
                var password_repeat = $("#register__password__repeat").val(); 
                
                $(".form__box").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                            
                            register_username: username,
                            register_mail: mail,
                            register_password: password,
                            register_password_repeat: password_repeat,
                            register: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/register.php",
                       
                        // On success output the requested site.
                        success: function (data) {
                         
                            $(".form__box").html(data);
                        
                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $(".form__box").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});

//-------------------------------------------------
//  Register user verify email
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#verify__mail__form").validate({
           
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
              
                "verify__mail__mail": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,
                    remote: {
                        url: "classes/register.php",
                        type: "post",
                        data: {
                            verify_check_mail: true,
                            verify_mail: function() {
                                return $("#verify__mail__mail").val();
                            }
                        }

                    }

                },

                "verify__mail__code": {
               
                    required: true,
                    regex: /^[a-z A-Z 0-9]{6,6}$/,
               
                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "verify__mail__mail": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
                    remote: "The email address you entered is not registered or already verified."
               
                },

                "verify__mail__code": {
               
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
               
                var mail = $("#verify__mail__mail").val();
                var code = $("#verify__mail__code").val();
                
                $("#verify__mail__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            verify_mail: mail,
                            verify_code: code,
                            verify_email: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/register.php",
                       
                        // On success output the requested site.
                        success: function (data) {
                            
                            if($(".form__box").length > 0) {

                                $(".form__box").html(data);
                    
                            } else {

                                $("#verify__mail__form").html(data);

                            }
                        
                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#verify__mail__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});

//-------------------------------------------------
//  Resend email verification code
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#resend__form").validate({
           
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
              
                "resend__mail": {
               
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,
                    remote: {
                        url: "classes/register.php",
                        type: "post",
                        data: {
                            resend_check_mail: true,
                            resend_mail: function() {
                                return $("#resend__mail").val();
                            }
                        }

                    }

                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "resend__mail": {
               
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
                    remote: "The email address you entered is not registered or already verified."
               
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
               
                var mail = $("#resend__mail").val();
                
                $("#resend__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            resend_mail: mail,
                            resend_code: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/register.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            $("#resend__form").html(data);

                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#resend__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});