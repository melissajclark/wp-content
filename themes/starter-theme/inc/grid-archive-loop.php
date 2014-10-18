 <?php while ( have_posts() ) : the_post(); ?>
        
           <div class="grid-item">
               <a href="<?php the_permalink(); ?>">
                   <?php the_post_thumbnail( 'thumbnail' ); ?>
                   <h2 class="caption"><?php the_title(); ?></h2>
               </a>
           </div>

       <?php endwhile; ?>