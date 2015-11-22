<?php
/**
 * The template file is used for displaying social media links.
 *
 * @package Starter_Theme
 */

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function starter_theme_social_profiles( $wp_customize ) {
	
    $wp_customize->add_section(
        'custom_social_profiles',
        array(
            'title' 		=> 'Social Profiles',
            'description' 	=> 'This info will display in the footer, after the Website Name.',
            'priority' 		=> 100,
        )
    );

    $wp_customize->add_setting(
        'social_profile',
        array(
            'default' => 'All Rights ',
        )
    );

    $wp_customize->add_control(
        'social_profile',
        array(
            'label' => 'Copyright text',
            'section' => 'custom_social_profiles',
            'type' => 'text',
        )
    );
}
add_action( 'customize_register', 'starter_theme_social_profiles' );