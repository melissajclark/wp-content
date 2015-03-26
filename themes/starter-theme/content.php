<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">

        <?php 
        if ( is_single() ) : // no link around title if it is a single post?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php else : ?>     
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
        <?php endif; ?>
        <span class="entry-date"><?php echo get_the_date(); ?></span>

       <span class="entry-meta">
           <span itemprop="author">

            <?php 

            if (is_single() || is_home() || is_archive() ) : 
                the_author_posts_link();

            else : 
                // do not display date
            
            endif; ?>
            </span>
        </span>
        
    </header><!-- .entry-header -->

    <div class="entry-content">
    <?php echo get_the_post_thumbnail($post_id, 'large') ?>
    
        <?php // displays the excerpt if it is an archive, otherwise shows the full content

        if (is_archive() ) : 
            the_excerpt();

        else :
            the_content();
        endif; ?>

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
