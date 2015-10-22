<?php 
/**
 *
 * Article: wraps around all content
 *
 **/ ?>

 <?php if ( is_singular('post') ) : ?>
   
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/BlogPosting">

<?php else : ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php endif; ?>
        
<?php 
/**
*
* Entry-Header: If statement outputs linked H2s for feed templates (archives, index, etc)
*             - On singular templates non-linked H2s are used
*             - Entry-meta - author & date are output on non-static content 
**/ ?>
    
<header class="entry-header">

    <?php if ( is_singular() ) : // no link around title if it is a single post ?>
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
    <?php else : ?>     
        <h2 class="entry-title" itemprop="name">
            <a itemprop="url" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2>
    <?php endif; ?>

    <?php if ( is_singular('post') || is_home() || is_archive() ) : // display entra meta only on post & blog templates ?>
        <span class="entry-meta">
            <span class="entry-date" itemprop="datePublished" content="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></span>
            <span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php the_author_posts_link(); ?></span>  

            <?php if ( has_category() && !has_tag() ) : ?>
                <span><?php esc_html_e('Category: ', 'starter-theme'); ?><?php the_category(', '); // comma only to remove usual bulleted list of terms ?></span>

            <?php elseif ( has_category() && has_tag() ) : ?>
                <span><?php esc_html_e('Category: ', 'starter-theme'); ?><?php the_category(', '); // comma only to remove usual bulleted list of terms ?> <?php esc_html_e('Tagged: ', 'starter-theme'); ?><?php the_tags(''); // comma only to remove usual "Tags" before list of terms ?></span>

            <?php elseif ( !has_category() && has_tag() ) : ?>
                <span><?php esc_html_e('Tagged: ', 'starter-theme'); ?><?php the_tags(''); // comma only to remove usual "Tags" before list of terms ?></span>
            <?php endif; ?>
        </span><!-- / entry-meta -->   
    <?php endif; ?>
</header><!-- .entry-header -->

<?php 
/**
*
* Entry-Content: If statement outputs content or excerpt, or custom fields depending on the template in use
*
**/ ?>

<section class="entry-content">
    <?php if (is_archive() ) : // displays the excerpt if it is an archive, otherwise shows the full content ?>
        <p itemprop="description"><?php the_excerpt(); ?></p>

    <?php else : // for all other templates, show this content ?>
        <?php the_content(); ?>
    <?php endif; ?>

    <?php if ( is_page() ) : // include the page-links if it is a page ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'starter-theme' ) . '</span>', 'after' => '</div>' ) ); ?>
    <?php endif; ?>
</section><!-- .entry-content -->

<?php 
/**
*
* Footer Entry Meta: If statement displays it on single blog posts or the blog feed (index.php)
*
**/ ?>

<?php if ( is_singular() && !is_page() ) : ?>
    <footer class="entry-meta">
        <div class="comments-link">
            <?php comments_popup_link( 
                 __( 'Leave a comment', 'starter-theme' ), 
                 __( '1 comment', 'starter-theme' ), 
                 __( '% comments', 'starter-theme' ) ); 
            ?>
        </div>
    </footer><!-- #entry-meta -->
<?php endif; // end footer entry-meta conditional ?>

</article><!-- #post-<?php the_ID(); ?> -->