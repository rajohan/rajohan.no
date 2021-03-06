//-------------------------------------------------
// Validator regex method
//-------------------------------------------------

$.validator.addMethod(

    "regex",
    function (value, element, regexp) {
       
        var re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
    
    }

);

//-------------------------------------------------
// Get the width of the scrollbar
//-------------------------------------------------

function getScrollBarWidth() {
   
    var $outer = $("<div>").css({visibility: "hidden", width: 100, overflow: "scroll"}).appendTo("body");
    var widthWithScroll = $("<div>").css({width: "100%"}).appendTo($outer).outerWidth();
    $outer.remove();
    return 100 - widthWithScroll;

}

var webpage_width = 900 - getScrollBarWidth(); // Set var with webpage width - scrollbar

//-------------------------------------------------
// Animate scroll to scrollTo
//-------------------------------------------------

function scroll(scrollTo, offset) {
  
    var $container = $("html,body");
    var $scrollTo = scrollTo;
    $container.animate({scrollTop: $scrollTo.offset().top+offset , scrollLeft: 0}, "slow");

}

//-------------------------------------------------
// Check if website is resized to width > 900 and set navbar to flex if it is and hide navbar if not
//-------------------------------------------------

$(window).resize(function() {
  
    if($(window).width() > webpage_width) {

        $(".navigation__list").css("display", "flex");
        $(".navigation__button").removeClass("navigation__button__open");
        $(".navigation__button").addClass("navigation__button__closed");

    } else {

        $(".navigation__list").css("display", "none");
        $(".navigation__button").removeClass("navigation__button__open");
        $(".navigation__button").addClass("navigation__button__closed");

    }
});

//-------------------------------------------------
// Hide/Show hamburger menu
//-------------------------------------------------

$(".navigation__hamburger-menu").on("click", function() {

    if($(".navigation__list").css("display") === "none") {
      
        $(".navigation__list").css("display", "flex");
        $(".navigation__button").removeClass("navigation__button__closed");
        $(".navigation__button").addClass("navigation__button__open");
        scroll($(".navigation"), 0);
   
    } else {
     
        $(".navigation__list").css("display", "none");
        $(".navigation__button").removeClass("navigation__button__open");
        $(".navigation__button").addClass("navigation__button__closed");

    }

});

//-------------------------------------------------
// Toggle active class on nav bar buttons
//-------------------------------------------------

$(".navigation__item").on("click", function() {

    if($(window).width() > webpage_width) {
      
        $(".navigation__item a").removeClass("navigation__link--active");
        $(this).children("a").addClass("navigation__link--active");
        $(".navigation__list").css("display", "flex");
    
    } else {
     
        $(".navigation__item a").removeClass("navigation__link--active");
        $(this).children("a").addClass("navigation__link--active");
        $(".navigation__list").css("display", "none");
   
    }

});

//-------------------------------------------------
// Take user Back to top
//-------------------------------------------------

$(".back-to-top").on("click", function() {
  
    scroll($(".navigation"), 0);

});

//-------------------------------------------------
// Hide/Show back to top button based on scroll posistion
//-------------------------------------------------

$(window).on("scroll", function() {
  
    var scrollPosition = $(".navigation").offset().top + $(".navigation").height();
    
    if (scrollPosition < window.scrollY) {
    
        $(".back-to-top").css("display", "block");
   
    } else {
   
        $(".back-to-top").css("display", "none");
  
    }
    
});

//-------------------------------------------------
//  Functions to scroll page to desired element on the legal policies page
//-------------------------------------------------
$("#legal__disclaimer").click(function() {
    scroll($("#legal__disclaimer-target"), -15);
});

$("#legal__privacy").click(function() {
    scroll($("#legal__privacy-target"), -15);
});

$("#legal__cookies").click(function() {
    scroll($("#legal__cookies-target"), -15);
});

$("#legal__refund").click(function() {
    scroll($("#legal__refund-target"), -15);
});

$("#legal__tos").click(function() {
    scroll($("#legal__tos-target"), -15);
});

//-------------------------------------------------
// Vote like/dislike blog/comments
//-------------------------------------------------

function add_vote(id, type, vote) {
    
    $.ajax({
            
        url: "classes/ajax.php",
        type: "post",
        data: {add_vote: "true", type: type, vote: vote, id: id},
        dataType: "json",
    
        // On success output the requested site.
        success: function (data) {

            $("#"+type+"__like__count__" + id).html(data.like);
            $("#"+type+"__dislike__count__" + id).html(data.dislike);

        }

    });
    
}

//-------------------------------------------------
// Blog navigation buttons (recent, views, votes)
//-------------------------------------------------

function blog_nav_sort(sort) {

    $.ajax({
            
        url: "modules/blog_nav_sort.php",
        type: "post",
        data: {blog_nav_sort: "true", sort: sort},
    
        // On success output the requested site.
        success: function (data) {

            $(".blog-navigation__sort__box").html(data);

            $(".blog-navigation__sort__buttons__item").removeClass("blog-navigation__sort__buttons__item__active");
            $("#blog-navigation__"+sort).addClass("blog-navigation__sort__buttons__item__active");

        }

    });

}

//-------------------------------------------------
// Sort comments (oldest, newest, best)
//-------------------------------------------------

function sort_comments(blog_id, order) {
    
    $.ajax({
        
        url: "blog/read/"+blog_id+"/1/",
        type: "post",
        data: {sort_comments: "true", blog_id: blog_id, order: order},
    
        // On success output the requested site.
        success: function (data) {

            $("body").html(data);

            $(".blog__comment__sort__by__link").removeClass("blog__comment__sort__by__link__active");
            $("#blog__comment__sort__by__"+order).addClass("blog__comment__sort__by__link__active");

        }

    });

}

