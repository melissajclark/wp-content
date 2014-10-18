<?php
/**
 * Represents the header for the admin page
 *
 * @package   Quick_Featured_Images
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://stehle-internet.de
 * @copyright 2013 Martin Stehle
 */
 ?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<h3><?php _e( 'Progress bar', $this->plugin_slug ); ?></h3>
	<p id="progress">
		<em class="screen-reader-text"><?php _e( 'You are here', $this->plugin_slug ); ?>:</em>
		<span id="bar" class="wp-ui-primary">
<?php 
$count = 1;
$max = sizeof( $this->valid_steps );
foreach ( $this->valid_steps as $key => $label ) {
	if ( $this->selected_step == $key ) {
		$elem = 'strong';
		$class = 'wp-ui-highlight';
	} else {
		$elem = 'span'; 
		$class = 'wp-ui-notification';
	}
	printf( '<%s class="%s">%s</%s>', $elem, $class, $label, $elem );
	if ( $count < $max ) {
		print '<span class="sep"> &gt; </span>';
	}
	$count++;
}
?>
	</span>
</p>

<div class="th_wrapper">
	<div id="th_main">
		<div class="th_content">
