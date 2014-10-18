<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   Quick_Featured_Images
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://stehle-internet.de
 * @copyright 2014 Martin Stehle
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( is_multisite() ) {

	$sites = wp_get_sites();

	if ( empty ( $sites ) ) return;

	foreach ( $sites as $site ) {
		// switch to next blog
		switch_to_blog( $site[ 'blog_id' ] );
		// remove settings
		delete_option( 'quick-featured-images-settings' ); 
		delete_option( 'quick-featured-images-defaults' );
	}
	// restore the current blog, after calling switch_to_blog()
	restore_current_blog();
} else {
	// remove settings
	delete_option( 'quick-featured-images-settings' ); 
	delete_option( 'quick-featured-images-defaults' );
}
