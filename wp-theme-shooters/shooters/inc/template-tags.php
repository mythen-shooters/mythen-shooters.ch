<?php
/**
 * Template Tags
 *
 * This file contains several template functions which are used to print out specific HTML markup
 * in the theme. You can override these template functions within your child theme.
 *
 * @package WorldStar
 */


if ( ! function_exists( 'worldstar_header_image' ) ) :
	/**
	 * Displays the custom header image below the navigation menu
	 */
	function worldstar_header_image() {
		// Get theme options from database.
		$theme_options = worldstar_theme_options();
		// Display featured image as header image on static pages.
		if ( is_page() && has_post_thumbnail() ) : ?>
			<div id="headimg" class="header-image featured-image-header">
				<?php the_post_thumbnail( 'worldstar-header-image' ); ?>
			</div>
		<?php // Display default header image set on Appearance > Header.
		elseif ( get_header_image() ) : ?>
			<div id="headimg" class="header-image">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id, 'full' ) ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
				</a>
			</div>
		<?php
		endif;
	}
endif;
if ( ! function_exists( 'worldstar_post_content' ) ) :
	/**
	 * Displays the post content on archive pages
	 */
	function worldstar_post_content() {
		// Get theme options from database.
		$theme_options = worldstar_theme_options();
		// Return early if no featured image should be displayed.
		if ( 'excerpt' === $theme_options['post_content'] ) {
			the_excerpt();
			worldstar_more_link();
		} else {
			the_content( esc_html__( 'Read more', 'worldstar' ) );
		}
	}
endif;
if ( ! function_exists( 'worldstar_post_image' ) ) :
	/**
	 * Displays the featured image on archive posts.
	 *
	 * @param string $size Post thumbnail size.
	 * @param array  $attr Post thumbnail attributes.
	 */
	function worldstar_post_image( $size = 'post-thumbnail', $attr = array() ) {
		// Display Post Thumbnail.
		if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php the_post_thumbnail( $size, $attr ); ?>
			</a>
		<?php endif;
	}
endif;
if ( ! function_exists( 'worldstar_post_image_single' ) ) :
	/**
	 * Displays the featured image on single posts
	 */
	function worldstar_post_image_single() {
		// Get theme options from database.
		$theme_options = worldstar_theme_options();
		// Display Post Thumbnail if activated.
		if ( true === $theme_options['post_image'] ) :
			the_post_thumbnail();
		endif;
	}
endif;
if ( ! function_exists( 'worldstar_entry_meta' ) ) :
	/**
	 * Displays the date, author and comments of a post
	 */
	function worldstar_entry_meta() {
		$postmeta = worldstar_meta_date();
		$postmeta .= worldstar_meta_author();
		$postmeta .= worldstar_meta_comments();
		echo '<div class="entry-meta">' . $postmeta . '</div>';
	}
endif;
if ( ! function_exists( 'worldstar_meta_date' ) ) :
	/**
	 * Displays the post date
	 */
	function worldstar_meta_date() {
		$time_string = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date published updated" datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		return '<span class="meta-date">' . $time_string . '</span>';
	}
endif;
if ( ! function_exists( 'worldstar_meta_author' ) ) :
	/**
	 * Displays the post author
	 */
	function worldstar_meta_author() {
		$author_string = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( esc_html__( 'View all posts by %s', 'worldstar' ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
		return '<span class="meta-author"> ' . $author_string . '</span>';
	}
endif;
if ( ! function_exists( 'worldstar_meta_comments' ) ) :
	/**
	 * Displays the post comments
	 */
	function worldstar_meta_comments() {
		ob_start();
		comments_popup_link( '0', '1', '%' );
		$comments_string = ob_get_contents();
		ob_end_clean();
		return '<span class="meta-comments"> ' . $comments_string . '</span>';
	}
endif;
if ( ! function_exists( 'worldstar_entry_categories' ) ) :
	/**
	 * Displays the category of posts
	 */
	function worldstar_entry_categories() {
		?>
		<div class="entry-categories clearfix">
			<span class="meta-category">
				<?php echo get_the_category_list( ' ' ); ?>
			</span>
		</div><!-- .entry-categories -->
		<?php
	}
endif;
if ( ! function_exists( 'worldstar_entry_tags' ) ) :
	/**
	 * Displays the post tags on single post view
	 */
	function worldstar_entry_tags() {
		// Get tags.
		$tag_list = get_the_tag_list( '', '' );
		// Display tags.
		if ( $tag_list ) : ?>
			<div class="entry-tags clearfix">
				<span class="meta-tags">
					<?php echo $tag_list; ?>
				</span>
			</div><!-- .entry-tags -->
		<?php
		endif;
	}
endif;
if ( ! function_exists( 'worldstar_more_link' ) ) :
	/**
	 * Displays the more link on posts
	 */
	function worldstar_more_link() {
		?>
		<a href="<?php echo esc_url( get_permalink() ) ?>" class="more-link"><?php esc_html_e( 'Read more', 'worldstar' ); ?></a>
		<?php
	}
endif;
if ( ! function_exists( 'worldstar_post_navigation' ) ) :
	/**
	 * Displays Single Post Navigation
	 */
	function worldstar_post_navigation() {
		// Get theme options from database.
		$theme_options = worldstar_theme_options();
		if ( true === $theme_options['post_navigation'] || is_customize_preview() ) {
			the_post_navigation( array(
				'prev_text' => '<span class="screen-reader-text">' . esc_html_x( 'Previous Post:', 'post navigation', 'worldstar' ) . '</span>%title',
				'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next Post:', 'post navigation', 'worldstar' ) . '</span>%title',
			) );
		}
	}
endif;
if ( ! function_exists( 'worldstar_breadcrumbs' ) ) :
	/**
	 * Displays ThemeZee Breadcrumbs plugin
	 */
	function worldstar_breadcrumbs() {
		if ( function_exists( 'themezee_breadcrumbs' ) ) {
			themezee_breadcrumbs( array(
				'before' => '<div class="breadcrumbs-container container clearfix">',
				'after' => '</div>',
			) );
		}
	}
endif;
if ( ! function_exists( 'worldstar_related_posts' ) ) :
	/**
	 * Displays ThemeZee Related Posts plugin
	 */
	function worldstar_related_posts() {
		if ( function_exists( 'themezee_related_posts' ) ) {
			themezee_related_posts( array(
				'class' => 'related-posts type-page clearfix',
				'before_title' => '<header class="page-header"><h2 class="archive-title related-posts-title">',
				'after_title' => '</h2></header>',
			) );
		}
	}
endif;
if ( ! function_exists( 'worldstar_pagination' ) ) :
	/**
	 * Displays pagination on archive pages
	 */
	function worldstar_pagination() {
		the_posts_pagination( array(
			'mid_size'  => 2,
			'prev_text' => '&laquo<span class="screen-reader-text">' . esc_html_x( 'Previous Posts', 'pagination', 'worldstar' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next Posts', 'pagination', 'worldstar' ) . '</span>&raquo;',
		) );
	}
endif;
/**
 * Displays credit link on footer line
 */
function worldstar_footer_text() {
	?>
	<span class="credit-link">
		<?php printf( esc_html__( 'Powered by %1$s and %2$s.', 'worldstar' ),
			'<a href="http://wordpress.org" title="WordPress">WordPress</a>',
			'<a href="https://themezee.com/themes/worldstar/" title="WorldStar WordPress Theme">WorldStar</a>'
		); ?>
	</span>
	<?php
}
add_action( 'worldstar_footer_text', 'worldstar_footer_text' );
