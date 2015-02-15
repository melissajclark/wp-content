<?php

/**
 * Return a value from the options table if it exists,
 * or return a default value
 *
 * @since 2.0
 */
function get_mtphr_post_duplicator_settings() {
	
	// Get the options
	$settings = get_option('mtphr_post_duplicator_settings', array());
	
	$defaults = array(
		'status' => 'same',
		'timestamp' => 'duplicate',
		'time_offset' => false,
		'time_offset_days' => 0,
		'time_offset_hours' => 0,
		'time_offset_minutes' => 0,
		'time_offset_seconds' => 0,
		'time_offset_direction' => 'newer'
	);
	
	// Filter the settings
	$settings = apply_filters( 'mtphr_post_duplicator_settings', $settings );
	
	// Return the settings
	return wp_parse_args( $settings, $defaults );
}