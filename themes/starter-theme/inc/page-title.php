<?php
/**
 * The template file is used for displaying the main page title on content throughout the website.
 *
 * @package Starter_Theme
 */
?>

<?php if ( is_singular() ) : ?>

    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>

<?php elseif ( is_archive() ) : ?>

    <?php // Run through all archive types and apply specific titles  ?>
    <?php if ( is_category() ) : ?>
            
        <h1 class="entry-title" itemprop="name"><?php single_cat_title( esc_html_e('Category: ', 'starter-theme') ); ?>

     <?php elseif ( is_tag() ) : ?> 

        <h1 class="entry-title" itemprop="name"><?php single_tag_title( esc_html_e('Tag: ', 'starter-theme') ); ?>

     <?php elseif ( is_tax() ) : ?> 

        <h1 class="entry-title" itemprop="name"><?php single_term_title( esc_html_e('Taxonomy: ', 'starter-theme') ); ?></h1>

     <?php elseif ( is_post_type_archive() ) : ?> 

        <h1 class="entry-title" itemprop="name"><?php post_type_archive_title(); ?></h1>

     <?php elseif ( is_author() ) : ?> 

        <h1 class="entry-title" itemprop="name"><?php printf( __( 'Author: %s', 'starter-theme' ), '<span>' . get_the_author() . '</span>' ); ?></h1>

     <?php elseif ( is_day() ) : ?> 

        <h1 class="entry-title" itemprop="name"><?php printf( __( 'Day: %s', 'starter-theme' ), '<span>' . get_the_date() . '</span>' ); ?></h1>

     <?php elseif ( is_month() ) : ?> 

        <h1 class="entry-title" itemprop="name"><?php printf( __( 'Month: %s', 'starter-theme' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'starter-theme' ) ) . '</span>' ); ?></h1>

     <?php elseif ( is_year() ) : ?> 

        <h1 class="entry-title" itemprop="name"><?php printf( __( 'Year: %s', 'starter-theme' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'starter-theme' ) ) . '</span>' ); ?></h1>
    
    <?php else : ?>

        <h1 class="entry-title" itemprop="name"><?php esc_html_e( 'Archives', 'starter-theme' ); ?></h1>

    <?php endif; // archive titles ?>

<?php elseif ( is_404() ) : ?> 

   <h1 class="entry-title" itemprop="name"><?php esc_html_e('Nothing Found', 'starter-theme'); ?></h1>

<?php elseif ( is_search() ) : ?>

    <?php global $wp_query;
    $total_results = $wp_query->found_posts; ?>
    <h1 class="entry-title">
        <?php esc_html_e('Search Results:', 'starter-theme'); ?> <?php echo $total_results; ?> <?php esc_html_e('results found for &#8220;', 'starter-theme'); ?><?php echo get_search_query(); ?><?php esc_html_e('&#8221;', 'starter-theme'); ?>
    </h1>

<?php endif; ?>