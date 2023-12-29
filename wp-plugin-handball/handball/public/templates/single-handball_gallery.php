<?php get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        	<header class="entry-header">

        		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

        	</header><!-- .entry-header -->

        	<div class="entry-content clearfix">

        		<?php the_content(); ?>

        	</div><!-- .entry-content -->

        </article>

        <?php endwhile; ?>

		</main>
	</section>

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
