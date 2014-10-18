<?php
/**
 * Quick Featured Images
 *
 * @package   Quick_Featured_Images_Settings
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins/quick-featured-images/
 * @copyright 2014 
 */

/**
 * @package Quick_Featured_Images_Settings
 * @author    Martin Stehle <m.stehle@gmx.de>
 */
class Quick_Featured_Images_Settings {

	/**
	 * Instance of this class.
	 *
	 * @since    7.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Required user capability to use this plugin
	 *
	 * @since   7.0
	 *
	 * @var     string
	 */
	protected $required_user_cap = 'edit_others_posts';

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
	 * Unique identifier for the admin page of this class.
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $page_slug = null;

	/**
	 * Unique identifier for the admin parent page of this class.
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $parent_page_slug = null;

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
	 * Slug of the menu page on which to display the form sections
	 *
	 *
	 * @since    7.0
	 *
	 * @var      array
	 */
	protected $main_options_page_slug = 'quick-featured-images-optionspage';

	/**
	 * Group name of options
	 *
	 *
	 * @since    7.0
	 *
	 * @var      array
	 */
	protected $settings_fields_slug = 'quick-featured-images-options';
	
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
		$this->page_slug = $this->plugin_slug . '-settings';
		$this->parent_page_slug = $plugin->get_page_slug();
		$this->plugin_version = $plugin->get_plugin_version();
		$this->settings_db_slug = $plugin->get_settings_db_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		#add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Add registering options
		 *
		 */
		add_action( 'admin_init', array( $this, 'register_options' ) );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    7.0
	 */
	public function main() {
		$this->display_header();
		include_once( 'views/section_settings.php' );
		$this->display_footer();
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
	 * Return the page headline.
	 *
	 * @since    7.0
	 *
	 *@return    page headline variable.
	 */
	public function get_page_headline() {
		return __( 'Image Columns', $this->plugin_slug );
	}

	/**
	 * Return the page description.
	 *
	 * @since    8.0
	 *
	 *@return    page description variable.
	 */
	public function get_page_description() {
		return __( 'Helpful options for managing featured images', $this->plugin_slug );
	}

	/**
	 * Return the page slug.
	 *
	 * @since    7.0
	 *
	 *@return    page slug variable.
	 */
	public function get_page_slug() {
		return $this->page_slug;
	}

	/**
	 * Return the required user capability.
	 *
	 * @since    7.0
	 *
	 *@return    required user capability variable.
	 */
	public function get_required_user_cap() {
		return $this->required_user_cap;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     7.0
	 *
	 * @return    null    Return early if no settings page is registered.
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
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		/* collect js for the color picker */
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin-settings.js', __FILE__ ), array( 'jquery' ), $this->plugin_version );
		}
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    7.0
	 */
	public function add_plugin_admin_menu() {

		// get translated string of the menu label and page headline
		$label = $this->get_page_headline();
		
		// Add a settings page for this plugin to the Settings menu.
		$this->plugin_screen_hook_suffix = add_submenu_page( 
			$this->parent_page_slug, // parent_slug
			sprintf( '%s: %s', $this->plugin_name, $label ), // page_title
			$label, // menu_title
			$this->required_user_cap, // capability to use the following function
			$this->page_slug, // menu_slug
			array( $this, 'main' ) // function to execute when loading this page
		);

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    7.0
	 */
	public function add_action_links( $links ) {
		$url = sprintf( 'admin.php?page=%s-settings', $this->plugin_slug );
		return array_merge(
			$links,
			array(
				'settings' => sprintf( '<a href="%s">%s</a>', admin_url( $url ), $this->get_page_headline() )
			)
		);

	}

	/**
	 * Set default settings
	 *
	 * @since    7.0
	 */
	private static function set_default_settings() {

		$db_slug = 'quick-featured-images-settings'; // todo: get the value from $settings_db_slug both in object and non-object context
		// check if there are already stored settings under the option's database slug
		if ( false === get_option( $db_slug, false ) ) {
			// store default values in the db as a single and serialized entry
			add_option( 
				$db_slug, 
				array(
					'show_posts_images' => '1',
					'show_pages_images' => '1',
				)
			);
		} // if ( false )
		
	}

	/**
	 * Get current or default settings
	 *
	 * @since    7.0
	 */
	public function get_stored_settings() {
		// try to load current settings. If they are not in the DB return set default settings
		$stored_settings = get_option( $this->settings_db_slug, false );
		// if empty array set and store default values
		if ( false === $stored_settings ) {
			$this->set_default_settings();
		}
		// try to load current settings again. Now there should be the data
		$stored_settings = get_option( $this->settings_db_slug, false );
		
		return $stored_settings; # todo: return $this->sanitize_stored_settings( $stored_settings );
	}
	
	/**
	* Define and register the options
	* Run on admin_init()
	*
	* @since   7.0
	*/
	public function register_options () {

		$title = null;
		$html = null;
		
		// get current or default settings
		$this->stored_settings = $this->get_stored_settings();

		/*
		 * 1st section
		 */
		 
		// build the form section for column toggles
		$section_key = '1st_section';
		// register the section
		add_settings_section(
			// 'id' attribute of tags
			$section_key, 
			// title of the section.
			__( 'Columns for featured images in posts lists', $this->plugin_slug ),
			// callback function that fills the section with the desired content
			array( $this, 'print_section_' . $section_key ),
			// menu page on which to display this section
			$this->main_options_page_slug
		); // end add_settings_section()

		// register the options for the section
		$title = __( 'Show additional column for featured images in lists of', $this->plugin_slug );
		add_settings_field(
			// form field name for use in the 'id' attribute of tags
			'column_toggles',
			// title of the form field
			$title . sprintf( '<br />&nbsp;<br /><img src="%s" alt="%s" width="200" height="104" />', plugins_url( 'assets/images/posts_list_w_image_column.gif' , __FILE__ ), __( 'Posts list with image column', $this->plugin_slug ) ),
			// callback function to print the form field
			array( $this, 'print_columns_options' ),
			// menu page on which to display this field for do_settings_section()
			$this->main_options_page_slug,
			// section where the form field appears
			$section_key,
			// arguments passed to the callback function 
			array( $title )
		); // end add_settings_field()

		/*
		 * Finally register all options. They will be stored in the database 
		 * in the wp_options table under the options name $this->settings_db_slug.
		 */
		register_setting( 
			// group name in settings_fields()
			$this->settings_fields_slug,
			// name of the option to sanitize and save in the db
			$this->settings_db_slug,
			// callback function that sanitizes the option's values.
			array( $this, 'sanitize_options' )
		); // end register_setting()
		
	} // end register_options()

	/**
	* Check and return correct values for the settings
	*
	* @since   7.0
	*
	* @param   array    $input    Options and their values after submitting the form
	* 
	* @return  array              Options and their sanatized values
	*/
	public function sanitize_options ( $input ) {
		$sanitized_input = array();
		foreach ( $input as $key => $value ) {
			// checkboxes
			if ( preg_match( '/^show_.+_images$/', $key ) ) {
				$sanitized_input[ $key ] = isset( $input[ $key ] ) ? '1' : '0' ;
				continue;
			}
		} // foreach()
		return $sanitized_input;
	} // end sanitize_options()

	/**
	 *
	 * Render the header of the admin page
	 *
	 * @access   private
	 * @since    7.0
	 */
	private function display_header() {
		include_once( 'views/section_header.php' );
	}
	
	/**
	 *
	 * Render the footer of the admin page
	 *
	 * @access   private
	 * @since    7.0
	 */
	private function display_footer() {
		include_once( 'views/section_footer.php' );
	}
	
	/**
	* Print the option
	*
	* @since   7.0
	*
	*/
	public function print_columns_options ( $args ) {
		// define the form sections, order by appereance, with headlines, and options
		$label_posts = 'Posts';
		$label_pages = 'Pages';
		$post_types = array(
			'show_posts_images' => _x( $label_posts, 'post type general name' ),
			'show_pages_images' => _x( $label_pages, 'post type general name' ),
		);
		// get the registered custom post types as objects
        $custom_post_types = get_post_types( array( '_builtin' => false ), 'objects' );
		// add their names and labels to the standard WP post types
        foreach ( $custom_post_types as $name => $object ) {
            if ( post_type_supports( $name, 'thumbnail' ) ) {
				$key = sprintf( 'show_%s_images', $name );
				$post_types[ $key ] = $object->label; 
            }
		}
		$html = sprintf( '<fieldset><legend class="screen-reader-text"><span>%s</span></legend>', $args[ 0 ] );
		foreach ( $post_types as $value => $label ) {
			$stored_value = isset( $this->stored_settings[ $value ] ) ? esc_attr( $this->stored_settings[ $value ] ) : '0';
			$checked = $stored_value ? checked( '1', $stored_value, false ) : '0';
			$html .= sprintf( 
				'<label for="%s"><input name="%s[%s]" type="checkbox" id="%s" value="1"%s /> %s</label><br />',
				$value,
				$this->settings_db_slug,
				$value,
				$value,
				$checked,
				$label 
			);
		} // foreach()
		$html .= '</fieldset>';
		$html .= sprintf( '<p class="description">%s</p>', __( 'Activate the checkboxes at each post type to show the extra columns in the post lists.', $this->plugin_slug ) );
		print $html;
	}

	/**
	* Print the explanation for section 1
	*
	* @since   7.0
	*/
	public function print_section_1st_section () {
		printf( "<p>%s</p>\n", __( 'The additional columns give you a quick overview about all used featured images for every post.', $this->plugin_slug ) );
	}

}
