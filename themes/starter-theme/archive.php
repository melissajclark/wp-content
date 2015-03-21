<?php

/** * Grid Archive Template File *  
* This file is used to display a page when nothing more specific matches a query. 
* Learn more: http://codex.wordpress.org/Template_Hierarchy 
* * @package Starter_Theme */

get_header(); ?>

<div id="primary" role="main">

   <?php if ( have_posts() ) : ?>
        <!-- there IS content for this query -->

        <?php // check if we're on an archive page
        if ( is_archive() ) :
            // if so, print the archive title before the loop begins
            get_template_part( 'inc/archive-header' );
        endif; ?>
        
      <!-- Begin Grid Archive -->

      <?php get_template_part( 'inc/grid-archive-loop'); ?>

      <!-- End of Grid Archive -->

        <nav id="nav-below">
            <div class="nav-previous"><?php next_posts_link( __( "Older posts", "starter-theme" ) ); ?></div>
            <div class="nav-next"><?php previous_posts_link( __( "Newer posts", "starter-theme" ) ); ?></div>
        </nav><!-- #nav-above -->

    <?php else : ?>
        <!-- there IS NOT content for this query -->

        <article id="post-0" class="hentry post no-results not-found">
            <header class="entry-header">
                <h1><?php _e( "Oops!", "starter-theme" ); ?></h1>
            </header><!-- .entry-header -->

            <p><?php _e( "We can&#039;t find content for this page!", "starter-theme" ); ?></p>
        </article><!-- #post-0 -->

    <?php endif; ?>

</div><!-- / #primary -->

<?php get_footer(); ?>