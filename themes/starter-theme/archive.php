<?php
/** 
* Archive Template File * 
* 
* This file is used to display a page when nothing more specific matches a query. (often used to display tags, categories, etc)
* Learn more: http://codex.wordpress.org/Template_Hierarchy 
* 
* @package Starter_Theme 
*/

get_header(); ?>

<div id="primary" role="main" class="container"> 
    <?php if ( have_posts() ) : // display the content _if_ there are posts ?>

        <?php  if ( is_archive() ) : // print the archive header if its an archive template?>
            <?php get_template_part( 'inc/archive-header' );  ?>
        <?php endif; ?>

        <?php while ( have_posts() ) : the_post(); // start the loop ?>
            <?php get_template_part('content'); ?>
        <?php endwhile; ?>

        <?php get_template_part('inc/pagination'); ?>

    <?php else : // display an error message if there are no posts found ?>

        <article id="post-0" class="hentry post no-results not-found">
            <header class="entry-header">
                <h1><?php _esc_html_e( "Oops!", "starter-theme" ); ?></h1>
            </header><!-- .entry-header -->

            <p><?php _esc_html_e( "We can&#039;t find content for this page!", "starter-theme" ); ?></p>
        </article><!-- #post-0 -->

    <?php endif; ?>

    <?php get_sidebar(); // #secondary div ?>
</div><!-- / .container -->   

<?php get_footer(); ?>