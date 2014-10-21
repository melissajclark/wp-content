function wooSliderAndCarousel() {

  jQuery(document).ready(function($){

    $(window).load(function() {
      // initalize slider first
      $("#carousel").flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 100,
        itemMargin: 10,
        asNavFor: "#slider"
      });
     
      $("#slider").flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel",
        maxItems: 8
      });
    });

  }); // end of WordPress doc ready function

} // end of wooslider function


function wooSlider() {

  jQuery(document).ready(function($){

    $(window).load(function() {   
      $("#slider").flexslider({
        animation: "slide",
        controlNav: true,
        animationLoop: false,
        slideshow: false,
        smoothHeight: true,
        slideShowSpeed: 9000,
        useCSS: true,
        touch: true,
        directionNav: true,
        prevText: "Previous",
        nextText: "Next",
        keyboard: true


      });
    });

  }); // end of WordPress doc ready function

} // end of wooslider function