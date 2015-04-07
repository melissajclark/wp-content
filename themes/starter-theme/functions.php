<?php
/**
 * Theme functions and definitions
 *
 * Sets up the theme and provides some helper functions including 
 * custom template tags, actions and filter hooks to change core functionality.
 *
 *
 * @package Starter_Theme
 */

/**
 * Set the content width
 */
if ( ! isset( $content_width ) ) :
	$content_width = 600;
endif;


/**
*
* Includes content from functions in inc/ directory
*
**/

// Comments & pingbacks display template
include('inc/functions/comments.php');

// include custom widget file: [TO DO]: customize or remove for new projects
include_once( 'inc/widget.php' );


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * To override starter_theme_setup() in a child theme, 
 * add your own starter_theme_setup to your child theme's functions.php file.
 */
if ( ! function_exists( 'starter_theme_setup' ) ):
	function starter_theme_setup() {

		// Make theme available for translation.
		// Translations can be filed in the /languages/ directory.
		load_theme_textdomain( 'starter-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 
			'aside', 
			'image', 
			'video', 
			'quote', 
			'link' 
		) );

		// Enable support for HTML5 markup.
		add_theme_support( 'html5', array(
			'comment-list',
			'search-form',
			'comment-form',
			'gallery',
		) );

		// Enable support for editable menus via Appearance > Menus
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'starter-theme' ),
		) );
		
		// Add custom image sizes
        	// add_image_size( &#039;name&#039;, 500, 300, true );
		// custom image size for slider
	}
endif; // starter_theme_setup
add_action( 'after_setup_theme', 'starter_theme_setup' );


// add_filter( 'image_size_names_choose', 'my_custom_sizes' );

// function my_custom_sizes( $sizes ) {
//     return array_merge( $sizes, array(
//         'name' => __( 'Name' ),
//     ) );
// }

/*================================================================
=            Useful Functions to Override WP Defaults            =
================================================================*/

// function to remove <p> tags on images
function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// function to set default image link to none
update_option('image_default_link_type','none');

// enables ACF Options Page
if(function_exists('acf_add_options_page')) { 
 
	acf_add_options_page('Theme Options');
}


/**
*
* Enable Custom Editor Styles
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
 * Register sidebars and widgetized areas
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


/* ENQUEUE SCRIPTS & STYLES
 ========================== */

function starter_theme_scripts() {

	// theme style.css file
    wp_enqueue_style( 'starter-theme-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

		//Don't use WordPress' local copy of jquery, load our own version from a CDN instead
		wp_deregister_script('jquery');
	  wp_enqueue_script(
	  	'jquery',
	  	"http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js",
	  	false, //dependencies
	  	null, //version number
	  	true //load in footer
	  );

	  wp_enqueue_script(
	    'scripts', //handle
	    get_template_directory_uri() . '/assets/js/scripts.min.js', //source
	    array( 'jquery' ), //dependencies
	    null, // version number
	    true //load in footer
	  );
	}
    
add_action('wp_enqueue_scripts', 'starter_theme_scripts');