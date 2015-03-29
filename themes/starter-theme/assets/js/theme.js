// flickity setup
$(document).ready(function(){
 
    $('.galleryContainer').flickity({

    	accessibility: true,
    	autoPlay: true,
        setGallerySize:false,
        initalIndex:2,
        cellAlign: 'center',
        pageDots:true,
        freeScroll:true,
        wrapAround:true,
        resize:true,
        draggable:false

     }); // end flickity

}); // end doc ready

