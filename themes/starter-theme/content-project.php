 <?php while ( have_posts() ) : the_post(); ?>
        
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

           <header class="entry-header">
               <h2 class="entry-title">
                   <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
               </h2>
           </header><!-- .entry-header -->

           <div class="entry-content">
               <?php the_content(); ?>
               <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'starter-theme' ) . '</span>', 'after' => '</div>' ) ); ?>
           </div><!-- .entry-content -->

           <footer class="entry-meta">

               <?php the_tags( '<div class="post-tags">' . __( 'Tagged: ', 'starter-theme' ) , ', ', '</div>' ); ?>

           </footer><!-- #entry-meta -->
       </article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; ?>

