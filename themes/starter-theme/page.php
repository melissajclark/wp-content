<?php
/**
 * The Page template
 *
 * This is the template that displays all pages by default.
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
                    <?php get_template_part('inc/gallery'); ?>
                    <?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'themeTextDomain' ) . '</span>', 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->

            <?php endwhile; // end of the loop. ?>
        </div><!-- / #primary -->
    </div><!-- / #container -->   
</div><!-- / #wrapper --> 

<?php get_footer(); ?>