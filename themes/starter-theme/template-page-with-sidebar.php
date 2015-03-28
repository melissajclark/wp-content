<?php
/**
 *
 * Template Name: Page with Sidebar
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div class="wrapper"> 
    <div class="container containerWithAside">
    
    	<div id="primary" role="main"> 
        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part('content'); ?>

            <?php endwhile; // end of the loop. ?>
        </div><!-- / #primary -->

        <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar( 'sidebar-2' ); ?>
        </div><!-- #secondary .widget-area -->

    </div><!-- / #container -->   
</div><!-- / #wrapper --> 

<?php get_footer(); ?>