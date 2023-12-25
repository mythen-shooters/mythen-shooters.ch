<?php
/**
 * The template for displaying articles in the search loop
 *
 * @package WorldStar
 */
?>
<div class="post-column clearfix">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		</header><!-- .entry-header -->
		<div class="entry-content clearfix">
			<?php the_excerpt(); ?>
			<?php worldstar_more_link(); ?>
		</div><!-- .entry-content -->
	</article>
</div>
