<h4><?php echo $this->valid_filters[ 'filter_custom_taxonomies' ]; ?></h4>
<?php
if ( $this->valid_custom_taxonomies ) {
	$custom_tax_labels = $this->get_custom_taxonomies_labels();
	$args = array(
		'orderby'       => 'name', 
		'order'         => 'ASC',
		'hide_empty'    => false, 
		'hierarchical'  => true, 
	);
	foreach ( $this->valid_custom_taxonomies as $custom_tax ) {
		$options = array();
		$terms = get_terms( $custom_tax, $args );
		if ( is_wp_error( $terms ) ) {
			printf( '<p>%s<p>', $terms->get_error_message() );
			continue;
		}
		if ( 0 < count( $terms ) ) {
			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name;
			}
			if ( isset( $this->selected_custom_taxonomies[ $custom_tax ] ) ) {
				$selected_tax = $this->selected_custom_taxonomies[ $custom_tax ];
			} else {
				$selected_tax = '';
			}
?>
<p>
	<label for="<?php printf( 'th_%s', $custom_tax ); ?>"><?php printf( __( 'Registered terms of the taxonomy <strong>%s</strong>', $this->plugin_slug ), $custom_tax_labels[ $custom_tax ] ); ?></label><br />
	<select id="<?php printf( 'th_%s', $custom_tax ); ?>" name="custom_taxonomies[<?php echo $custom_tax; ?>]">
<?php
			print $this->get_html_empty_option();
			foreach ( $options as $key => $label ) {
				printf( '<option value="%s" %s>%s</option>', $key, selected( $selected_tax == $key, true, false ), $label );
			}

?>
	</select>
</p>
<?php
		} else {
?>
<p>
<?php
			printf( __( 'There are no terms of the taxonomy <strong>%s</strong>.', $this->plugin_slug ), $custom_tax_labels[ $custom_tax ] );
?>
</p>
<?php
		} // if( count(terms) )
	}
?>
<h5><?php _e( 'Strange search result with custom taxonomies?', $this->plugin_slug ); ?></h5>
<p><?php _e( 'The search for custom taxonomy terms could lead to surprising results. The reason is custom taxonomies can be used in many different ways. It is not possible to catch them all in one single code expression. If you should be unsatisfied with the result try other filters to get the result you want.', $this->plugin_slug ); ?></p>
<?php
} else {
?>
<p><?php _e( 'There are no custom taxonomies.', $this->plugin_slug ); ?></p>
<?php
} // if( valid_custom_taxonomies )
