jQuery( document ).ready( function( $ ){
 

	// single image selection
	var selector_single_image_button = '#upload_image_button';
    $( selector_single_image_button ).click( function( e ) {
 
        e.preventDefault();
 
		var custom_uploader;
		
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media( {
            title: $( selector_single_image_button ).val(),
            button: {
                text: $( selector_single_image_button ).val()
            },
            multiple: false
        } );
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on( 'select', function() {
			var selector_image = '#selected_image';
            var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
            $( '#image_id' ).val( attachment.id );
            $( selector_image ).attr( 'src', attachment.url );
            $( selector_image ).attr( 'class', 'attachment-thumbnail' );
            $( selector_image ).attr( 'style', 'width:95%' );
        } );
 
        //Open the uploader dialog
        custom_uploader.open();
 
    } );
 
	// multiple images selection
	var selector_multiple_images_button = '#select_images_multiple';
    $( selector_multiple_images_button ).click( function( e ) {
 
        e.preventDefault();
 
		var custom_uploader;

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media( {
            title: $( selector_multiple_images_button ).val(),
            button: {
                text: $( selector_multiple_images_button ).val()
            },
            multiple: true
        } );
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on( 'select', function() {
            var attachments = custom_uploader.state().get( 'selection' ).toJSON();
			var attachments_ids = [];
			for ( i = 0; i < attachments.length; i++ ) {
				attachments_ids[ i ] = attachments[ i ].id
			}
            $( '#multiple_image_ids' ).val( attachments_ids.toString() );
        } );
 
        //Open the uploader dialog
        custom_uploader.open();
 
    } );
 
} );
