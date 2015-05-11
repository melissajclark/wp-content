<?php
/**
 * The Page template
 *
 * This is the template that displays all pages by default.
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div class="contentContainer">
	<div id="primary" role="main"> 
    <?php while ( have_posts() ) : the_post(); ?>
		
        <?php get_template_part('content'); ?>

        <?php endwhile; // end of the loop. ?>
    </div><!-- / #primary -->
</div><!-- / #contentContainer -->   

<?php get_footer(); ?>