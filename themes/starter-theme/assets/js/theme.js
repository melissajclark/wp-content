// flickity setup
$(document).ready(function(){
 
    $('.galleryContainer').flickity({

    	accessibility: true,
    	autoPlay: false,
        setGallerySize:false,
        cellSelector: '.gallerySlide',
        initalIndex:1,
        cellAlign: 'center',
        wrapAround:true,
        pagedots:false,
        freeScroll:true

     }); // end flickity

}); // end doc ready

