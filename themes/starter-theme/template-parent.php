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

	<?php // display grid of child Posts ?>
    <?php $childPosts = new WP_query( // custom query to display events
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
    	</div><!-- .cardLayoutBlock -->

        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</div><!-- / #primary -->

<?php get_footer(); ?>