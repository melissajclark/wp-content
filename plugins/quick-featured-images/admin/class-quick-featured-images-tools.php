<?php
/**
 * @package   Quick_Featured_Images_Tools
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://stehle-internet.de
 * @copyright 2014 Martin Stehle
 */

class Quick_Featured_Images_Tools {

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
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $required_user_cap = 'edit_others_posts'; // - user role must be edit_post and edit_others_posts

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
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
	 * Valid progress steps
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $valid_steps = null;

	/**
	 * User selected progress step
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $selected_step = null;

	/**
	 * Whether an image id is required or not (dependets on the selected action)
	 *
	 * @since    2.0
	 *
	 * @var      bool
	 */
	protected $is_image_required = null;

	/**
	 * User selected ID of the new featured image
	 *
	 * @since    1.0.0
	 *
	 * @var      integer
	 */
	protected $selected_image_id = null;

	/**
	 * User selected IDs of the new featured images
	 *
	 * @since    6.0
	 *
	 * @var      array
	 */
	protected $selected_multiple_image_ids = null;

	/**
	 * User selected ID of the featured image to replace
	 *
	 * @since    1.0.0
	 *
	 * @var      integer
	 */
	protected $selected_old_image_ids = null;

	/**
	 * Whether the id of a to be replaced image is set or not
	 *
	 * @since    2.0
	 *
	 * @var      bool
	 */
	protected $is_error_no_old_image = null;

	/**
	 * Whether the user jumps from 'select' directly to 'confirm' omitting 'refine'
	 *
	 * @since    5.1
	 *
	 * @var      bool
	 */
	protected $is_skip_refine = null;

	/**
	 * Width of thumbnail images in the current WordPress settings
	 *
	 * @since    2.0
	 *
	 * @var      integer
	 */
	protected $used_thumbnail_width = null;
	
	/**
	 * Height of thumbnail images in the current WordPress settings
	 *
	 * @since    2.0
	 *
	 * @var      integer
	 */
	protected $used_thumbnail_height = null;
	
	/**
	 * Minimum length of image dimensions to search for
	 *
	 * @since    2.0
	 *
	 * @var      integer
	 */
	protected $min_image_length = null;
	
	/**
	 * Maximum length of image dimensions to search for
	 *
	 * @since    2.0
	 *
	 * @var      integer
	 */
	protected $max_image_length = null;
	
	/**
	 * User selected action the plugin should perform
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $selected_action = null;

	/**
	 * Valid names and descriptions of the actions
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $valid_actions = null;

	/**
	 * Valid names and descriptions of the actions without a user selected image
	 *
	 * @since    5.0
	 *
	 * @var      array
	 */
	protected $valid_actions_without_image = null;

	/**
	 * Valid names and descriptions of the actions with multiple user selected images
	 *
	 * @since    6.0
	 *
	 * @var      array
	 */
	protected $valid_actions_multiple_images = null;

	/**
	 * User selected filters the plugin should perform
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $selected_filters = null;

	/**
	 * Valid names and descriptions of the filters
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $valid_filters = null;

	/**
	 * User selected options the plugin should consider
	 *
	 * @since    5.1
	 *
	 * @var      array
	 */
	protected $selected_options = null;

	/**
	 * Valid names and descriptions of the options
	 *
	 * @since    5.1
	 *
	 * @var      array
	 */
	protected $valid_options = null;

	/**
	 * User selected statuses the plugin should perform
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $selected_statuses = null;

	/**
	 * Valid names and descriptions of the post statuses
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $valid_statuses = null;
	
	/**
	 * User selected search term
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $selected_search_term = null;
	
	/**
	 * User selected category
	 *
	 * @since    1.0.0
	 *
	 * @var      integer
	 */
	protected $selected_category_id = null;

	/**
	 * User selected parent page
	 *
	 * @since    1.0.0
	 *
	 * @var      integer
	 */
	protected $selected_parent_page_id = null;
	
	/**
	 * User selected author
	 *
	 * @since    1.0.0
	 *
	 * @var      integer
	 */
	protected $selected_author_id = null;
	
	/**
	 * User selected tag
	 *
	 * @since    1.0.0
	 *
	 * @var      integer
	 */
	protected $selected_tag_id = null;
	
	/**
	 * User selected names and descriptions of post types
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $selected_post_types = null;
	
	/**
	 * Valid names and descriptions of the post types
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $valid_post_types = null;
	
	/**
	 * User selected names and descriptions of custom post types
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $selected_custom_post_types = null;
	
	/**
	 * Valid names and descriptions of the custom post types
	 *
	 * @since    3.0
	 *
	 * @var      array
	 */
	protected $valid_custom_post_types = null;
	
	/**
	 * User selected names and descriptions of custom taxonomies
	 *
	 * @since    3.0
	 *
	 * @var      array
	 */
	protected $selected_custom_taxonomies = null;
	
	/**
	 * Valid names and descriptions of the custom taxonomies
	 *
	 * @since    3.0
	 *
	 * @var      array
	 */
	protected $valid_custom_taxonomies = null;
	
	/**
	 * User selected date queries the plugin should perform
	 *
	 * @since    4.0
	 *
	 * @var      array
	 */
	protected $selected_date_queries = null;

	/**
	 * Post dates as stored in the db
	 *
	 * @since    4.0
	 *
	 * @var      array
	 */
	protected $valid_post_dates = null;

	/**
	 * Valid names and descriptions of the date queries
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $valid_date_queries = null;
	
	/**
	 * User selected custom fields the plugin should perform
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $selected_custom_field = null;

	/**
	 * Valid names and descriptions of the custom fields
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $valid_custom_field = null;

	/**
	 * User selected post ids
	 *
	 * @since    1.0.0
	 *
	 * @var      array
	 */
	protected $selected_post_ids = null;
	
	/**
	 * Valid names and descriptions of image sizes
	 *
	 * @since    2.0
	 *
	 * @var      array
	 */
	protected $valid_image_dimensions = null;

	/**
	 * User given image sizes
	 *
	 * @since    2.0
	 *
	 * @var      array
	 */
	protected $selected_image_dimensions = null;
	
	 /**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   4.1: added get_plugin_name()
	 * @updated   7.0: added get_plugin_version()
	 */
	private function __construct() {

		// Call some values from public plugin class.
		$plugin = Quick_Featured_Images_Admin::get_instance();
		$this->plugin_name = $plugin->get_plugin_name();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$this->page_slug = $this->plugin_slug . '-tools';
		$this->parent_page_slug = $plugin->get_page_slug();
		$this->plugin_version = $plugin->get_plugin_version();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the admin page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		
		// Add 'Bulk set' link in rows of media library list
		add_filter( 'media_row_actions', array( &$this, 'add_media_row_action' ), 10, 2 );

	}
	
