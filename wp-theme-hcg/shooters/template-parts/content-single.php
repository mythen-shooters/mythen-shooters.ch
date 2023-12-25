<?php
/**
 * The template for displaying single posts
 *
 * @package WorldStar
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="post-image">
 
		<?php worldstar_post_image_single(); ?>
		<?php worldstar_entry_categories(); ?>
	</div>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php worldstar_entry_meta(); ?>
	</header><!-- .entry-header -->
	<div class="entry-content clearfix">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'worldstar' ),
			'after'  => '</div>',
		) ); ?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php worldstar_entry_tags(); ?>
		<?php worldstar_post_navigation(); ?>
	</footer><!-- .entry-footer -->
</article>
