
// bXslider function
function sliderBX(){
    jQuery(document).ready(function($){
        $('.bxslider').bxSlider({
          infiniteLoop: false,
            hideControlOnEnd: true,
            adaptiveHeight: true,
            responsive: true
        });
    });
}

function wooSlider(){
  jQuery(document).ready(function($) {
    $(document).ready(function() {
     $('.flexslider').flexslider({
       animation: "slide",
       animationLoop: false,
       // itemHeight: 550,
       // itemMargin: 5,
       pausePlay: true,
       controlNav: true
     });
    });
  }); // jQuery ready function
} // end wooSlider function
