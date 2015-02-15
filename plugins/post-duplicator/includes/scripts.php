<?php

add_action( 'admin_enqueue_scripts', 'mtphr_post_duplicator_metaboxer_scripts' );
/**
 * Load the metaboxer scripts
 *
 * @since 2.4
 */
function mtphr_post_duplicator_metaboxer_scripts( $hook ) {
	
		if( $hook == 'tools_page_mtphr_post_duplicator_settings_menu' ) {
		
		// Load the style sheet
		wp_register_style( 'mtphr-post-duplicator-metaboxer', MTPHR_POST_DUPLICATOR_URL.'/metaboxer/metaboxer.css', false, MTPHR_POST_DUPLICATOR_VERSION );
		wp_enqueue_style( 'mtphr-post-duplicator-metaboxer' );
	}
}




add_action( 'admin_enqueue_scripts', 'm4c_duplicate_post_scripts' );
/**
 * Add the necessary jquery.
 *
 * @since 1.0.0
 */
function m4c_duplicate_post_scripts( $hook_suffix ) {
	if( $hook_suffix == 'edit.php' ) {
		wp_enqueue_script( 'mtphr-post-duplicator', MTPHR_POST_DUPLICATOR_URL.'/assets/js/pd-admin.js', array('jquery'), MTPHR_POST_DUPLICATOR_VERSION );
	}
}