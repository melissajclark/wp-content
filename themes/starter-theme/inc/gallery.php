<?php 
/**
*
* Gallery Module
*
**/

$images = get_field('gallery');

if( $images ): ?>
    <div class="galleryContainer"> 
        <?php foreach( $images as $image ): ?>
                <img class="gallerySlide" src="<?php echo $image['sizes']['flickity_gallery']; ?>" alt="<?php echo $image['alt']; ?>" />
        <?php endforeach; ?>
    </div>
<?php endif; ?>