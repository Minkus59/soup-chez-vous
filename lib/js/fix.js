$(window).scroll(function() {
    var scroll = $(window).scrollTop();
    if (scroll == 0) {
       $("nav").addClass("relativ");
       $("nav").removeClass("fixedTop");
    }
    else {
       $("nav").removeClass("relativ");
       $("nav").addClass("fixedTop");
    }
});