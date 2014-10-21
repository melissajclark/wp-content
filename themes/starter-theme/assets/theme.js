
// bXslider function
// function sliderBX(){
//     jQuery(document).ready(function($){
//         $('.bxslider').bxSlider({
//           infiniteLoop: false,
//             hideControlOnEnd: true,
//             adaptiveHeight: true,
//             responsive: true
//         });
//     });
// }

function wooSlider(){
  jQuery(document).ready(function($) {
    $(document).load(function() {
      // The slider being synced must be initialized first
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

  }); // jQuery ready function
}); // end wooSlider function