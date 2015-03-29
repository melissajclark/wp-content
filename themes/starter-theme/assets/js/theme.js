// flickity setup
$(document).ready(function(){
 
    $('.galleryContainer').flickity({

    	accessibility: true,
    	autoPlay: false,
        setGallerySize:false,
        // cellSelector: '.gallerySlide',
        initalIndex:1,
        cellAlign: 'center',
        wrapAround:true,
        pageDots:false,
        // freeScroll:true,
        resize:true,
        draggable:false

     }); // end flickity

}); // end doc ready

