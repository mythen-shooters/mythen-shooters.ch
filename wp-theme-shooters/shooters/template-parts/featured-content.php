<?php
/**
 * Featured Content Template
 *
 * Queries posts by selected featured posts category and displays featured content area
 *
 * @package WorldStar
 */
// Get Theme Options from Database.
$theme_options = worldstar_theme_options();
// Get cached post ids.
$post_ids = worldstar_get_magazine_post_ids( 'featured-posts', $theme_options['featured_category'], 5 );
 
// Fetch posts from database.
$query_arguments = array(
	'post__in'       => $post_ids,
	'posts_per_page' => 5,
	'no_found_rows'  => true,
);
$featured_query = new WP_Query( $query_arguments );
// Check if there are posts.
if ( $featured_query->have_posts() ) : ?>
	<div id="featured-posts-wrap" class="featured-posts-wrap">
		<div id="featured-posts" class="featured-posts clearfix">
			<?php while ( $featured_query->have_posts() ) : $featured_query->the_post();
				get_template_part( 'template-parts/content', 'featured' );
			endwhile; ?>
		</div>
	</div>
<?php
endif;
// Reset Postdata.
wp_reset_postdata();
