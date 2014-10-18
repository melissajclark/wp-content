<?php
/**
 * The blog sidebar
 *
 * @package Starter_Theme
 */

?>
<div id="secondary" class="widget-area" role="complementary">
    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
</div><!-- #secondary .widget-area -->

<!-- Make sure to use this:

	<?php get_sidebar( 'blog' ); ?>

When including the blog sidebar in a template.
-->


