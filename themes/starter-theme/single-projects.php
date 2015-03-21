<?php
/**
 * Single post template
 *
 * @package StarterTheme
 */

get_header(); ?>

<div class="wrapper"> 
    <div class="container">
    	<div id="primary" role="main"> 
        
        <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content/content-project' ); ?>

        <?php comments_template( '', true ); ?>

        <?php // pagingation could go here ?>

        <?php endwhile; // end of the loop. ?>

        </div><!-- / #primary -->
    </div><!-- / #container -->   
</div><!-- / #wrapper --> 
<?php get_sidebar(); ?>
<?php get_footer(); ?>