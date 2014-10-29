<?php

/*
 *
 * Function used to output calcluation options on each field editing section on the back-end.
 *
 * @since 2.2.28
 * @returns void
 */

function nf_edit_field_sub_settings( $field_id ) {
	global $ninja_forms_fields;

	$field_row = ninja_forms_get_field_by_id( $field_id );
	$field_type = $field_row['type'];

	if ( $ninja_forms_fields[$field_type]['process_field'] ) {
		if ( isset ( $field_row['data']['admin_label'] ) ) {
			$admin_label = $field_row['data']['admin_label'];
		} else {
			$admin_label = '';
		}
		if ( isset ( $field_row['data']['num_sort'] ) ) {
			$num_sort = $field_row['data']['num_sort'];
		} else {
			$num_sort = '';
		}
		?>
		<div class="description description-wide">
		<hr>
		<h5><?php _e( 'Submission Settings', 'ninja-forms' );?></h5>
		<?php
		ninja_forms_edit_field_el_output( $field_id, 'text', __( 'Admin Label', 'ninja-forms' ), 'admin_label', $admin_label, 'wide', '', 'widefat code', __( 'This is the label used when viewing/editing/exporting submissions.', 'ninja-forms' ) );
		ninja_forms_edit_field_el_output( $field_id, 'checkbox', __( 'Sort as numeric', 'ninja-forms' ), 'num_sort', $num_sort, 'wide', '', '', __( 'If this box is checked, this column in the submissions table will sort by number.', 'ninja-forms' ) );
		
	}
}

add_action( 'ninja_forms_edit_field_after_registered', 'nf_edit_field_sub_settings', 11 );