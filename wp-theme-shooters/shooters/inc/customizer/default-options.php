<?php
/**
 * Returns theme options
 *
 * Uses sane defaults in case the user has not configured any theme options yet.
 *
 * @package WorldStar
 */
 
/**
 * Get saved user settings from database or theme defaults
 *
 * @return array
 */
function worldstar_theme_options() {
	// Merge theme options array from database with default options array.
	$theme_options = wp_parse_args( get_option( 'worldstar_theme_options', array() ), worldstar_default_options() );
	// Return theme options.
	return $theme_options;
}
/**
 * Returns the default settings of the theme
 *
 * @return array
 */
function worldstar_default_options() {
	$default_options = array(
		'site_title'						=> true,
		'site_description'					=> false,
		'theme_width' 						=> 'wide-layout',
		'theme_layout' 						=> 'right-sidebar',
		'blog_title'						=> esc_html__( 'Latest Posts', 'worldstar' ),
		'post_layout'						=> 'two-columns',
		'post_content' 						=> 'excerpt',
		'excerpt_length' 					=> 20,
		'meta_date'							=> true,
		'meta_author'						=> true,
		'meta_comments'						=> true,
		'meta_category'						=> true,
		'post_image'						=> true,
		'meta_tags'							=> true,
		'post_navigation'					=> true,
		'featured_magazine' 				=> false,
		'featured_blog' 					=> false,
		'featured_category' 				=> 0,
	);
	return $default_options;
}
