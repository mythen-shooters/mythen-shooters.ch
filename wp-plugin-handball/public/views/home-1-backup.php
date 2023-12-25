<?php
get_header();
?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php
			$postQuery = new WP_Query([
			    'post_type' => ['handball_match', 'post'],
			    'order_by' => 'meta_value',
			    'post_status' => 'publish',
			    
			    'meta_key' => 'handball_is_news',
			    'meta_value' => 1,
			    
			    'orderby' => 'publish_date',
			    'order' => 'DESC',
			    'posts_per_page' => 6
			]);
			
			$open = false;
			$i = 0;
			while ($postQuery->have_posts()) {
			    $postQuery->the_post();
			    $post = $postQuery->post;

			    $excerpt = wp_kses_post(wp_trim_words($post->post_content, 25));
			    $imgUrl = WpPostHelper::getFirstImageUrlInPost($post);
				
				if ($i % 2 == 0) {
					echo '<div style="overflow:hidden;">';
					$open = true;
				}
			?>
			<style>
				.center-cropped {
					display: inline-block;
					width: 380px;
					height: 240px;
					background-position: center center;
					background-size: cover;
				}
     >
</div>
			</style>

				<div class="content-column one_half  clearfix" style='padding-right:25px;'>
					<article id="post-<?= $post->ID ?>">
                    	<header class="entry-header">
                    		<h1 class="page-title"><?= esc_attr($post->post_title) ?></h1>
                    	</header>
                    	<div class="entry-content clearfix">
                    		<?php
                    		 if (!empty($imgUrl)) {
                    		     echo '<div class="center-cropped" style="background-image: url(\''.$imgUrl.'\');"></div>';
                    		 }
                    		?>
							<!--
                    		<?= esc_attr($excerpt) ?>
							-->
                    		<br />
                    		<a href="<?= get_permalink($post)?>" class="more-link">Weiterlesen</a>
                    	</div>
                    </article>
                 </div>
			<?php
			
				if ($i % 2 == 1) {
					echo '</div>';
					$open = false;
				}
				$i++; 
			
			}
			if ($open) { echo '</div>'; }
            ?>
			
			
			
			

<div class="clearfix"></div>

			<?php
			require_once (WP_PLUGIN_DIR . '/handball/includes/class-handball-repository.php');
			$repo = new HandballMatchRepository();
			$upComingMatches = $repo->findMatchesNextWeek();
			$pastMatches = $repo->findMatchesLastWeek();
			?>

			<div class="content-column one_half" style="padding-right:15px;margin-top:15px">
    			<header class="page-header">
    				<h1 class="archive-title">Spielplan</h1>
    			</header>
    			<div class="entry-content clearfix">
					<?php
					   if (empty($upComingMatches)) {
					       echo 'Keine Spiele in nächster Zeit.';
					   }
					   foreach ($upComingMatches as $match) {
					       $showScore = false;
					       $showPreviewLink = true;
					       $showReportLink= true;
					       $showLeague = false;
					       $showEncounterWithLeague = true;
						   $highlightHomeGame = true;
					       include(WP_PLUGIN_DIR . '/handball/public/templates/_match-detail.php');
					   }
					?>
    			</div>
			</div>
			<div class="content-column one_half  last_column"  style="margin-top:15px">
    			<header class="page-header">
    				<h1 class="archive-title">Resultate</h1>
    			</header>
    			<div class="entry-content clearfix">
					<?php
					if (empty($pastMatches)) {
					    echo 'Keine Spiele in letzter Zeit.';
					}
					foreach ($pastMatches as $match) {
					       $showScore = true;
					       $showPreviewLink = true;
					       $showReportLink = true;
					       $showLeague = false;
					       $showEncounterWithLeague = true;
					       $highlightHomeGame = false;
					       include(WP_PLUGIN_DIR . '/handball/public/templates/_match-detail.php');
					   }
					?>
    			</div>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
