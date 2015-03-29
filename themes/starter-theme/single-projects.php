<?php
/**
 * Single project template
 *
 * @package StarterTheme
 */

get_header(); ?>

<div class="wrapper"> 
    <div class="container">
    	<div id="primary" role="main"> 

	    <?php while ( have_posts() ) : the_post(); ?>

	        <?php get_template_part( 'content' ); ?>

	        <?php get_template_part( 'inc/pagination' ); ?>

	    <?php endwhile; // end of the loop. ?>

        </div><!-- / #primary -->
    </div><!-- / #container -->   
</div><!-- / #wrapper --> 

<?php get_footer(); ?>