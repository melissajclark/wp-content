<?php
/**
 * Template Name: Page with Slider
 *
 * This is the template that displays all pages by default.
 *
 * @package Starter_Theme
 */

get_header(); ?>

<section id="primary" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header><!-- .entry-header -->

            <div class="entry-content">

            <!-- Custom Field Content for Images -->
            <?php if( have_rows( 'images' ) ): ?>

                <ul class="bxslider">

                <?php while( have_rows( 'images' ) ): the_row(); 

                    $image = get_sub_field( 'image' );
                    $link = get_sub_field( 'url' );

                    ?>

                    <li>

                        <?php if( $link ): ?>
                            <a href="<?php echo $link; ?>">
                        <?php endif; ?>

                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />

                        <?php if( $link ): ?>
                            </a>
                        <?php endif; ?>

                    </li>

                <?php endwhile; ?>

                </ul>

            <?php endif; ?>

                <?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'themeTextDomain' ) . '</span>', 'after' => '</div>' ) ); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; // end of the loop. ?>

</section><!-- #primary -->

<?php get_footer(); ?>