//-------------------------------------------------
// Reload comments when pagination is clicked
//-------------------------------------------------

$(".comments__pagination a").on("click", function(event) {

    event.preventDefault(); // Prevent the page from reloading
    var blog_id = $(".blog__comment").attr("id");
    var pageurl = $(this).attr("href");

    $.ajax({
            
        url: pageurl,
        type: "post",
        data: {reload_comments: "true", blog_id: blog_id},

        // On success output the requested site.
        success: function (data) {
            
            $("body").html(data);

        }

    });
    
});

//-------------------------------------------------
// Hide/show comment answers
//-------------------------------------------------

var blog_comments_hide_count = 1;

$(".blog__comment__message__hide").on("click", function() { 

    $(this).parent().siblings().slice(2).toggle();

    if(blog_comments_hide_count === 1)  {
        blog_comments_hide_count = 0;
        $(this).html("Show answers <span>&dtrif;</span>");

    } else {

        blog_comments_hide_count = 1;
        $(this).html("Hide answers <span>&utrif;</span>");
        
    }

});

//-------------------------------------------------
// Highlight comment parent 
//-------------------------------------------------

$(".blog__box").on("click", ".blog__comment__reply-to__text", function() { 
    
    var id = $(this).attr("data-reply-id"); // Id to parent message
    $("#message_id_"+id).css("background-color", "#FDFF47"); // Highlight message

    // Check if message to be highlighted have a reply to box and add bg color to it aswell if it exists
    if($("#message_top_id_"+id).length > 0) {

        $("#message_top_id_"+id).css("background-color", "#FDFF47");
        scroll($("#message_id_"+id), -100); // Scroll to message

    } else {

        scroll($("#message_id_"+id), -70); // Scroll to message

    }

    // Crate timer to remove the bg color
    var change_bg = setInterval(function() {

        $("#message_id_"+id).css("background-color", "#FFFFFF");

        // Check if message to be unhighlighted have a reply to box and remove bg color from it aswell if it exists
        if($("#message_top_id_"+id).length > 0) {

            $("#message_top_id_"+id).css("background-color", "#FFFFFF");

        }

        clearInterval(change_bg); // Clear interval 

    },2000);

});


//-------------------------------------------------
// Newsletter blog_nav bar submit
//-------------------------------------------------

$("#blog-navigation__newsletter__button").on("click", function(event) { 

    event.preventDefault(); // Prevent the page from reloading
    var mail = $("#blog-navigation__newsletter__mail").val();

    $.ajax({
            
        url: "newsletter/",
        type: "post",
        data: {blog_navigation__newsletter: "true",},

        // On success output the requested site.
        success: function (data) {
            
            $("body").html(data);
            $("#newsletter__subscribe__mail").val(mail);
            $("#newsletter__subscribe__button").click(); 

        }

    });

});

//-------------------------------------------------
// Comment reply button click
//-------------------------------------------------

$(".blog__box").on("click", ".blog__comment__date-reply__img", function() { 

    // If user is logged in
    if($(".text-editor").length) {

        var reply_to = $(this).attr("data-id");
        var reply_to_user = $(this).attr("data-user");

        $(".text-editor__status").attr("data-reply-to", reply_to);
        $(".text-editor__reply-to").text(reply_to_user);
        $(".text-editor__status__cancel").css("display", "flex");

        scroll($(".text-editor"), 0); // Scroll text editor

    } else { // User not logged in

        scroll($(".not__logged-in__error"), 0); // Scroll text editor

    }


});

//-------------------------------------------------
// Texteditor status cancel button
//-------------------------------------------------

$(".text-editor__status__cancel").on("click", function() { 

    $(".text-editor__reply-to").text("none");
    $(".text-editor__status").attr("data-reply-to", "0");
    $(".text-editor__status__cancel").css("display", "none");

});

//-------------------------------------------------
// User menu drop down hide/show
//-------------------------------------------------

var scrollUserNav = 1;
$(".navigation__user-menu__nav__user").on("click", function() {
   
    $(".navigation__user-menu__nav__items").toggle();

    if(scrollUserNav === 1) {

        scroll($(".navigation"), 0);
        scrollUserNav = 0;
        $(".navigation__user-menu__nav__user__arrow").html("&utrif;");

    } else {

        scrollUserNav = 1;
        $(".navigation__user-menu__nav__user__arrow").html("&dtrif;");
    }

});

//-------------------------------------------------
// Settings navigation
//-------------------------------------------------

function settingsNav(page) {
    
    $.ajax({
            
        url: "classes/ajax.php",
        type: "post",
        data: {settings_nav: "true", settings_page: page},

        // On success output the requested site.
        success: function () {
            
            location.reload();

        }

    });

}

//-------------------------------------------------
// Blog nav bar on hover image/title
//-------------------------------------------------

$(".blog-navigation__sort__content__title").hover(
    function() {
        $(this).parent().parent().children("a").css("opacity", "0.7"); 
        $(this).css({"color" : "#254B62" , "opacity" : "1"}); 
    },
    function(){
        $(this).parent().parent().children("a").css("opacity", "1"); 
        $(this).css({"color" : "#000000" , "opacity" : "1"} ); 
    }
);

$(".blog-navigation__sort__content__img").hover(
    function() {
        $(this).parent().siblings(".blog-navigation__sort__content__text").children(".blog-navigation__sort__content__title").css("color", "#254B62");
        $(this).css("opacity", "0.7");
    },
    function(){
        $(this).parent().siblings(".blog-navigation__sort__content__text").children(".blog-navigation__sort__content__title").css("color", "#000000"); 
        $(this).css("opacity", "1");
    }
);