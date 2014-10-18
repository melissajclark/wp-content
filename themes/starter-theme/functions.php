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
	}
endif; // starter_theme_setup
add_action( 'after_setup_theme', 'starter_theme_setup' );

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

/**
 * Enqueue javascript files as needed
 */
function starter_theme_scripts_method() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// wp_enqueue_script(
	//	'theme',
	//	get_template_directory_uri() . '/assets/theme.js',
	//	array('jquery')
	// );
}    
add_action('wp_enqueue_scripts', 'starter_theme_scripts_method');

/**
 * Remove the front-end admin bar for everybody, always
 */
// show_admin_bar( false );

/**
 * Add TinyMCE buttons that are disabled by default to 2nd row
 */
//function starter_theme_mce_buttons($buttons) {	
//	$buttons[] = 'justify'; // fully justify text
//	$buttons[] = 'hr'; // insert HR
//
//	return $buttons;
//}
//add_filter('mce_buttons_2', 'starter_theme_mce_buttons');

/**
 * Remove from TinyMCE all colors except those specified
 */
//function starter_theme_change_mce_colors( $init ) {
//	$init['theme_advanced_text_colors'] = '8dc63f';
//	$init['theme_advanced_more_colors'] = false;
//return $init;
//}
//add_filter('tiny_mce_before_init', 'starter_theme_change_mce_colors');

// enables ACF Options Page

if(function_exists('acf_add_options_page')) { 
 
	acf_add_options_page();
	acf_add_options_sub_page('Header');
	acf_add_options_sub_page('Footer');
 
}

// Comments & pingbacks display template
include('inc/functions/comments.php');


// adjusts for paging on Grid Archive pages

function starter_theme_custom_query( $query ) {
    if ( is_category( 'Recipes' ) && !is_admin() ) {
         $query->set( 'posts_per_page', 18 );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'starter_theme_custom_query' );


/**
* Snippet below allows for changing post order by category
*
*/

// function starter_theme_custom_query( $query ) {
//     if ( is_category( 'Locations' ) && !is_admin() ) {
//          $query->set( 'orderby', 'title' );
//          $query->set( 'order', 'ASC' );
//     }
//     return $query;
// }
// add_filter( 'pre_get_posts', 'starter_theme_custom_query' );


/**
* Snippet below changes multiple queries in one function
*/

// function starter_theme_custom_query( $query ) {
//     if ( is_category( 'Recipes' ) && !is_admin() ) {
//          $query->set( 'nopaging', true );
//          $query->set( 'orderby', 'menu_order' );
//          $query->set( 'order', 'ASC' );
//     }
//     return $query;
// }
// add_filter( 'pre_get_posts', 'starter_theme_custom_query' );
