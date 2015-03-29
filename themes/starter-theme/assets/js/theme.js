// flickity setup
$(document).ready(function(){
 
    $(".mainGallery").flickity({

    	accessibility: true,
    	// enable keyboard navigation, pressing left & right keys

    	autoPlay: false,
    	// advances to the next cell
    	// if true, default is 3 seconds
    	// or set time between advances in milliseconds
    	// i.e. `autoPlay: 1000` will advance every 1 second

    	cellSelector: '.gallerySlide'
    	// specify selector for cell elements

     }); // end flickity

}); // end doc ready

