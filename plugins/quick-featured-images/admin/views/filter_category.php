<h4><?php echo $this->valid_filters[ 'filter_category' ]; ?></h4>
<p>
	<label for="category_id"><?php _e( 'Select a category', $this->plugin_slug ); ?></label><br />
<?php 
$text = '&mdash; Select &mdash;';
$args = array(
	'name'		=> 'category_id',
	'selected'	=> $this->selected_category_id,
	'orderby'	=> 'NAME',
	'show_option_none' => __( $text ),
);
wp_dropdown_categories( $args ); 
?>
</p>
