<?php
/**
 * Quick Featured Images
 *
 * @package   Quick_Featured_Images
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://stehle-internet.de
 * @copyright 2014 Martin Stehle
 */

 class Quick_Featured_Images_Admin {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 * @updated with every version
	 *
	 * @var     string
	 */
	protected $plugin_version = '9.1';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
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
	protected $required_user_cap = 'edit_others_posts'; // minimum required right to see this plugin in the WP backend

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
	 *
	 * @since    4.1
	 *
	 * @var      string
	 */
	protected $plugin_name = 'Quick Featured Images';

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'quick-featured-images';

	/**
	 * Unique slug for the admin page of this class
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	protected $page_slug = 'quick-featured-images-overview';

	/**
	 * Unique identifier in the WP options table
	 *
	 * @since    7.0
	 *
	 * @var      string
	 */
	private $settings_db_slug = 'quick-featured-images-settings';

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 * @updated   3.2.1: hook on displaying a message after plugin activation
	 * @updated   8.0: removed action display_menu_icon
	 */
	private function __construct() {
	
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		// Add the admin page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		
		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		#add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// style for top level menu item 
		//add_action( 'admin_head', array( $this, 'display_menu_icon' ) );

		// hook on displaying a message after plugin activation
		// if single activation via link or bulk activation
		if ( isset( $_GET[ 'activate' ] ) or isset( $_GET[ 'activate-multi' ] ) ) {
			$plugin_was_activated = get_transient( $this->plugin_slug );
			if ( false !== $plugin_was_activated ) {
				add_action( 'admin_notices', array( $this, 'display_activation_message' ) );
				delete_transient( $this->plugin_slug );
			}
		}
	}

	/**
	 *
	 * Render the header of the admin page
	 *
	 * @access   public
	 * @since    7.0
	 */
	public function main() {
		$this->display_header();
		include_once( 'views/section_overview.php' );
		$this->display_footer();
	}
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
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
	 * Return the plugin name.
	 *
	 * @since    4.1
	 *
	 * @return    Plugin name variable.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 *@return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return the page headline.
	 *
	 * @since    7.0
	 *
	 *@return    page headline variable.
	 */
	public function get_page_headline() {
		$text = 'Overview';
		return __( $text );
	}

	/**
	 * Return the page description.
	 *
	 * @since    8.0
	 *
	 *@return    page description variable.
	 */
	public function get_page_description() {
		return __( 'Your time-saving Swiss Army Knife for featured images: Set, replace and delete them in bulk, set default images, get overview lists.', $this->plugin_slug );
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
	 * Return the plugin version.
	 *
	 * @since    7.0
	 *
	 *@return    Plugin version variable.
	 */
	public function get_plugin_version() {
		return $this->plugin_version;
	}

	/**
	 * Return the options slug in the WP options table.
	 *
	 * @since    7.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_settings_db_slug() {
		return $this->settings_db_slug;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		// Lowest Wordpress version to run with this plugin
		$required_wp_version = '3.8'; /* because of dashicons, at least 3.7 because of WP_DATE_QUERY */
		$plugin_slug = 'quick-featured-images';

		// check minimum version
		if ( ! version_compare( $GLOBALS['wp_version'], $required_wp_version, '>=' ) ) {
			// deactivate plugin
			deactivate_plugins( plugin_basename( __FILE__ ), false, is_network_admin() );
			// load language file for a message in the language of the WP installation
			load_plugin_textdomain( $plugin_slug, false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
			// stop WP request and display the message with backlink. Is there a proper way than wp_die()?
			wp_die( 
				// message in browser viewport
				sprintf( 
					'<p>%s</p>', 
					sprintf( 
						__( 'The plugin requires WordPress version %s or higher. Therefore, WordPress did not activate it. If you want to use this plugin update the Wordpress files to the latest version.', $plugin_slug ), 
						$required_wp_version 
					)
				),
				// title in title tag
				'Wordpress &rsaquo; Plugin Activation Error', 
				array( 
					// HTML status code returned
					'response'  => 200, 
					// display a back link in the returned page
					'back_link' => true 
				)
			);
		}

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since    1.0.0
	 *
	 * @param    int    $blog_id    ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs WHERE archived = '0' AND spam = '0' AND deleted = '0'";
		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 * @updated   3.2.1: added setting of transient
	 */
	private static function single_activate() {
		// store the flag into the db to trigger the display of a message after activation
		set_transient( 'quick-featured-images', '1', 60 ); // plugin_slug
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		#$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		#load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );

	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_admin_styles() {
	
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		// request css only if this plugin was called
		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), $this->plugin_version );
		}
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), $this->plugin_version );
	}

	/**
	 * Returns the url to the installation folder of this plugin
	 *
	 * @since    1.0.0
	 */
	public function get_plugin_base_url () {
		return dirname( plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Returns the url of the plugin's public part
	 *
	 * @since    1.0.0
	 */
	public function get_plugin_public_url () {
		return plugin_dir_url( __FILE__ );
	}
	
	/**
	 * Print a message about the location of the plugin in the WP backend
	 * 
	 * @since    3.2.1
	 * @updated  7.0: changed url and message (page moved from media sub menu to own object menu)
	 */
	public function display_activation_message () {
		$url  = admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) );
		$text = 'Featured Images';
		$link = sprintf( '<a href="%s">%s</a>', $url, __( $text ) );
		$msg  = sprintf( __( 'Welcome to %s! You can find the plugin at %s.', $this->plugin_slug ), $this->plugin_name, $link );
		$html = sprintf( '<div class="updated"><p>%s</p></div>', $msg );
		print $html;
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 * @updated  4.1: change hard coded plugin name to variable
	 * @updated  7.0: page moved from media sub menu to own object menu
	 */
	public function add_plugin_admin_menu() {
		
		// get translated string of the menu label and page headline
		$label = $this->get_page_headline();
		
		$page_title = sprintf( '%s: %s', $this->plugin_name, $label );
		$text = 'Featured Images';
		$menu_title = __( $text );
		$function = array( $this, 'main' ); // to execute when loading this page

		/*
		 * Add the top level menu page of this plugin
		 *
		 */
		$this->plugin_screen_hook_suffix = add_menu_page(
			$page_title,
			$menu_title, // menu_title
			$this->required_user_cap, // capability to use the following function
			$this->page_slug,
			$function,
			'dashicons-images-alt2', // icon
			11 // position after menu item 'Media'
		);
		
		// Give first sub level menu link a different label than the top level menu link 
		// by calling the add_submenu_page function the first time with the parent_slug and menu_slug as same values
		add_submenu_page( 
			$this->page_slug, // parent slug
			$page_title,
			$label, // menu_title
			$this->required_user_cap, // capability to use the following function
			$this->page_slug, // menu slug
			$function
		);
		
	}
	
	/**
	 *
	 * Render the header of the admin page
	 *
	 * @access   private
	 * @since    1.0.0
	 */
	private function display_header() {
		include_once( 'views/section_header.php' );
	}
	
	/**
	 *
	 * Render the footer of the admin page
	 *
	 * @access   private
	 * @since    1.0.0
	 */
	private function display_footer() {
		include_once( 'views/section_footer.php' );
	}
	
	/**
	 * Print icon for top level menu item of this plugin
	 *
	 * @since     7.0
	 * @updated   8.0: deprecated
	 *
	 * @return    null    
	 */
	/*public function display_menu_icon(){
		print '<style type="text/css">';
		print '/* Quick Featured Images Menu Icon * /';
		print "\n";
		printf( '#toplevel_page_%s .dashicons-admin-generic:before {', $this->page_slug );
		#print ' content: "\f232";';
		#print ' content: "\f233";';
		print '}';
		print "\n";
		print '</style>';
	}*/

}

/**
 * Library class for all QFI classes with common variables and functions
 * Status: experimental, actually not in use
 *
 * @since: 8.0
 *
 */
class Quick_Featured_Images_Base {

	/**
	 * For development: Display a var_dump() of the variable within HTML 'pre' elements and die if true
	 *
	 * about the term dambedei (read: "dump and die"): If you know what it is you know my home region ;-)
	 *
	 * @since    1.0.0
	 */
	function dambedei ( $v, $die = false ) {
		print "<pre>";
		var_dump( $v );
		print "</pre>";
		if ( $die ) die();
	}
}