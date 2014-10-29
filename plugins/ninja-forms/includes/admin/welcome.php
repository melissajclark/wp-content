<?php
/**
 * About Page Class
 *
 * @package     NF
 * @subpackage  Admin/Welcome
 * @copyright   Copyright (c) 2014, WP Ninjas
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.7
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * NF_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.4
 */
class NF_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';
	public $display_version = NF_PLUGIN_VERSION;
	public $header_text;
	public $header_desc;

	/**
	 * Get things started
	 *
	 * @since 1.4
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );

		$this->header_text = sprintf( __( 'Welcome to Ninja Forms %s', 'ninja-forms' ), $this->display_version );
		$this->header_desc = sprintf( __( 'Thank you for updating to the latest version! Ninja Forms %s brings you unprecedented control over your notifications in a form creation plugin!', 'ninja-forms' ), $this->display_version );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_menus() {
		// About Page
		add_dashboard_page(
			__( 'Welcome to Ninja Forms', 'ninja-forms' ),
			__( 'Welcome to Ninja Forms', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-about',
			array( $this, 'about_screen' )
		);

		// Changelog Page
		add_dashboard_page(
			__( 'Ninja Forms Changelog', 'ninja-forms' ),
			__( 'Ninja Forms Changelog', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-changelog',
			array( $this, 'changelog_screen' )
		);

		// Getting Started Page
		add_dashboard_page(
			__( 'Getting started with Ninja Forms', 'ninja-forms' ),
			__( 'Getting started with Ninja Forms', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-getting-started',
			array( $this, 'getting_started_screen' )
		);

		// Credits Page
		add_dashboard_page(
			__( 'The people who build Ninja Forms', 'ninja-forms' ),
			__( 'The people who build Ninja Forms', 'ninja-forms' ),
			$this->minimum_capability,
			'nf-credits',
			array( $this, 'credits_screen' )
		);
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'nf-about' );
		remove_submenu_page( 'index.php', 'nf-changelog' );
		remove_submenu_page( 'index.php', 'nf-getting-started' );
		remove_submenu_page( 'index.php', 'nf-credits' );

		// Badge for welcome page
		$badge_url = NF_PLUGIN_URL . 'assets/images/nf-badge.png';
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.nf-badge {
			padding-top: 125px;
			height: 52px;
			width: 185px;
			color: #fff;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.about-wrap .nf-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.nf-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}

		.about-wrap .feature-section {
			margin-top: 20px;
		}

		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Navigation tabs
	 *
	 * @access public
	 * @since 1.9
	 * @return void
	 */
	public function tabs() {
		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'nf-about';
		?>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'nf-about' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-about' ), 'index.php' ) ) ); ?>">
				<?php _e( "What's New", 'ninja-forms' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'nf-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-getting-started' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Getting Started', 'ninja-forms' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'nf-credits' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-credits' ), 'index.php' ) ) ); ?>">
				<?php _e( 'Credits', 'ninja-forms' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function about_screen() {
		?>
		<div class="wrap about-wrap">
			<h1><?php echo $this->header_text; ?></h1>
			<div class="about-text"><?php echo $this->header_desc; ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $this->display_version ); ?></div>

			<?php $this->tabs(); ?>

			<div class="changelog">

				<div class="about-overview">
					<iframe width="640" height="360" src="//www.youtube.com/embed/LeXxZn0aPlo" frameborder="0" allowfullscreen></iframe>
				</div>
				<h2 class="about-headline-callout"><?php _e( 'A more powerful and flexible notification system', 'ninja-forms' );?></h2>

				<div class="feature-section col two-col">

					<div class="col-1">
						<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/ss-noti-view.png'; ?>">
						<h4><?php _e( 'Unlimited notifications', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Create as many notifications (Email, Success Message, Redirect) as you like for each of your Ninja Forms.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

					<div class="col-2 last-feature">
						<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/ss-noti-create.gif'; ?>">
						<h4><?php _e( 'Easy notification creation', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'All relevant notification settings on one page. Easily fill these settings with submitted data.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

				</div>

				<hr />

				<div class="feature-section col three-col">

					<div class="col-1">
						<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/ss-noti-deactivate.png'; ?>">
						<h4><?php _e( 'Activate or deactivate notifications', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Easily activate or deactivate notifications, depending on your current needs.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

					<div class="col-2">
						<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/ss-noti-filter.png'; ?>">
						<h4><?php _e( 'Filter notifications by type', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Easily filter long lists of notifications by a specified type to find just the one you\'re looking for.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

					<div class="col-3 last-feature">
						<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/ss-noti-duplicate.png'; ?>">
						<h4><?php _e( 'Duplicate notifications', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Duplicate notifications and change settings to quickly create similar notifications.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

				</div>

				<hr />

				<div class="feature-section col two-col">

					<div class="col-1">
						<h4><?php _e( 'More to come', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'This update is just the beginning; the future will bring even more improvements to the notification system. We have plans to add "global" notifications that can be used across multiple forms. Also be on the look out for Ninja Forms extesions to make notifications even more powerful.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

					<div class="col-2 last-feature">
						<h4><?php _e( 'Notification documentation', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'To get you started, we\'ve already added documentation on the new notifications feature. If you still have questions you can always contact the Ninja Forms support team.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
						<p>
							<a href="<?php echo esc_url( 'http://ninjaforms.com/documentation/using-ninja-forms/creating-new-notification/' ); ?>"><?php _e( 'Notification Documentation', 'ninja-forms' ); ?></a> &middot;
							<a href="<?php echo esc_url( 'http://ninjaforms.com/contact/' ); ?>"><?php _e( 'Get Support', 'ninja-forms' ); ?></a>
						</p>
					</div>

				</div>

			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( 'index.php?page=ninja-forms' ) ); ?>"><?php _e( 'Return to Ninja Forms', 'ninja-forms' ); ?></a> &middot;
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'nf-changelog' ), 'index.php' ) ) ); ?>"><?php _e( 'View the Full Changelog', 'ninja-forms' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Changelog Screen
	 *
	 * @access public
	 * @since 2.0.3
	 * @return void
	 */
	public function changelog_screen() {
		list( $display_version ) = explode( '-', NF_PLUGIN_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php echo $this->header_text; ?></h1>
			<div class="about-text"><?php echo $this->header_desc; ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $this->display_version ); ?></div>

			<?php $this->tabs(); ?>

			<div class="changelog">
				<h3><?php _e( 'Full Changelog', 'ninja-forms' );?></h3>

				<div class="feature-section">
					<?php echo $this->parse_readme(); ?>
				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( 'index.php?page=ninja-forms' ) ); ?>"><?php _e( 'Go to Ninja Forms', 'ninja-forms' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Getting Started Screen
	 *
	 * @access public
	 * @since 1.9
	 * @return void
	 */
	public function getting_started_screen() {
		list( $display_version ) = explode( '-', NF_PLUGIN_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php echo $this->header_text; ?></h1>
			<div class="about-text"><?php echo $this->header_desc; ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $this->display_version ); ?></div>

			<?php $this->tabs(); ?>

			<p class="about-description"><?php _e( 'Use the tips below to get started using Ninja Forms. You will be up and running in no time!', 'ninja-forms' ); ?></p>

			<div class="changelog">
				<h3><?php _e( 'Creating Your First Form', 'ninja-forms' );?></h3>

				<div class="feature-section">

					<img src="<?php echo NF_PLUGIN_URL . 'assets/images/screenshots/ss-new-form.png'; ?>" class="nf-welcome-screenshots">

					<h4><?php printf( __( '<a href="%s">Forms &rarr; Add New</a>', 'ninja-forms' ), admin_url( 'admin.php?page=ninja-forms&tab=form_settings&form_id=new' ) ); ?></h4>
					<p><?php _e( 'The Forms menu is your access point for all aspects of your Ninja Forms creation and setup. We\'ve already created your first form for you so you can use that as an example or create your own, simply click Add New and start with your Forms Settings.', 'ninja-forms' ); ?></p>

					<h4><?php _e( 'Form Settings', 'ninja-forms' );?></h4>
					<p><?php _e( 'The Form Settings tab is where you will configure all the options that pertain to the specific form you are editing. Everything about how your form behaves is handled here.', 'ninja-forms' );?></p>

					<h4><?php _e( 'Field Settings', 'ninja-forms' );?></h4>
					<p><?php _e( 'The Field Settings tab is where you will actually build your form by adding fields and placing them in the order you want them to appear with a simple drag and drop method. Each field will have an assortment of avaialble options that are either general for all fields or specific to that field type.', 'ninja-forms' );?></p>

				</div>

			</div>

			<hr />

			<div class="changelog">
				<h3><?php _e( 'Displaying Your Form', 'ninja-forms' );?></h3>

				<div class="feature-section col two-col">

					<div class="col-1">
						<h4><?php _e( 'Append to Page', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Under Basic Form Behavior in the Form Settings you can easily select a page that you would like the form automatically appended to the end of that page\'s content. A similiar option is avaiable in every content edit screen in it\'s sidebar.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

					<div class="col-2 last-feature">
						<h4><?php _e( 'Shortcode', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Place [ninja_forms_display_form id=1] in any area that accepts shortcodes to display your form anywhere you like. Even in the middle of your page or posts content.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

				</div>

				<div class="feature-section col two-col">

					<div class="col-1">
						<h4><?php _e( 'Ninja Forms Widget', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Ninja Forms provides a widget that you can place in any widgetized area of your site and select exactly which form you would like displayed in tat space.', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

					<div class="col-2 last-feature">
						<h4><?php _e( 'Template Function', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'Ninja Forms also comes with a simple template function that can be places directly into a php template file. <code>if( function_exists( \'ninja_forms_display_form\' ) ){ ninja_forms_display_form( 1 ); }</code>', 'ninja-forms' ), admin_url( 'edit.php?post_type=download&page=nf-settings&tab=misc' ) ); ?></p>
					</div>

				</div>

			</div>

			<hr />

			<div class="changelog">
				<h3><?php _e( 'Need Help?', 'ninja-forms' );?></h3>

				<div class="feature-section col two-col">

					<div class="col-1">
						<h4><?php _e( 'Growing Documentation', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'We have all kinds of documentation available covering everything from <a href="%s">Troubleshooting</a> to our <a href="%s">Devloper API</a>. New Documents be added every day.', 'ninja-forms' ), 'http://ninjaforms.com/documentation/using-ninja-forms/faq-troubleshooting/', 'http://ninjaforms.com/documentation/developer-api/' ); ?></p>
					</div>

					<div class="col-2 last-feature">
						<h4><?php _e( 'Best Support in the Business', 'ninja-forms' );?></h4>
						<p><?php printf( __( 'We do our very best to provide every Ninja Forms user with the best support possible. If you encounter a problem or have a question, <a href="%s">please contact us</a>.', 'ninja-forms' ), 'http://ninjaforms.com/contact/' ); ?></p>
					</div>

				</div>

			</div>
		</div>
		<?php
	}

	/**
	 * Render Credits Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function credits_screen() {
		list( $display_version ) = explode( '-', NF_PLUGIN_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Ninja Forms %s', 'ninja-forms' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Ninja Forms %s is primed to make your experience managing submissions an enjoyable one!', 'ninja-forms' ), $display_version ); ?></div>
			<div class="nf-badge"><?php printf( __( 'Version %s', 'ninja-forms' ), $display_version ); ?></div>

			<?php $this->tabs(); ?>

			<p class="about-description"><?php _e( 'Ninja Forms is created by a worldwide team of developers who aim to provide the #1 WordPress community form creation plugin.', 'ninja-forms' ); ?></p>

			<?php echo $this->contributors(); ?>
		</div>
		<?php
	}


	/**
	 * Parse the NF readme.txt file
	 *
	 * @since 2.0.3
	 * @return string $readme HTML formatted readme file
	 */
	public function parse_readme() {
		$file = file_exists( NF_PLUGIN_DIR . 'readme.txt' ) ? NF_PLUGIN_DIR . 'readme.txt' : null;

		if ( ! $file ) {
			$readme = '<p>' . __( 'No valid changlog was found.', 'ninja-forms' ) . '</p>';
		} else {
			$readme = file_get_contents( $file );
			$readme = nl2br( esc_html( $readme ) );

			$readme = end( explode( '== Changelog ==', $readme ) );

			$readme = preg_replace( '/`(.*?)`/', '<code>\\1</code>', $readme );
			$readme = preg_replace( '/[\040]\*\*(.*?)\*\*/', ' <strong>\\1</strong>', $readme );
			$readme = preg_replace( '/[\040]\*(.*?)\*/', ' <em>\\1</em>', $readme );
			$readme = preg_replace( '/= (.*?) =/', '<h4>\\1</h4>', $readme );
			$readme = preg_replace( '/\[(.*?)\]\((.*?)\)/', '<a href="\\2">\\1</a>', $readme );
		}

		return $readme;
	}


	/**
	 * Render Contributors List
	 *
	 * @since 1.4
	 * @uses NF_Welcome::get_contributors()
	 * @return string $contributor_list HTML formatted list of all the contributors for NF
	 */
	public function contributors() {
		$contributors = $this->get_contributors();

		if ( empty( $contributors ) )
			return '';

		$contributor_list = '<ul class="wp-people-group">';

		foreach ( $contributors as $contributor ) {
			$contributor_list .= '<li class="wp-person">';
			$contributor_list .= sprintf( '<a href="%s" title="%s">',
				esc_url( 'https://github.com/' . $contributor->login ),
				esc_html( sprintf( __( 'View %s', 'ninja-forms' ), $contributor->login ) )
			);
			$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= '</li>';
		}

		$contributor_list .= '</ul>';

		return $contributor_list;
	}

	/**
	 * Retreive list of contributors from GitHub.
	 *
	 * @access public
	 * @since 1.4
	 * @return array $contributors List of contributors
	 */
	public function get_contributors() {
		$contributors = get_transient( 'nf_contributors' );

		if ( false !== $contributors )
			return $contributors;

		$response = wp_remote_get( 'https://api.github.com/repos/wpninjas/ninja-forms/contributors', array( 'sslverify' => false ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )
			return array();

		$contributors = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! is_array( $contributors ) )
			return array();

		set_transient( 'nf_contributors', $contributors, 3600 );

		return $contributors;
	}

	/**
	 * Sends user to the Welcome page on first activation of NF as well as each
	 * time NF is upgraded to a new version
	 *
	 * @access public
	 * @since 1.4
	 * @global $nf_options Array of all the NF Options
	 * @return void
	 */
	public function welcome() {
		global $nf_options;

		// Bail if no activation redirect
		if ( ! get_transient( '_nf_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_nf_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		$upgrade = get_option( 'nf_version_upgraded_from' );

		if( ! $upgrade ) { // First time install
			wp_safe_redirect( admin_url( 'index.php?page=nf-getting-started' ) ); exit;
		} else { // Update
			wp_safe_redirect( admin_url( 'index.php?page=nf-about' ) ); exit;
		}
	}
}
new NF_Welcome();
