<?php
get_header(); ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', 'page' );
				endwhile;
				worldstar_pagination();
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif; ?>
		</main><!-- #main -->
	</section><!-- #primary -->
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
