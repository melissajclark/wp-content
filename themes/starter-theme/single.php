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

	        <?php get_template_part( 'content/content' ); ?>

	        <?php comments_template( '', true ); ?>

	        <!-- You could also put some between-post links here (next post, previous post) -->

	    <?php endwhile; // end of the loop. ?>

        </div><!-- / #primary -->

        <?php get_sidebar(); ?>
        
    </div><!-- / #container -->   
</div><!-- / #wrapper --> 

<?php get_footer(); ?>