<?php
/**
 * Template Name: Gallery
 *
 * This is the template that displays all gallery pages by default.
 *
 * @package Starter_Theme
 */

get_header(); ?>


<div id="primary" role="main">

    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content">

                <?php the_content(); ?>

                <?php // gallery content begins here

                $images = get_field('gallery');

                if( $images ): ?>
                <section class="wooSliderContainer">
                    <section class="flexslider">
                        <ul class="slides">
                            <?php foreach( $images as $image ): ?>
                                <li>
                                    <img class="flexSliderImage" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                    <p><?php echo $image['caption']; ?></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                </section>
                <?php endif; ?>

                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'themeTextDomain' ) . '</span>', 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php endwhile; // end of the loop. ?>
    </div><!-- / container -->
</div><!-- / #primary -->

<?php get_footer(); ?>