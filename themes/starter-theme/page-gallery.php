<?php
/**
 * Template Name: Gallery Template
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

             <h3>Glide Slider</h3>

            <?php        // Custom Field Content for Images

            $images = get_field('gallery');

            if( $images ): ?>
                <div class="slider">
                    <ul class="slider__wrapper">
                        <?php foreach( $images as $image ): ?>
                            <li class="slider__item"><img class="glideSlideImage" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/>
                             <!--    <p><?php echo $image['caption']; ?></p> -->
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>


                <?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'themeTextDomain' ) . '</span>', 'after' => '</div>' ) ); ?>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->

    <?php endwhile; // end of the loop. ?>

</section><!-- #primary -->

<?php get_footer(); ?>