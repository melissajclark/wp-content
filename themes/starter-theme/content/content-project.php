<!-- Individual Article / Project -->
<article id="post-<?php the_ID(); ?>" data-date="<?php the_field('date'); ?>" data-language="<?php the_field('language'); ?>" data-people="<?php the_field('team_members'); ?>" data-location="<?php the_field('city'); ?>" data-status="<?php  $term_list = wp_get_post_terms($post->ID, 'status', array("fields" => "names"));
print_r($term_list); ?>"  <?php post_class("filterableItem"); ?>>


    <header class="entry-header">
        <h1 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h1>
        <span class="entry-date"><?php echo get_the_date(); ?></span>
    </header><!-- .entry-header -->

    <div class="entry-content">
    <ul style="list-style-type:none; display:inline-block; margin: 0em 0em 0em 0em; padding: 0 0 0 0;">
        <li><strong>Date:</strong> <?php the_field('date'); ?></li>
        <li><strong>Language:</strong> <?php the_field('language'); ?></li>
        <li><strong>People:</strong> <?php the_field('team_members'); ?></li>
        <li><strong>Location:</strong> <?php the_field('city'); ?></li>
        
        <?php
            $taxonomy = 'status';

            // get the term IDs assigned to post.
            $post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
            // separator between links
            $separator = ', ';

            if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {

                $term_ids = implode( ',' , $post_terms );
                $terms = wp_list_categories( 'title_li=&style=none&echo=0&taxonomy=' . $taxonomy . '&include=' . $term_ids );
                $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

                // display post categories
                echo  $terms;
            }
        ?>
    </ul>

          
        <!-- <?php the_content(); ?> -->
        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'starter-theme' ) . '</span>', 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">

        <?php the_tags( '<div class="post-tags">' . __( 'Tagged: ', 'starter-theme' ) , ', ', '</div>' ); ?>

        <div class="comments-link">
            <?php comments_popup_link( 
                 __( 'Leave a comment', 'starter-theme' ), 
                 __( '1 comment', 'starter-theme' ), 
                 __( '% comments', 'starter-theme' ) ); 
            ?>
        </div>
    </footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->