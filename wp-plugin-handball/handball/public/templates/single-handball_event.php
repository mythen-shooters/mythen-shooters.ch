<?php get_header(); ?>

	<section id="primary" class="fullwidth-content-area content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        	<header class="entry-header">
				<? the_title('<h1 class="entry-title">', '</h1>') ?>
			</header>
        		<?php
        		global $post;
        		require_once (plugin_dir_path(__FILE__) . '../../includes/class-handball-model.php');
        		$event = new Event($post);

        		echo '<div><span>'.
        		  esc_attr($event->formattedStartDateTimeLong()).' Uhr -
                 '.esc_attr($event->formattedEndDateTimeLong()).' Uhr</span></div>';
        		?>
        	</header>
        	<div class="entry-content clearfix">
        		<?php the_content(); ?>
        	</div>
        		<?php
				$time_string = sprintf('%3$s',
					esc_attr(get_the_time()),
					esc_attr(get_the_date('c')),
					esc_html(get_the_date())
				);
				?>
			<div style="font-size:0.8em;border-top: 1px solid white;padding-top:5px;margin-bottom:20px;">
          <?= $time_string ?>, <?= esc_html(get_the_author()) ?>
        </div>
        </article>
        <?php endwhile; ?>
		</main>
	</section>
<?php get_footer(); ?>
