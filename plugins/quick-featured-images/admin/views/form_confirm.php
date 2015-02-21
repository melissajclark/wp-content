<?php 
	switch ( $this->selected_action ) {
		case 'assign':
			$question = __( 'Should the selected image be set as featured image to all listed posts?', $this->plugin_slug );
			break;
		case 'assign_randomly':
			$question = __( 'Should the selected images be set randomly as featured images to all listed posts?', $this->plugin_slug );
			break;
		case 'replace':
			$question = __( 'Should the current set featured image be replaced by the selected image at all listed posts?', $this->plugin_slug );
			break;
		case 'remove':
			$question = __( 'Should the selected image be removed from all listed posts?', $this->plugin_slug );
			break;
		case 'assign_first_img':
			$question = __( 'Should the future images be set as featured images at all listed posts?', $this->plugin_slug );
			break;
		case 'remove_any_img':
			$question = __( 'Should the added featured images be removed from all listed posts?', $this->plugin_slug );
			break;
	} // switch()
	
?>
<h3><?php _e( 'Preview of your selection', $this->plugin_slug ); ?></h3>
<h4><?php printf( __( '%d matches found', $this->plugin_slug ), sizeof( $results ) ); ?></h4>
<?php 
if ( $results ) { 
	// translate once for multiple usage and improve performance
	$label_details 	  = __( 'Details', $this->plugin_slug );
	$label_number 	  = __( 'No.', $this->plugin_slug );
	$label_current_fi = __( 'Current Featured Image', $this->plugin_slug );
	$label_future_fi  = __( 'Future Featured Image', $this->plugin_slug );
	$label_written_on = __( 'written on', $this->plugin_slug );
	$label_by         = __( 'by', $this->plugin_slug );
	// WP core labels
	$text 			  = 'No image set';
	$label_no_image   = __( $text );
	$text 			  = 'Status:';
	$label_status     = __( $text );
	$text 			  = 'Apply';
	$label_apply      = __( $text );
	$text 			  = 'Cancel';
	$label_cancel     = __( $text );
	$text             = '(no title)';
	$default_title    = __( $text );

?>
<p><?php _e( 'The list is in alphabetical order according to post title. You can edit a post in a new window by clicking on its link in the list.', $this->plugin_slug ); ?></p>
<table class="widefat">
	<thead>
		<tr>
			<th class="num"><?php echo $label_number; ?></th>
			<th><?php echo $label_details; ?></th>
			<th class="num"><?php echo $label_current_fi; ?></th>
			<th class="num"><?php echo $label_future_fi; ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$c = 1;
	foreach ( $results as $result ) {
		// alternating row colors: if $c is divisible by 2 (so the modulo is 0) then set 'alt'-class
		$class_attrib = 0 == $c % 2 ? ' class="alt"' : '';
		// post title, else default title
		$post_title = $result[ 1 ] ? $result[ 1 ] : $default_title;
		// post date
		$post_date = sprintf( '%s %s', $label_written_on, $result[ 2 ] );
		// post author
		$post_author = sprintf( '%s %s', $label_by, $result[ 3 ] );
		// post type label
		$post_type = $result[ 7 ];
		$post_type_obj = get_post_type_object( $post_type );
		if ( $post_type_obj ) {
			$post_type = $post_type_obj->labels->singular_name; // readable name
		}
		// post status
		$post_status = isset( $this->valid_statuses[ $result[ 6 ] ] ) ? $this->valid_statuses[ $result[ 6 ] ] : $result[ 6 ];
		// check if no featured image for the post, else add default
		$current_img = $result[ 4 ] ? $result[ 4 ] : $label_no_image;
		$future_img = $result[ 5 ] ? $result[ 5 ] : $label_no_image;
		// print the table row
		printf( '<tr%s>', $class_attrib );
		printf( '<td class="num">%d</td>', $c );
		printf( 
			'<td><a href="%s" target="_blank">%s</a><br>%s<br>%s<br>%s, %s %s</td>',
			$result[ 0 ], // edit post link
			$post_title,
			$post_date,
			$post_author,
			$post_type,
			$label_status,
			$post_status
		);
		printf( '<td class="num">%s</td>', $current_img );
		printf( '<td class="num">%s</td>', $future_img );
		print "</tr>\n";
		// increase counter
		$c++;
	}
?>
	</tbody>
	<tfoot>
		<tr>
			<th class="num"><?php echo $label_number; ?></th>
			<th><?php echo $label_details; ?></th>
			<th class="num"><?php echo $label_current_fi; ?></th>
			<th class="num"><?php echo $label_future_fi; ?></th>
		</tr>
	</tfoot>
</table>
<h3><?php _e( 'Confirm the change', $this->plugin_slug ); ?></h3>
<p><?php echo $question; ?> <?php _e( 'You can not undo the operation!', $this->plugin_slug ); ?></p>
<form method="post" action="<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s&amp;step=perform', $this->page_slug ) ) ); ?>">
	<p>
		<input type="hidden" name="image_id" value="<?php echo $this->selected_image_id; ?>" />
		<input type="hidden" name="action" value="<?php echo $this->selected_action; ?>" />
<?php 
if ( $this->selected_multiple_image_ids ) {
	$v = implode( ',', $this->selected_multiple_image_ids );
?>
		<input type="hidden" name="multiple_image_ids" value="<?php echo $v; ?>" />
<?php
}
if ( $this->selected_filters ) {
	foreach ( $this->selected_filters as $v ) {
?>
		<input type="hidden" name="filters[]" value="<?php echo $v; ?>" />
<?php
	}
}
foreach ( $this->selected_statuses as $v ) {
?>
		<input type="hidden" name="statuses[]" value="<?php echo $v; ?>" />
<?php 
}
foreach ( $this->selected_post_types as $v ) {
?>
		<input type="hidden" name="post_types[]" value="<?php echo $v; ?>" />
<?php 
}
foreach ( $this->selected_mime_types as $v ) {
?>
		<input type="hidden" name="mime_types[]" value="<?php echo $v; ?>" />
<?php 
}
if ( $this->selected_custom_post_types ) {
	foreach ( $this->selected_custom_post_types as $v ) {
?>
		<input type="hidden" name="custom_post_types[]" value="<?php echo $v; ?>" />
<?php
	}
}
if ( $this->selected_options ) {
	foreach ( $this->selected_options as $v ) {
?>
		<input type="hidden" name="options[]" value="<?php echo $v; ?>" />
<?php
	}
}
if ( $this->selected_search_term ) {
?>
		<input type="hidden" name="search_term" value="<?php echo $this->selected_search_term; ?>" />
<?php 
}
if ( $this->selected_category_id ) {
?>
		<input type="hidden" name="category_id" value="<?php echo $this->selected_category_id; ?>" />
<?php 
}
if ( $this->selected_parent_page_id ) {
?>
		<input type="hidden" name="page_id" value="<?php echo $this->selected_parent_page_id; ?>" />
<?php 
}
if ( $this->selected_author_id ) {
?>
		<input type="hidden" name="author_id" value="<?php echo $this->selected_author_id; ?>" />
<?php 
}
if ( $this->selected_tag_id ) {
?>
		<input type="hidden" name="tag_id" value="<?php echo $this->selected_tag_id; ?>" />
<?php 
}
/*if ( $this->selected_custom_field ) {
	foreach ( $this->selected_custom_field as $k => $v ) {
? >
		<input type="hidden" name="custom_field[<?php echo $k; ?>]" value="<?php echo $v; ?>" />
< ? php
	}
}*/
if ( $this->selected_old_image_ids ) {
	foreach ( $this->selected_old_image_ids as $k => $v ) {
?>
		<input type="hidden" name="replacement_image_ids[<?php echo $k; ?>]" value="<?php echo $v; ?>" />
<?php
	}
}
if ( in_array( 'filter_image_size', $this->selected_filters ) ) {
	// $this->selected_image_dimensions is never empty because of default values, so loop without check
	foreach ( $this->selected_image_dimensions as $k => $v ) {
?>
		<input type="hidden" name="image_dimensions[<?php echo $k; ?>]" value="<?php echo $v; ?>" />
<?php
	}
}
if ( $this->selected_custom_taxonomies ) {
	foreach ( $this->selected_custom_taxonomies as $k => $v ) {
?>
		<input type="hidden" name="custom_taxonomies[<?php echo $k; ?>]" value="<?php echo $v; ?>" />
<?php
	}
}
if ( $this->selected_date_queries ) {
	foreach ( $this->selected_date_queries as $k => $v ) {
?>
		<input type="hidden" name="date_queries[<?php echo $k; ?>]" value="<?php echo $v; ?>" />
<?php
	}
}
?>
		<?php wp_nonce_field( 'quickfi_confirm', $this->plugin_slug . '_nonce' ); ?>
		<input type="submit" class="button-primary" value="<?php echo $label_apply; ?>" /> <a class="button" href='<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) ) );?>'><?php echo $label_cancel;?></a>
	</p>
</form>
<?php
} else { 
?>
<p><a class="button" href='<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) ) );?>'><?php _e( 'Start again', $this->plugin_slug );?></a> <?php _e( 'or refine your selection with the following form fields.', $this->plugin_slug );?></p>
<?php
}
