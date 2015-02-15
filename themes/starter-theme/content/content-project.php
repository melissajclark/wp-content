<article id="post-<?php the_ID(); ?>" data-date="<?php the_field('date'); ?>" data-language="<?php the_field('language'); ?>" data-people="<?php the_field('team_members'); ?>" data-location="<?php the_field('city'); ?>"<?php post_class("projectItem"); ?>>
    <header class="entry-header">
        <h1 class="entry-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h1>
        <span class="entry-date"><?php echo get_the_date(); ?></span>
    </header><!-- .entry-header -->

    <div class="entry-content">
    <ul>
        <li>Date: <?php the_field('date'); ?></li>
        <li>Language: <?php the_field('language'); ?></li>
        <li>People: <?php the_field('team_members'); ?></li>
        <li>Location: <?php the_field('city'); ?></li>

    </ul>
          
        <?php the_content(); ?>
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
