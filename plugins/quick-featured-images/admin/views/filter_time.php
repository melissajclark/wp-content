<h4><?php echo $this->valid_filters[ 'filter_time' ]; ?></h4>
<h5><?php _e( 'Date range', $this->plugin_slug ); ?>:</h5>
<p><?php _e( 'To define a time segment select both the start date and the end date.', $this->plugin_slug ); ?></p>
<p><?php _e( 'You can also define a time period by selecting only one date as the limiting value of the period.', $this->plugin_slug ); ?></p>
<p><?php _e( 'The listed dates are the date of the publication of stored posts.', $this->plugin_slug ); ?></p>
<?php

?>
<div class="th_wrapper">
<?php 
$this->valid_post_dates = $this->get_registered_post_dates();

foreach ( $this->valid_date_queries as $key => $label ) { 
	switch ( $key ) {	
		case 'after':
		case 'before':
?>
	<div class="th_w50percent">
		<p>
			<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label><br>
			<select id="<?php printf( 'th_%s', $key ); ?>" name="date_queries[<?php echo $key; ?>]">
<?php 
			print $this->get_html_date_options( $key );
?>
			</select>
		</p>
	</div><!-- .th_w50percent -->
<?php 
			break;
	} // switch()
} // foreach()
?>
</div><!-- .th_wrapper -->
<?php
$key = 'inclusive';
$label = $this->valid_date_queries[ $key ];
?>
<p>
	<input type="checkbox" id="<?php printf( 'th_%s', $key ); ?>" name="date_queries[<?php echo $key; ?>]" value="1" <?php checked( isset( $this->selected_date_queries[ $key ] ) ); ?> />
	<label for="<?php printf( 'th_%s', $key ); ?>"><?php echo $label; ?></label><br>
</p>

