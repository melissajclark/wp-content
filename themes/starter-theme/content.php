<?php
/**
 * The template file is used for displaying the main content of pages and posts throughout the website.
 *
 * @package Starter_Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">

        <?php if ( is_front_page() ) : ?>

            <?php // no title or breadcrumbs if it is the home page ?>

        <?php elseif ( is_singular() ) :  ?>

            <?php get_template_part('inc/page-title'); ?>

            <?php if ( function_exists('yoast_breadcrumb') ) : ?>
                <?php // breadcrumbs most be turned on in Yoast's settings ?>
                <?php yoast_breadcrumb('<p class="breadcrumbs">','</p>'); ?>
            <?php endif; ?>

        <?php else : ?>     
            <h2 class="entry-title" itemprop="name">
                <a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
        <?php endif; ?>

        <?php // display entra meta only on post & blog templates
            if ( is_singular('post') || is_home() || is_archive() ) :  ?>
            <?php get_template_part('inc/entry-meta'); ?>
        <?php endif; ?>
    </header><!-- .entry-header -->

    <section class="entry-content">
        <?php if ( is_archive() ) : // display the excerpt if it is an archive ?>

            <?php the_post_thumbnail('square'); ?>
            <p itemprop="description"><?php the_excerpt(); ?></p>

        <?php else : // not an archive? output the full content ?>

            <?php the_content(); ?>

        <?php endif; ?>

        <?php if ( is_page() ) : // include the page-links if it is a page ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'starter-theme' ) . '</span>', 'after' => '</div>' ) ); ?>
        <?php endif; ?>
    </section><!-- .entry-content -->

    <?php if ( is_singular() && !is_page() ) : ?>
        <footer class="entry-meta">
            <div class="comments-link">
                <?php comments_popup_link( 
                     __( 'Leave a comment', 'starter-theme' ), 
                     __( '1 comment', 'starter-theme' ), 
                     __( '% comments', 'starter-theme' ) ); 
                ?>
            </div>
        </footer><!-- #entry-meta -->
    <?php endif; // end footer entry-meta conditional ?>

</article><!-- #post-<?php the_ID(); ?> -->