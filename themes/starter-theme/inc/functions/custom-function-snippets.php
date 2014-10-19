 <!-- Category Description -->

<?php if ( category_description() ) :
    echo '<div class="description">';
        echo category_description();
    echo '</div>';
endif; ?>

<?php // don't include the opening php tag if adding to functions.php

// use this to change the paging for archives (grids)
function starter_theme_custom_query( $query ) {
    if ( is_archive() && !is_admin() ) {
         $query->set( 'nopaging', true );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'starter_theme_custom_query' );

// use this to change the paging for a specific category
function starter_theme_custom_query( $query ) {
    if ( is_category( 'Recipes' ) && !is_admin() ) {
         $query->set( 'posts_per_page', 18 );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'starter_theme_custom_query' );

// use this to change the post order for a specific category
function starter_theme_custom_query( $query ) {
    if ( is_category( 'Locations' ) && !is_admin() ) {
         $query->set( 'orderby', 'title' );
         $query->set( 'order', 'ASC' );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'starter_theme_custom_query' );


// example of making multiple modifications in one function
function starter_theme_custom_query( $query ) {
    if ( is_category( 'Recipes' ) && !is_admin() ) {
         $query->set( 'nopaging', true );
         $query->set( 'orderby', 'menu_order' );
         $query->set( 'order', 'ASC' );
    }
    return $query;
}
add_filter( 'pre_get_posts', 'starter_theme_custom_query' );


/**
 * Remove the front-end admin bar for everybody, always
 */
show_admin_bar( false );

/**
 * Add TinyMCE buttons that are disabled by default to 2nd row
 */
function starter_theme_mce_buttons($buttons) {    
 $buttons[] = 'justify'; // fully justify text
 $buttons[] = 'hr'; // insert HR

 return $buttons;
}
add_filter('mce_buttons_2', 'starter_theme_mce_buttons');

/**
 * Remove from TinyMCE all colors except those specified
 */
function starter_theme_change_mce_colors( $init ) {
 $init['theme_advanced_text_colors'] = '8dc63f';
 $init['theme_advanced_more_colors'] = false;
return $init;
}
add_filter('tiny_mce_before_init', 'starter_theme_change_mce_colors');