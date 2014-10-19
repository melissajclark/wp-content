function slider(){
    jQuery(document).ready(function($){
        $('.bxslider').bxSlider({
            mode: 'fade',
            pager: true,
            nextSelector: '#slider-next',
            prevSelector: '#slider-prev',
             nextText: 'Onward →',
             prevText: '← Go back'
        });
    });
}