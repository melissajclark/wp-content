<?php

add_action( 'admin_menu', 'mtphr_post_duplicator_settings_page' );
/**
 * Add a menu page to display options
 *
 * @since 2.0
 */
function mtphr_post_duplicator_settings_page() {

	add_management_page(
		'Post Duplicator',														// The value used to populate the browser's title bar when the menu page is active
		'Post Duplicator',														// The label of this submenu item displayed in the menu
		'administrator',															// What roles are able to access this submenu item
		'mtphr_post_duplicator_settings_menu',				// The ID used to represent this submenu item
		'mtphr_post_duplicator_settings_display'			// The callback function used to render the options for this submenu item
	);
}




add_action( 'admin_init', 'mtphr_post_duplicator_initialize_settings' );
/**
 * Initializes the options page.
 *
 * @since 2.2
 */ 
function mtphr_post_duplicator_initialize_settings() {

	$settings['status'] = array(
		'title' => __( 'Post Status', 'post-duplicator' ),
		'type' => 'select',
		'options' => array(
			'same' => __('Same as original', 'post-duplicator'),
			'draft' => __('Draft', 'post-duplicator'),
			'publish' => __('Published', 'post-duplicator'),
			'pending' => __('Pending', 'post-duplicator')	
		),
		'default' => 'same'
	);
	
	$settings['timestamp'] = array(
		'title' => __( 'Post Date', 'post-duplicator' ),
		'type' => 'radio',
		'options' => array(
			'duplicate' => __('Duplicate Timestamp', 'post-duplicator'),
			'current' => __('Current Time', 'post-duplicator')
		),
		'display' => 'inline',
		'default' => 'duplicate'
	);
	
	$settings['time_offset'] = array(
		'title' => __( 'Offset Date', 'post-duplicator' ),
		'type' => 'checkbox',
		'append' => array(
			'time_offset_days' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' days', 'post-duplicator'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_hours' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' hours', 'post-duplicator'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_minutes' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' minutes', 'post-duplicator'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_seconds' => array(
				'type' => 'text',
				'size' => 2,
				'after' => __(' seconds', 'post-duplicator'),
				'text_align' => 'right',
				'default' => 0
			),
			'time_offset_direction' => array(
				'type' => 'select',
				'options' => array(
					'newer' => __('newer', 'post-duplicator'),
					'older' => __('older', 'post-duplicator')
				),
				'default' => 'newer'
			)
		)
	);

	if( false == get_option('mtphr_post_duplicator_settings') ) {	
		add_option( 'mtphr_post_duplicator_settings' );
	}
	
	/* Register the style options */
	add_settings_section(
		'mtphr_post_duplicator_settings_section',						// ID used to identify this section and with which to register options
		'',																									// Title to be displayed on the administration page
		'mtphr_post_duplicator_settings_callback',					// Callback used to render the description of the section
		'mtphr_post_duplicator_settings'										// Page on which to add this section of options
	);
	
	$settings = apply_filters( 'mtphr_post_duplicator_settings', $settings );

	if( is_array($settings) ) {
		foreach( $settings as $id => $setting ) {	
			$setting['option'] = 'mtphr_post_duplicator_settings';
			$setting['option_id'] = $id;
			$setting['id'] = 'mtphr_post_duplicator_settings['.$id.']';
			add_settings_field( $setting['id'], $setting['title'], 'mtphr_post_duplicator_field_display', 'mtphr_post_duplicator_settings', 'mtphr_post_duplicator_settings_section', $setting);
		}
	}
	
	// Register the fields with WordPress
	register_setting( 'mtphr_post_duplicator_settings', 'mtphr_post_duplicator_settings' );
}




/**
 * Renders a simple page to display for the theme menu defined above.
 *
 * @since 2.0
 */
function mtphr_post_duplicator_settings_display() {
	?>
	<div class="wrap">
	
		<h2><?php _e( 'Post Duplicator Settings', 'post-duplicator' ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
			settings_fields( 'mtphr_post_duplicator_settings' );
			do_settings_sections( 'mtphr_post_duplicator_settings' );
			submit_button();
			?>
		</form>

	</div><!-- /.wrap -->
	<?php
}




/**
 * The callback function for the settings sections.
 *
 * @since 2.0
 */ 
function mtphr_post_duplicator_settings_callback() {
	echo '<h4>Customize the settings for duplicated posts.</h4>';
}




/**
 * The custom field callback.
 *
 * @since 1.0
 */ 
function mtphr_post_duplicator_field_display( $args ) {

	// First, we read the options collection
	if( isset($args['option']) ) {
		$options = get_option( $args['option'] );
		$value = isset( $options[$args['option_id']] ) ? $options[$args['option_id']] : '';
	} else {
		$value = get_option( $args['id'] );
	}	
	if( $value == '' && isset($args['default']) ) {
		$value = $args['default'];
	}
	if( isset($args['type']) ) {
	
		echo '<div class="mtphr-post-duplicator-metaboxer-field mtphr-post-duplicator-metaboxer-'.$args['type'].'">';
		
		// Call the function to display the field
		if ( function_exists('mtphr_post_duplicator_metaboxer_'.$args['type']) ) {
			call_user_func( 'mtphr_post_duplicator_metaboxer_'.$args['type'], $args, $value );
		}
		
		echo '<div>';
	}
	
	// Add a descriptions
	if( isset($args['description']) ) {
		echo '<span class="description"><small>'.$args['description'].'</small></span>';
	}
}

 