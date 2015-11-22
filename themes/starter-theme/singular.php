<?php
/**
 * The Singular template
 *
 * This is the template that displays all pages or posts by default.
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div id="primary" role="main"> 

	<?php while ( have_posts() ) : the_post(); ?>
		 <?php get_template_part('content'); ?>

	    <?php if ( !is_singular('page') ) : // this is not a page ?>
	        <?php comments_template( '', true ); ?>
	    	<?php get_template_part( 'inc/pagination' ); ?>
	    <?php endif; ?>

	 <?php endwhile; // end of the loop. ?>

</div><!-- #primary -->

	<?php if ( !is_singular('page') ) : // this is not a page ?>
		<?php get_sidebar(); ?>
	<?php endif; ?>

<?php get_footer(); ?>