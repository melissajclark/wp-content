<?php
/**
 * Single post template
 *
 * @package StarterTheme
 */

get_header(); ?>

<div id="primary" role="main">
    <div class="wrapper"> 
        <div class="container"> 

	    <?php while ( have_posts() ) : the_post(); ?>

	        <?php get_template_part( 'content/content' ); ?>

	        <?php comments_template( '', true ); ?>

	        <!-- You could also put some between-post links here (next post, previous post) -->

	    <?php endwhile; // end of the loop. ?>

        </div><!-- / container -->
    </div><!-- / wrapper -->   
</div><!-- / #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>