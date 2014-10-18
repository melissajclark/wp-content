<?php
/**
 * Options Page
 *
 * @package   Quick_Featured_Images_Admin
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://wordpress.org/plugins/quick-featured-images/
 * @copyright 2014 
 */

$qfi_tools_instance    = Quick_Featured_Images_Tools::get_instance();
$qfi_defaults_instance = Quick_Featured_Images_Defaults::get_instance();
$qfi_settings_instance = Quick_Featured_Images_Settings::get_instance();
$img_base = dirname( plugin_dir_url( __FILE__ ) ) . '/assets/images/';
?>

<h3><?php _e( 'Manage featured images in a quick way', $this->plugin_slug ); ?></h3>
<p><?php echo $this->get_page_description(); ?></p>
<ul>
	<li>
		<h4><?php echo $qfi_tools_instance->get_page_headline(); ?></h4>
<?php
if ( current_user_can( $qfi_tools_instance->get_required_user_cap() ) ) {
	printf( 
		'		<p><a href="%s"><span class="dashicons dashicons-admin-tools"></span><br />%s</a></p>',
		admin_url( sprintf( 'admin.php?page=%s', $qfi_tools_instance->get_page_slug() ) ),
		$qfi_tools_instance->get_page_description()
	);
} else {
?>
		<p><span class="dashicons dashicons-admin-tools"></span><br /><?php _e( 'Bulk set, replace and remove featured images', $this->plugin_slug ); ?></p>
		<p><?php _e( 'You have not the privileges to edit others posts. If you want to use this page ask your WordPress administrator.', $this->plugin_slug ); ?></p>
<?php
}
?>
	</li>
	<li>
		<h4><?php echo $qfi_defaults_instance->get_page_headline(); ?></h4>
<?php
if ( current_user_can( $qfi_defaults_instance->get_required_user_cap() ) ) {
	printf( 
		'						<p><a href="%s"><span class="dashicons dashicons-images-alt"></span><br />%s</a></p>',
		admin_url( sprintf( 'admin.php?page=%s', $qfi_defaults_instance->get_page_slug() ) ),
		$qfi_defaults_instance->get_page_description()
	);
} else {
?>
		<p><span class="dashicons dashicons-admin-defaults"></span><br /><?php _e( 'Set default featured images', $this->plugin_slug ); ?></p>
		<p><?php _e( 'You have not the privileges to manage options. If you want to use this page ask your WordPress administrator.', $this->plugin_slug ); ?></p>
<?php
}
?>
	</li>
	<li>
		<h4><?php echo $qfi_settings_instance->get_page_headline(); ?></h4>
<?php
if ( current_user_can( $qfi_settings_instance->get_required_user_cap() ) ) {
	printf( 
		'						<p><a href="%s"><span class="dashicons dashicons-admin-settings"></span><br />%s</a></p>', 	
		admin_url( sprintf( 'admin.php?page=%s', $qfi_settings_instance->get_page_slug() ) ), 
		$qfi_settings_instance->get_page_description() 
	);
} else {
?>
		<p><span class="dashicons dashicons-admin-settings"></span><br /><?php _e( 'Set the visibility of columns of featured images in posts lists', $this->plugin_slug ); ?></p>
		<p><?php _e( 'You have not the privileges to manage options. If you want to use this page ask your WordPress administrator.', $this->plugin_slug ); ?></p>
<?php
}
?>
	</li>
</ul>
