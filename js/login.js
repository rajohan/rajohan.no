//-------------------------------------------------
//  Login user
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#login__form").validate({
           
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
              
                "login__username": {
               
                    required: true,
                    regex: /^[\w\-]{5,15}$/,
                    remote: {
                        url: "classes/login.php",
                        type: "post",
                        data: {
                            login_check_username: true,
                            login_username: function() {
                                return $("#login__username").val();
                            }
                        }

                    }

                },

                "login__password": {
               
                    required: true,
                    regex: /^.{6,}$/
               
                },

                "login__remember": {
                    required: false,
                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "login__username": {
               
                    required: "This field is required, your username is missing.",
                    regex: "Invalid username.",
                    remote: "The username you entered does not exist."
               
                },

                "login__password": {
               
                    required: "This field is required, password is missing.",
                    regex: "Invalid password."
                    
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
               
                var username = $("#login__username").val();
                var password = $("#login__password").val();
                var remember;

                if ($("#login__remember").is(":checked")) {

                    remember = 1;

                } else {

                    remember = 0;

                }
                
                $("#login__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            login_username: username,
                            login_password: password,
                            login_remember: remember,
                            login_user: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/login.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            $(".container").html(data);
                        
                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#login__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});