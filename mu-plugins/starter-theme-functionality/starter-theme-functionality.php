<?php
/**
 * Plugin Name:       Starter_Theme Functionality Plugin
 * Description:       This plugin stores all custom functionality for the Starter_Theme website.
 * Version:           1.0.0
 * Author:            Melissa Jean Clark
 * Author URI:        http://melissajclark.ca
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       starter-theme-functionality
 * Domain Path:       /languages
 */

/**
*
* Useful Function to override WordPress defaults
*
**/

// function to remove <p> tags on images
function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// function to set default image link to none
update_option('image_default_link_type','none');

/*-----  End of Useful Functions to Override WP Defaults  ------*/