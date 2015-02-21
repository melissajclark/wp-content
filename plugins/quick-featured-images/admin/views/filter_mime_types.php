<h4><?php echo $this->valid_filters[ 'filter_mime_types' ]; ?></h4>
<p><?php _e( 'Select multimedia file types', $this->plugin_slug ); ?>. <?php _e( 'You can select two multimedia files types: audios and videos. If you check at least one of both all other post types (posts, pages, etc.) will be ignored.', $this->plugin_slug ); ?></p>
<p>
<?php
foreach ( $this->valid_mime_types as $key => $label ) {
?>
	<input type="checkbox" id="<?php printf( 'th_%s', $key ); ?>" name="mime_types[]" value="<?php echo $key; ?>"  <?php checked( in_array( $key, $this->selected_mime_types ) ); ?> />
	<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label><br />
<?php
}
?>
</p>
