// flickity setup
$(document).ready(function(){
 
    $('.galleryContainer').flickity({

    	accessibility: true,
    	autoPlay: true,
        setGallerySize:false,
        cellSelector: '.gallerySlide',
        // initalIndex:2,
        // cellAlign: 'center',
        // pageDots:true,
        // freeScroll:true,
        // resize:true,
        // draggable:false,
        contain:true

     }); // end flickity

}); // end doc ready

