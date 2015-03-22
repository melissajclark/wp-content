<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div class="wrapper"> 
    <div class="container containerWithAside">
    	<div id="primary" role="main"> 

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="entry-title"><?php printf( __( 'Search Results for: %s', 'themeTextDomain' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header>

            <?php /* Start the Loop */ ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <?php
                    get_template_part( 'content/content');
                ?>

            <?php endwhile; ?>

            <?php get_template_part( 'inc/pagination' ); ?>

        <?php else : ?>

            <?php get_template_part( 'content/content-none' ); ?>

        <?php endif; ?>

        </div><!-- / #primary -->

        <?php get_sidebar(); ?>

    </div><!-- / #container -->   
</div><!-- / #wrapper --> 

<?php get_footer(); ?>