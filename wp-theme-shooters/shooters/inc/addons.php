<?php
/**
 * Add Support for Theme Addons
 *
 * @package WorldStar
 */
 
/**
 * Register support for Jetpack and theme addons
 */
function worldstar_theme_addons_setup() {
	// Add theme support for WorldStar Pro plugin.
	add_theme_support( 'worldstar-pro' );
	// Add theme support for ThemeZee Plugins.
	add_theme_support( 'themezee-breadcrumbs' );
	add_theme_support( 'themezee-mega-menu', array( 'primary', 'secondary' ) );
	// Add theme support for Widget Bundle.
	add_theme_support( 'themezee-widget-bundle', array(
		'thumbnail_size' => array( 80, 80 ),
	) );
	// Add theme support for Related Posts.
	add_theme_support( 'themezee-related-posts', array(
		'thumbnail_size' => array( 420, 240 ),
	) );
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container'      => 'post-wrapper',
		'footer_widgets' => 'footer',
		'wrapper'        => false,
		'render'         => 'worldstar_infinite_scroll_render',
		'posts_per_page' => 6,
	) );
}
add_action( 'after_setup_theme', 'worldstar_theme_addons_setup' );


/**
 * Custom render function for Infinite Scroll.
 */
function worldstar_infinite_scroll_render() {
	// Get theme options from database.
	$theme_options = worldstar_theme_options();
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', $theme_options['post_content'] );
	}
}
