<?php
/**
 * Single post template
 *
 * @package StarterTheme
 */

get_header(); ?>

<section id="primary">

    <?php while ( have_posts() ) : the_post(); ?>

        <?php get_template_part( 'content' ); ?>

        <?php comments_template( '', true ); ?>

        <!-- You could also put some between-post links here (next post, previous post) -->

    <?php endwhile; // end of the loop. ?>

</section><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>