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
	
<?php else : ?>

	<nav id="nav-below">
		<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'themeTextDomain' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'themeTextDomain' ) ); ?></div>
	</nav><!-- #nav-above -->

<?php endif; ?>