<?php
/**
 * Template Name: Page with Slider
 *
 * This is the template that displays all pages by default.
 *
 * @package Starter_Theme
 */

get_header(); ?>

<section id="primary" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">

            <h3>Woo Flexslider</h3>

            <?php 

            $images = get_field('gallery');

            if( $images ): ?>
                <div id="slider" class="flexslider">
                    <ul class="slides">
                        <?php foreach( $images as $image ): ?>
                            <li>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                <p><?php echo $image['caption']; ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            
        <?php endif; ?>

        <hr/>

        <h3>BX Slider</h3>

        <!-- Custom Field Content for Images -->
            <?php 

            $images = get_field('gallery');

            if( $images ): ?>
                <div id="slider">
                    <ul class="bxslider">
                        <?php foreach( $images as $image ): ?>
                            <li>
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                <p><?php echo $image['caption']; ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

        <hr/>

        <h3>Wallop Slider</h3>

        <!-- Custom Field Content for Images -->

        <div class="photo-slider wallop-slider wallop-slider--slide">
            <?php 

            $images = get_field('gallery');

            if( $images ): ?>
                    <ul class="wallop-slider__list">
                        <?php foreach( $images as $image ): ?>
                            <li class="wallop-slider__item">
                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                <p><?php echo $image['caption']; ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
            <?php endif; ?>
            <button class="wallop-slider__btn wallop-slider__btn--previous btn btn--previous" disabled="disabled">Previous</button>
      <button class="wallop-slider__btn wallop-slider__btn--next btn btn--next">Next</button>

    </div> <!-- end of wallopSlider -->

        <hr/>


                <?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'themeTextDomain' ) . '</span>', 'after' => '</div>' ) ); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; // end of the loop. ?>

</section><!-- #primary -->

<?php get_footer(); ?>