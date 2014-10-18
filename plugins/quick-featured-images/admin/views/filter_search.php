<h4><?php echo $this->valid_filters[ 'filter_search' ]; ?></h4>
<p>
	<label for="th_search_term"><?php _e( 'Type in a search term', $this->plugin_slug ); ?></label>
	<input type="text" id="th_search_term" name="search_term" value="<?php if ( $this->selected_search_term ) { echo $this->selected_search_term; } ?>" />
</p>
