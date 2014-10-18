<?php
/**
 * Quick Featured Images
 *
 * @package   Quick_Featured_Images_Columns
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins/quick-featured-images/
 * @copyright 2014 
 */

/**
 * @package Quick_Featured_Images_Columns
 * @author    Martin Stehle <m.stehle@gmx.de>
 */
class Quick_Featured_Images_Columns {

	/**
	 * Instance of this class.
	 *
	 * @since    7.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Name of this plugin.
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $plugin_name = null;

	/**
	 * Unique identifier for this plugin.
	 *
	 * It is the same as in class Quick_Featured_Images_Admin
	 * Has to be set here to be used in non-object context, e.g. callback functions
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = null;

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since    7.0
	 *
	 * @var     string
	 */
	protected $plugin_version = null;

	/**
	 * Unique identifier in the WP options table
	 *
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $settings_db_slug = null;

	/**
	 * Stored settings in an array
	 *
	 *
	 * @since    7.0
	 *
	 * @var      array
	 */
	protected $stored_settings = array();

	/**
	 * Name of the additional column.
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $column_name = 'qfi-thumbnail';

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     7.0
	 */
	private function __construct() {

		// Call variables from public plugin class.
		$plugin = Quick_Featured_Images_Admin::get_instance();
		$this->plugin_name = $plugin->get_plugin_name();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$this->plugin_version = $plugin->get_plugin_version();
		$this->settings_db_slug = $plugin->get_settings_db_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		#add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// add featured image columns if desired
		$filter_function = array( $this, 'add_thumbnail_column' );
		$action_function = array( $this, 'display_thumbnail_in_column' );
		// get current or default settings
		$this->stored_settings = get_option( $this->settings_db_slug, array() );

		foreach ( $this->stored_settings as $key => $value ) {
			if ( preg_match('/^show_(.+)_images$/', $key, $matches ) ) {
				if ( '1' == $value ) {
					// make the following lines more readable
					$post_type = $matches[ 1 ];
					// add filter and action functions to show the additional column with images
					// check with has_filter() to prevent multiple images in a column row
					if ( 'posts' == $post_type or 'pages' == $post_type ) {
						// use hooks for WP standard post types
						$hook = sprintf( 'manage_%s_columns', $post_type );
						if ( ! has_filter( $hook, $filter_function ) ) {
							add_filter( $hook, $filter_function );
						}
						$hook = sprintf( 'manage_%s_custom_column', $post_type );
						if ( ! has_action( $hook, $action_function ) ) {
							add_action( $hook, $action_function, 10, 2 );
						}
					} else {
						// use hooks for custom post types
						$hook = sprintf( 'manage_%s_posts_columns', $post_type );
						if ( ! has_filter( $hook, $filter_function ) ) {
							add_filter( $hook, $filter_function );
						}
						if ( is_post_type_hierarchical( $post_type ) ) {
							$hook = 'manage_pages_custom_column';
							if ( ! has_action( $hook, $action_function ) ) {
								add_action( $hook, $action_function, 10, 2 );
							}
						} else {
							$hook = sprintf( 'manage_%s_posts_custom_column', $post_type );
							if ( ! ( has_action( 'manage_posts_custom_column', $action_function ) or has_action( $hook, $action_function ) ) ) {
								add_action( $hook, $action_function, 10, 2 );
							}
						} // if ( is_post_type_hierarchical )
					} // if ( post type )
				} // if ( value == 1 )
			} // if ( preg_match() )
		} // foreach( stored_settings )

		// style for thumbnail column
		add_action( 'admin_head', array( $this, 'display_thumbnail_column_style' ) );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     7.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     7.0
	 *
	 * @return    null
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		// request css only if this plugin was called
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array( ), $this->plugin_version );
		}

 	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     7.0
	 *
	 * @return    null
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		/* collect js for the color picker */
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), $this->plugin_version );
		}
	}

	/**
	 * Add a column with the title 'Featured Image' in the post lists
	 *
	 * @since     7.0
	 *
	 * @return    null    
	 */
    public function add_thumbnail_column( $cols ) {
		$text = 'Featured Image';
        $cols[ $this->column_name ] = __( $text );
        return $cols;
    }
	
	/**
	 * Print the featured image in the column
	 *
	 * @since     7.0
	 *
	 * @return    null    
	 */
    public function display_thumbnail_in_column( $column_name, $post_id ) {
		/*
		// export to class wide vars to call it only once
		$max_dimension = 110; // width of thumbnail column in px at 1024 px window width
		$default_value = $max_dimension * 2;
		// set dimensions with values in Settings => Media => Thumbnail Size
		$width  = absint( get_option( 'thumbnail_size_w', $default_value ) / 2 );
		$height = absint( get_option( 'thumbnail_size_h', $default_value ) / 2 );
		// set maximum value if necessary
		$width = $width > $max_dimension ? $max_dimension : $width;
		$height = $height > $max_dimension ? $max_dimension : $height;
		*/
		$width = $height = 80;
		if ( $this->column_name == $column_name ) {
			$thumbnail_id = get_post_thumbnail_id( $post_id );
			// image from gallery
			if ( $thumbnail_id ) {
				echo wp_get_attachment_image( $thumbnail_id, array( $width, $height ) );
			} else {
				echo __( 'No Image' );
			}
		}
    }
	
	/**
	 * Print CSS for image column
	 *
	 * @since     7.0
	 *
	 * @return    null    
	 */
	public function display_thumbnail_column_style(){
		print '<style type="text/css">';
		print '/* Quick Featured Images plugin styles */';
		print "\n";
		print '/* Fit thumbnails in posts list column */';
		printf( '.column-%s img {', $this->column_name );
		print '	width: 100%;';
		print '	height: 100%;';
		printf( '	max-width: %dpx;', 80 );
		printf( '	max-height: %dpx;', 80 );
		print '}';
		print "\n";
		print '/* Auto-hiding of the thumbnail column in posts lists */';
		print '@media screen and ( max-width: 782px ) {';
		printf( '	.column-%s {', $this->column_name );
		print '		display: none;';
		print '	}';
		print '}';
		print "\n";
		print '</style>';
	}

}
