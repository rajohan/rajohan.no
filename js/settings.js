//-------------------------------------------------
//  User settings social media
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#settings__social__form").validate({
           
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
              
                "settings__facebook": {
               
                    required: false,
                    regex: /^(http:\/\/www\.|www\.|https:\/\/www\.|http:\/\/|https:\/\/)?(facebook)(\.[a-z]{2,5})(.*)$/,

                },

                "settings__twitter": {
               
                    required: false,
                    regex: /^(http:\/\/www\.|www\.|https:\/\/www\.|http:\/\/|https:\/\/)?(twitter)(\.[a-z]{2,5})(\/.*)$/,
               
                },

                "settings__linkedin": {

                    required: false,
                    regex: /^(http:\/\/www\.|www\.|https:\/\/www\.|http:\/\/|https:\/\/)?(linkedin)(\.[a-z]{2,5})(\/.*)$/,

                },

                "settings__github": {

                    required: false,
                    regex: /^(http:\/\/www\.|www\.|https:\/\/www\.|http:\/\/|https:\/\/)?(github)(\.[a-z]{2,5})(\/.*)$/,

                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "settings__facebook": {
               
                    regex: "Invalid Facebook link.",
               
                },

                "settings__twitter": {
               
                    regex: "Invalid Twitter link."
                    
                },

                "settings__linkedin": {
               
                    regex: "Invalid LinkedIn link."
                    
                },

                "settings__github": {
               
                    regex: "Invalid Github link."
                    
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
               
                var facebook = $("#settings__facebook").val();
                var twitter = $("#settings__twitter").val();
                var linkedin = $("#settings__linkedin").val();
                var github = $("#settings__github").val();
                
                $("#settings__social__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            facebook: facebook,
                            twitter: twitter,
                            linkedin: linkedin,
                            github: github,
                            settings_social: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/ajax.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            $("#settings__social__form").html(data);

                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#settings__social__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});

//-------------------------------------------------
//  User settings email
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#settings__mail__form").validate({
           
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
              
                "settings__mail": {
                    
                    required: true,
                    regex: /^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/i,
                    remote: {
                        url: "classes/ajax.php",
                        type: "post",
                        data: {
                            settings_mail_check: true,
                            settings_mail: function() {
                                return $("#settings__mail").val();
                            }
                        }

                    } 
                },

                "settings__mail__hide": {
               
                    required: false,
               
                },

                "settings__newsletters": {
               
                    required: false,
               
                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "settings__mail": {
                    
                    required: "This field is required, your email address is missing.",
                    regex: "Invalid email address.",
                    remote: "The email address you entered is already registered."
               
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
               
                var mail = $("#settings__mail").val();
                var mail_hide = $("#settings__mail__hide").is(":checked");
                var newsletters = $("#settings__newsletters").is(":checked");
                
                $("#settings__mail__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            mail: mail,
                            mail_hide: mail_hide,
                            newsletters: newsletters,
                            settings_mail: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/ajax.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            if(data === "Email changed") {

                                window.location.replace("/verify/?email="+mail);

                            } else {

                                $("#settings__mail__form").html(data);

                            }

                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#settings__mail__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});

//-------------------------------------------------
//  User settings password
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#settings__password__form").validate({
           
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
              
                "settings__password": {
               
                    required: true,
                    regex: /^.{6,}$/,

                },

                "settings__new-password": {
               
                    required: true,
                    regex: /^.{6,}$/,

                },

                "settings__new-password__repeat": {
               
                    required: true,
                    equalTo: "#settings__new-password",
               
                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "settings__password": {
               
                    required: "This field is required, password is missing.",
                    regex: "Invalid password. Minimum 6 characters.",
               
                },

                "settings__new-password": {
               
                    required: "This field is required, password is missing.",
                    regex: "Invalid password. Minimum 6 characters.",
               
                },

                "settings__new-password__repeat": {
               
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
               
                var password = $("#settings__password").val();
                var new_password = $("#settings__new-password").val();
                var new_password_repeat = $("#settings__new-password__repeat").val();
                
                $("#settings__password__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            password: password,
                            new_password: new_password,
                            new_password_repeat: new_password_repeat,
                            settings_password: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/ajax.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            if(data === "Password changed") {

                                window.location.replace("/login/");

                            } else {

                                $("#settings__password__form").html(data);

                            }

                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#settings__password__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});

//-------------------------------------------------
//  User settings personal details
//-------------------------------------------------

$(document).ready(function () {
   
    $(document).on("click keyup focus focusin focusout blur", function () {
       
        $("#settings__form").validate({
           
            onkeyup: function (element) {
            
                $(element).valid();
           
            },
          
            errorElement: "div", // Error box element type

            errorPlacement: function(error, element) {

                // Error box placement
                if(element.parent().next().length < 1) {

                    error.appendTo(element.parent().parent().next()); 

                } else {

                    error.appendTo(element.parent().next());

                }
                
            },

            errorClass: "error", // Error class
            validClass: "valid", // Valid class

            //-------------------------------------------------
            // Rules
            //-------------------------------------------------

            rules: {
              
                "settings__username": {
               
                    required: true,
                    regex: /^[\w\-]{5,15}$/,
                    remote: {
                        url: "classes/ajax.php",
                        type: "post",
                        data: {
                            settings_username_check: true,
                            settings_username: function() {
                                return $("#settings__username").val();
                            }
                        }

                    } 

                },

                "settings__first-name": {
               
                    required: false,
                    regex: /^[a-zÀ-ʫ\'´`-]+?\.?\s?([a-zÀ-ʫ\'´`-]+\.?\s?)+$/i,

                },
                
                "settings__last-name": {
               
                    required: false,
                    regex: /^[a-zÀ-ʫ\'´`-]+?\.?\s?([a-zÀ-ʫ\'´`-]+\.?\s?)+$/i,

                },

                "settings__birth__day": {
               
                    required: false,
                    regex: /^[0-9]{2,2}$/,

                },

                "settings__birth__month": {
               
                    required: false,
                    regex: /^[0-9]{2,2}$/,

                },

                "settings__birth__year": {
               
                    required: false,
                    regex: /^[0-9]{4,4}$/,

                },

                "settings__phone": {
               
                    required: false,
                    regex: /^(?:[0-9-+()\s]){0,6}(?:[0-9-+()\s]){0,6}([0-9\s]){4,15}$/,

                },

                "settings__address": {
               
                    required: false,
                    regex: /^[A-å0-9À-ʫ\'\.\-\s\,&@]{2,}$/i,

                },

                "settings__country": {
               
                    required: false,
                    regex: /^[A-åÀ-ʫ ,\.()\'-]{2,}$/i,

                },

                "settings__webpage": {
               
                    required: false,
                    regex: /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i,

                },

                "settings__company": {
               
                    required: false,
                    regex: /^[A-å0-9À-ʫ\'\.\-\s\,&@]{2,}$/i,

                },

                "settings__company-role": {
               
                    required: false,
                    regex: /^[A-å0-9À-ʫ\'\.\-\s\,&@]{2,}$/i,

                },

            },

            //-------------------------------------------------
            // Messages
            //-------------------------------------------------

            messages: {

                "settings__username": {
               
                    required: "This field is required, username is missing.",
                    regex: "Invalid username. Minimum 5 and max 15 characters. Only letters and numbers are allowed.",
                    remote: "Username is already taken.",
               
                },

                "settings__first-name": {
               
                    regex: "Invalid first name.",
               
                },

                "settings__last-name": {
               
                    regex: "Invalid last name.",
               
                },

                "settings__birth__day": {
               
                    regex: "Invalid birth date.",
               
                },

                "settings__birth__month": {
               
                    regex: "Invalid birth date.",
               
                },

                "settings__birth__year": {
               
                    regex: "Invalid birth date.",
               
                },

                "settings__phone": {
               
                    regex: "Invalid phone number.",
               
                },

                "settings__address": {
               
                    regex: "Invalid address.",
               
                },

                "settings__country": {
               
                    regex: "Invalid country.",
               
                },

                "settings__webpage": {
               
                    regex: "Invalid webpage url.",
               
                },

                "settings__company": {
               
                    regex: "Invalid company name.",
               
                },

                "settings__company-role": {
               
                    regex: "Invalid company role.",

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
               
                var username = $("#settings__username").val();
                var first_name = $("#settings__first-name").val();
                var first_name_hide = $("#settings__first-name__hide").is(":checked");
                var last_name = $("#settings__last-name").val();
                var last_name_hide = $("#settings__last-name__hide").is(":checked");
                var birth_day = $("#settings__birth__day").val();
                var birth_month = $("#settings__birth__month").val();
                var birth_year = $("#settings__birth__year").val();
                var birth_hide = $("#settings__birth__hide").is(":checked");
                var phone = $("#settings__phone").val();
                var phone_hide = $("#settings__phone__hide").is(":checked");
                var address = $("#settings__address").val();
                var address_hide = $("#settings__address__hide").is(":checked");
                var country = $("#settings__country").val();
                var webpage = $("#settings__webpage").val();
                var company = $("#settings__company").val();
                var company_role = $("#settings__company-role").val();
                var bio = $("#text-editor__box")[0].innerHTML;

                
                $("#settings__form").html("<img alt=\"loading\" src=\"img/loading.gif\">"); // Output a loading image.
                
                // Set timer for the loading image.
                setTimeout(function () {
                    
                    // Run the ajax request.
                    $.ajax({
                       
                        data: {
                          
                            username: username,
                            first_name: first_name,
                            first_name_hide: first_name_hide,
                            last_name: last_name,
                            last_name_hide: last_name_hide,
                            birth_day: birth_day,
                            birth_month: birth_month,
                            birth_year: birth_year,
                            birth_hide: birth_hide,
                            phone: phone,
                            phone_hide: phone_hide,
                            address: address,
                            address_hide: address_hide,
                            country: country,
                            webpage: webpage,
                            company: company,
                            company_role: company_role,
                            bio: bio,
                            settings_personal: "true",
                       
                        },
                       
                        type: "post",
                        url: "classes/ajax.php",
                       
                        // On success output the requested site.
                        success: function (data) {

                            $("#settings__form").html(data);

                        },
                       
                        // On error output a error message.
                        error: function () {
                      
                            $("#settings__form").html("Sorry, an error has occurred. Please try again.");
                      
                        }

                    });

                }, 500);

                return false;

            }

        });

    });

});