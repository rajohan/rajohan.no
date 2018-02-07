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

    } else {

        $(".navigation__list").css("display", "none");

    }
});

//-------------------------------------------------
// Hide/Show hamburger menu
//-------------------------------------------------

$(".navigation__hamburger-menu").on("click", function() {

    if($(".navigation__list").css("display") === "none") {
      
        $(".navigation__list").css("display", "flex");
        scroll($(".navigation"), 0);
   
    } else {
     
        $(".navigation__list").css("display", "none");
   
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