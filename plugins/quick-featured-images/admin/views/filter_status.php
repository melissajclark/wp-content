<h4><?php echo $this->valid_filters[ 'filter_status' ]; ?></h4>
<p><?php _e( 'Select the statuses of the posts/pages:', $this->plugin_slug ); ?></p>
<p>
<?php 
foreach ( $this->valid_statuses as $key => $label ) { 
?>
	<input type="checkbox" id="<?php printf( 'th_%s', $key ); ?>" name="statuses[]" value="<?php echo $key; ?>" <?php checked( in_array( $key, $this->selected_statuses ) ); ?> />
	<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label><br>
<?php 
}
?>
</p>
