<?php 
if ( ! current_theme_supports( 'post-thumbnails' ) ) {
?>
<h3><?php _e( 'Notice', $this->plugin_slug ); ?></h3>
<div class="th_content_inside">
	<p class="failure"><?php _e( 'The current theme does not support featured images. Anyway you can use this plugin. The effects are stored and will be visible in a theme which supports featured images.', $this->plugin_slug ); ?></p>
</div>
<?php 
}
?>
<form method="post" action="<?php echo esc_url( admin_url( sprintf( 'admin.php?page=%s&amp;step=select', $this->page_slug ) ) ); ?>">
	<h3><?php _e( 'What do you want to do?', $this->plugin_slug ); ?></h3>
	<p><?php _e( 'Here you can add, replace and delete featured images to your posts. Select one of the following actions and, if necessary, one or more images.', $this->plugin_slug ); ?></p>
	<p><?php _e( 'Whatever you select: You can refine your choice on the next page.', $this->plugin_slug ); ?></p>
	<fieldset>
		<legend class="screen-reader-text"><span><?php _e( 'Select action', $this->plugin_slug ); ?></span></legend>
		<h4><?php _e( 'Actions with a selected image', $this->plugin_slug ); ?></h4>
		<p><?php _e( 'These actions require to select an image with the following button.', $this->plugin_slug ); ?></p>
<?php 
foreach ( $this->valid_actions as $name => $label ) {
?>
		<p>
			<input type="radio" id="<?php echo $name; ?>" name="action" value="<?php echo $name; ?>" <?php checked( 'assign' == $name ); ?> />
			<label for="<?php echo $name; ?>"><strong><?php echo $label; ?>.</strong><br><?php
	if ( 'assign' == $name ) {
		_e( 'This will also replace already added featured images.', $this->plugin_slug );
	}
?></label>
		</p>
<?php
} // foeach( valid_actions )
?>
		<div class="th_wrapper">
			<div class="th_w50percent">
				<p><?php _e( 'Select the image you want to add to, replace or delete from posts and pages by clicking on the following button.', $this->plugin_slug ); ?></p>
				<p>
<?php
// default values for image element
$img_url = includes_url() . 'images/blank.gif';
$img_class = '';
$img_style = '';
// if an image id was given
if ( $this->selected_image_id ) {
	$arr_image = wp_get_attachment_image_src( $this->selected_image_id );
	// and if there is an valid image
	if ( $arr_image ) {
		// show the image and set the id as param value
		$img_url = $arr_image[0];
		$img_class = 'attachment-thumbnail';
		$img_style = sprintf( 'width:%dpx', $this->used_thumbnail_width );
	}
}
?>
					<input type="hidden" id="image_id" name="image_id" value="<?php echo $this->selected_image_id; ?>">
					<img id="selected_image" src="<?php echo $img_url; ?>" alt="<?php $text = 'Featured Image'; _e( $text ); ?>" class="<?php echo $img_class; ?>" style="<?php echo $img_style; ?>" /><br />
					<input type="button" id="upload_image_button" class="button th_select_image" value="<?php _e( 'Choose Image', $this->plugin_slug ); ?>" />
				</p>
			</div>
			<div class="th_w50percent">
				<p><strong><?php _e( 'If the button does not work, read this:', $this->plugin_slug ); ?></strong></p>
				<p><?php _e( 'Some users reported that this button would not work in some WordPress installations. If this should be the case you can take another way:', $this->plugin_slug ); ?></p>
				<p><?php _e( '1. Go to the media library. 2. Move the mouse over the desired image. Further links are appearing, among them the link &quot;Bulk set as featured image&quot;. 3. After a click on it you can move on in this plugin.', $this->plugin_slug ); ?></p>
			</div>
		</div>

		<h4><?php _e( 'Actions with multiple selected images', $this->plugin_slug ); ?></h4>
		<p><?php _e( 'These actions require at least one selected image with the following button.', $this->plugin_slug ); ?></p>
<?php
foreach ( $this->valid_actions_multiple_images as $name => $label ) {
?>
		<p>
			<input type="radio" id="<?php echo $name; ?>" name="action" value="<?php echo $name; ?>" <?php checked( 'assign' == $name ); ?> />
			<label for="<?php echo $name; ?>"><strong><?php echo $label; ?>.</strong></label>
		</p>
<?php
} // foreach( valid_actions_multiple_images )
$img_ids = is_array( $this->selected_multiple_image_ids ) ? implode( ',', $this->selected_multiple_image_ids ) : '';
?>
<p><?php _e( 'To select multiple images click on the button and use the CTRL key while clicking on the images.', $this->plugin_slug ); ?></p>
<p><input type="hidden" id="multiple_image_ids" name="multiple_image_ids" value="<?php echo $img_ids; ?>">
<input type="button" id="select_images_multiple" class="button" value="<?php _e( 'Choose Images', $this->plugin_slug ); ?>" /></p>
<?php
if ( $this->selected_multiple_image_ids ) {
?>
<ul class="selected_images">
<?php
	$size = array( 60, 60 );
	foreach( $this->selected_multiple_image_ids as $attachment_id ) {
?>	<li><?php echo wp_get_attachment_image( $attachment_id, $size ); ?></li>
<?php
	} // foreach()
?>
</ul>
<?php
} // if ( $this->selected_multiple_image_ids )
?>
		<h4><?php _e( 'Actions without a selected image', $this->plugin_slug ); ?></h4>
		<p><?php _e( 'These actions do not require a selected image.', $this->plugin_slug ); ?></p>
<?php
foreach ( $this->valid_actions_without_image as $name => $label ) {
?>
		<p>
			<input type="radio" id="<?php echo $name; ?>" name="action" value="<?php echo $name; ?>" <?php checked( 'assign' == $name ); ?> />
			<label for="<?php echo $name; ?>"><strong><?php echo $label; ?>.</strong></label>
		</p>
<?php
}
?>
	</fieldset>
<?php 
wp_nonce_field( 'quickfi_start', $this->plugin_slug . '_nonce' ); 
submit_button( __( 'Next', $this->plugin_slug ), 'secondary' );
?>
</form>
