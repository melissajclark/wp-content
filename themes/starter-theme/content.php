<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h1>
        <span class="entry-date"><?php echo get_the_date(); ?></span>

       <span class="entry-meta">
           <span itemprop="author">

            <?php 

            if (is_single() ) : 
                the_author_posts_link();

            elseif ( is_home() ) :
                the_author_posts_link(); 
            
            endif;
            ?>
            </span>
        </span>
        
    </header><!-- .entry-header -->

    <div class="entry-content">
    <?php echo get_the_post_thumbnail($post_id, 'large') ?>
        <?php the_content(); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'starter-theme' ) . '</span>', 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">

    <p><?php _e('Category: '); ?><?php the_category(', '); ?></p>

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
