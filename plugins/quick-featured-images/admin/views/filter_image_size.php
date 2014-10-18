<h4><?php echo $this->valid_filters[ 'filter_image_size' ]; ?></h4>
<p><?php _e( 'The search will find posts with an already added featured image which its original image file is smaller than one of the given dimensions.', $this->plugin_slug ); ?></p>
<p><?php _e( 'For example you can search for posts with too small featured images.', $this->plugin_slug ); ?></p>
<?php
$label = sprintf( '%s =&gt; %s', __( 'Settings', $this->plugin_slug ), __( 'Media', $this->plugin_slug ) );
if ( current_user_can( 'manage_options' ) ) {
	$text = sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( admin_url( 'options-media.php' ) ), $label );
} else {
	$text= sprintf( '<strong>%s</strong>', $label );
}
?>
<p><?php printf( __( 'Only positive integers from %d to %d are allowed. By default the thumbnail dimensions as defined in %s are used.', $this->plugin_slug ), $this->min_image_length, $this->max_image_length, $text ); ?></p>
<?php 
foreach ( $this->valid_image_dimensions as $key => $label ) {
?>
<p>
	<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label>
	<input type="text" 
	name="image_dimensions[<?php echo $key; ?>]" 
	id="<?php printf( 'th_%s', $key ); ?>" 
	value="<?php echo $this->selected_image_dimensions[ $key ]; ?>" maxlength="4">
	px
</p>
<?php 
} // foreach()
?>
</p>
