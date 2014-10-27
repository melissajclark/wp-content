function simpleWooSlider() {
  jQuery(document).ready(function($){ // wordpress doc ready

    $(window).load(function() {
      $('.flexslider').flexslider({
        animation: "slide"
      });
    });

  }); // end of WordPress doc ready function
} // end of simpleWooSlider

function sliderBX(){ 
    jQuery(document).ready(function($){
        $('.bxslider').bxSlider({
          infiniteLoop: false,
            hideControlOnEnd: true,
            adaptiveHeight: true,
            responsive: true
        });
    }); // end of WordPress doc ready function
} // end of sliderBX function


(function() { //wallopSlider function
    'use strict';

    // New isntance of WallopSlider
    var photoSlider = new WallopSlider('.photo-slider');

})();

function glideSlider(){ 
    jQuery(document).ready(function($){
        $('.slider').glide({
          autoplay: false,
          arrows: 'body',
          navigation: 'body',
          arrows: true,
          // arrowsWrapperClass: 'slider__arrows',
          // arrowMainClass: 'slider__arrows-item',
          // arrowRightClass: 'slider__arrows-item--right',
          // arrowLeftClass: 'slider__arrows-item--left',
          // arrowRightText: '>',
          // arrowLeftText: '<',
          keyboard: true,
          navigation: false
        });
    }); // end of WordPress doc ready function
} // end of glideSlider function

