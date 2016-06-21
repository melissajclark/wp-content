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
// -------------------------------------
function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// function to set default image link to none
// ------------------------------------------
update_option('image_default_link_type','none');

// enable SVG support
// -----------------
function cc_mime_types($mimes) {
$mimes['svg'] = 'image/svg+xml';
return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/*-----  End of Useful Functions to Override WP Defaults  ------*/


/**
*
* Register Custom Post Type
*
**/

/* [To Do]: replace "post-type-plural" and "post-type-singular" with desired post type name OR remove this code */

// add_action( 'init', 'cptui_register_my_cpts' );
// function cptui_register_my_cpts() {

    /**
    *
    * Example Code to Register Post Type
    *
    **/
    
    // $labels = array(
    //     "name" => "post-type-plural",
    //     "singular_name" => "post-type-singular",
    //     "all_items" => "All post-type-plural",
    //     "add_new" => "Add New",
    //     "add_new_item" => "Add New post-type-singular",
    //     "edit" => "Edit",
    //     "edit_item" => "Edit post-type-singular",
    //     "new_item" => "New post-type-singular",
    //     "view" => "View",
    //     "view_item" => "View post-type-singular",
    //     "search_items" => "Search post-type-plural",
    //     "not_found" => "No post-type-plural Found",
    //     "not_found_in_trash" => "No post-type-plural Found in Trash",
    //     );

    // $args = array(
    //     "labels" => $labels,
    //     "description" => "post-type-plural",
    //     "public" => true,
    //     "show_ui" => true,
    //     "has_archive" => false,
    //     "show_in_menu" => true,
    //     "exclude_from_search" => false,
    //     "capability_type" => "post",
    //     "map_meta_cap" => true,
    //     "hierarchical" => true,
    //     "rewrite" => array( "slug" => "post-type-plural", "with_front" => true ),
    //     "query_var" => true,
    //     "menu_position" => 8,               
    //     "supports" => array( "title", "editor", "thumbnail" ),      
    //     "taxonomies" => array( "example-taxonomy", "another-example-taxonomy" )   );
    // register_post_type( "post-type-singular", $args );

// End of cptui_register_my_cpts()
// }

/**
*
* Register Custom Taxonomies
*
**/

/* [To Do]: replace "taxonomy-name-plural" and "taxonomy-name-singular" with desired name" OR remove this code */

// add_action( 'init', 'cptui_register_my_taxes' );
// function cptui_register_my_taxes() {

//     $labels = array(
//         "name" => "taxonomy-name-plural",
//         "label" => "taxonomy-name-plural",
//         "menu_name" => "taxonomy-name-plural",
//         "all_items" => "All taxonomy-name-plural",
//         "edit_item" => "Edit taxonomy-name-singular",
//         "view_item" => "View taxonomy-name-singular",
//         "update_item" => "Update taxonomy-name-singular Name",
//         "add_new_item" => "Add New taxonomy-name-singular",
//         "new_item_name" => "New taxonomy-name-singular Name",
//         "parent_item" => "Parent taxonomy-name-singular",
//         "parent_item_colon" => "Parent taxonomy-name-singular:",
//         "search_items" => "Search taxonomy-name-plural",
//         "popular_items" => "Popular taxonomy-name-plural",
//         "separate_items_with_commas" => "Separate taxonomy-name-plural with commas",
//         "add_or_remove_items" => "Add or remove taxonomy-name-plural",
//         "choose_from_most_used" => "Choose from most used taxonomy-name-plural",
//         "not_found" => "No taxonomy-name-plural found",
//             );

//     $args = array(
//         "labels" => $labels,
//         "hierarchical" => true,
//         "label" => "taxonomy-name-plural",
//         "show_ui" => true,
//         "query_var" => true,
//         "rewrite" => array( 'slug' => 'taxonomy-name-plural', 'with_front' => true ),
//         "show_admin_column" => true,
//     );
//     register_taxonomy( "taxonomy-name-plural", array( "post-type-singular" ), $args );

// // End cptui_register_my_taxes
// }