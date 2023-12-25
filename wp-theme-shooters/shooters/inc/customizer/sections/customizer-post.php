<?php
/**
 * Post Settings
 *
 * Register Post Settings section, settings and controls for Theme Customizer
 *
 * @package WorldStar
 */
 
/**
 * Adds post settings in the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function worldstar_customize_register_post_settings( $wp_customize ) {
	// Add Sections for Post Settings.
	$wp_customize->add_section( 'worldstar_section_post', array(
		'title'    => esc_html__( 'Post Settings', 'worldstar' ),
		'priority' => 30,
		'panel' => 'worldstar_options_panel',
		)
	);
	// Add Post Layout Settings for archive posts.
	$wp_customize->add_setting( 'worldstar_theme_options[post_layout]', array(
		'default'           => 'two-columns',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'worldstar_sanitize_select',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[post_layout]', array(
		'label'    => esc_html__( 'Post Layout (archive pages)', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[post_layout]',
		'type'     => 'select',
		'priority' => 1,
		'choices'  => array(
			'one-column' => esc_html__( 'One Column', 'worldstar' ),
			'two-columns' => esc_html__( 'Two Columns', 'worldstar' ),
			),
		)
	);
	// Add Settings and Controls for post content.
	$wp_customize->add_setting( 'worldstar_theme_options[post_content]', array(
		'default'           => 'excerpt',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'worldstar_sanitize_select',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[post_content]', array(
		'label'    => esc_html__( 'Post Length (archive pages)', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[post_content]',
		'type'     => 'radio',
		'priority' => 2,
		'choices'  => array(
			'index' => esc_html__( 'Show full posts', 'worldstar' ),
			'excerpt' => esc_html__( 'Show post excerpts', 'worldstar' ),
			),
		)
	);
	// Add Setting and Control for Excerpt Length.
	$wp_customize->add_setting( 'worldstar_theme_options[excerpt_length]', array(
		'default'           => 20,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[excerpt_length]', array(
		'label'    => esc_html__( 'Excerpt Length', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[excerpt_length]',
		'type'     => 'text',
		'active_callback' => 'worldstar_control_post_content_callback',
		'priority' => 3,
		)
	);
	// Add Post Meta Settings.
	$wp_customize->add_setting( 'worldstar_theme_options[postmeta_headline]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new WorldStar_Customize_Header_Control(
		$wp_customize, 'worldstar_theme_options[postmeta_headline]', array(
			'label' => esc_html__( 'Post Meta', 'worldstar' ),
			'section' => 'worldstar_section_post',
			'settings' => 'worldstar_theme_options[postmeta_headline]',
			'priority' => 4,
		)
	) );
	$wp_customize->add_setting( 'worldstar_theme_options[meta_date]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[meta_date]', array(
		'label'    => esc_html__( 'Display post date', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[meta_date]',
		'type'     => 'checkbox',
		'priority' => 5,
		)
	);
	$wp_customize->add_setting( 'worldstar_theme_options[meta_author]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[meta_author]', array(
		'label'    => esc_html__( 'Display post author', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[meta_author]',
		'type'     => 'checkbox',
		'priority' => 6,
		)
	);
	$wp_customize->add_setting( 'worldstar_theme_options[meta_category]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[meta_category]', array(
		'label'    => esc_html__( 'Display post categories', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[meta_category]',
		'type'     => 'checkbox',
		'priority' => 7,
		)
	);
	$wp_customize->add_setting( 'worldstar_theme_options[meta_comments]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[meta_comments]', array(
		'label'    => esc_html__( 'Display post comments', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[meta_comments]',
		'type'     => 'checkbox',
		'priority' => 8,
		)
	);
	// Add Post Footer Settings.
	$wp_customize->add_setting( 'worldstar_theme_options[single_posts_headline]', array(
		'default'           => '',
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'esc_attr',
		)
	);
	$wp_customize->add_control( new WorldStar_Customize_Header_Control(
		$wp_customize, 'worldstar_theme_options[single_posts_headline]', array(
			'label' => esc_html__( 'Single Posts', 'worldstar' ),
			'section' => 'worldstar_section_post',
			'settings' => 'worldstar_theme_options[single_posts_headline]',
			'priority' => 9,
		)
	) );
	$wp_customize->add_setting( 'worldstar_theme_options[post_image]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'refresh',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[post_image]', array(
		'label'    => esc_html__( 'Display featured image on single posts', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[post_image]',
		'type'     => 'checkbox',
		'priority' => 10,
		)
	);
	$wp_customize->add_setting( 'worldstar_theme_options[meta_tags]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[meta_tags]', array(
		'label'    => esc_html__( 'Display post tags on single posts', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[meta_tags]',
		'type'     => 'checkbox',
		'priority' => 11,
		)
	);
	$wp_customize->add_setting( 'worldstar_theme_options[post_navigation]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[post_navigation]', array(
		'label'    => esc_html__( 'Display post navigation on single posts', 'worldstar' ),
		'section'  => 'worldstar_section_post',
		'settings' => 'worldstar_theme_options[post_navigation]',
		'type'     => 'checkbox',
		'priority' => 12,
		)
	);
}
add_action( 'customize_register', 'worldstar_customize_register_post_settings' );
