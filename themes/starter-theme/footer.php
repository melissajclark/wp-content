<?php
/**
 * The footer template
 *
 * Contains the closing of <div id="main"> and all content after.
 *
 * @package Starter_Theme
 */
?>
 
	</div><!-- #main -->
 
</div><!-- #page -->
 
<footer id="colophon" role="contentinfo">
	<div id="copyright">
		&copy; <?php echo date("Y"); ?> <?php echo bloginfo( "name" ); ?><br>
		<a href="http://melissajclark.ca" rel="nofollow">theme by Melissa</a>
	</div>
</footer><!-- #colophon -->
 
<?php wp_footer(); ?> 
</body>
</html>