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
	$content_width = 1000;
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
		add_image_size(     'hero',     	1600, 600, false ); // (cropped)

		// add image sizes to back-end for client
		add_filter('image_size_names_choose', 'my_image_sizes');
		    function my_image_sizes($sizes) {
		        $addsizes = array(
		            'hero'      	=> __( 'Square - Small', 'starter-theme'),
		);
		    $newsizes = array_merge($sizes, $addsizes);
		    return $newsizes;
		} 

	}
endif; // starter_theme_setup
add_action( 'after_setup_theme', 'starter_theme_setup' );


/**
*
* Enqueue Scripts & Styles
*
**/


function starter_theme_scripts() {
    wp_register_style('starter-theme-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('starter-theme-style'); // Enqueue it!

	if ( is_singular('post') && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

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
 * Remove text colour buttons in WYSIWYG
 *
 */
function starter_theme_tinymce_buttons($buttons) {
      //Remove the text color selector
      $remove = 'forecolor';

      //Find the array key and then unset
      if ( ( $key = array_search($remove,$buttons) ) !== false )
		unset($buttons[$key]);

      return $buttons;
 }
add_filter('mce_buttons_2','starter_theme_tinymce_buttons');


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
 * Customizer
 *
 */

function starter_theme_customize_sanitize( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

get_template_part('inc/customizer/social', 'profiles');

/**
 *
 * Move Yoast SEO down - below ACF Content
 *
 */

add_filter( 'wpseo_metabox_prio', function() { return 'low';});