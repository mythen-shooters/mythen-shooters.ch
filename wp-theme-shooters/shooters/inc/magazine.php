<?php
/**
 * Magazine Functions
 *
 * Custom Functions and Template tags used in the Magazine widgets and Magazine templates
 *
 * @package WorldStar
 */
 
/**
* Displays Magazine widget area
*/


/**
 * Get Magazine Post IDs
 *
 * @param String $cache_id        Magazine Widget Instance.
 * @param int    $category        Category ID.
 * @param int    $number_of_posts Number of posts.
 * @return array Post IDs
 */
function worldstar_get_magazine_post_ids( $cache_id, $category, $number_of_posts ) {
	$cache_id = sanitize_key( $cache_id );
	$post_ids = get_transient( 'worldstar_magazine_post_ids' );
	if ( ! isset( $post_ids[ $cache_id ] ) || is_customize_preview() ) {
		// Get Posts from Database.
		$query_arguments = array(
			'fields'              => 'ids',
			'cat'                 => (int) $category,
			'posts_per_page'      => (int) $number_of_posts,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);
		$query = new WP_Query( $query_arguments );
		// Create an array of all post ids.
		$post_ids[ $cache_id ] = $query->posts;
		// Set Transient.
		set_transient( 'worldstar_magazine_post_ids', $post_ids );
	}
	return apply_filters( 'worldstar_magazine_post_ids', $post_ids[ $cache_id ], $cache_id );
}
/**
 * Delete Cached Post IDs
 *
 * @return void
 */
function worldstar_flush_magazine_post_ids() {
	delete_transient( 'worldstar_magazine_post_ids' );
}
add_action( 'save_post', 'worldstar_flush_magazine_post_ids' );
add_action( 'deleted_post', 'worldstar_flush_magazine_post_ids' );
add_action( 'customize_save_after', 'worldstar_flush_magazine_post_ids' );
add_action( 'switch_theme', 'worldstar_flush_magazine_post_ids' );
