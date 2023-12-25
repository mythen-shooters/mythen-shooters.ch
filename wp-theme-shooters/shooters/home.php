<?php
get_header();
$theme_options = worldstar_theme_options();
if ( true === $theme_options['featured_blog'] ) :
	get_template_part( 'template-parts/featured-content' );
endif;
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			// Display Magazine Homepage Widgets.
			worldstar_magazine_widgets();
			if ( have_posts() ) : ?>
				<?php // Display Latest Posts Title.
				if ( '' !== $theme_options['blog_title'] ) : ?>
					<header class="page-header">
						<h1 class="archive-title"><?php echo wp_kses_post( $theme_options['blog_title'] ); ?></h1>
					</header><!-- .page-header -->
				<?php endif; ?>
				<div id="post-wrapper" class="post-wrapper clearfix">
					<?php while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', $theme_options['post_content'] );
					endwhile; ?>
				</div>
				<?php
				worldstar_pagination();
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif; ?>
		</main><!-- #main -->
	</section><!-- #primary -->
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
