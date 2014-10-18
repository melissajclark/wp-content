<h4><?php echo $this->valid_filters[ 'filter_custom_field' ]; ?></h4>
<?php 
$cf_operators = array(
	'='		=> __( 'is equal', $this->plugin_slug ), 
	'!='	=> __( 'is not equal', $this->plugin_slug ),
	'>'		=> __( 'is greater than', $this->plugin_slug ),
	//'>=', 
	'<'		=> __( 'is lower than', $this->plugin_slug ),
	//'<=', 
	'LIKE'	=> __( 'contains', $this->plugin_slug ),
	//'NOT LIKE', 
	//'IN', 
	//'NOT IN', 
	//'BETWEEN', 
	//'NOT BETWEEN', 
	//'EXISTS',
	//'NOT EXISTS'
);
/* for future 
$cf_types = array(
	'CHAR',
	'NUMERIC',
	'BINARY',
	'DATE', 
	'DATETIME', 
	'DECIMAL', 
	'SIGNED', 
	'TIME', 
	'UNSIGNED'
);
*/
$custom_field_keys = $this->get_custom_field_keys();
if ( $custom_field_keys ) {
	foreach ( $this->valid_custom_field as $key => $label ) {
		switch ( $key ) {
			case 'key':
?>
<p>
	<?php _e( 'Select the custom field to find the associated posts/pages.', $this->plugin_slug ); ?><br />
	<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label><br />
	<select id="<?php printf( 'th_%s', $key ); ?>" name="custom_field[<?php echo $key; ?>]">
<?php
				print $this->get_html_options_strings( $this->selected_custom_field, $key, $custom_field_keys );
?>
	</select>
</p>
<?php 
				break;
			case 'value':
?>
<p>
	<?php _e( 'Optional: Type in the value which will be compared with the value of the selected custom field.', $this->plugin_slug ); ?>
	<?php _e( 'Leave it empty if you just want to test the existence of the custom field per post/page.', $this->plugin_slug); ?>
	<br />
	<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label>
	<input type="text" id="<?php printf( 'th_%s', $key ); ?>" name="custom_field[<?php echo $key; ?>]" value="<?php if ( isset( $this->selected_custom_field[ $key ] ) ) { echo $this->selected_custom_field[ $key ]; } ?>" />
</p>
<?php 
				break;
			case 'compare':
?>
<p>
	<?php _e( 'Optional: Change the operator of the comparison. The default is to compare equality with the value you type in the \'value\' field.', $this->plugin_slug ); ?><br />
	<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label><br />
	<select id="<?php printf( 'th_%s', $key ); ?>" name="custom_field[<?php echo $key; ?>]">
<?php
				print $this->get_html_options_strings( $this->selected_custom_field, $key, $cf_operators );
?>
	</select>
</p>
<?php 
		} // switch()
	} // foreach()
} else {
?>
<p><?php _e( 'There are no custom fields in use.', $this->plugin_slug ); ?></p>
<?php 
} // if()
?>
</p>
