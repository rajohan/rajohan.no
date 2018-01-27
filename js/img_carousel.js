/////////////////////////////////////////////////////////
// Array of images to cycle
/////////////////////////////////////////////////////////
var images = new Array();
images = [

    {"Source":"img/header/header1.jpg","Title":"Learn the basics","Text":"HTML, CSS, JavaScript, jQuery and PHP tutorials","Button_text":"View tutorials","Link":"blog/"},
    {"Source":"img/header/header2.jpg","Title":"Need a website?","Text":"I'm a single source high quality solution for enforcing your business existence online","Button_text":"View services","Link":"services/"},
    {"Source":"img/header/header3.jpg","Title":"Personal blog","Text":"Read about my life and follow me through my projects","Button_text":"View blog","Link":"blog/"},
    {"Source":"img/header/header4.jpg","Title":"Computer basics","Text":"Linux, security and other computer related guides","Button_text":"View guides","Link":"blog/"}

];


/////////////////////////////////////////////////////////
// Global variables
/////////////////////////////////////////////////////////
var count = images.length - 1; // Subtracting 1 accounts for the array starting at [0]
var counting = 0; // Start couting at 0
var timerSwitcher; // Timer to switch header image
var loadCount = 1; // Counter for slow loading of images
var cycleTime = 8000; // Time between each image change
var fadeTime = 500; // Fade in/out time

/////////////////////////////////////////////////////////
// Slow load all header images
/////////////////////////////////////////////////////////
var slowLoad = setInterval(function() {
    
    // Slow load images
    if(loadCount < images.length) {
       
        $("body").append("<img src='"+images[loadCount]["Source"]+"' alt='Header"+loadCount+"' style='display:none;'>"); // Insert a <img> with display none to slow load all header images
        loadCount++; // add 1 to loadCount
   
        // We are done slow loading images
    } else {

        clearInterval(slowLoad); // Clear timer slowLoad

    }

},1000);


/////////////////////////////////////////////////////////
// Fade out old header image and fade in the new one
/////////////////////////////////////////////////////////
function changeImage() {

    $(".header").fadeOut(fadeTime,function(){

        $(".header").css({"background-image":"linear-gradient(to right bottom,rgba(0, 0, 0, 0.8),rgba(0, 0, 0, 0.8)), url("+images[counting]["Source"]+")"}).fadeIn(fadeTime); // Change header image
        $("#header__title").html(images[counting]["Title"]).fadeIn(fadeTime); // Change header title
        $("#header__text").html(images[counting]["Text"]).fadeIn(fadeTime); // Change header text
        $("#header__button").html(images[counting]["Button_text"]).fadeIn(fadeTime); // Change button text
        $("#header__button").attr({"href":images[counting]["Link"]}).fadeIn(fadeTime); // Change button link
    
    });

    $(".header__placeholder").css({"background-image":"linear-gradient(to right bottom,rgba(0, 0, 0, 0.8),rgba(0, 0, 0, 0.8)), url("+images[counting]["Source"]+")"}); // Change placeholder image
}


/////////////////////////////////////////////////////////
// Change active circle
/////////////////////////////////////////////////////////
function activeCircle() {

    // If counting not equals count add 1 to counting and change active circle
    if(counting !== count) {

        counting++; // Add 1 to counting
        $("#header__switcher-"+counting).removeClass("header__circle-switcher--active"); // Remove active class from old circle
        $("#header__switcher-"+(counting+1)).addClass("header__circle-switcher--active"); // Add active class to new active circle
    
    // Else set counting to 0 and change active circle
    } else {
      
        counting = 0; // Set counting to 0
        $("#header__switcher-"+(count+1)).removeClass("header__circle-switcher--active"); // Remove active class from old circle
        $("#header__switcher-"+(counting+1)).addClass("header__circle-switcher--active"); // Add active class to new active circle
    
    }

}


/////////////////////////////////////////////////////////
// Switch header image
/////////////////////////////////////////////////////////
function imgSwitcher() {

    timerSwitcher = setInterval(function() {

        changeImage(); // Set new background image
        activeCircle(); // Change active circle
    
    },cycleTime);

}
imgSwitcher(); // Start imageSwitcher timer


/////////////////////////////////////////////////////////
// Change header image when prev button is clicked
/////////////////////////////////////////////////////////
$(".header__img-switcher--prev").on("click", function() {

    clearInterval(timerSwitcher); // Clear imageSwitcher timer

    // If counting = 0 set counting to the value of count and change active circle
    if(counting === 0) {
      
        counting = count; // Set counting equal to count
        $("#header__switcher-"+1).removeClass("header__circle-switcher--active"); // Remove active class from old circle
        $("#header__switcher-"+(counting+1)).addClass("header__circle-switcher--active"); // Add active class to new active circle
    
    // Else subtract 1 from counting and change active circle
    } else {
     
        counting--; // Subtract 1 from counting
        $("#header__switcher-"+(counting+2)).removeClass("header__circle-switcher--active"); // Remove active class from old circle
        $("#header__switcher-"+(counting+1)).addClass("header__circle-switcher--active"); // Add active class to new active circle
    
    }

    changeImage(); // Set new background image
    imgSwitcher(); // Restart imageSwitcher timer

});


/////////////////////////////////////////////////////////
// Change header image when next button is clicked
/////////////////////////////////////////////////////////
$(".header__img-switcher--next").on("click", function() {

    clearInterval(timerSwitcher); // Clear imageSwitcher timer
    activeCircle(); // Change active circle
    changeImage(); // Set new background image
    imgSwitcher(); // Restart imageSwitcher timer

});


/////////////////////////////////////////////////////////
// Change header image when circles are clicked
/////////////////////////////////////////////////////////
$(".header__circle-switcher").on("click", function() {

    clearInterval(timerSwitcher); // Clear imageSwitcher timer

    var id = $(this).attr("data"); // Set id to value of data attribute from the circle clicked
    counting = id - 1; // Set counting to id - 1
    changeImage(); // Set new background image

    $(".header__circles .header__circle-switcher").removeClass("header__circle-switcher--active"); // Remove active class from old circle
    $("#header__switcher-"+(id)).addClass("header__circle-switcher--active"); // Add active class to new active circle

    imgSwitcher(); // Restart imageSwitcher timer

});