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


<?php get_template_part ('inc/social-media-fields') // grabs theme's social media content - [TO DO] update icon assets in final theme?>

	<div id="copyright">
		&copy; <?php echo date("Y"); ?> <?php echo bloginfo( "name" ); ?><br>
		<a href="http://melissajclark.ca" rel="nofollow">theme by Melissa</a>
	</div>

</footer><!-- #colophon -->
	
 <!--    <?php if ( is_page_template( 'page-slider.php' ) ) : ?>   
    
    <script>     
        wooSlider(); // calls slider function in theme.js for wooSlider
    </script>

    <script>     
        sliderBX(); // calls slider function in theme.js for BX Slider
    </script>

    <script>     
        glideSlider(); // calls slider function in theme.js for glide Slider
    </script>

    <?php endif; ?> -->

    

    <?php if ( is_page_template( 'page-gallery.php' ) ) : ?>   

    <script>     
        glideSlider(); // calls slider function in theme.js for glide Slider
    </script>

    <?php endif; ?>
 
<?php wp_footer(); ?> 
</body>
</html>