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
 
	acf_add_options_page();
	// acf_add_options_sub_page('Header');
	// acf_add_options_sub_page('Footer');
	acf_add_options_sub_page('Starter_Theme Options');
 
}
/*-----  End of Useful Functions to Override WP Defaults  ------*/


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
	    'filterMe', // all JS in filterMe.js
	    get_template_directory_uri() . '/assets/filterMe.js',
	    array('jquery')
	);

	wp_enqueue_script(
	    'theme', // all functions in theme.js
	    get_template_directory_uri() . '/assets/theme.js',
	    array('jquery')
	);
}    
add_action('wp_enqueue_scripts', 'starter_theme_scripts');


// adjusts for paging on Grid Archive pages

function starter_theme_custom_query( $query ) {
    if ( is_category( 'Recipes' ) && !is_admin() ) {
         $query->set( 'posts_per_page', 18 );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'starter_theme_custom_query' );


/*==================================================
=            Custom Post Type: Projects            =
==================================================*/

add_action('init', 'cptui_register_my_cpt_projects');
function cptui_register_my_cpt_projects() {
register_post_type('projects', array(
'label' => 'Projects',
'description' => '',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'projects', 'with_front' => true),
'query_var' => true,
'has_archive' => true,
'supports' => array('title','editor','excerpt','revisions','thumbnail','author'),
'labels' => array (
  'name' => 'Projects',
  'singular_name' => 'Project',
  'menu_name' => 'Projects',
  'add_new' => 'Add Project',
  'add_new_item' => 'Add New Project',
  'edit' => 'Edit',
  'edit_item' => 'Edit Project',
  'new_item' => 'New Project',
  'view' => 'View Project',
  'view_item' => 'View Project',
  'search_items' => 'Search Projects',
  'not_found' => 'No Projects Found',
  'not_found_in_trash' => 'No Projects Found in Trash',
  'parent' => 'Parent Project',
)
) ); }

/*-----  End of Custom Post Type: Projects  ------*/


/*=================================================
=            Custom Taxonomy: Statuses            =
=================================================*/

add_action('init', 'cptui_register_my_taxes_status');
function cptui_register_my_taxes_status() {
register_taxonomy( 'status',array (
  0 => 'projects',
),
array( 'hierarchical' => true,
	'label' => 'Statuses',
	'show_ui' => true,
	'query_var' => true,
	'show_admin_column' => true,
	'labels' => array (
  'search_items' => 'Status',
  'popular_items' => '',
  'all_items' => '',
  'parent_item' => '',
  'parent_item_colon' => '',
  'edit_item' => '',
  'update_item' => '',
  'add_new_item' => '',
  'new_item_name' => '',
  'separate_items_with_commas' => '',
  'add_or_remove_items' => '',
  'choose_from_most_used' => '',
)
) ); 
}
/*-----  End of Custom Taxonomy: Statuses  ------*/

/**
*
* Function to display terms in a taxonomy from: http://wordpress.stackexchange.com/questions/23606/how-do-i-list-custom-taxonomy-terms-without-the-links
*
**/


function taxonomy_list( $taxonomy ) {
    $args = array('order'=>'ASC','hide_empty'=>false);
    $terms = get_terms( $taxonomy, $args );
    if ( $terms ) {
        printf( '<ul name="%s">', esc_attr( $taxonomy ) );
        foreach ( $terms as $term ) {
            printf( '<li>%s</li>', esc_html( $term->name ) );
        }
        print( '</ul>' );
    }
}


