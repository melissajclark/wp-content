
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
        // controlNav: "thumbnails"
      });
    });
  }); // jQuery ready function
}
