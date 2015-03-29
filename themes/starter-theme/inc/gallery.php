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
            <div class="gallerySlide"> 
                <img src="<?php echo $image['sizes']['flickity_gallery']; ?>" alt="<?php echo $image['alt']; ?>" />
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>