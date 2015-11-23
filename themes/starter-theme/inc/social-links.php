<?php
/**
 * Social Media Links
 * 
 * Values for these links are set using the customizer.
 *
 * @package Starter_Theme
 */
?>

<?php $twitterURL = get_theme_mod('social_profile_twitter'); ?>

<?php if ( !empty($twitterURL) ) : ?>
	<a href="<?php echo esc_url('https://www.twitter.com/' . $twitterURL); ?>"><?php esc_html_e( 'Twitter', 'starter-theme' ); ?></a>
<?php endif; ?>

<?php $instagramURL = get_theme_mod('social_profile_instagram'); ?>

<?php if ( !empty($instagramURL) ) : ?>
	<a href="<?php echo esc_url('https://www.instagram.com/' . $instagramURL); ?>"><?php esc_html_e( 'Instagram', 'starter-theme' ); ?></a>
<?php endif; ?>

<?php $linkedinURL = get_theme_mod('social_profile_linkedin'); ?>

<?php if ( !empty($linkedinURL) ) : ?>
	<a href="<?php echo esc_url($linkedinURL); ?>"><?php esc_html_e( 'Linkedin', 'starter-theme' ); ?></a>
<?php endif; ?>