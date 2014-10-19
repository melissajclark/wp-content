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