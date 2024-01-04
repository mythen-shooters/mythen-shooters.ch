<?php
/**
 * Custom functions that are not template related
 *
 * @package WorldStar
 */
 
if ( ! function_exists( 'worldstar_default_menu' ) ) :
	/**
	 * Display default page as navigation if no custom menu was set
	 */
	function worldstar_default_menu() {
		echo '<ul id="menu-main-navigation" class="main-navigation-menu menu">' . wp_list_pages( 'title_li=&echo=0' ) . '</ul>';
	}
endif;
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function worldstar_body_classes( $classes ) {
	// Get theme options from database.
	$theme_options = worldstar_theme_options();
	// Switch theme width.
	if ( 'boxed-layout' == $theme_options['theme_width'] ) {
		$classes[] = 'boxed-layout';
	}
	// Check if sidebar widget area is empty or switch sidebar layout to left.
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	} elseif ( 'left-sidebar' == $theme_options['theme_layout'] ) {
		$classes[] = 'sidebar-left';
	}
	// Add post columns classes.
	if ( 'two-columns' == $theme_options['post_layout'] ) {
		$classes[] = 'post-layout-columns';
	}
	// Hide Date?
	if ( false === $theme_options['meta_date'] ) {
		$classes[] = 'date-hidden';
	}
	// Hide Author?
	if ( false === $theme_options['meta_author'] ) {
		$classes[] = 'author-hidden';
	}
	// Hide Comments?
	if ( false === $theme_options['meta_comments'] ) {
		$classes[] = 'comments-hidden';
	}
	return $classes;
}
add_filter( 'body_class', 'worldstar_body_classes' );

/**
 * Change excerpt length for default posts
 *
 * @param int $length Length of excerpt in number of words.
 * @return int
 */
function worldstar_excerpt_length( $length ) {
	// Get theme options from database.
	$theme_options = worldstar_theme_options();
	// Return excerpt text.
	if ( isset( $theme_options['excerpt_length'] ) and $theme_options['excerpt_length'] >= 0 ) :
		return absint( $theme_options['excerpt_length'] );
	else :
		return 30; // Number of words.
	endif;
}
add_filter( 'excerpt_length', 'worldstar_excerpt_length' );
/**
 * Change excerpt more text for posts
 *
 * @param String $more_text Excerpt More Text.
 * @return string
 */
function worldstar_excerpt_more( $more_text ) {
	return '';
}
add_filter( 'excerpt_more', 'worldstar_excerpt_more' );
/**
 * Set wrapper start for wooCommerce
 */
function worldstar_wrapper_start() {
	echo '<section id="primary" class="content-area">';
	echo '<main id="main" class="site-main" role="main">';
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
add_action( 'woocommerce_before_main_content', 'worldstar_wrapper_start', 10 );
/**
 * Set wrapper end for wooCommerce
 */
function worldstar_wrapper_end() {
	echo '</main><!-- #main -->';
	echo '</section><!-- #primary -->';
}
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'woocommerce_after_main_content', 'worldstar_wrapper_end', 10 );



remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
