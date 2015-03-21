<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div id="primary" role="main">
    <div class="wrapper"> 
        <div class="container"> 

    <?php if ( have_posts() ) : ?>

    <header class="archive-header">
    
        <!-- option 1 -->
        <!-- normal format (search results for: .....) -->

        <!-- <h1 class="archive-title">
            <?php printf( __( 'Search Results for: %s', 'starter-theme' ), '<span>' . get_search_query() . '</span>' ); ?>
        </h1> -->
        
        <!-- option 2 -->
        <!-- fancier format: displays search term in quotes + number of results -->

        <?php
        global $wp_query;
        $total_results = $wp_query->found_posts;
        ?>

        <h1>Search Results</h1>
        <h2><?php echo $total_results; ?> results found for &#8220;<?php echo get_search_query(); ?>&#8221;</h2>

    </header>

        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>

            <?php
                get_template_part( 'content/content');
            ?>

        <?php endwhile; ?>

        <?php get_template_part( 'inc/pagination' ); ?>

    <?php else : ?>

        <?php get_template_part( 'content/content', 'content/content-none' ); ?>

    <?php endif; ?>

        </div><!-- / container -->
    </div><!-- / wrapper -->   
</div><!-- / #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>