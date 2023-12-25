<?php
/**
 * The template for displaying articles in the loop with full content
 *
 * @package WorldStar
 */
?>
<div class="post-column clearfix">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
		<div class="post-image">
			<?php worldstar_post_image(); ?>
			<?php worldstar_entry_categories(); ?>
		</div>
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			<?php worldstar_entry_meta(); ?>
		</header><!-- .entry-header -->
		<div class="entry-content clearfix">
			<?php the_content( esc_html__( 'Read more', 'worldstar' ) ); ?>
		</div><!-- .entry-content -->
	</article>
</div>
