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
 
	acf_add_options_page('Theme Options');
}


/**
 * See article: https://tommcfarlin.com/filter-wp-title/
 * Provides a standard format for the page title depending on the view. This is
 * filtered so that plugins can provide alternative title formats.
 *
 * @param       string    $title    Default title text for current view.
 * @param       string    $sep      Optional separator.
 * @return      string              The filtered title.
 * @package     mayer
 * @subpackage  includes
 * @version     1.0.0
 * @since       1.0.0
 */
function mayer_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	} // end if

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	} // end if

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = sprintf( __( 'Page %s', 'mayer' ), max( $paged, $page ) ) . " $sep $title";
	} // end if

	return $title;

} // end mayer_wp_title
add_filter( 'wp_title', 'mayer_wp_title', 10, 2 );


/**
*
* Adds the post thumbnail to content in an RSS feed
*
**/

add_filter( 'the_content_feed', 'the_content_feed_rss' );
 
function the_content_feed_rss( $content ) {
    $featured_image = '';
    $featured_image = get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'style' => 'float:left;margin-right:.75em;' ) );
    $content = get_the_excerpt() . ' <a href="'. get_permalink() .'">' . __( 'Read More' ) . '</a>';
    if( '' != $featured_image )
        $content = '<div>' . $featured_image . $content . '<br style="clear:both;" /></div>';
    return $content;
}


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
	    'plugins', //handle
	    get_template_directory_uri() . '/assets/plugins.js', //source
	    array('juery'), // dependencies
	    null, // version number
	    true //load in footer
	  );

	  wp_enqueue_script(
	    'scripts', //handle
	    get_template_directory_uri() . '/assets/theme.js', //source
	    array( 'jquery', 'plugins' ), //dependencies
	    null, // version number
	    true //load in footer
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



/*-----  End of Custom Taxonomy: Statuses  ------*/

/**
*
* Function to display terms in a taxonomy from: http://wordpress.stackexchange.com/questions/23606/how-do-i-list-custom-taxonomy-terms-without-the-links
* REALLY USEFUL: displays all terms in the taxonomy - not post specific!
*
**/


function taxonomy_list( $taxonomy ) {
    $args = array('order'=>'ASC','hide_empty'=>false);
    $terms = get_terms( $taxonomy, $args );
    if ( $terms ) {
        printf( '', esc_attr( $taxonomy ) );
        foreach ( $terms as $term ) {
        	printf( '<option><value="%s">%s</option>', esc_html( $term->name ) );
        }
        print( '' );
    }
}

/**
*
* Useful function: Displays list of terms attached to a post.
*
**/

// $terms = get_the_terms( $post->ID, 'TAXONOMY');
                        
//if ( $terms && ! is_wp_error( $terms ) ) : 

    // $status_links = array();

   // foreach ( $terms as $term ) {
        // $status_links[] = $term->slug;
   // }
                        
    //$on_status = join(",", $status_links);
   // <?php echo $on_status;

