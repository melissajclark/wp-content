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
	$content_width = 800;
endif;


/**
*
* Includes content from functions in inc/ directory
*
**/

// Comments & pingbacks display template
include('inc/functions/comments.php');

// include custom widget file
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
			'footer' => __( 'Footer Menu', 'starter-theme' ),
			'sidebar-links' => __( 'Sidebar Links', 'starter-theme' ),
		) );
		
		// Add custom image sizes
        	// add_image_size( &#039;name&#039;, 500, 300, true );
		// custom image size for slider
		// add_image_size( 'slider', 550, 550 ); // 550 pixels wide by 550 pixels tall, soft proportional crop mode
	}
endif; // starter_theme_setup
add_action( 'after_setup_theme', 'starter_theme_setup' );


add_filter( 'image_size_names_choose', 'my_custom_sizes' );

function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'slider' => __( 'Slider' ),
    ) );
}

/**
 * Register sidebars and widgetized areas
 */
function starter_theme_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Sidebar', 'starter-theme' ),
        'id' => 'sidebar-1', // ID to use when including sidebar in other templates
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Widget Area', 'starter-theme' ),
        'id' => 'footer-area', 
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<span style="display:none;">',
        'after_title' => '</span>',
    ) );

    register_sidebar( array(
        'name' => __( 'Blog Page Sidebar', 'starter-theme' ),
        'id' => 'sidebar-blog', 
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<span style="display:none;">',
        'after_title' => '</span>',
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

	// below block of code - used for every JS / JQ file included, put all inside this function

	// Optional: include conditional at beginning of function if script is only needed on a certain page:

	// if ( is_front_page() ) : --> only include line if it is conditional

	// wp_enqueue_script(
	//	'theme',
	//	get_template_directory_uri() . '/assets/theme.js',
	//	array('jquery')
	// );

	// endif; --> only include line if it is conditional

	wp_enqueue_script(
		'flexslider', // woo flexslider
		get_template_directory_uri() . '/assets/vendor/jquery.flexslider-min.js',
		array('jquery')
	);

	wp_enqueue_script(
		'bxslider', // bxSlider
		get_template_directory_uri() . '/assets/vendor/jquery.bxslider.js',
		array('jquery')
	);


	wp_enqueue_script(
		'WallopSlider', // wallop slider
		get_template_directory_uri() . '/assets/vendor/WallopSlider.js',
		array('jquery')
	);


	wp_enqueue_script(
		'glideSlider', // glide slider
		get_template_directory_uri() . '/assets/vendor/jquery.glide.js',
		array('jquery')
	);

	wp_enqueue_script(
	    'theme', // all functions in theme.js
	    get_template_directory_uri() . '/assets/theme.js',
	    array('jquery')
	);
}    
add_action('wp_enqueue_scripts', 'starter_theme_scripts');

// enables ACF Options Page

if(function_exists('acf_add_options_page')) { 
 
	acf_add_options_page();
	// acf_add_options_sub_page('Header');
	// acf_add_options_sub_page('Footer');
	acf_add_options_sub_page('Starter_Theme Options');
 
}


// adjusts for paging on Grid Archive pages

function starter_theme_custom_query( $query ) {
    if ( is_category( 'Recipes' ) && !is_admin() ) {
         $query->set( 'posts_per_page', 18 );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'starter_theme_custom_query' );





