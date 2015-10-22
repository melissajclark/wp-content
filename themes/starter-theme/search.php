<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div id="primary" role="main"> 
    <?php if ( have_posts() ) : ?>

        <header class="entry-header">
            <?php global $wp_query;
            $total_results = $wp_query->found_posts; ?>
            <h1 class="entry-title">
                <?php esc_html_e('Search Results:', 'starter-theme'); ?> 
                <?php echo $total_results; ?> 
                <?php esc_html_e('results found for &#8220;', 'starter-theme'); ?>
                <?php echo get_search_query(); ?>
                <?php esc_html('&#8221;', 'starter-theme'); ?>
            </h1>
        </header><!-- .entry-header -->

        <?php while ( have_posts() ) : the_post(); // start the loop ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                </header><!-- .entry-header -->
                <?php echo the_post_thumbnail('large'); ?>
                <?php the_excerpt(); ?>
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php endwhile; ?>

        <?php get_template_part( 'inc/pagination' ); ?>

    <?php else : ?>

        <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>
</div><!-- / #primary -->

    <?php get_sidebar(); ?>
 
   
<?php get_footer(); ?>