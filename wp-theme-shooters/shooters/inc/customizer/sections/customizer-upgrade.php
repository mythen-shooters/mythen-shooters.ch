<?php
/**
 * Pro Version Upgrade Section
 *
 * Registers Upgrade Section for the Pro Version of the theme
 *
 * @package WorldStar
 */
 
/**
 * Adds pro version description and CTA button
 *
 * @param object $wp_customize / Customizer Object.
 */
function worldstar_customize_register_upgrade_settings( $wp_customize ) {
	// Add Upgrade / More Features Section.
	$wp_customize->add_section( 'worldstar_section_upgrade', array(
		'title'    => esc_html__( 'More Features', 'worldstar' ),
		'priority' => 70,
		'panel' => 'worldstar_options_panel',
		)
	);
	// Add custom Upgrade Content control.
	$wp_customize->add_setting( 'worldstar_theme_options[upgrade]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new WorldStar_Customize_Upgrade_Control(
		$wp_customize, 'worldstar_theme_options[upgrade]', array(
		'section' => 'worldstar_section_upgrade',
		'settings' => 'worldstar_theme_options[upgrade]',
		'priority' => 1,
		)
	) );
}
add_action( 'customize_register', 'worldstar_customize_register_upgrade_settings' );
