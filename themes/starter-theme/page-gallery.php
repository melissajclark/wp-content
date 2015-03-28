<?php
/**
 * Template Name: Gallery
 *
 * This is the template that displays all gallery pages by default.
 *
 * @package Starter_Theme
 */

get_header(); ?>


<div class="wrapper"> 
    <div class="container">
    	<div id="primary" role="main"> 
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
                <div class="gallery"> 
                    <?php foreach( $images as $image ): ?>
                        <div class="cell"> 
                            <img src="<?php echo $image['sizes']['gallery']; ?>" alt="<?php echo $image['alt']; ?>" />
                            <p><?php echo $image['caption']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'themeTextDomain' ) . '</span>', 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php endwhile; // end of the loop. ?>
        </div><!-- / container -->
    </div><!-- / wrapper -->  
</div><!-- / #primary -->

<?php get_footer(); ?>