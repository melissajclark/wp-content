<?php
/**
 * Represents the header for the admin page
 *
 * @package   Quick_Featured_Images
 * @author    Martin Stehle <m.stehle@gmx.de>
 * @license   GPL-2.0+
 * @link      http://stehle-internet.de
 * @copyright 2014 Martin Stehle
 */
 ?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<?php include_once 'options-head.php'; // print out success or error messages from the Settings API ?>
	<div class="th_wrapper">
		<div id="th_main">
			<div class="th_content">
			