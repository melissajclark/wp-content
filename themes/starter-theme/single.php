<?php
/**
 * Single post template
 *
 * @package StarterTheme
 */

get_header(); ?>

<div class="contentWrapper"> 
    <div class="container containerWithAside">
    	<div id="primary" role="main"> 

	    <?php while ( have_posts() ) : the_post(); ?>

	        <?php get_template_part( 'content' ); ?>

	        <?php comments_template( '', true ); ?>

			<?php get_template_part( 'inc/pagination' ); ?>

	    <?php endwhile; // end of the loop. ?>

        </div><!-- / #primary -->

        <?php get_sidebar(); ?>
        
    </div><!-- / #container -->   
</div><!-- / #contentWrapper --> 

<?php get_footer(); ?>