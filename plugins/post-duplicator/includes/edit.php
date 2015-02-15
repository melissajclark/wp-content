<?php

add_filter( 'post_row_actions', 'mtphr_post_duplicator_action_row', 10, 2 );
add_filter( 'page_row_actions', 'mtphr_post_duplicator_action_row', 10, 2 );
/**
 * Add a duplicate post link.
 *
 * @since 1.0.0
 */
function mtphr_post_duplicator_action_row( $actions, $post ){

	// Get the post type object
	$post_type = get_post_type_object( $post->post_type );
	
	// Create a nonce & add an action
	$nonce = wp_create_nonce( 'm4c_ajax_file_nonce' ); 
  $actions['duplicate_post'] = '<a class="m4c-duplicate-post" rel="'.$nonce.'" href="'.$post->ID.'">Duplicate '.$post_type->labels->singular_name.'</a>';

	return $actions;
}

