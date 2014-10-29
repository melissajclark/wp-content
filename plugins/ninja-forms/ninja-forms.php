<?php
/*
Plugin Name: Ninja Forms
Plugin URI: http://ninjaforms.com/
Description: Ninja Forms is a webform builder with unparalleled ease of use and features.
Version: 2.8.6
Author: The WP Ninjas
Author URI: http://ninjaforms.com
Text Domain: ninja-forms
Domain Path: /lang/

Copyright 2011 WP Ninjas/Kevin Stover.


This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Ninja Forms also uses the following jQuery plugins. Their licenses can be found in their respective files.

	jQuery TipTip Tooltip v1.3
	code.drewwilson.com/entry/tiptip-jquery-plugin
	www.drewwilson.com
	Copyright 2010 Drew Wilson

	jQuery MaskedInput v.1.3.1
	http://digitalbush.co
	Copyright (c) 2007-2011 Josh Bush

	jQuery Tablesorter Plugin v.2.0.5
	http://tablesorter.com
	Copyright (c) Christian Bach 2012

	jQuery AutoNumeric Plugin v.1.9.15
	http://www.decorplanit.com/plugin/
	By: Bob Knothe And okolov Yura aka funny_falcon

	word-and-character-counter.js
	v2.4 (c) Wilkins Fernandez

*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

class Ninja_Forms {

	/**
	 * @var Ninja_Forms
	 * @since 2.7
	 */
	private static $instance;

	/**
	 * @var registered_notification_types
	 */
	var $notification_types = array();

	/**
	 * Main Ninja_Forms Instance
	 *
	 * Insures that only one instance of Ninja_Forms exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 2.7
	 * @static
	 * @staticvar array $instance
	 * @return The highlander Ninja_Forms
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Ninja_Forms ) ) {
			self::$instance = new Ninja_Forms;
			self::$instance->setup_constants();
			self::$instance->includes();

			// Start our submissions custom post type class
			self::$instance->subs_cpt = new NF_Subs_CPT();

			// Add our registration class object
			self::$instance->register = new NF_Register();

			register_activation_hook( __FILE__, 'ninja_forms_activation' );
			add_action( 'plugins_loaded', array( self::$instance, 'load_lang' ) );
			add_action( 'init', array( self::$instance, 'set_transient_id'), 1 );
			add_action( 'init', array( self::$instance, 'init' ), 5 );
			add_action( 'admin_init', array( self::$instance, 'admin_init' ), 5 );
		}

		return self::$instance;
	}

	/**
	 * Run all of our plugin stuff on init.
	 * This allows filters and actions to be used by third-party classes.
	 * 
	 * @since 2.7
	 * @return void
	 */
	public function init() {
		// The subs variable won't be interacted with directly.
		// Instead, the subs() methods will act as wrappers for it.
		self::$instance->subs = new NF_Subs();

		// Get our notifications up and running.
		self::$instance->notifications = new NF_Notifications();

		// Get our step processor up and running.
		// We only need this in the admin.
		if ( is_admin() ) {
			self::$instance->step_processing = new NF_Step_Processing();
			self::$instance->download_all_subs = new NF_Download_All_Subs();
			self::$instance->convert_notifications = new NF_Convert_Notifications();
			self::$instance->update_email_settings = new NF_Update_Email_Settings();
		}

		// Fire our Ninja Forms init filter.
		// This will allow other plugins to register items to the instance.
		do_action( 'nf_init', self::$instance );
	}

	/**
	 * Run all of our plugin stuff on admin init.
	 * 
	 * @since 2.7.4
	 * @return void
	 */
	public function admin_init() {
		// Check and update our version number.
		self::$instance->update_version_number();
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 2.7
	 * @access protected
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ninja-forms' ), '2.8' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 2.7
	 * @access protected
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'ninja-forms' ), '2.8' );
	}

	/**
	 * Function that acts as a wrapper for our individual notification objects.
	 * It checks to see if an object exists for this notification id.
	 * If it does, it returns that object. Otherwise, it creates a new one and returns it.
	 * 
	 * @access public
	 * @param int $n_id
	 * @since 2.8
	 * @return object self::$instance->$n_var
	 */
	public function notification( $n_id = '' ) {
		// Bail if we don't get a notification id.
		if ( '' == $n_id )
			return false;

		$n_var = 'notification_' . $n_id;
		// Check to see if an object for this notification already exists.
		// Create one if it doesn't exist.
		if ( ! isset ( self::$instance->$n_var ) )
			self::$instance->$n_var = new NF_Notification( $n_id );

		return self::$instance->$n_var;
	}

	/**
	 * Function that acts as a wrapper for our individual sub objects.
	 * It checks to see if an object exists for this sub id.
	 * If it does, it returns that object. Otherwise, it creates a new one and returns it.
	 * 
	 * @access public
	 * @param int $sub_id
	 * @since 2.7
	 * @return object self::$instance->$sub_var
	 */
	public function sub( $sub_id = '' ) {
		// Bail if we don't get a sub id.
		if ( $sub_id == '' )
			return false;
		
		$sub_var = 'sub_' . $sub_id;
		// Check to see if an object for this sub already exists.
		// Create one if it doesn't exist.
		if ( ! isset( self::$instance->$sub_var ) )
			self::$instance->$sub_var = new NF_Sub( $sub_id );

		return self::$instance->$sub_var;
	}

	/**
	 * Function that acts as a wrapper for our subs_var - NF_Subs() class.
	 * It doesn't set a sub_id and can be used to interact with methods that affect mulitple submissions
	 * 
	 * @access public
	 * @since 2.7
	 * @return object self::$instance->subs_var
	 */
	public function subs() {
		return self::$instance->subs;
	}

	/**
	 * Function that acts as a wrapper for our form_var - NF_Form() class.
	 * It sets the form_id and then returns the instance, which is now using the
	 * proper form id
	 * 
	 * @access public
	 * @param int $form_id
	 * @since 2.7
	 * @return object self::$instance->form_var
	 */
	public function form( $form_id = '' ) {
		// Bail if we don't get a form id.
		if ( $form_id == '' )
			return false;
		
		$form_var = 'form_' . $form_id;
		// Check to see if an object for this form already exists
		// Create one if it doesn't exist.
		if ( ! isset( self::$instance->$form_var ) )
			self::$instance->$form_var = new NF_Form( $form_id );

		return self::$instance->$form_var;
	}

	/**
	 * Setup plugin constants
	 *
	 * @access private
	 * @since 2.7
	 * @return void
	 */
	private function setup_constants() {
		global $wpdb;

		// Plugin version
		if ( ! defined( 'NF_PLUGIN_VERSION' ) )
			define( 'NF_PLUGIN_VERSION', '2.8.6' );

		// Plugin Folder Path
		if ( ! defined( 'NF_PLUGIN_DIR' ) )
			define( 'NF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL
		if ( ! defined( 'NF_PLUGIN_URL' ) )
			define( 'NF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File
		if ( ! defined( 'NF_PLUGIN_FILE' ) )
			define( 'NF_PLUGIN_FILE', __FILE__ );

		// Objects table name
		if ( ! defined( 'NF_OBJECTS_TABLE_NAME') )
			define( 'NF_OBJECTS_TABLE_NAME', $wpdb->prefix . 'nf_objects' );

		// Meta table name
		if ( ! defined( 'NF_OBJECT_META_TABLE_NAME' ) )
			define( 'NF_OBJECT_META_TABLE_NAME', $wpdb->prefix . 'nf_objectmeta' );

		// Relationships table name
		if ( ! defined( 'NF_OBJECT_RELATIONSHIPS_TABLE_NAME' ) )
			define( 'NF_OBJECT_RELATIONSHIPS_TABLE_NAME', $wpdb->prefix . 'nf_relationships' );

		/* Legacy Definitions */

		// Ninja Forms debug mode
		if ( ! defined( 'NINJA_FORMS_JS_DEBUG' ) )
			define( 'NINJA_FORMS_JS_DEBUG', false );

		// Ninja Forms plugin directory
		if ( ! defined( 'NINJA_FORMS_DIR' ) )
			define( 'NINJA_FORMS_DIR', NF_PLUGIN_DIR );
		
		// Ninja Forms plugin url
		if ( ! defined( 'NINJA_FORMS_URL' ) )
			define( 'NINJA_FORMS_URL', NF_PLUGIN_URL );

		// Ninja Forms Version
		if ( ! defined( 'NINJA_FORMS_VERSION' ) )
			define( 'NINJA_FORMS_VERSION', NF_PLUGIN_VERSION );

		// Ninja Forms table name
		if ( ! defined( 'NINJA_FORMS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_TABLE_NAME', $wpdb->prefix . 'ninja_forms' );

		// Fields table name
		if ( ! defined( 'NINJA_FORMS_FIELDS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_FIELDS_TABLE_NAME', $wpdb->prefix . 'ninja_forms_fields' );

		// Fav fields table name
		if ( ! defined( 'NINJA_FORMS_FAV_FIELDS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_FAV_FIELDS_TABLE_NAME', $wpdb->prefix . 'ninja_forms_fav_fields' );

		// Subs table name
		if ( ! defined( 'NINJA_FORMS_SUBS_TABLE_NAME' ) )
			define( 'NINJA_FORMS_SUBS_TABLE_NAME', $wpdb->prefix . 'ninja_forms_subs' );
	}

	/**
	 * Include our Class files
	 *
	 * @access private
	 * @since 2.7
	 * @return void
	 */
	private function includes() {
		// Include our sub object.
		require_once( NF_PLUGIN_DIR . 'classes/sub.php' );
		// Include our subs object.
		require_once( NF_PLUGIN_DIR . 'classes/subs.php' );
		// Include our subs CPT.
		require_once( NF_PLUGIN_DIR . 'classes/subs-cpt.php' );
		// Include our form object.
		require_once( NF_PLUGIN_DIR . 'classes/form.php' );
		// Include our field, notification, and sidebar registration class.
		require_once( NF_PLUGIN_DIR . 'classes/register.php' );
		// Include our 'nf_action' watcher.
		require_once( NF_PLUGIN_DIR . 'includes/actions.php' );
		// Include our single notification object
		require_once( NF_PLUGIN_DIR . 'classes/notification.php' );
		// Include our notifications object
		require_once( NF_PLUGIN_DIR . 'classes/notifications.php' );
		// Include our notification table object
		require_once( NF_PLUGIN_DIR . 'classes/notifications-table.php' );
		// Include our base notification type
		require_once( NF_PLUGIN_DIR . 'classes/notification-base-type.php' );

		if ( is_admin () ) {
			// Include our step processing stuff if we're in the admin.
			require_once( NF_PLUGIN_DIR . 'includes/admin/step-processing.php' );
			require_once( NF_PLUGIN_DIR . 'classes/step-processing.php' );


			// Include our download all submissions php files
			require_once( NF_PLUGIN_DIR . 'classes/download-all-subs.php' );
			require_once( NF_PLUGIN_DIR . 'includes/admin/upgrades/convert-notifications.php' );
			require_once( NF_PLUGIN_DIR . 'includes/admin/upgrades/update-email-settings.php' );
			require_once( NF_PLUGIN_DIR . 'includes/admin/upgrades/upgrade-functions.php' );
			require_once( NF_PLUGIN_DIR . 'includes/admin/upgrades/convert-subs.php' );
			require_once( NF_PLUGIN_DIR . 'includes/admin/upgrades/upgrades.php' );
		}

		// Include our upgrade files.
		require_once( NF_PLUGIN_DIR . 'includes/admin/welcome.php' );


		// Include deprecated functions and filters.
		require_once( NF_PLUGIN_DIR . 'includes/deprecated.php' );

		/* Legacy includes */
		
		/* Require Core Files */
		require_once( NINJA_FORMS_DIR . "/includes/ninja-settings.php" );
		require_once( NINJA_FORMS_DIR . "/includes/database.php" );
		require_once( NINJA_FORMS_DIR . "/includes/functions.php" );
		require_once( NINJA_FORMS_DIR . "/includes/activation.php" );
		require_once( NINJA_FORMS_DIR . "/includes/register.php" );
		require_once( NINJA_FORMS_DIR . "/includes/shortcode.php" );
		require_once( NINJA_FORMS_DIR . "/includes/widget.php" );
		require_once( NINJA_FORMS_DIR . "/includes/field-type-groups.php" );
		require_once( NINJA_FORMS_DIR . "/includes/eos.class.php" );
		require_once( NINJA_FORMS_DIR . "/includes/from-setting-check.php" );
		require_once( NINJA_FORMS_DIR . "/includes/reply-to-check.php" );
		require_once( NINJA_FORMS_DIR . "/includes/import-export.php" );

		require_once( NINJA_FORMS_DIR . "/includes/display/scripts.php" );

		// Include Processing Functions if a form has been submitted.
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/class-ninja-forms-processing.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/class-display-loading.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/pre-process.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/process.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/post-process.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/save-sub.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/filter-msgs.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/fields-pre-process.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/fields-process.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/fields-post-process.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/processing/req-fields-pre-process.php" );

		//Display Form Functions
		require_once( NINJA_FORMS_DIR . "/includes/display/form/display-form.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/display-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/response-message.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/label.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/help.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/desc.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/form-title.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/field-error-message.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/form-wrap.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/form-cont.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/fields-wrap.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/required-label.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/open-form-tag.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/close-form-tag.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/hidden-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/form-visibility.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/sub-limit.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/form/nonce.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/restore-progress.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/inside-label-hidden.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/field-type.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/default-value-filter.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/calc-field-class.php" );
		require_once( NINJA_FORMS_DIR . "/includes/display/fields/clear-complete.php" );


		//Require EDD autoupdate file
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// load our custom updater if it doesn't already exist
			require_once(NINJA_FORMS_DIR."/includes/EDD_SL_Plugin_Updater.php");
		}

		require_once( NINJA_FORMS_DIR . "/includes/class-extension-updater.php" );

		require_once( NINJA_FORMS_DIR . "/includes/admin/scripts.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/sidebar.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/tabs.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/post-metabox.php" );

		require_once( NINJA_FORMS_DIR . "/includes/admin/ajax.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/admin.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/sidebar-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/display-screen-options.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/register-screen-options.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/register-screen-help.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/output-tab-metabox.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/form-preview.php" );

		//Edit Field Functions
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/edit-field.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/label.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/hr.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/req.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/custom-class.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/help.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/desc.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/li.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/remove-button.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/save-button.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/calc.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/user-info-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/post-meta-values.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/input-limit.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/edit-field/sub-settings.php" );

		/* * * * ninja-forms - Main Form Editing Page

		/* Tabs */

		/* Form List */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/form-list/form-list.php" );

		/* Form Settings */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/form-settings/form-settings.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/form-settings/help.php" );

		/* Field Settings */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/field-settings.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/empty-rte.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/edit-field-ul.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/help.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/sidebars/def-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/sidebars/fav-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/sidebars/template-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/sidebars/layout-fields.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/sidebars/user-info.php" );
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/field-settings/sidebars/payment-fields.php" );

		/* Form Preview */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms/tabs/form-preview/form-preview.php" );


		/* * * * ninja-forms-settings - Settings Page

		/* Tabs */

		/* General Settings */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-settings/tabs/general-settings/general-settings.php" );

		/* Favorite Field Settings */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-settings/tabs/favorite-fields/favorite-fields.php" );

		/* Label Settings */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-settings/tabs/label-settings/label-settings.php" );

		/* Ajax Settings */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-settings/tabs/ajax-settings/ajax-settings.php" );

		/* License Settings */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-settings/tabs/license-settings/license-settings.php" );


		/* * * * ninja-forms-impexp - Import / Export Page

		/* Tabs */

		/* Import / Export Forms */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-impexp/tabs/impexp-forms/impexp-forms.php" );

		/* Import / Export Fields */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-impexp/tabs/impexp-fields/impexp-fields.php" );

		/* Import / Export Submissions */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-impexp/tabs/impexp-subs/impexp-subs.php" );

		/* Backup / Restore */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-impexp/tabs/impexp-backup/impexp-backup.php" );

		/* * * * ninja-forms-subs - Submissions Review Page

		/* Tabs */

		/* * * ninja-forms-addons - Addons Manager Page

		/* Tabs */

		/* Manage Addons */
		require_once( NINJA_FORMS_DIR . "/includes/admin/pages/ninja-forms-addons/tabs/addons/addons.php" );

		/* System Status */
		require_once( NINJA_FORMS_DIR . "/includes/classes/class-nf-system-status.php" );

		/* Require Pre-Registered Fields */
		require_once( NINJA_FORMS_DIR . "/includes/fields/textbox.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/checkbox.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/list.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/hidden.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/organizer.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/submit.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/spam.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/honeypot.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/timed-submit.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/hr.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/desc.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/textarea.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/password.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/rating.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/calc.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/country.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/tax.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/credit-card.php" );
		require_once( NINJA_FORMS_DIR . "/includes/fields/number.php" );

		require_once( NINJA_FORMS_DIR . "/includes/admin/save.php" );
	}

	/**
	 * Load our language files
	 * 
	 * @access public
	 * @since 2.7
	 * @return void
	 */
	public function load_lang() {
		/** Set our unique textdomain string */
		$textdomain = 'ninja-forms';

		/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
		$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );

		/** Set filter for WordPress languages directory */
		$wp_lang_dir = apply_filters(
			'ninja_forms_wp_lang_dir',
			WP_LANG_DIR . '/ninja-forms/' . $textdomain . '-' . $locale . '.mo'
		);

		/** Translations: First, look in WordPress' "languages" folder = custom & update-secure! */
		load_textdomain( $textdomain, $wp_lang_dir );

		/** Translations: Secondly, look in plugin's "lang" folder = default */
		$plugin_dir = basename( dirname( __FILE__ ) );
		$lang_dir = apply_filters( 'ninja_forms_lang_dir', $plugin_dir . '/lang/' );
		load_plugin_textdomain( $textdomain, FALSE, $lang_dir );
	}

	/**
	 * Update our version number if necessary
	 * 
	 * @access public
	 * @since 2.7
	 * @return void
	 */
	public function update_version_number(){
		$plugin_settings = nf_get_settings();

		if ( !isset ( $plugin_settings['version'] ) OR ( NF_PLUGIN_VERSION != $plugin_settings['version'] ) ) {
			$plugin_settings['version'] = NF_PLUGIN_VERSION;
			update_option( 'ninja_forms_settings', $plugin_settings );
		}
	}

	/**
	 * Set $_SESSION variable used for storing items in transient variables
	 * 
	 * @access public
	 * @since 2.7
	 * @return void
	 */	 
	public function set_transient_id(){
		if( !session_id() )
	        session_start();
		if ( !isset ( $_SESSION['ninja_forms_transient_id'] ) AND !is_admin() ) {
			$t_id = ninja_forms_random_string();
			// Make sure that our transient ID isn't currently in use.
			while ( get_transient( $t_id ) !== false ) {
				$_id = ninja_forms_random_string();
			}
			$_SESSION['ninja_forms_transient_id'] = $t_id;
		}
	}

} // End Class

/**
 * The main function responsible for returning The Highlander Ninja_Forms
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $nf = Ninja_Forms(); ?>
 *
 * @since 2.7
 * @return object The Highlander Ninja_Forms Instance
 */
function Ninja_Forms() {
	return Ninja_Forms::instance();
}

Ninja_Forms();