<?php 
/**
 * Archive pagination
 *
 * @package Starter_Theme
 */
?>

<?php if ( is_singular() ) : ?>

	<nav class="pagination">
	    <div class="paginationItem paginationItem--previous"><?php previous_post_link('&laquo; %link'); ?></div>
	    <div class="paginationItem paginationItem--next"><?php next_post_link('%link &raquo;'); ?></div>
	</nav><!-- .pagination -->

<?php elseif ( is_home() || is_archive() ) : ?>

	<nav class="pagination">
	    <div class="paginationItem paginationItem--previous"><?php previous_posts_link( '&laquo; Newer Posts ' ); ?></div>
		<div class="paginationItem paginationItem--next"><?php next_posts_link( 'Older Posts &raquo; ' ); ?></div>
	</nav><!-- .pagination -->

<?php elseif ( is_search() ) : ?>

	<nav class="pagination">
	    <div class="paginationItem paginationItem--previous"><?php previous_posts_link( 'Newer Search Results' ); ?></div>
		<div class="paginationItem paginationItem--next"><?php next_posts_link( 'Older Search Results', '' ); ?></div>
	</nav><!-- .pagination -->

<?php endif; ?>
