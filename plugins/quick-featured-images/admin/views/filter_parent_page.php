<h4><?php echo $this->valid_filters[ 'filter_parent_page' ]; ?></h4>
<p>
<?php 
$parent_pages = $this->get_post_ids_of_parent_pages();

if ( $parent_pages ) {
?>
	<label for="page_id"><?php _e( 'Select a parent page', $this->plugin_slug ); ?></label><br />
<?php 
	$text = '&mdash; Select &mdash;';
	$args = array(
		'include' => $parent_pages,
		'selected' => $this->selected_parent_page_id,
		'show_option_none' => __( $text ),
		'option_none_value' => '',
	);
	wp_dropdown_pages( $args ); 
} else {
	_e( 'There are no pages with child pages.', $this->plugin_slug );
}
?>
</p>
