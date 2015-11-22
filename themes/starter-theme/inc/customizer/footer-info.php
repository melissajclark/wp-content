<?php
/**
 * The template file is used for displaying the customized footer.
 *
 * @package Starter_Theme
 */

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function starter_theme_customize_footer( $wp_customize ) {
	
    $wp_customize->add_section(
        'customized_footer_settings',
        array(
            'title' 		=> 'Copyright Info',
            'description' 	=> 'This info will display in the footer, after the Website Name.',
            'priority' 		=> 100,
        )
    );

    $wp_customize->add_setting(
        'copyright_textbox',
        array(
            'default' => 'All Rights ',
        )
    );

    $wp_customize->add_control(
        'copyright_textbox',
        array(
            'label' => 'Copyright text',
            'section' => 'customized_footer_settings',
            'type' => 'text',
        )
    );
}
add_action( 'customize_register', 'starter_theme_customize_footer' );