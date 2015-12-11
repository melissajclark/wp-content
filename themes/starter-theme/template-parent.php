<?php
/**
 * Template Name: Parent Page
 *
 * This template displays a list of child items for this page. 
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div id="primary" role="main"> 

	<?php // // custom query to display children of this page  ?>
    <?php $childPosts = new WP_query( 
            array(
                'post_type' 		=> 'page',
                'post_parent'		=>  $post->ID,
                'posts_per_page' 	=> -1,
                'orderby'           => 'menu_order',
                'order'             => 'ASC',
                )
            ); ?>

    <?php if ($childPosts->have_posts() ) : ?>
    	<div class="container">
            <?php while ( $childPosts->have_posts() ) : $childPosts->the_post(); ?> 
                <?php get_template_part('content'); ?>
            <?php endwhile; ?>
    	</div><!-- .container -->

        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</div><!-- / #primary -->

<?php get_footer(); ?>