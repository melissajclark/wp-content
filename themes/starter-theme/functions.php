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
		
		// Add theme support for customizable features
		// -------------------------------------------
		add_theme_support( 'automatic-feed-links' ); // Add default posts and comments RSS feed links to head.
		add_theme_support( 'post-thumbnails' ); // Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );

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
			'primary' => 	__( 'Primary Menu', 'starter-theme' ),
			'footer' => 	__( 'Footer Menu', 'starter-theme' ),
		) );

		// Add custom image sizes
		add_image_size(     'square',     	400, 400, false ); // (cropped)
		add_image_size(     'big-square', 	1000, 1000, false ); // (cropped)

		// add image sizes to back-end for client
		add_filter('image_size_names_choose', 'my_image_sizes');
		    function my_image_sizes($sizes) {
		        $addsizes = array(
		            'square'      	=> __( 'Square - Small', 'starter-theme'),
		            'big-square' 	=> __( 'Square - Large', 'starter-theme'),
		);
		    $newsizes = array_merge($sizes, $addsizes);
		    return $newsizes;
		} // end of image name function

	}
endif; // starter_theme_setup
add_action( 'after_setup_theme', 'starter_theme_setup' );


/**
*
* Enqueue Scripts & Styles
*
**/


function starter_theme_scripts() {
	
    wp_enqueue_style( 'starter-theme-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,600,400italic', false ); // theme google fonts
    wp_enqueue_style( 'starter-theme-style', get_stylesheet_uri() ); // theme style.css file

	if ( is_singular('post') && comments_open() && get_option( 'thread_comments' ) ) {
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
	    'plugins', //handle
	    get_template_directory_uri() . '/assets/js/plugins.js', //source
	    array( 'jquery' ), //dependencies
	    null, // version number
	    true //load in footer
	  );

	  wp_enqueue_script(
	    'theme', //handle
	    get_template_directory_uri() . '/assets/js/theme.js', //source
	    array( 'jquery', 'plugins' ), //dependencies
	    null, // version number
	    true //load in footer
	  );
	}
    
add_action('wp_enqueue_scripts', 'starter_theme_scripts');


/**
*
* Enable Custom Editor styles
*
**/

function starter_theme_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}
add_action( 'admin_init', 'starter_theme_add_editor_styles' );


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
}
add_action( 'widgets_init', 'starter_theme_widgets_init' );


/**
*
* Enable ACF Options Page
*
**/

if(function_exists('acf_add_options_page')) { 
	acf_add_options_page('Theme Options');
}