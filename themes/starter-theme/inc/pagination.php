<?php 
/**
 * Archive pagination
 *
 * @package themeHandle
 */
?>

<?php if ( is_singular() ) : ?>

	<nav id="nav-below">
	    <div class="nav-previous"><?php previous_post_link( '%link', __( 'Previous', 'starter-theme' ) ); ?></div>
	    <div class="nav-next"><?php next_post_link( '%link', __( 'Next', 'starter-theme' ) ); ?></div>
	</nav>
	
<?php elseif (is_home() || is_archive() ) : ?>

	<nav id="nav-below">
	    <div class="nav-previous"><?php previous_posts_link( __( 'Older', 'starter-theme' ) ); ?></div>
	    <div class="nav-next"><?php next_posts_link( __( 'Newer', 'starter-theme' ) ); ?></div>
	</nav>

<?php endif; ?>