<?php
/**
 * The template for displaying large posts in the Magazine Horizontal Box widget.
 *
 * @package WorldStar
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'large-post clearfix' ); ?>>
 
	<div class="post-image">
		<?php worldstar_post_image(); ?>
		<?php worldstar_entry_categories(); ?>
	</div>
	<div class="post-content">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php worldstar_entry_meta(); ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php the_excerpt(); ?>
			<?php worldstar_more_link(); ?>
		</div><!-- .entry-content -->
	</div>
</article>