	/**
	 * Do the admin main function 
	 *
	 * @since     1.0.0
     * @updated   2.0: added check for required image
     * @updated   3.0: some performance improvements
     * @updated   4.1: added check for direct bulk set link
     * @updated   4.1.1: fixed security check
     * @updated   5.0: added action "take first img", added snippet form_back_to_selection
     * @updated   5.1: added skip of refine page if user has not selected a filter
     * @updated   6.0: refactored if-branches, added selection of multiple images
	 *
	 */
	public function main() {
		// set variables
		$this->set_default_values();
		// get current step
		$this->selected_step = $this->get_sanitized_step();
		// print header
		$this->display_header();
		#dambedei($_REQUEST);
		#dambedei($_SERVER);
		/*
		 * print content
		 */
		// no action and image required, just the start page
		if ( 'start' == $this->selected_step ) {
			include_once( 'views/form_start.php' );
		} else {
			// get user selected action
			$this->selected_action = $this->get_sanitized_action();
			// check if action is defined, else print error page
			if ( ! $this->selected_action ) {
				$this->display_error( 'wrong_action', false );
			} else {
				// check whether thumb id is not required due to selected action
				if ( in_array( $this->selected_action, array_merge( array_keys( $this->valid_actions_without_image ), array_keys( $this->valid_actions_multiple_images ) ) ) ) {
					$this->is_image_required = false;
				}
				// get selected image id, else 0
				$this->selected_image_id = $this->get_sanitized_image_id();
				// get selected image ids, else empty array
				$this->selected_multiple_image_ids = $this->get_sanitized_multiple_image_ids();
				// check whether an image id is available if required
				if ( $this->is_image_required && ! $this->selected_image_id ) {
					$this->display_error( 'no_image', false );
				// check whether selected attachment is an image if required
				} elseif ( $this->is_image_required && ! wp_get_attachment_image_src( $this->selected_image_id ) ) {
					$this->display_error( 'no_result', sprintf( __( 'Wrong image ID %d', $this->plugin_slug ), $this->selected_image_id ) );
				// check whether there are selected images if required
				} elseif ( 'assign_randomly' == $this->selected_action && ! $this->selected_multiple_image_ids ) {
					$this->display_error( 'no_image', false );
				} else {
					// get user selected filters
					$this->selected_filters = $this->get_sanitized_filter_names();
					// get user selected options
					$this->selected_options = $this->get_sanitized_option_names();
					// after the old image selection page (filter_replace.php) and if no old image was selected
					if ( 'replace' == $this->selected_action && 'confirm' == $this->selected_step && ! isset( $_REQUEST[ 'replacement_image_ids' ] ) ) {
						// stay on the selection page with a warning
						$this->selected_step = 'select';
						$this->is_error_no_old_image = true;
					// check if user comes from direct link in media page
					} elseif ( 'assign' == $this->selected_action && 'select' == $this->selected_step && $this->selected_image_id && isset( $_REQUEST[ '_wpnonce' ] ) ) {
						// go to the filter selection page directly
						$this->is_direct_access = true;
					// check if user comes from the selection page and has not select any filter
					} elseif ( 'refine' == $this->selected_step	&& empty( $this->selected_filters ) ) {
						// skip refine page, go to the confirm page directly
						$this->selected_step = 'confirm';
						$this->is_skip_refine = true;
					}

					switch ( $this->selected_step ) {
						case 'select':
							if ( $this->is_error_no_old_image ) {
								check_admin_referer( 'quickfi_refine', $this->plugin_slug . '_nonce' );
							} elseif ( $this->is_direct_access ) {
								// no referer check
								check_admin_referer( 'bulk-assign' );
							} else {
								check_admin_referer( 'quickfi_start', $this->plugin_slug . '_nonce' );
							}
							// print selected thumbnail if required
							include_once( 'views/section_image.php' );	
							// print form to select the posts to apply the action to
							include_once( 'views/form_select.php' );	
							break;
						case 'refine':
							check_admin_referer( 'quickfi_select', $this->plugin_slug . '_nonce' );
							// print selected thumbnail if required
							include_once( 'views/section_image.php' );	
							// print form to refine choice
							include_once( 'views/form_refine.php' );	
							// print form for going back to the filter selection without loosing input data
							include_once( 'views/form_back_to_selection.php' );	
							break;
						case 'confirm':
							if ( $this->is_skip_refine ) {
								check_admin_referer( 'quickfi_select', $this->plugin_slug . '_nonce' );
							} else {
								check_admin_referer( 'quickfi_refine', $this->plugin_slug . '_nonce' );
							}
							// filter posts
							$results = $this->find_posts();
							// print selected thumbnail if required
							include_once( 'views/section_image.php' );	
							// print refine form again if there are no results
							include_once( 'views/form_confirm.php' );	
							// print form to refine choice if filters were selected
							if ( $this->selected_filters ) {
								include_once( 'views/form_refine.php' );	
							}
							// print form for going back to the filter selection without loosing input data
							include_once( 'views/form_back_to_selection.php' );	
							break;
						case 'perform':
							check_admin_referer( 'quickfi_confirm', $this->plugin_slug . '_nonce' );
							// filter posts and apply action to found posts
							$results = $this->perform_action();
							// print results
							include_once( 'views/section_results.php' );	
					} // switch( selected step )
				} // if( image available )
			} // if( action available )
		} // if( is start )
		// print footer
		$this->display_footer();
	}
	
	/**
	 * Set variables
	 *
	 * @access   private
	 * @since    1.0.0
	 * @updated  2.0: added: filter filter_img_size, action remove_any_img, $valid_image_dimensions, $selected_image_dimensions
	 * @updated  3.0: added: filter filter_custom_taxonomies, valid_custom_post_types, valid_custom_taxonomies, selected_custom_taxonomies, all post types by default
	 * @updated  4.0: added: filter filter_time and its variables
	 * @updated  4.1: added: is_direct_access
     * @updated  4.1.2: fixed wrong placement of valid_custom_taxonomies
     * @updated  5.0: added valid actions without selected image, added maximum dimensions for thumbnails
     * @updated  5.1.1: changed 'take_first_img' to 'assign_first_img'
     * @updated  6.0: added selection of multiple images
	 */
	private function set_default_values() {
		/*
		 * Note: The order of the entries affects the order in the frontend page
		 *
		 */
		// process steps
		$this->valid_steps = array(
			'start'		=> __( 'Select', $this->plugin_slug ),
			'select'	=> __( 'Add filter', $this->plugin_slug ),
			'refine' 	=> __( 'Refine', $this->plugin_slug ),
			'confirm'	=> __( 'Confirm', $this->plugin_slug ),
			'perform'	=> __( 'Perform', $this->plugin_slug ),
		);
		// process options
		$this->valid_options = array(
			'overwrite' => __( 'Overwrite featured images', $this->plugin_slug ),
		);
		// actions
		$this->valid_actions = array(
			'assign'			=> __( 'Set the selected image as new featured image', $this->plugin_slug ),
			'replace'			=> __( 'Replace featured images by the selected image', $this->plugin_slug ),
			'remove'			=> __( 'Remove the selected image as featured image', $this->plugin_slug ),
		);
		$this->valid_actions_without_image = array(
			'assign_first_img'	=> __( 'Set the first post image as featured image', $this->plugin_slug ),
			'remove_any_img'	=> __( 'Remove any image as featured image', $this->plugin_slug ),
		);
		$this->valid_actions_multiple_images = array(
			'assign_randomly'	=> __( 'Set multiple images randomly as featured images', $this->plugin_slug ),
		);
		// filters
		$this->valid_filters = array(
			'filter_post_types' 		=> __( 'Post Type Filter', $this->plugin_slug ),
			'filter_status' 			=> __( 'Status Filter', $this->plugin_slug ),
			'filter_search' 			=> __( 'Search Filter', $this->plugin_slug ),
			'filter_time' 				=> __( 'Time Filter', $this->plugin_slug ),
			'filter_author' 			=> __( 'Author Filter', $this->plugin_slug ),
			//'filter_custom_field' 		=> __( 'Custom Field Filter', $this->plugin_slug ),
			'filter_custom_taxonomies'	=> __( 'Custom Taxonomy Filter', $this->plugin_slug ),
			'filter_image_size' 		=> __( 'Featured Image Size Filter', $this->plugin_slug ),
			'filter_category' 			=> __( 'Category Filter', $this->plugin_slug ),
			'filter_tag' 				=> __( 'Tag Filter', $this->plugin_slug ),
			'filter_parent_page' 		=> __( 'Parent Page Filter', $this->plugin_slug ),
		);
		// post types (generic and custom)
		$label_posts = 'Posts';
		$label_pages = 'Pages';
		$this->valid_post_types = array(
			'post' => _x( $label_posts, 'post type general name' ),
			'page' => _x( $label_pages, 'post type general name' ),
		);
		$this->valid_custom_post_types = $this->get_registered_custom_post_types();
		// statuses
		$this->valid_statuses = array(
			'publish' => __( 'Published: already published', $this->plugin_slug ),
			'pending' => __( 'Pending review: waiting for reviews', $this->plugin_slug ),
			'draft'   => __( 'Draft: saved as draft', $this->plugin_slug ),
			'future'  => __( 'Scheduled: will be published in the future', $this->plugin_slug ),
			'private' => __( 'Private: visible only to users who are logged in', $this->plugin_slug )
		);
		// time and dates
		$this->valid_date_queries = array(
			'after' 	=> __( 'Start Date', $this->plugin_slug ),
			'before' 	=> __( 'End Date', $this->plugin_slug ),
			'inclusive'	=> __( 'Include the posts of the selected dates', $this->plugin_slug )
		);
		// custom fields
		$this->valid_custom_field = array(
			'key' 		=> __( 'Custom field name', $this->plugin_slug ),
			'compare' 	=> __( 'Operator to test with the value in the custom field', $this->plugin_slug ),
			'value' 	=> __( 'Custom field value to compare with', $this->plugin_slug ),
			'type' 		=> __( 'Custom field type', $this->plugin_slug )
		);
		// custom taxonomies
		$this->valid_custom_taxonomies = $this->get_registered_custom_taxonomies();
		// image dimensions
		$this->valid_image_dimensions = array(
			'max_width' 	=> __( 'Image width in pixels lower than', $this->plugin_slug ),
			'max_height' 	=> __( 'Image height in pixels lower than', $this->plugin_slug ),
		);
		// default: user selected image is required
		$this->is_image_required = true;
		// default: start form
		$this->selected_step = 'start';
		// default: no images
		$this->selected_old_image_ids = array();
		$this->selected_image_id = 0;
		$this->is_error_no_old_image = false;
		$this->is_direct_access = false;
		$this->is_skip_refine = false;
		// default: no category
		$this->selected_category_id = 0;
		// default: no parent page
		$this->selected_parent_page_id = 0;
		// default: no author
		$this->selected_author_id = 0;
		// default: no tag
		$this->selected_tag_id = 0;
		// default: no date query
		$this->selected_date_queries = array( 'inclusive' => "1" ); // default: include posts matching selected time specifications
		// default: all post statuses
		$this->selected_statuses = array_keys( $this->valid_statuses ); // default: all statuses
		// default: all post types
		$this->selected_post_types = array_keys( $this->valid_post_types ); // default: all posts, pages and custom post types. old: posts only. No pages, no custom post types. old string: array_keys( $this->valid_post_types );
		// default: all custom post types
		$this->selected_custom_post_types = $this->valid_custom_post_types;
		// default: no custom taxonomies
		$this->selected_custom_taxonomies = array();
		// default: no custom field
		$this->selected_custom_field = array();
		// default: no selected posts
		$this->selected_post_ids = array();
		// get user defined dimensions for thumbnails, else take 150 px and set maximum value if necessary
		$max_dimension = 160; // width of thumbnail column in px at 1024 px window width
		$this->used_thumbnail_width  = get_option( 'thumbnail_size_w', $max_dimension );
		$this->used_thumbnail_height = get_option( 'thumbnail_size_h', $max_dimension );
		$this->used_thumbnail_width = $this->used_thumbnail_width > $max_dimension ? $max_dimension : $this->used_thumbnail_width;
		$this->used_thumbnail_height = $this->used_thumbnail_height > $max_dimension ? $max_dimension : $this->used_thumbnail_height;
		 // default:  stored sizes for thumbnails
		$this->selected_image_dimensions = array(
			'max_width' 	=> $this->used_thumbnail_width,
			'max_height' 	=> $this->used_thumbnail_height,
		);
		// default: min 1 x 1 px, max 9999 x 9999 px images
		$this->min_image_length = 1;
		$this->max_image_length = 9999;
	}
	
