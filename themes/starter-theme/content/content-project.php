<!-- Individual Article / Project -->
<article id="post-<?php the_ID(); ?>" data-date="<?php the_field('date'); ?>" data-language="<?php the_field('language'); ?>" data-people="<?php the_field('team_members'); ?>" data-location="<?php the_field('city'); ?>" data-status='<?php $terms = get_the_terms( $post->ID, 'status');
                        
if ( $terms && ! is_wp_error( $terms ) ) : 

    $status_links = array();

    foreach ( $terms as $term ) {
        $status_links[] = $term->slug;
    }
                        
    $on_status = join(",", $status_links);
?>
    <?php echo $on_status; ?>

<?php endif; ?>'<?php post_class("filterableItem"); ?>>

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
        <li><strong>Status:</strong><?php $terms = get_the_terms( $post->ID, 'status');
                        
if ( $terms && ! is_wp_error( $terms ) ) : 

    $status_links = array();

    foreach ( $terms as $term ) {
        $status_links[] = $term->name;
    }
                        
    $on_status = join(", ", $status_links);
?>
    <?php echo $on_status; ?>

<?php endif; ?></li>

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