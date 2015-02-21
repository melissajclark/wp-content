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
	 *
	 * @updated 8.3.1: sanitized recognition of key names, fixed bug on displaying undesired columns
	 * @updated 9.0: added column sort function
	 */
	private function __construct() {

		// Call variables from public plugin class.
		$plugin = Quick_Featured_Images_Admin::get_instance();
		$this->plugin_name = $plugin->get_plugin_name();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$this->plugin_version = $plugin->get_plugin_version();
		$this->settings_db_slug = $plugin->get_settings_db_slug();

		// add featured image columns if desired
		$add_column_function = array( $this, 'add_thumbnail_column' );
		$display_column_function = array( $this, 'display_thumbnail_in_column' );
		$add_sort_function = array( $this, 'add_sortable_column' );
		// get current or default settings
		$this->stored_settings = get_option( $this->settings_db_slug, array() );

		// add Featured Image column in desired posts lists
		foreach ( $this->stored_settings as $key => $value ) {
			if ( '1' == $value ) {
				if ( preg_match('/^column_thumb_([a-z0-9_\-]+)$/', $key, $matches ) ) {
					// make the following lines more readable
					$post_type = $matches[ 1 ];
					
					// get the hook name for the columns filter
					$hook = sprintf( 'manage_%s_posts_columns', $post_type );
					// add a column to list of desired post type and
					// sanitizing: check with has_filter() to prevent multiple columns in a row
					if ( ! has_filter( $hook, $add_column_function ) ) {
						add_filter( $hook, $add_column_function );
					}
					
					// get the hook name for the sortable columns filter
					$hook = sprintf( 'manage_edit-%s_sortable_columns', $post_type );
					// add the column to list of sortable columns
					// sanitizing: check with has_filter() to prevent more than 1 call
					if ( ! has_filter( $hook, $add_sort_function ) ) {
						add_filter( $hook, $add_sort_function );
					}
					
					// get the hook name for the column edit action
					$hook = sprintf( 'manage_%s_posts_custom_column', $post_type );
					// add thumbnail in column per post
					// sanitizing: check with has_filter() to prevent multiple contents in a column
					if ( ! has_action( $hook, $display_column_function ) ) {
						add_action( $hook, $display_column_function, 10, 2 );
					}
					
				} // if ( preg_match() )
			} // if ( value == 1 )
		} // foreach( stored_settings )

		// load admin style sheet
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		// print style for thumbnail column
		add_action( 'admin_head', array( $this, 'display_thumbnail_column_style' ) );
		// define image column sort order
		add_filter( 'pre_get_posts', array( $this, 'sort_column_by_image_id' ) );
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
	 * @return    array	list of columns    
	 */
    public function add_thumbnail_column( $cols ) {
		$text = 'Featured Image';
		$cols[ $this->column_name ] = __( $text );
        return $cols;
    }
	
    /**
     * Add the Featured Image column to sortable columns
     *
	 * @since     9.0
	 *
	 * @return    array	extended list of sortable columns    
     */
    public function add_sortable_column( $cols ) {
        $cols[ $this->column_name ] = $this->column_name;

        return $cols;
    }

	/**
	 * Print the featured image in the column
	 *
	 * @since     7.0
	 * @updated 9.1: revised label text for WP 4.1
	 *
	 * @return    array	extended list of columns    
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
				$text = 'No image set';
				echo __( $text );
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

    /**
     * Define sort order: order posts by featured image id
     *
	 * @since     9.0
	 *
     * @param $query
     */
    public function sort_column_by_image_id( $query ) {
	
		// if user wants to get rows sorted by featured image
        if ( $query->get( 'orderby' ) === $this->column_name ) {
			// set thumbnail id as sort value
            $query->set( 'meta_key', '_thumbnail_id' );
			// change sorting from alphabetical to numeric
            $query->set( 'orderby', 'meta_value_num' );
        }
    }

}
