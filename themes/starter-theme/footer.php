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
 
<footer id="colophon" role="contentinfo" class="wrapper">

	<div class="container">
		
		<div id="copyright">
		<?php get_template_part ('inc/social-media-fields') // grabs theme's social media content - [TO DO] update icon assets in final theme?>
			&copy; <?php echo date("Y"); ?> <?php echo bloginfo( "name" ); ?>
			<a href="http://melissajclark.ca" rel="nofollow">theme by Melissa</a>
		</div> 
	</div><!-- / container -->

</footer><!-- #colophon -->


<?php if ( is_page_template( 'page-gallery.php' ) ) : ?>   

<script>     
    simpleWooSlider(); // calls slider function in theme.js for wooSlider
</script>

<?php endif; ?>

 
<?php wp_footer(); ?> 
</body>
</html>