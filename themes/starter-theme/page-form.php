<?php
/**
 * Template Name: Form
 *
 * This is the template that displays all pages by default.
 *
 * @package Starter_Theme
 */

acf_form_head(); ?>
<?php get_header(); ?>

    <div id="primary">
        <div id="content" role="main">

            <?php /* The loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <?php acf_form(); ?>

            <?php endwhile; ?>

        </div><!-- #content -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>