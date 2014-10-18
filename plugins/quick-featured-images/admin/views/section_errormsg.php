<h3><?php _e( 'Error', $this->page_slug );?></h3>
<div class="th_content_inside">
	<h4><?php _e( 'Reason', $this->plugin_slug );?></h4>
	<p class="failure"><?php print $msg; ?></p>
	<h4><?php _e( 'Solution', $this->plugin_slug );?></h4>
	<p class="success"><?php print $solution; ?></p>
</div>
<p><a class="button" href='<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) ) );?>'><?php _e( 'Start again', $this->plugin_slug );?></a></p>