	/**
	 *
	 * Render the header of the admin page
	 *
	 * @access   private
	 * @since    1.0.0
	 */
	private function display_header() {
		include_once( 'views/section_header_progress.php' );
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
	 *
	 * Render the error page
	 *
	 * @access   private
	 * @since    1.0.0
}	 */
	private function display_error( $reason, $value_name ) {	
		switch ( $reason ) {
			case 'missing_input_value':
				$msg = sprintf( __( 'The input field %s is empty.', $this->plugin_slug ), $value_name );
				$solution = __( 'Type in a value into the input field.', $this->plugin_slug );
				break;
			case 'missing_variable':
				$msg = sprintf( __( '%s is not defined.', $this->plugin_slug ), $value_name );
				$solution = __ ('Check how to define the value.', $this->plugin_slug );
				break;
			case 'no_image':
				$msg = __( 'There is no selected image.', $this->plugin_slug );
				$solution = __( 'Select an image from the media library.', $this->plugin_slug );
				break;
			case 'wrong_action':
				$msg = __( 'You have not selected an action.', $this->plugin_slug );
				$solution = __( 'Start again and select which action you want to apply.', $this->plugin_slug );
				break;
			case 'wrong_value':
				$msg = sprintf( __( 'The input field %s has an invalid value.', $this->plugin_slug ), $value_name );
				$solution = __( 'Type in valid values in the input field.', $this->plugin_slug );
				break;
			case 'no_result':
				$msg = $value_name;
				$solution = __( 'Type in values stored by WordPress.', $this->plugin_slug );
				break;
		} // switch ( $reason )
		include_once( 'views/section_errormsg.php' );
		//die();
	} // display_error()

