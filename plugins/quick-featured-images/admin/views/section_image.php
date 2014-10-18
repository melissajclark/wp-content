<h3><?php _e( 'Your selection', $this->plugin_slug ); ?></h3>
<?php
if ( in_array( $this->selected_action, array_keys( $this->valid_actions ) ) && $this->selected_image_id ) {
?>
<div class="th_wrapper">
	<div class="th_w50percent">
		<h4><?php _e( 'Your selected thumbnail', $this->plugin_slug ); ?></h4>
		<p>
		<?php echo wp_get_attachment_image( $this->selected_image_id, 'thumbnail' ); ?><br>
		<strong><?php _e( 'Image title', $this->plugin_slug ); ?>:</strong> <?php echo get_the_title( $this->selected_image_id ); ?>
		</p>
		<p><a class="button" href='<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) ) );?>'><?php _e( 'If wrong image start again', $this->plugin_slug );?></a></p>
	</div><!-- .th_w50percent -->
	<div class="th_w50percent">
<?php
} elseif ( in_array( $this->selected_action, array_keys( $this->valid_actions_multiple_images ) ) && $this->selected_multiple_image_ids ) {
?>
<div class="th_wrapper">
	<div class="th_w50percent">
		<h4><?php _e( 'Your selected thumbnails', $this->plugin_slug ); ?></h4>
		<ul class="selected_images">
<?php
	$size = array( 60, 60 );
	$attr = array( 'class' => 'attachment-thumbnail' );
	foreach( $this->selected_multiple_image_ids as $attachment_id ) {
?>			<li><?php echo wp_get_attachment_image( $attachment_id, $size, false, $attr ); ?></li>
<?php
	} // foreach()
?>
		</ul>
<?php
?>
		<p><a class="button" href='<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) ) );?>'><?php _e( 'If wrong image start again', $this->plugin_slug );?></a></p>
	</div><!-- .th_w50percent -->
	<div class="th_w50percent">
<?php
}
?>		<h4><?php _e( 'Your selected action', $this->plugin_slug ); ?></h4>
<?php
if ( isset( $this->valid_actions[ $this->selected_action ] ) ) {
	$selected_action = $this->valid_actions[ $this->selected_action ];
} elseif ( isset( $this->valid_actions_without_image[ $this->selected_action ] ) ) {
	$selected_action = $this->valid_actions_without_image[ $this->selected_action ];
} elseif ( isset( $this->valid_actions_multiple_images[ $this->selected_action ] ) ) {
	$selected_action = $this->valid_actions_multiple_images[ $this->selected_action ];
} else {
	$selected_action = __( 'You have not selected an action.', $this->plugin_slug );
}
?>
		<p><?php echo $selected_action; ?></p>
		<p><a class="button" href='<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s', $this->page_slug ) ) );?>'><?php _e( 'If wrong action start again', $this->plugin_slug );?></a></p>
<?php
if ( $this->selected_image_id || $this->selected_multiple_image_ids ) {
?>
	</div><!-- .th_w50percent -->
</div><!-- .th_wrapper -->
<?php
}
// don't show on selection page
if ( 'select' != $this->selected_step ) {
?>
<div class="th_wrapper">
	<div class="th_w50percent">
		<h4><?php _e( 'Your selected options', $this->plugin_slug ); ?></h4>
<?php 
	if ( $this->selected_options ) {
?>
		<ul>
<?php 
		foreach ( $this->selected_options as $option ) {
?>
			<li><?php echo $this->valid_options[ $option ]; ?></li>
<?php 
		}
?>
		</ul>
<?php 
	} else {
?>
		<p><?php _e( 'No selected options', $this->plugin_slug ); ?></p>
<?php 
}
?>
	</div><!-- .th_w50percent -->
	<div class="th_w50percent">
		<h4><?php _e( 'Your selected filters', $this->plugin_slug ); ?></h4>
<?php 
	if ( $this->selected_filters ) {
?>
		<ul>
<?php 
		foreach ( $this->selected_filters as $filter ) {
?>
			<li><?php echo $this->valid_filters[ $filter ]; ?></li>
<?php 
		}
?>
		</ul>
<?php 
	} else {
?>
		<p><?php _e( 'No selected filters', $this->plugin_slug ); ?></p>
<?php 
	}
?>
	</div><!-- .th_w50percent -->
</div><!-- .th_wrapper -->
<?php
} // if ( 'select' != $this->selected_step )
