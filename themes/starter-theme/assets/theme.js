function wooSlider() {

  jQuery(document).ready(function($){

    $(window).load(function() {
      // initalize slider first
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 210,
        itemMargin: 5,
        asNavFor: '#slider'
      });
     
      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel"
      });
    });

  }); // end of WordPress doc ready function

} // end of wooslider function