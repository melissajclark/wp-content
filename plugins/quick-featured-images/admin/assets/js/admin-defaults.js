jQuery( document ).ready( function( $ ){
 
	/*
	 * Media uploader
	 */

	// placeholder url
	var blank_url = $( '#placeholder_url' ).val();

	// bind the media uploader at current and future ( 'live()' ) image upload buttons
    $( '.imageupload' ).live( 'click', function( e ) {
		
        e.preventDefault();
 
		var custom_uploader;
		// get number of row
		var row_number = this.id.match( /[0-9]+/ );
		// set selector names
		var selector_image_id_element = '#image_id_' + row_number;
		var selector_image_element = '#selected_image_' + row_number;

        //Extend the wp.media object
		var selector_upload_text = '#upload_image_XX';
        custom_uploader = wp.media.frames.file_frame = wp.media( {
            title: $( selector_upload_text ).val(),
            button: {
                text: $( selector_upload_text ).val()
            },
            multiple: false
        } );
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on( 'select', function() {
            var attachment = custom_uploader.state().get( 'selection' ).first().toJSON();
            $( selector_image_id_element ).val( attachment.id );
            $( selector_image_element ).attr( 'src', attachment.url );
            $( selector_image_element ).attr( 'class', 'attachment-thumbnail' );
            $( selector_image_element ).attr( 'style', 'width:80px; display: block;' );
        } );
 
        //Open the uploader dialog
        custom_uploader.open();
 
    } );

	/*
	 * Remove rule row
	 */
	// clear default image
	selector_clear_image_button = '.remove_rule';
    $( selector_clear_image_button ).live( 'click', function( e ) {
 
        e.preventDefault();
		
		if( confirm( $( '#confirmation_question' ).val() ) ) {

			// get number of row
			var row_number = this.id.match( /[0-9]+/ );
			
			// remove image if first row, else remove row
			/*if ( '1' == row_number ) {
				var selector_image_id_element = '#image_id_1';
				var selector_image_element = '#selected_image_1';
				$( selector_image_id_element ).val( 0 );
				$( selector_image_element ).attr( 'src', blank_url );
				$( selector_image_element ).attr( 'class', '' );
				$( selector_image_element ).attr( 'style', '' );
				$( selector_image_element ).attr( 'width', '' );
				$( selector_image_element ).attr( 'height', '' );
			} else {
				$( '#row_' + row_number ).remove();
			}*/
			$( '#row_' + row_number ).remove();
		}
    } );
 
	/*
	 * Add rule row
	 */
 	$( '#add_rule_button' ).click( function( e ){

		e.preventDefault();
		
		// get template html
		template_row = $( '#template_row' ).clone();
		// detect new row number
		row_number = parseInt( $( 'table.widefat tbody tr' ).last().prev().attr( 'id' ).match( /[0-9]+/ )) + 1;
		if ( ! isFinite( row_number ) ) {
			row_number = 2; // assume second row if not a valid number
		}
		
		// replace placeholder with row number:
		// text replacements
		template_row.find( '#image_id_XX' ).each( function( index, el ) {
			el_val = String( $( el ).attr( 'name' ));
			$( el ).attr( 'name', el_val.replace( 'XX', row_number ));
		} );
		template_row.find( '[ for*="taxonomy_XX" ]' ).each( function( index, el ) {
			el_val = String( $( el ).attr( 'for' ));
			$( el ).attr( 'for', el_val.replace( 'XX', row_number ));
		} );
		template_row.find( '#taxonomy_XX' ).each( function( index, el ) {
			el_val = String( $( el ).attr( 'name' ));
			$( el ).attr( 'name', el_val.replace( 'XX', row_number ));
		} );
		template_row.find( '[ for*="matchterm_XX" ]' ).each( function( index, el ) {
			el_val = String( $( el ).attr( 'for' ));
			$( el ).attr( 'for', el_val.replace( 'XX', row_number ));
		} );
		template_row.find( '#matchterm_XX' ).each( function( index, el ) {
			el_val = String( $( el ).attr( 'name' ));
			$( el ).attr( 'name', el_val.replace( 'XX', row_number ));
		} );
		// attribute replacements
		template_row.attr( 'id', 'row_' + row_number );
		template_row.find( 'td.num' ).text( row_number );
		template_row.find( '#image_id_XX' ).attr( 'id', 'image_id_' + row_number );
		template_row.find( '#selected_image_XX' ).attr( 'id', 'selected_image_' + row_number );
		template_row.find( '#upload_image_XX' ).attr( 'name', 'upload_image_' + row_number );
		template_row.find( '#upload_image_XX' ).attr( 'id', 'upload_image_' + row_number );
		template_row.find( '#taxonomy_XX' ).attr( 'id', 'taxonomy_' + row_number );
		template_row.find( '#matchterm_XX' ).attr( 'id', 'matchterm_' + row_number );
		template_row.find( '#remove_rule_XX' ).attr( 'name', 'remove_rule_' + row_number );
		template_row.find( '#remove_rule_XX' ).attr( 'id', 'remove_rule_' + row_number );
		// add row color alternation if row number is odd
		if ( row_number % 2 == 0 ) {
			template_row.attr( 'class', 'alt' );
		}

		// display new row
		template_row.insertBefore( '#template_row' );
		
	} );
	
	/*
	 * Do not submit template row
	 */
	$( '#submit' ).click( function(){
		$( '#template_row' ).remove();
		return true;
	} );
	
} );
