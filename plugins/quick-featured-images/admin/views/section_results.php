<h3><?php _e( 'Results of the action', $this->plugin_slug ); ?></h3>
<?php
if ( $results ) {
	// translate once for multiple usage and improve performance
	$label_details 	  = __( 'Details', $this->plugin_slug );
	$label_no_image   = __( 'No Image' );
	$label_current_fi = __( 'Current Featured Image', $this->plugin_slug );
	$label_number 	  = __( 'No.', $this->plugin_slug );
	$label_success 	  = __( 'Changed successfully', $this->plugin_slug );
	$label_unchanged  = sprintf( '<span class="failure">%s</span>', __( 'Unchanged', $this->plugin_slug ) );
?> 
<p><?php _e( 'You can take a view to the post in a new window by clicking on its link in the list.', $this->plugin_slug ); ?></p>
<table class="widefat">
	<thead>
		<tr>
			<th class="num"><?php echo $label_number; ?></th>
			<th><?php echo $label_details; ?></th>
			<th class="num"><?php echo $label_current_fi; ?></th>
		</tr>
	</thead>
	<tbody>
<?php
	$c = 1;
	foreach ( $results as $result ) {
		// check if no featured image for the post, else add default
		$img = $result[ 2 ] ? $result[ 2 ] : $label_no_image;
		// get the result message per post
		$msg = $result[ 3 ] ? $label_success : $label_unchanged;
		// alternating row colors with error class if error
		$classname = $result[ 3 ] ? '' : 'form-invalid';
		if ( 0 == $c % 2 ) { // if $c is divisible by 2 (so the modulo is 0)
			$classname .= $result[ 3 ] ? 'alt' : ' alt';
		}
		// print the table row
		printf( '<tr%s>', ' class="' . $classname . '"' );
		printf( '<td class="num">%d</td>', $c );
		printf( '<td><a href="%s" target="_blank">%s</a><br>%s</td>', $result[ 0 ], $result[ 1 ], $msg );
		printf( '<td class="num">%s</td>', $img );
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
		</tr>
	</tfoot>
</table>
<?php 
} else { 
?>
<p><?php _e( 'No matches found.', $this->plugin_slug ); ?></p>
<?php 
}
?>
<p><a class="button" href="<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) ) );?>"><?php _e( 'Start again', $this->plugin_slug );?></a></p>
<h3><?php _e( 'Do you like the plugin?', $this->plugin_slug ); ?></h3>
<p><a href="http://wordpress.org/support/view/plugin-reviews/quick-featured-images"><?php _e( 'Please rate it at wordpress.org!', $this->plugin_slug ); ?></a></p>
