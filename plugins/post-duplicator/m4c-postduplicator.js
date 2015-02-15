jQuery( document ).ready( function() {

	/**
	 * Duplicate post listener.
	 *
	 * Creates an ajax request that creates a new post, 
	 * duplicating all the data and custom meta.
	 *
	 * @since 1.0.0
	 */
	jQuery( '.m4c-duplicate-post' ).click( function( e ) {
		
		e.preventDefault();
	
		// Create the data to pass
		var data = {
			action: 'm4c_duplicate_post',
			original_id: jQuery(this).attr('href'),
			security: jQuery(this).attr('rel')
		};
	
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post( ajaxurl, data, function( response ) {

			// Reload the page
			location.reload();
		});
	});
});