	/**
	 *
	 * Render options of HTML selection lists with strings as values
	 *
	 * @access   private
	 * @since    1.0.0
	 * @updated  3.0: changed printf into return, added parameter first_empty
	 * @updated   4.0: improved performance by changing array_key_exists() to isset()
	 */
	private function get_html_options_strings( $arr, $key, $options, $first_empty = true ) {
		$output = $first_empty ? $this->get_html_empty_option() : '';
		if ( isset( $arr[ $key ] ) ) { 
			foreach ( $options as $key => $label ) {
				$output .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( isset( $arr[ $key ] ), true, false ), $label );
			}
		} else {
			foreach ( $options as $key => $label ) {
				$output .= sprintf( '<option value="%s">%s</option>', $key, $label );
			}
		}
		return $output;
	}
	
	/**
	 *
	 * Render options of HTML selection lists with dates
	 *
	 * @access   private
	 * @since    4.0
	 */
	private function get_html_date_options( $key, $first_empty = true ) {
		global $wp_locale;
		$output = $first_empty ? $this->get_html_empty_option() : '';

		if ( count( $this->valid_post_dates ) ) {
			if ( isset( $this->selected_date_queries[ $key ] ) ) { 
				foreach ( $this->valid_post_dates as $date ) {
					if ( 0 == $date->year ) {
						continue;
					}
					$month = zeroise( $date->month, 2 );
					$option_value = sprintf( '%s-%s', $date->year, $month );
					$output .= sprintf( '<option value="%s" %s>%s %s</option>', $option_value, selected( $option_value == $this->selected_date_queries[ $key ], true, false ), $date->year, $wp_locale->get_month( $month ) );
				}
			} else {
				foreach ( $this->valid_post_dates as $date ) {
					if ( 0 == $date->year ) {
						continue;
					}
					$month = zeroise( $date->month, 2 );
					$output .= sprintf( '<option value="%s-%s">%s %s</option>', $date->year, $month, $date->year, $wp_locale->get_month( $month ) );
				}
			}
		}
		return $output;
	}

	/**
	 *
	 * Return empty option for selection field
	 *
	 * @access   private
	 * @since    3.0
	 */
	private function get_html_empty_option() {
		$text = '&mdash; Select &mdash;';
		return sprintf( '<option value="">%s</option>', __( $text ) );
	}

	/**
	 * Check the arguments for WP_Query depended on users selection
	 *
	 * @access   private
	 * @since    1.0.0
	 * @updated  2.0: new filter_image_size, new action remove_any_img, merged with former prepare_query_args()
	 * @updated  3.0: new filter_custom_taxonomies, changed order of cases, merge of post types and custom post types
	 * @updated  3.0.2: corrected case filter_search
	 * @updated  3.1: changed replace case, set merge of post types and custom post types as default
	 * @updated  4.0: new filter_time
	 *
	 * @return    array    the args
	 */
	private function get_query_args() {
		// define default params
		$args[ 'posts_per_page' ] =  -1; // find all matching posts, not only 10
		$args[ 'orderby' ] = 'title';
		$args[ 'order' ] = 'ASC';
		$args[ 'ignore_sticky_posts' ] = true;
		$args[ 'post_type' ] = array_merge ( $this->selected_post_types, $this->selected_custom_post_types );
		switch ( $this->selected_action ) {
			case 'replace':
				$this->selected_post_ids = $this->get_post_ids_of_old_thumbnails();
				$args[ 'post__in' ] = $this->get_id_array_for_query( $this->selected_post_ids );
				break;
			case 'remove':
				$this->selected_post_ids = $this->get_post_ids_of_thumbnail();
				$args[ 'post__in' ] = $this->get_id_array_for_query( $this->selected_post_ids );
		} // switch()
		if ( $this->selected_filters ) {
			#in_array ( 'filter_post_types', $this->selected_filters ) ?
			foreach ( $this->selected_filters as $filter ) {
				switch ( $filter ) {
					case 'filter_post_types':
						$this->selected_post_types = $this->get_sanitized_post_types();
						$this->selected_custom_post_types = $this->get_sanitized_custom_post_types();
						$args[ 'post_type' ] = array_merge ( $this->selected_post_types, $this->selected_custom_post_types );
						break;
					case 'filter_status':
						$this->selected_statuses = $this->get_sanitized_post_statuses();
						$args[ 'post_status' ] = implode( ',', $this->selected_statuses );
						break;
					case 'filter_search':
						$this->selected_search_term = $this->get_search_term();
						// if there is a search term assign it to the query
						if ( '' != $this->selected_search_term ) {
							$args[ 's' ] = $this->selected_search_term;
						}
						break;
					case 'filter_author':
						$this->selected_author_id = $this->get_sanitized_author_id();
						// if there is a selected author assign him/her to the query
						if ( 0 < $this->selected_author_id ) {
							$args[ 'author' ] = $this->selected_author_id;
						}
						break;
					case 'filter_custom_field':
						$this->selected_custom_field = $this->get_sanitized_custom_field();
						$args[ 'meta_query' ] = array( $this->selected_custom_field );
						break;
					case 'filter_time':
						$this->selected_date_queries = $this->get_sanitized_date_queries();
						// format the input for the query
						$date_query = array();
						foreach ( $this->selected_date_queries as $key => $value ) {
							switch ( $key ) {
								case 'after':
								case 'before':
									// start and end dates
									$time_data = array();
									if ( isset( $this->selected_date_queries[ $key ] ) AND  "" != $this->selected_date_queries[ $key ] ) {
										$time_data[ $key ] = date( 'Y-m', strtotime( $this->selected_date_queries[ $key ] ) );
										if ( isset( $this->selected_date_queries[ 'inclusive' ] ) AND  "1" === $this->selected_date_queries[ 'inclusive' ] ) {
											if ( 'before' == $key ) {
												$time_data[ $key ] .= '+1 month'; // correction because of $default_to_max in WP_Date_Query
											}
											$time_data[ 'inclusive' ] = true;
										} else {
											if ( 'after' == $key ) {
												$time_data[ $key ] .= '+1 month'; // correction because of $default_to_max in WP_Date_Query
											}
											$time_data[ 'inclusive' ] = false;
										}
									}
									if ( ! empty( $time_data ) ) {
										$date_query[] = $time_data;
									}
									break;
							} // switch()
						} // foreach()
						$args[ 'date_query' ] = $date_query;
						break;
					case 'filter_image_size':
						$this->selected_image_dimensions = $this->get_sanitized_image_dimensions();
						$post_ids = $this->get_post_ids_of_to_small_thumbnails();
						// if there are post ids get the intersection with posts ids of to small images, else zero results
						if ( $post_ids && $this->selected_post_ids ) {
							$this->selected_post_ids = $this->get_array_intersect( $this->selected_post_ids, $post_ids );
						} elseif ( $post_ids ) {
							$this->selected_post_ids = $post_ids;
						} else {
							$this->selected_post_ids = array();
						}
						$args[ 'post__in' ] = $this->get_id_array_for_query( $this->selected_post_ids );
						break;
					case 'filter_category':
						$this->selected_category_id = $this->get_sanitized_category_id();
						// if there is a selected category assign it to the query
						if ( 0 < $this->selected_category_id ) {
							$args[ 'cat' ] = $this->selected_category_id; // todo: user selects more than 1 category, 'category__in'
						}
						break;
					case 'filter_tag':
						$this->selected_tag_id = $this->get_sanitized_tag_id();
						// if there is a selected tag assign it to the query
						if ( 0 < $this->selected_tag_id ) {
							$args[ 'tag_id' ] = $this->selected_tag_id; // todo: user selects more than 1 tag, 'tag__in'
						}
						break;
					case 'filter_custom_taxonomies':
						$this->selected_custom_taxonomies = $this->get_sanitized_custom_taxonomies();
						$tax_query = array();
						// format the input for the query
						foreach ( $this->selected_custom_taxonomies as $sel_cus_tax => $id ) {
							if ( "" == $id ) continue; // next loop cycle if not selected
							$tax_query[] = array(
								'field' => 'id',
								'taxonomy' => $sel_cus_tax,
								'terms' => $id
							);
						}
						// logical relationship between each inner taxonomy array is intersection when there is more than 1 array
						if ( 1 < sizeof( $tax_query ) ) {
							$tax_query[ 'relation' ] = 'AND';
						}
						// if there are selected terms finally assign them to the query
						if ( ! empty ( $tax_query ) ) {
							$args[ 'tax_query' ] = $tax_query;
						}
						break;
					case 'filter_parent_page':
						$this->selected_parent_page_id = $this->get_sanitized_page_id();
						// if there is a selected parent page assign it to the query
						if ( 0 < $this->selected_parent_page_id ) {
							$args[ 'post_parent' ] =  $this->selected_parent_page_id;
						}
				} // switch()
			} // foreach()
		} // if()
		#dambedei($args);
		return $args;
	}

	/**
	 * Call the WP Query and apply the selected action to found posts
	 * 
	 * Is an alias to 'find_posts( true )' for more readability
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 */
	private function perform_action() {
		return $this->find_posts( true );
	}

	/**
	 * Do the loop to find posts, change the thumbnail if param is true
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   2.0: moving loop into ifs and switch to gain more performance
	 * @updated   3.2: added current attached featured image html
	 * @updated   4.0: improved performance with cache array
	 * @updated   5.0: added action "assign_first_img"
	 * @updated   5.1: added future image as column value for preview list
	 * @updated   5.1.1: refactored lines around $this->get_image_id_by_url()
	 * @updated   6.0: added action "assign_randomly"
	 *
	 * @return    array    affected posts
	 */
	private function find_posts( $perform = false ) {
		// initialise result array 
		$results = array();
		// define thumbnail properties
		$size = array( 
			absint( $this->used_thumbnail_width / 2 ), 
			absint( $this->used_thumbnail_height / 2 ) 
		);
		$attr = array( 'class' => 'attachment-thumbnail' );
		// define caching arrays for better performance of calculating attachment images
		$false_id = 'false_id'; // something to use as an array key
		$current_featured_images = array();
		$future_featured_images = array();
		$current_featured_images[ $false_id ] = false;
		$future_featured_images[ $false_id ] = false;
		// The Query
		$the_query = new WP_Query( $this->get_query_args() );
		#printf( '<p>%s</p>', $the_query->request ); // just for debugging
		// The Loop
		if ( $the_query->have_posts() ) {
			if ( $perform ) { // really make changes
				// do task dependent on selected action
				switch ( $this->selected_action ) {
					case 'assign':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$success = false;
							// get the post id once
							$post_id = get_the_ID();
							// check if there is an existing featured image
							$thumb_id = get_post_thumbnail_id( $post_id );
							// if no existing featured image or permission to overwrite it
							if ( ! $thumb_id or in_array( 'overwrite', $this->selected_options ) ) {
								// do the task
								$success = set_post_thumbnail( $post_id, $this->selected_image_id );
								// get new featured image (this is also a test of successful setting the featured image)
								$thumb_id = get_post_thumbnail_id( $post_id );
							}
							if ( $thumb_id ) {
								if ( ! isset( $current_featured_images[ $thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $thumb_id ] = wp_get_attachment_image( $thumb_id, $size, false, $attr );
								}
							} else {
								$thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
							}
							// store edit link, post title, image html, success of action (true or false)
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(),
								$current_featured_images[ $thumb_id ],
								$success 
							);
						} // while()
						break;
					case 'replace':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$success = false;
							// get the post id once
							$post_id = get_the_ID();
							// do the task
							$success = set_post_thumbnail( $post_id, $this->selected_image_id );
							// get new featured image (this is also a test of successful setting the featured image)
							$thumb_id = get_post_thumbnail_id( $post_id );
							if ( $thumb_id ) {
								if ( ! isset( $current_featured_images[ $thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $thumb_id ] = wp_get_attachment_image( $thumb_id, $size, false, $attr );
								}
							} else {
								$thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
							}
							// store edit link, post title, image html, success of action (true or false)
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(),
								$current_featured_images[ $thumb_id ],
								$success 
							);
						} // while()
						break;
					case 'assign_first_img':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$success = false;
							// get the post id once
							$post_id = get_the_ID();
							// check if there is an existing featured image
							$current_thumb_id = get_post_thumbnail_id( $post_id );
							// search post content for embedded images and take the first found image
							$future_thumb_id = $this->get_image_id_by_url( get_the_content() );
							// if old thumb 
							if ( $current_thumb_id ) {
								// if new thumb + overwrite old thumb => new thumb
								if ( $future_thumb_id and in_array( 'overwrite', $this->selected_options ) ) {
									// do the task
									$success = set_post_thumbnail( $post_id, $future_thumb_id );
									// get new featured image (this is also a test of successful setting the featured image)
									$future_thumb_id = get_post_thumbnail_id( $post_id );
								} else {
								// else (just old thumb) => old thumb (keep current image)
									$future_thumb_id = $current_thumb_id;
								}
							// else (no old thumb )
							} else {
								$current_thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
								// if new thumb  => new thumb
								if ( $future_thumb_id ) {
									// do the task
									$success = set_post_thumbnail( $post_id, $future_thumb_id );
									// get new featured image (this is also a test of successful setting the featured image)
									$future_thumb_id = get_post_thumbnail_id( $post_id );
								} else {
								// else (nothing) => no thumb
									$future_thumb_id = $current_thumb_id;
								}
							}
							// get the html code for featured image once
							if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
								$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
							}
							// store edit link, post title, image html, success of action (true or false)
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(),
								$future_featured_images[ $future_thumb_id ],
								$success 
							);
						} // while()
						break;
					case 'assign_randomly':
						$last_index = count( $this->selected_multiple_image_ids ) - 1;
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							$success = false;
							// get the post id once
							$post_id = get_the_ID();
							// check if there is an existing featured image
							$thumb_id = get_post_thumbnail_id( $post_id );
							// if no existing featured image or permission to overwrite it
							if ( ! $thumb_id or in_array( 'overwrite', $this->selected_options ) ) {
								// do the task, get thumb id randomly
								$success = set_post_thumbnail( $post_id, $this->selected_multiple_image_ids[ rand( 0, $last_index ) ] );
								// get new featured image (this is also a test of successful setting the featured image)
								$thumb_id = get_post_thumbnail_id( $post_id );
							}
							if ( $thumb_id ) {
								if ( ! isset( $current_featured_images[ $thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $thumb_id ] = wp_get_attachment_image( $thumb_id, $size, false, $attr );
								}
							} else {
								$thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
							}
							// store edit link, post title, image html, success of action (true or false)
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(),
								$current_featured_images[ $thumb_id ],
								$success 
							);
						} // while()
						break;
					case 'remove':
					case 'remove_any_img':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							// get the post id once
							$post_id = get_the_ID();
							// do the task
							$success = delete_post_thumbnail( $post_id );
							// get html for featured image (yes, it's deleted, but does it for check)
							$thumb_id = get_post_thumbnail_id( $post_id );
							if ( $thumb_id ) {
								if ( ! isset( $current_featured_images[ $thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $thumb_id ] = wp_get_attachment_image( $thumb_id, $size, false, $attr );
								}
							} else {
								$thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
							}
							// store edit link, post title, image html, success of action (true or false)
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(), 
								$current_featured_images[ $thumb_id ],
								$success
							);
						} // while()
						break;
				} // switch()
			} else { // preview only, no changes
				// do task dependent on selected action
				switch ( $this->selected_action ) {
					case 'assign':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							// get the post id once
							$post_id = get_the_ID();
							// get html of current thumbnail
							$current_thumb_id = get_post_thumbnail_id( $post_id );
							if ( $current_thumb_id ) {
								if ( ! isset( $current_featured_images[ $current_thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $current_thumb_id ] = wp_get_attachment_image( $current_thumb_id, $size, false, $attr );
								}
								// get html of future thumbnail
								if ( in_array( 'overwrite', $this->selected_options ) ) {
									// preview old thumb + new thumb
									$future_thumb_id = $this->selected_image_id;
									if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
										// get the html code for featured image once
										$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
									}
								} else {
									// preview old thumb + old thumb
									$future_thumb_id = $current_thumb_id;
									$future_featured_images[ $future_thumb_id ] = $current_featured_images[ $current_thumb_id ];
								}
							} else {
								// preview no old thumb + new thumb
								$current_thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
								// get html of future thumbnail
								$future_thumb_id = $this->selected_image_id;
								if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
									// get the html code for featured image once
									$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
								}
							}
							// store edit link, post title, post date, post author, current image html, future image html
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(), 
								sprintf( '%s %s', __( 'written on', $this->plugin_slug ), get_the_date() ),
								sprintf( '%s %s', __( 'by', $this->plugin_slug ), get_the_author() ),
								$current_featured_images[ $current_thumb_id ],
								$future_featured_images[ $future_thumb_id ],
							);
						} // while()
						break;
					case 'replace':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							// get the post id once
							$post_id = get_the_ID();
							// get html of current thumbnail
							$current_thumb_id = get_post_thumbnail_id( $post_id );
							if ( $current_thumb_id ) {
								if ( ! isset( $current_featured_images[ $current_thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $current_thumb_id ] = wp_get_attachment_image( $current_thumb_id, $size, false, $attr );
								}
							} else {
								$current_thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
							}
							// get html of future thumbnail
							$future_thumb_id = $this->selected_image_id;
							if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
								// get the html code for featured image once
								$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
							}
							// store edit link, post title, post date, post author, current image html, future image html
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(), 
								sprintf( '%s %s', __( 'written on', $this->plugin_slug ), get_the_date() ),
								sprintf( '%s %s', __( 'by', $this->plugin_slug ), get_the_author() ),
								$current_featured_images[ $current_thumb_id ],
								$future_featured_images[ $future_thumb_id ],
							);
						} // while()
						break;
					case 'assign_first_img':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							// get the post id once
							$post_id = get_the_ID();
							// get html of current thumbnail
							$current_thumb_id = get_post_thumbnail_id( $post_id );
							if ( $current_thumb_id ) {
								if ( ! isset( $current_featured_images[ $current_thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $current_thumb_id ] = wp_get_attachment_image( $current_thumb_id, $size, false, $attr );
								}
								if ( in_array( 'overwrite', $this->selected_options ) ) {
									// preview old thumb + new thumb
									$future_thumb_id = $this->get_image_id_by_url( get_the_content() );
									if ( $future_thumb_id ) {
										if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
											// get the html code for featured image once
											$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
										}
									} else {
										// preview old thumb + old thumb
										$future_thumb_id = $current_thumb_id;
										$future_featured_images[ $future_thumb_id ] = $current_featured_images[ $current_thumb_id ];
									}
								} else {
									// preview old thumb + old thumb
									$future_thumb_id = $current_thumb_id;
									$future_featured_images[ $future_thumb_id ] = $current_featured_images[ $current_thumb_id ];
								} // if 'overwrite' option
							} else {
								// preview no old thumb + new thumb
								$current_thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
								// try to get html of future thumbnail
								$future_thumb_id = $this->get_image_id_by_url( get_the_content() );
								if ( $future_thumb_id ) {
									if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
										// get the html code for featured image once
										$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
									}
								} else {
									// preview no old thumb + no old thumb
									$future_thumb_id = $current_thumb_id;
									$future_featured_images[ $future_thumb_id ] = $current_featured_images[ $current_thumb_id ];
								} // if $future_thumb_id
							}
							// store edit link, post title, post date, post author, current image html, future image html
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(), 
								sprintf( '%s %s', __( 'written on', $this->plugin_slug ), get_the_date() ),
								sprintf( '%s %s', __( 'by', $this->plugin_slug ), get_the_author() ),
								$current_featured_images[ $current_thumb_id ],
								$future_featured_images[ $future_thumb_id ],
							);
						} // while()
						break;
					case 'assign_randomly':
						$last_index = count( $this->selected_multiple_image_ids ) - 1;
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							// get the post id once
							$post_id = get_the_ID();
							// get html of current thumbnail
							$current_thumb_id = get_post_thumbnail_id( $post_id );
							if ( $current_thumb_id ) {
								if ( ! isset( $current_featured_images[ $current_thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $current_thumb_id ] = wp_get_attachment_image( $current_thumb_id, $size, false, $attr );
								}
								// get html of future thumbnail
								if ( in_array( 'overwrite', $this->selected_options ) ) {
									// preview old thumb + new thumb
									$future_thumb_id = $this->selected_multiple_image_ids[ rand( 0, $last_index ) ]; // get thumb id randomly
									if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
										// get the html code for featured image once
										$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
									}
								} else {
									// preview old thumb + old thumb
									$future_thumb_id = $current_thumb_id;
									$future_featured_images[ $future_thumb_id ] = $current_featured_images[ $current_thumb_id ];
								}
							} else {
								// preview no old thumb + new thumb
								$current_thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
								// get html of future thumbnail
								$future_thumb_id = $this->selected_multiple_image_ids[ rand( 0, $last_index ) ]; // get thumb id randomly
								if ( ! isset( $future_featured_images[ $future_thumb_id ] ) ) {
									// get the html code for featured image once
									$future_featured_images[ $future_thumb_id ] = wp_get_attachment_image( $future_thumb_id, $size, false, $attr );
								}
							}
							// store edit link, post title, post date, post author, current image html, future image html
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(), 
								sprintf( '%s %s', __( 'written on', $this->plugin_slug ), get_the_date() ),
								sprintf( '%s %s', __( 'by', $this->plugin_slug ), get_the_author() ),
								$current_featured_images[ $current_thumb_id ],
								$future_featured_images[ $future_thumb_id ],
							);
						} // while()
						break;
					case 'remove':
					case 'remove_any_img':
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							// get html for featured image
							$current_thumb_id = get_post_thumbnail_id( get_the_ID() );
							if ( $current_thumb_id ) {
								if ( ! isset( $current_featured_images[ $current_thumb_id ] ) ) {
									// get the html code for featured image once
									$current_featured_images[ $current_thumb_id ] = wp_get_attachment_image( $current_thumb_id, $size, false, $attr );
								}
							} else {
								$current_thumb_id = $false_id; // cast from '' or 'false' to a value to use as an array key
							}
							// store edit link, post title, post date, post author, current image html, future image html
							$results[] = array( 
								get_edit_post_link(), 
								get_the_title(), 
								sprintf( '%s %s', __( 'written on', $this->plugin_slug ), get_the_date() ),
								sprintf( '%s %s', __( 'by', $this->plugin_slug ), get_the_author() ),
								$current_featured_images[ $current_thumb_id ],
								false,
							);
						} // while()
				} // switch()
			} // if( $perform )
		} // if( have_posts )
		// Restore original Post Data
		wp_reset_postdata();
		// return results
		return $results;
	}
	
	/**
	 * Returns the post id of an uploaded image, else 0
	 * Looks for internal images only, i.e. images from the 
	 * media library and not images embedded by URL from 
	 * external servers
	 *
	 * @access   private
	 * @since     5.0
	 * @updated   5.1.1: refactored
	 * @updated   7.0: improved performance by changing intval() to (int)
	 *
	 * @return    integer    the post id of the image
	 */
	private function get_image_id_by_url ( $content ) {
		// set variables
		global $wpdb;
		$thumb_id = 0;
		$pat_find_img_src = '/<img.*?src=[\'"]([^\'"]+)[\'"][^>]*>/i';
		// look for images in HTML code
		preg_match_all( $pat_find_img_src, $content, $matches );
		// if img elements found: try to get the first image's ID
		if ( isset( $matches ) and 0 < count( $matches ) ) {
			foreach ( $matches[ 1 ] as $url ) {
				preg_match( '|' . get_site_url() . '|i', $url, $matches );
				// if site-owned image
				if ( isset( $matches ) and 0 < count( $matches ) ) {
					// delete optional query string in img src
					$url = preg_replace( '/([^?]+).*/', '\1', $url );
					// delete image dimensions data in img file name, just take base name and extension
					$guid = preg_replace( '/(.+)-\d+x\d+\.(\w+)/', '\1.\2', $url );
					// look up its ID in the db
					$img_id = $wpdb->get_var( $wpdb->prepare( "SELECT `ID` FROM $wpdb->posts WHERE `guid` = '%s'", $guid ) );
					// if it is available take its ID as new thumb id
					if ( $img_id ) {
						// finally we have an id
						$thumb_id = (int) $img_id ;
					}
				} // if $matches
				// stop loop, because we want only the first matching image of a post
				if ( $thumb_id ) {
					break;
				}
			} // foreach( $url )
		} // if $matches
		return $thumb_id;
	}

	/**
	 * Returns the post ids which are assigned with featured images smaller than user given dimensions
	 *
	 * @access   private
	 * @since     2.0
	 * @updated   2.0.2: changed variable name below_max_* to is_below_max_*
	 *
	 * @return    array    the post ids assigned with the to small thumbnail
	 */
	private function get_post_ids_of_to_small_thumbnails() {
		$post_ids = array();
		$relevant_featured_image_ids = array();
		$max_width = $this->selected_image_dimensions[ 'max_width' ];
		$max_height = $this->selected_image_dimensions[ 'max_height' ];
		// get all images used as featured images
		$featured_image_ids = $this->get_featured_image_ids();
		// only use featured images smaller than user given dimensions
		foreach ( $featured_image_ids as $post_thumbnail_id ) {
			// get image of given size
			$arr_image = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
			if ( $arr_image )  {
				$is_below_max_width   = $arr_image[1] < $max_width ? true : false;
				$is_below_max_height  = $arr_image[2] < $max_height ? true : false;
				$is_original = $arr_image[3] ? false : true;
				// set as revelant image if it is not resized (= original) and within user given dimensions
				if  ( $is_original && ( $is_below_max_width || $is_below_max_height ) ) {
					$relevant_featured_image_ids[] = $post_thumbnail_id;
				}
			} // if( image )
		} // foreach()
		// get post ids assigned with the relevant featured image ids
		if ( $relevant_featured_image_ids ) {
			$post_ids = $this->get_post_ids_of_featured_image_ids( $relevant_featured_image_ids );
		}
		// return result
		return $post_ids;
	}

	/**
	 * Returns the post ids which are assigned with the featured images which should be replaced
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   3.1: renamed and rewritten for more than one image
	 *
	 * @return    array    the post ids assigned with the thumbnails
	 */
	private function get_post_ids_of_old_thumbnails() {
		$this->selected_old_image_ids = $this->get_sanitized_array( 'replacement_image_ids', $this->get_featured_image_ids() );
		return $this->get_post_ids_of_featured_image_ids( $this->selected_old_image_ids );
	}

	/**
	 * Returns the post ids which are assigned with the featured image which should be removed
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   7.0: improved performance by changing intval() to (int)
	 *
	 * @return    array    the post ids assigned with the thumbnail
	 */
	private function get_post_ids_of_thumbnail() {
		$post_ids = array();
		global $wpdb;
		// get a normal array all names of meta keys except the WP builtins meta keys beginning with an underscore '_'
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = '_thumbnail_id' AND `meta_value` = %d", $this->selected_image_id ), ARRAY_N );
		// flatten results
		if ( $results ) {
			foreach ( $results as $r ) {
				$post_ids[] = (int) $r[ 0 ] ;
			}
		}
		if ( empty( $post_ids ) ) {
			$post_ids[] = 0; // enter at least one element with no sense to yield 0 results with WP_QUERY()
		}
		return $post_ids;
	}
	
	/**
	 * Returns the post ids of pages which have child pages
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   7.0: improved performance by changing intval() to (int)
	 *
	 * @return    array    the post ids of parent pages
	 */
	private function get_post_ids_of_parent_pages() {
		$post_ids = array();
		global $wpdb;
		// get a normal array all names of meta keys except the WP builtins meta keys beginning with an underscore '_'
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT `post_parent` FROM $wpdb->posts WHERE `post_parent` != 0 AND `post_type` = %s", 'page' ), ARRAY_N );
		// flatten results
		if ( $results ) {
			foreach ( $results as $r ) {
				$post_ids[] = (int) $r[ 0 ] ;
			}
		}
		return $post_ids;
	}
	
	/**
	 * Returns the posts ids which are assigned to given featured image ids
	 *
	 * @access   private
	 * @since     2.0
	 * @updated   2.0.2: revised SQL statement to more general expression with $wpdb
	 * @updated   7.0: improved performance by changing intval() to (int)
	 *
	 * @return    array    the post ids assigned to given featured images
	 */
	private function get_post_ids_of_featured_image_ids( $image_ids = array() ) {
		$post_ids = array();
		global $wpdb;
		// get a normal array with all IDs of posts assigned with the image ids
		foreach ( $image_ids as $id ) {
			$results = $wpdb->get_results( $wpdb->prepare( "SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` = '_thumbnail_id' AND `meta_value` = %d", $id ), ARRAY_N );
			// flatten results
			if ( $results ) {
				foreach ( $results as $r ) {
					$post_ids[] = (int) $r[ 0 ] ;
				}
			}
		} // foreach()
		return $post_ids;
	}

	/**
	 * Returns the thumbnails ids which are assigned with a post
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   2.0: added intval()
	 * @updated   3.1: do not return selected image if it is a featured image
	 * @updated   7.0: improved performance by changing intval() to (int)
 	 *
	 * @return    array    the image ids assigned to posts as featured images
	 */
	private function get_featured_image_ids() {
		$image_ids = array();
		global $wpdb;
		// get a normal array all names of meta keys except the WP builtins meta keys beginning with an underscore '_'
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT `meta_value` FROM $wpdb->postmeta WHERE `meta_key` LIKE '_thumbnail_id' AND `meta_value` != %d", $this->selected_image_id ), ARRAY_N );
		// flatten results
		if ( $results ) {
			foreach ( $results as $r ) {
				$image_ids[] = (int) $r[ 0 ] ;
			}
		}
		return $image_ids;
	}

	/**
	 * Check the step parameter and return safe values
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    string    the name of the step the plugin should take
	 */
	private function get_sanitized_step() {
		return $this->get_sanitized_value(
			'step',
			array_keys( $this->valid_steps ),
			'start'
		);
	}

	/**
	 * Check the action parameter and return safe values 
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated  6.0: added array valid_actions_multiple_images
	 *
	 * @return    string    the name of the action the plugin should perform, else empty string
	 */
	private function get_sanitized_action() {
		return $this->get_sanitized_value(
			'action',
			array_keys( array_merge( $this->valid_actions, $this->valid_actions_without_image, $this->valid_actions_multiple_images ) )
		);
	}

	/**
	 * Check the requested statuses and return safe values 
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    array    the names of the statuses of posts and pages
	 */
	private function get_sanitized_post_statuses() {
		return $this->get_sanitized_array(
			'statuses',
			array_keys( $this->valid_statuses )
		);
	}

	/**
	 * Check the requested filters and return safe values 
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    array    the names of the filters
	 */
	private function get_sanitized_filter_names() {
		return $this->get_sanitized_array(
			'filters',
			array_keys( $this->valid_filters )
		);
	}

	/**
	 * Check the requested options and return safe values 
	 *
	 * @access   private
	 * @since     5.1
	 *
	 * @return    array    the names of the options
	 */
	private function get_sanitized_option_names() {
		return $this->get_sanitized_array(
			'options',
			array_keys( $this->valid_options )
		);
	}

	/**
	 * Check the requested post types and return safe values 
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    array    the names of the selected post types
	 */
	private function get_sanitized_post_types() {
		return $this->get_sanitized_array(
			'post_types',
			array_keys( $this->valid_post_types )
		);
	}

	/**
	 * Check the requested custom post types and return safe values 
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated  3.0: changed get_registered_custom_post_types() to $valid_custom_post_types
	 *
	 * @return    array    the names of the selected custom post types
	 */
	private function get_sanitized_custom_post_types() {
		return $this->get_sanitized_array(
			'custom_post_types',
			$this->valid_custom_post_types
		);
	}

	/**
	 * Check the requested custom taxonomies and return safe values 
	 *
	 * @access   private
	 * @since    3.0
	 *
	 * @return    array    the names of the selected custom taxonomies
	 */
	private function get_sanitized_custom_taxonomies() {
		return $this->get_sanitized_associated_array(
			'custom_taxonomies',
			$this->valid_custom_taxonomies
		);
	}

	/**
	 * Check the requested time or date period and return safe values 
	 *
	 * @access   private
	 * @since     4.0
	 *
	 * @return    array    the names of the user selected date queries
	 */
	private function get_sanitized_date_queries() {
		return $this->get_sanitized_associated_array( 
			'date_queries', 
			$this->valid_date_queries 
		);
	}

	/**
	 * Check the requested custom field operation and return safe values 
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    array    the name of the user selected custom field, the operation and the comparison value
	 */
	private function get_sanitized_custom_field() {
		return $this->get_sanitized_associated_array( 'custom_field', $this->valid_custom_field );
	}

	/**
	 * Check the requested custom field operation and return safe values 
	 *
	 * @access   private
	 * @since     2.0
	 * @updated   4.0: improved performance by changing array_key_exists() to isset()
	 * @updated   7.0: improved performance by changing intval() to absint()
	 *
	 * @return    array    the the user given dimensions of an image
	 */
	private function get_sanitized_image_dimensions() {
		$img_dims = $this->get_sanitized_associated_array( 'image_dimensions', $this->valid_image_dimensions, $this->selected_image_dimensions );
		// cast to positive integers
		foreach ( array_keys( $this->valid_image_dimensions ) as $key ) {
			if ( isset( $img_dims[ $key ] ) ) {
				$img_dims[ $key ] = absint( $img_dims[ $key ]  ); // no 'else' block necessary because of default values setting
			}
		}
		// correct too high or too low values
		foreach ( $img_dims as $key => $value ) {
			if ( $img_dims[ $key ] > $this->max_image_length ) {
				$img_dims[ $key ] = $this->max_image_length;
			} elseif ( $img_dims[ $key ] < $this->min_image_length ) {
				$img_dims[ $key ] = $this->min_image_length;
			}
		}
		return $img_dims;
	}

	/**
	 * Check the parameter defined by key and return safe value
	 * Written to return a single value, e.g. for radio buttons
	 *
	 * @access   private
	 * @since     1.0.0
     * @updated   2.0: faster with isset()
	 *
	 * @return    mixed    the user selected valid value or the default value
	 */
	private function get_sanitized_value( $key, $valid_values, $default_value = null ) {
		$value = isset( $_REQUEST[ $key ] ) ? $_REQUEST[ $key ] : $default_value;
		if ( in_array( $value, $valid_values ) ) {
			return $value;            
		} else {                       
			return $default_value;          
		}                             
	}

	/**
	 * Check the parameter and return safe values 
	 * Written to return multiple values, e.g. for checkboxes
	 *
	 * @access   private
	 * @since     1.0.0
     * @updated   2.0: faster with isset()
	 *
	 * @return    array    the user selected valid values or the default values
	 */
	private function get_sanitized_array( $key, $valid_array, $default_array = array() ) {
		if ( isset( $_REQUEST[ $key ] ) and is_array( $_REQUEST[ $key ] ) ) {
			return $this->get_array_intersect( $_REQUEST[ $key ], $valid_array );
		} else {
			return $default_array;
		}
	}

	/**
	 * Check the parameters and return safe values 
	 * Written to return multiple values associated with key names, e.g. for WP Query
	 * The function filters out empty strings
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   2.0: added check whether array is empty, added isset() to catch empty values (0, "" etc.)
	 *
	 * @return    array    the user selected valid values or the default values
	 */
	private function get_sanitized_associated_array( $key, $valid_array, $default_array = array() ) {
		$queries = array();
		$arr = isset( $_REQUEST[ $key ] ) ? $_REQUEST[ $key ] : $default_array;
		if ( ! empty( $arr ) && is_array( $arr ) ) {
			foreach ( array_keys( $valid_array ) as $key ) {
				if ( array_key_exists( $key, $arr ) and isset( $arr[ $key ] ) ) {
					$queries[ $key ] = $arr[ $key ];
				}
			}
		}
		return $queries;
	}

	/**
	 * Define parameters and return registered custom post types
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   3.1.1: only returns thumbnail supporting types
	 *
	 * @return    array    the names of the registered and thumbnail supporting custom post types
	 */
	private function get_registered_custom_post_types() {
		$args = array(
			   '_builtin' => false # only custom post types
		);
        $thumbnail_supporting_custom_post_types = array();
		// get the registered custom post types as objects
        $cpts = get_post_types( $args, 'names' );
		// consider only thumbnail supporting types
        foreach ( $cpts as $name => $cpt ) {
            if ( post_type_supports( $name, 'thumbnail' ) ) {
                $thumbnail_supporting_custom_post_types[] = $name;
            }
        }
		// return the result
		return $thumbnail_supporting_custom_post_types;
	}

	/**
	 * Define parameters and return thumbnail supporting custom post types
	 *
	 * @access   private
	 * @since     3.1
	 * @updated   3.1.1: only returns thumbnail supporting types
	 *
	 * @return    array    the names and labels of the registered and thumbnail supporting custom post types
	 */
	private function get_custom_post_types_labels() {
		$args = array(
			   '_builtin' => false # only custom post types
		);
        $name_labels = array();
		// get the registered custom post types as objects
        $objects = get_post_types( $args, 'objects' );
		// store their names and labels
        foreach ( $objects as $name => $object ) {
            if ( post_type_supports( $name, 'thumbnail' ) ) {
                $name_labels[ $name ] = $object->label;
            }
        }
		// return the result
		return $name_labels;
	}

	/**
	 * Return registered custom taxonomies
	 *
	 * @access   private
	 * @since    3.0
	 *
	 * @return    array    the names of the registered custom taxonomies
	 */
	private function get_registered_custom_taxonomies() {
		$args = array(
			   '_builtin' => false # only custon post types
		);
		return get_taxonomies( $args, 'names' );
	}

	/**
	 * Return registered custom taxonomies with their labels
	 *
	 * @access   private
	 * @since    3.0
	 *
	 * @return    array    the names of the registered custom taxonomies
	 */
	private function get_custom_taxonomies_labels() {
		$args = array(
			   '_builtin' => false # only custon post types
		);
        $name_labels = array();
		// get the registered custom post types as objects
        $objects = get_taxonomies( $args, 'objects' );
		// store their names and labels
        foreach ( $objects as $name => $object ) {
            $name_labels[ $name ] = $object->label;
        }
		// return the result
		return $name_labels;
	}

	/**
	 * Return registered post dates
	 *
	 * @access   private
	 * @since    4.0
	 *
	 * @return    array    the values of the registered post dates
	 */
	private function get_registered_post_dates() {
		global $wpdb;
		$post_types = implode( "', '", array_merge( array_keys( $this->valid_post_types ), $this->valid_custom_post_types ) );
		$post_statuses = implode( "', '" , array_keys( $this->valid_statuses ) );
		$query = "SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month FROM $wpdb->posts WHERE post_type IN ( '" . $post_types . "' ) AND post_status IN ( '" . $post_statuses . "' ) ORDER BY post_date DESC";
		return $wpdb->get_results( $query );
	}

	/**
	 * Return the intersection of two given arrays
	 * Runs 5 times faster than PHP's array_intersect()
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    array    the intersection of two arrays
	 */
	private function get_array_intersect( $a, $b ) { 
		$m = array(); 
		$intersection = array(); 
		// copy first array to array
		$len = sizeof( $a );
		for( $i = 0; $i < $len; $i++ ) { 
			$m[] = $a[ $i ]; 
		} 
		// append second array to array
		$len = sizeof( $b );
		for( $i = 0; $i < $len; $i++ ) { 
			$m[] = $b[ $i ]; 
		} 
		// make values sorted
		sort( $m ); 
		// compare value with the next one and append to intersection array if equal
		$len = sizeof( $m ) - 1;
		for( $i = 0; $i < $len; $i++ ) { 
			if ( $m[ $i ] == $m[ $i + 1 ] ) $intersection[] = $m[ $i ]; 
		} 
		// return intersection
		return $intersection; 
	}
	
	/**
	 * Check the integer value of a user selected value else default value
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   2.0: added abs(), added sanitize_text_field(), faster with isset()
	 * @updated   3.0: added check for values less than 0
	 * @updated   7.0: improved performance by changing intval() to absint()
	 *
	 * @return    integer    the id or 0
	 */
	private function get_sanitized_id( $key, $default = 0 ) {
		if ( ( ! isset( $_REQUEST[ $key ] ) ) or empty( $_REQUEST[ $key ] ) or 0 > (int) $_REQUEST[ $key ]  ) {
			return $default;
		} else {
			return absint( sanitize_text_field( $_REQUEST[ $key ]  ) );
		}
	}
	
	/**
	 * Check the id of selected featured image and return safe value
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    integer    the id or 0
	 */
	private function get_sanitized_image_id() {
		return $this->get_sanitized_id( 'image_id' );
	}
	
	/**
	 * Check the ids of selected featured images and return safe value
	 *
	 * @access   private
	 * @since     6.0
	 *
	 * @return    array    the ids or empty
	 */
	private function get_sanitized_multiple_image_ids() {
		if ( ! isset( $_REQUEST[ 'multiple_image_ids' ] ) or empty( $_REQUEST[ 'multiple_image_ids' ] ) ) {
			return array();
		} else {
			// read: sanatize string, make array out of string, convert each array value to integer, return result array
			return array_map( 'intval', explode( ',', sanitize_text_field( $_REQUEST[ 'multiple_image_ids' ] ) ) );
		}
	}
	
	/**
	 * Check the id of selected page and return safe value
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    integer    the id or 0
	 */
	private function get_sanitized_page_id() {
		return $this->get_sanitized_id( 'page_id' );
	}
	
	/**
	 * Check the id of selected author and return safe value
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    integer    the id or 0
	 */
	private function get_sanitized_author_id() {
		return $this->get_sanitized_id( 'author_id' );
	}
	
	/**
	 * Check the id of selected tag and return safe value
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    integer    the id or 0
	 */
	private function get_sanitized_tag_id() {
		return $this->get_sanitized_id( 'tag_id' );
	}
	
	/**
	 * Check the id of selected category and return safe value
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    integer    the id or 0
	 */
	private function get_sanitized_category_id() {
		return $this->get_sanitized_id( 'category_id' );
	}
	
	/**
	 * Check the user selected search term and return safe value
	 *
	 * @access   private
	 * @since     1.0.0
	 * @updated   2.0: added sanitize_text_field(), faster with isset()
	 *
	 * @return    string    the search term
	 */
	private function get_search_term() {
		if ( ! isset( $_REQUEST[ 'search_term' ] ) or empty( $_REQUEST[ 'search_term' ] ) ) {
			return '';
		} else {
			return sanitize_text_field( $_REQUEST[ 'search_term' ] );
		}
	}
	
	/**
	 * If results in array, return them, else say query something like "no results in array"
	 *
	 * @access   private
	 * @since     2.0
	 *
	 * @return    array    Array with content or 0
	 */
	private function get_id_array_for_query( $arr ) {
		if ( empty( $arr ) ) {
			return array( 0 );
		} else {
			return $arr;
		}
	}
	
	/**
	 * Look in the DB for custom field names and return them
	 *
	 * @access   private
	 * @since     1.0.0
	 *
	 * @return    array    the custom field names
	 */
	private function get_custom_field_keys() {
		global $wpdb;
		$key = 'meta_key';
		$custom_fields = array();
		// get a normal array all names of meta keys except the WP builtins meta keys beginning with an underscore '_'
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT %s FROM $wpdb->postmeta WHERE %s NOT REGEXP '^_' ORDER BY %s", $key, $key, $key ), ARRAY_N );
		// flatten results
		if ( $results ) {
			foreach ( $results as $r ) {
				$custom_fields[] = $r[ 0 ];
			}
		}
		// return array
		return $custom_fields;
	}
	
	/**
	 * Returns the url of the plugin's admin part
	 *
	 * @since    1.0.0
	 */
	public function get_plugin_admin_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Returns the url of the plugin's images folder without an trailing slash	
	 *
	 * @since    1.0.0
	 */
	public function get_admin_images_url() {
		return sprintf( '%s/assets/images', $this->get_plugin_admin_url() );
	}
	
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

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
		return __( 'Set, replace, remove', $this->plugin_slug );
	}

	/**
	 * Return the page description.
	 *
	 * @since    8.0
	 *
	 *@return    page description variable.
	 */
	public function get_page_description() {
		return __( 'Bulk set, replace and remove featured images for existing posts', $this->plugin_slug );
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
	 * @since     1.0.0
	 * @updated   7.0: alter version variable
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
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), $this->plugin_version );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 * @updated   7.0: alter version variable
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), $this->plugin_version );
		}

		/*
		 * Enqueue all stuff to use media API
		 *
		 * requires at least WP 3.5
		 */
		wp_enqueue_media();
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
		
		/*
		 * Add the top level menu page of this plugin
		 *
		 */
		//$this->plugin_screen_hook_suffix = add_object_page(...);
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
	 * Add a "Bulk set" link to the media row actions
	 *
	 * @since    4.1
	 */
	function add_media_row_action( $actions, $post ) {

		// if current media is not an image or user has not the right or thumbnails are not supported return without change
		if ( 'image/' != substr( $post->post_mime_type, 0, 6 ) || ! current_user_can( $this->required_user_cap ) || ! current_theme_supports( 'post-thumbnails' ) )
			return $actions;
		
		// else build the link with nonce
		$url = wp_nonce_url( admin_url( sprintf( 'admin.php?page=%s&step=select&action=assign&image_id=%d', $this->page_slug, $post->ID ) ), 'bulk-assign' );
		
		// add it
		$actions['quick-featured-images'] = sprintf( '<a href="%s">%s</a>', esc_url( $url ), __( 'Bulk set as featured image', 'quick-featured-images' ) );
		
		// return extended action links list
		return $actions;
	}

}
