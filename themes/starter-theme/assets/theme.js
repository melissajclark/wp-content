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
        sync: "#carousel"
      });
    });

  }); // end of WordPress doc ready function

} // end of wooslider function


function wooSlider() {

  jQuery(document).ready(function($){

    $(window).load(function() {
      // initalize slider first
      // $("#carousel").flexslider({
      //   animation: "slide",
      //   controlNav: false,
      //   animationLoop: false,
      //   slideshow: false,
      //   itemWidth: 100,
      //   itemMargin: 10,
      //   asNavFor: "#slider"
      // });
     
      $("#slider").flexslider({
        animation: "fade",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        // sync: "#carousel"
      });
    });

  }); // end of WordPress doc ready function

} // end of wooslider function