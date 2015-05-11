<?php
/**
 * Plugin Name:       Starter_Theme Functionality Plugin
 * Description:       This plugin stores all custom functionality for the Starter_Theme website.
 * Version:           1.0.0
 * Author:            Melissa Jean Clark
 * Author URI:        http://melissajclark.ca
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       starter-theme-functionality
 * Domain Path:       /languages
 */

/**
*
* Useful Function to override WordPress defaults
*
**/

	// function to remove <p> tags on images
	function filter_ptags_on_images($content){
	    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
	}
	add_filter('the_content', 'filter_ptags_on_images');

	// function to set default image link to none
	update_option('image_default_link_type','none');

	/**
	*
	* Enable Custom Editor styles
	*
	**/
	
	// adds CSS
	function starter_theme_add_editor_styles() {
		add_editor_style( 'editor-style.css' );
	}
	add_action( 'admin_init', 'starter_theme_add_editor_styles' );

	// adds custom fonts
	// [TO DO] - update with correct typography for new projects

	function starter_theme_add_editor_fonts(){
		$font_url = str_replace(',', '%2C', 'fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600italic,600,300,300italic|Lato:400,400italic,300italic,300,700,700italic');
		add_editor_style($font_url);
	}
	add_action('after_theme_setup', 'starter_theme_add_editor_fonts');

	/**
	*
	* Customize the Excerpt
	*
	**/

	function custom_excerpt_length($length) {
		return 75;
	}
	add_filter('excerpt_length', 'custom_excerpt_length', 999);

	function new_excerpt_more($more){
		return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) .'">' . __('Read More', 'starter-theme') . '</a>';
	}
	add_filter('excerpt_more', 'new_excerpt_more');


/*-----  End of Useful Functions to Override WP Defaults  ------*/


/**
 *
 * Register sidebars and widgetized areas
 *
 */
function starter_theme_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Blog Sidebar', 'starter-theme' ),
        'id' => 'sidebar-1', // ID to use when including sidebar in other templates
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );    

    register_sidebar( array(
        'name' => __( 'Page Sidebar', 'starter-theme' ),
        'id' => 'sidebar-2', // ID to use when including sidebar in other templates
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'starter_theme_widgets_init' );