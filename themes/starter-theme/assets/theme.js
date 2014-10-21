function wooSlider() {

  jQuery(document).ready(function($){

    $(window).load(function() {
      // initalize slider first
      $("#carousel").flexslider({
        animation: "fade",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 210,
        itemMargin: 5,
        asNavFor: "#slider"
      });
     
      $("#slider").flexslider({
        animation: "fade",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
      });
    });

  }); // end of WordPress doc ready function

} // end of wooslider function