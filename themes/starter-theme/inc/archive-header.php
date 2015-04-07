<header class="archive-header">
    <h1 class="entry-title">
    <?php
        if ( is_category() ) :
            single_cat_title( _e('Category: ') ); 

        elseif ( is_tag() ) :
            single_tag_title( _e('Tag: '));

        elseif ( is_author() ) :
            printf( __( 'Author: %s', 'starter-theme' ), '<span>' . get_the_author() . '</span>' );

        elseif ( is_day() ) :
            printf( __( 'Day: %s', 'starter-theme' ), '<span>' . get_the_date() . '</span>' );

        elseif ( is_month() ) :
            printf( __( 'Month: %s', 'starter-theme' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'starter-theme' ) ) . '</span>' );

        elseif ( is_year() ) :
            printf( __( 'Year: %s', 'starter-theme' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'starter-theme' ) ) . '</span>' );
        else :
            _e( 'Archives', 'starter-theme' );

        endif;
    ?>
    </h1>
</header>