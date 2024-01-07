<?
$gallery = new Gallery($post);
?>

<?= get_header() ?>
	<section id="primary" class="fullwidth-content-area content-area">
		<main id="main" class="site-main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?= the_ID() ?>" <?= post_class() ?>>
				<header class="entry-header">
					<?= the_title('<h1 class="entry-title">', '</h1>') ?>
				</header>
				<?= $gallery->formattedStartDateLong() ?>
				<div class="entry-content clearfix">
					<?= the_content() ?>
				</div>
			</article>
        	<?php endwhile; ?>
		</main>
	</section>
<?= get_footer() ?>
