<?php
/**
 * The header template
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * @package Starter_Theme
 */
?>
 
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
 
<head>
    <meta charset="<?php bloginfo( "charset" ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); // Lets other plugins and files tie into our theme's <head>?>
</head>
 
<body <?php body_class(); ?>>
<div id="page">

    <header id="top" role="banner" class="site-header container">
        <a href="#main" class="screen-reader-text" id="skiptomain"><?php esc_html_e('Skip to content', 'starter-theme'); ?></a>
        
        <h1>
            <a href="<?php echo esc_url( home_url( "/" ) ); ?>">
                <?php bloginfo("name"); ?>
            </a>
        </h1>

        <nav id="siteNavigation" class="siteNavigation siteNavigation--Main" role="navigation">
            <ul class="siteMenu siteMenu--Main">
                <?php wp_nav_menu( 
                    array( "theme_location" => "primary", 
                            "container"     => '', 
                            'items_wrap'    => '%3$s' 
                    ) ); ?>
            </ul><!-- .menu -->

            <button class="siteNavigation--Toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'starter-theme' ); ?></button>
        </nav><!-- siteNavigation -->  
    </header><!--  .container -->

<main id="main">