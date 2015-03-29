<?php 
/**
 *
 * Article: Custom taxonomy + classes are created for 'Projects' post_type
 *          - Otherwise, the article element is created as usual   
 *
 **/ ?>

    <?php if ( is_singular('projects') || is_archive('projects') ) :  // Article element around content: if it's the 'projects' post_type: append taxonomy data-attributes to element  ?>

        <article id="post-<?php the_ID(); ?>" 

             data-tools="<?php // displays values for custom taxonomy 'tools' language attached to post
              $terms = get_the_terms( $post->ID, 'tools'); // gets the taxonomy
                                      
              if ( $terms && ! is_wp_error( $terms ) ) : 
                  $status_links = array();

                  foreach ( $terms as $term ) {
                      $status_links[] = $term->name;
                  }                                  
                  $on_status = join(", ", $status_links);                                
              echo $on_status; ?><?php endif; ?>" <?php post_class('filterableItem'); ?>>

    <?php else : // Article element around content: not a 'project'? Set up the <article> as normal ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        
    <?php endif; // End of conditional statement for setting up article element ?>

<?php 
/**
*
* Entry-Header: If statement outputs linked H2s for feed templates (archives, index, etc)
*             - On singular templates non-linked H2s are used
*             - Entry-meta - author & date are output on non-static content 
*
**/ ?>
    
    <header class="entry-header">

        <?php 
        if ( is_single() || is_page() ) : // no link around title if it is a single post?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php else : ?>     
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
        <?php endif; ?>
        
        <?php // conditional statement displays entry-meta on apropriate templates (not pages or projects) 
            if ( is_singular('projects') ) : ?>

            <?php // do not display anything ?>

        <?php 
            elseif (is_single() || is_home() || is_archive() && ! is_archive('projects') ) : ?>

            <span class="entry-meta">
                <span class="entry-date"><?php echo get_the_date(); ?></span>
                <span itemprop="author"><?php the_author_posts_link(); ?></span>  
            </span><!-- / entry-meta -->

        <?php else :  // do not display date ?>
               
        <?php endif; ?>
    </header><!-- .entry-header -->

<?php 
/**
 *
 * Entry-Content: If statement outputs content or excerpt, or custom fields depending on the template in use
 *
 **/ ?>

    <div class="entry-content">
    
        <?php // displays the excerpt if it is an archive, otherwise shows the full content

            if (is_archive() ) : // checks if its an archive and shows content accordingly ?>
                <?php echo get_the_post_thumbnail($post_id, 'large') ?>
                <?php the_excerpt(); ?>

            <?php else : // for all other templates, show this content ?>

                <?php get_template_part('inc/gallery'); ?>   
                <?php the_content(); ?>

        <?php endif; ?>

        <?php if ( is_page() ) : // include the page-links if it is a page ?>

            <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'starter-theme' ) . '</span>', 'after' => '</div>' ) ); ?>

        <?php endif; ?>

    </div><!-- .entry-content -->

<?php 
/**
 *
 * Footer Entry Meta: If statement displays it on single blog posts or the blog feed (index.php)
 *
 **/ ?>

        <?php // display the footer entry-meta on apropriate templates (blog feed, single posts)
            if ( is_singular('projects') ) : ?>

        <?php 
          elseif ( is_single() || is_home() ) : ?>

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

            <?php else : // doesn't match? don't show anything! ?>

        <?php endif; // end footer entry-meta conditional ?>

</article><!-- #post-<?php the_ID(); ?> -->
