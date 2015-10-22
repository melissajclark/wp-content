<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Starter_Theme
 */

get_header(); ?>

<div id="primary" role="main" class="container"> 
    <article id="post-0" class="post error404 not-found">
    	<?php get_template_part('inc/archive-header'); ?>

	    <section class="entry-content">
	        <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps a search would help?', 'starter-theme' ); ?></p>
	        <?php get_search_form(); ?>
	    </section><!-- .entry-content -->
	</article><!-- #post-0 -->
</div><!-- / #primary -->

<?php get_sidebar(); ?>
   
<?php get_footer(); ?>