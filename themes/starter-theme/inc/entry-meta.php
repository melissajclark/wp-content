<?php
/**
 * The template file is used for displaying entry meta on blog posts.
 *
 * @package Starter_Theme
 */
?>

<p class="entry-meta">
    <span class="entry-date" itemprop="datePublished" content="<?php echo get_the_date(); ?>"><?php echo get_the_date(); ?></span>
    <span itemprop="author" itemscope itemtype="http://schema.org/Person"><?php the_author_posts_link(); ?></span>  

    <?php if ( has_category() && !has_tag() ) : ?>
        <span><?php esc_html_e('Category: ', 'starter-theme'); ?><?php the_category(', '); // comma only to remove usual bulleted list of terms ?></span>

    <?php elseif ( has_category() && has_tag() ) : ?>
        <span><?php esc_html_e('Category: ', 'starter-theme'); ?><?php the_category(', '); // comma only to remove usual bulleted list of terms ?> <?php esc_html_e('Tagged: ', 'starter-theme'); ?><?php the_tags(''); // comma only to remove usual "Tags" before list of terms ?></span>

    <?php elseif ( !has_category() && has_tag() ) : ?>
        <span><?php esc_html_e('Tagged: ', 'starter-theme'); ?><?php the_tags(''); // comma only to remove usual "Tags" before list of terms ?></span>
    <?php endif; ?>
</p><!-- / entry-meta -->   