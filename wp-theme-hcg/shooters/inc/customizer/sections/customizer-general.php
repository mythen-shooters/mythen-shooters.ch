<?php
/**
 * General Settings
 *
 * Register General section, settings and controls for Theme Customizer
 *
 * @package WorldStar
 */
 
/**
 * Adds all general settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function worldstar_customize_register_general_settings( $wp_customize ) {
	// Add Section for Theme Options.
	$wp_customize->add_section( 'worldstar_section_general', array(
		'title'    => esc_html__( 'General Settings', 'worldstar' ),
		'priority' => 10,
		'panel' => 'worldstar_options_panel',
		)
	);
	// Add Settings and Controls for Theme Width.
	$wp_customize->add_setting( 'worldstar_theme_options[theme_width]', array(
		'default'           => 'wide-layout',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'worldstar_sanitize_select',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[theme_width]', array(
		'label'    => esc_html__( 'Theme Width', 'worldstar' ),
		'section'  => 'worldstar_section_general',
		'settings' => 'worldstar_theme_options[theme_width]',
		'type'     => 'radio',
		'priority' => 1,
		'choices'  => array(
			'wide-layout' => esc_html__( 'Wide Layout', 'worldstar' ),
			'boxed-layout' => esc_html__( 'Boxed Layout', 'worldstar' ),
			),
		)
	);
	// Add Settings and Controls for Layout.
	$wp_customize->add_setting( 'worldstar_theme_options[theme_layout]', array(
		'default'           => 'right-sidebar',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'worldstar_sanitize_select',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[theme_layout]', array(
		'label'    => esc_html__( 'Theme Layout', 'worldstar' ),
		'section'  => 'worldstar_section_general',
		'settings' => 'worldstar_theme_options[theme_layout]',
		'type'     => 'radio',
		'priority' => 1,
		'choices'  => array(
			'left-sidebar' => esc_html__( 'Left Sidebar', 'worldstar' ),
			'right-sidebar' => esc_html__( 'Right Sidebar', 'worldstar' ),
			),
		)
	);
	// Add Title for latest posts setting.
	$wp_customize->add_setting( 'worldstar_theme_options[blog_title]', array(
		'default'           => esc_html__( 'Latest Posts', 'worldstar' ),
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_html',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[blog_title]', array(
		'label'    => esc_html__( 'Blog Title', 'worldstar' ),
		'section'  => 'worldstar_section_general',
		'settings' => 'worldstar_theme_options[blog_title]',
		'type'     => 'text',
		'priority' => 1,
		)
	);
}
add_action( 'customize_register', 'worldstar_customize_register_general_settings' );
