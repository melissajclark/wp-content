<?php 
/**
*
* Gallery Module
*
**/

$images = get_field('gallery');

if( $images ): ?>
    <div class="mainGallery"> 
        <?php foreach( $images as $image ): ?>
            <div class="gallerySlide"> 
                <img src="<?php echo $image['sizes']['flickity_gallery']; ?>" alt="<?php echo $image['alt']; ?>" />
                <span class="overlay"><?php echo $image['caption']; ?></span>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>