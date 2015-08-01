<?php
/**
 * The footer template
 *
 * Contains the closing of <div id="main"> and all content after.
 *
 * @package Starter_Theme
 */
?>

<?php // close divs opened in header (#main + #page) ?>

	</div><!-- #main -->
</div><!-- #page -->
 
<footer id="colophon" role="contentinfo" class="contentWrapper">	
	<div id="copyright" class="contentContainer">
		<?php get_template_part ('inc/social-media-fields') // grabs theme's social media content - [TO DO] update icon assets in final theme?>
			&copy; <?php echo date("Y"); ?> <?php echo bloginfo( "name" ); ?>

		<a href="http://melissajclark.ca" rel="bookmark">theme by Melissa</a>
	</div><!-- / #copyright .contentContainer -->
</footer><!-- #colophon -->

<?php // Load external scripts in the footer ?>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600italic,600,300,300italic|Lato:400,400italic,300italic,300,700,700italic' rel='stylesheet' type='text/css'>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<?php wp_footer(); ?> 
</body>
</html>