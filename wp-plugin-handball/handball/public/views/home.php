<?php
get_header();
?>
	<section id="primary" class="content-area">

    				<h1 class="widget-title">News</h1>
	<style>
				.center-cropped {
					display: inline-block;
					width: 100%;
					height: 500px;
					background-position: center center;
					background-size: cover;
				}
     		</style>

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
			    'posts_per_page' => 4
			]);
			
			function createNewsDiv($post) {
				$excerpt = wp_kses_post(wp_trim_words($post->post_content, 20));
			    $imgUrl = WpPostHelper::getFirstImageUrlInPost($post);

				$content = "";
             	if (!empty($imgUrl)) {
                  $content .= "<div class='center-cropped' style=\"background-image: url('".$imgUrl."');\"></div>";
                }

				$subText = '';
				$gameId = get_post_custom_values('handball_game_id', $post->ID);
				$reportType = get_post_custom_values('handball_game_report_type', $post->ID);
				if (!empty($gameId)) {
					$games = new HandballMatchRepository();
					$game = $games->findById($gameId);
					if ($game != null) {
						// why is this an array?
						if ($reportType[0] == 'report') {
							$subText = $game->getLeagueLong() . ': ' . $game->getEncounter() . ' ' . $game->getScore();
						} else {
							// preview
							$subText = $game->getLeagueLong() . ': ' . $game->getEncounter();
						}
					}
				}
			
				$content .= "
						<div style='position:relative;bottom:130px;height:130px;padding:15px;background-color:rgba(54,98,130, 0.9);color:white;overflow:hidden;'>							
							<p style='margin:0px;font-size:30px;font-weight:bold;'>
							  ".esc_attr($post->post_title) ."
							</p>

							<p style='margin:0px;font-size:18px;font-weight:bold;'>
								".esc_attr($subText)."
							</p>

							<p style='margin:0px;font-size:18px;overflow:hidden;'>
								". esc_attr($excerpt) . " <a href='". get_permalink($post)."'>weiterlesen</a>
							</p>
						</div>";						
				return $content;
					
			}
			
			$posts = [];
			while ($postQuery->have_posts()) {
			    $postQuery->the_post();
				$posts[] = $postQuery->post;
			}
			?>




				<div class="content-column clearfix news-ticker-desktop" style="padding-top:3px;">
					<?
					$i = 0;
					$display = 'block';
					foreach ($posts as $post) {
						$i++;
						if ($i > 1) {
							$display = 'none';
						}
						$newsContent = createNewsDiv($post);
					?>
						<article id="news-post-<? echo $i; ?>" style="height:500px;display:<? echo $display; ?>">
							<?php echo $newsContent; ?>
						</article>
					<?
					}
					?>

					<div style="background-color:var(--orange);height:4px;margin-top:12px;margin-bottom:4px;"></div>

					<style>
						.news-card {
							width:25%;
							height:150px;
							background-color: var(--blue);
							margin-bottom:20px;
							color: white;
							float:left;
							border: 8px solid var(--blue);
							display: inline-block;
							background-position: center center;
							background-size: cover;
							cursor: pointer;
						}
						.news-card:hover {
							border-color: var(--orange);
						}
						.new-card-last {
							border-right: 8px solid var(--blue);
						}
						.news-card-selected {
							/*border-color: var(--orange);*/
						}
						.news-image {
						}
					</style>

					<?php
						$i = 0;
						foreach($posts as $post) {
							$i++;
							$last = "";
							if ($i == 1) {
								$last = "news-card-selected";
							}
							if ($i == 4) {
								$last = "new-card-last";
							}
							$imgUrl = WpPostHelper::getFirstImageUrlInPost($post);
					?>
					<div class="news-card <? echo $last; ?>" style="background-image: url('<? echo $imgUrl; ?>');" onclick="showNews(<? echo $i; ?>)">
						
					</div>
					<?php
						}
					?>

					<script type="text/javascript">
						function showNews(news) {
							document.getElementById('news-post-1').style.display = 'none';
							document.getElementById('news-post-2').style.display = 'none';
							document.getElementById('news-post-3').style.display = 'none';
							document.getElementById('news-post-4').style.display = 'none';

							document.getElementById('news-post-' + news).style.display = 'block';
						}
					</script>

					<div class="clearfix">
					</div>
                 </div>
			





				<div class="content-column clearfix news-ticker-mobile" style="padding-top:3px;">
					<?
						foreach($posts as $post) {
							$imgUrl = WpPostHelper::getFirstImageUrlInPost($post);
							$excerpt = wp_kses_post(wp_trim_words($post->post_content, 15));							

							$subText = '';
							$gameId = get_post_custom_values('handball_game_id', $post->ID);
							$reportType = get_post_custom_values('handball_game_report_type', $post->ID);
							if (!empty($gameId)) {
								$games = new HandballMatchRepository();
								$game = $games->findById($gameId);
								if ($game != null) {
									// why is this an array?
									if ($reportType[0] == 'report') {
										$subText = $game->getLeagueLong() . '<br/> ' . $game->getEncounter() . ' ' . $game->getScore();
									} else {
										// preview
										$subText = $game->getLeagueLong() . '<br/> ' . $game->getEncounter();
									}
								}
							}
					?>
						<a style="display:block;cursor:pointer;color:white;margin-bottom:8px;background-color:var(--light-blue);" class="news-mobile-card" href='<?= get_permalink($post) ?>'>
								<img src="<?= $imgUrl ?>" />
							
							<div style="padding:8px;">
							<p style='margin:0px;font-size:18px;font-weight:bold;'>
							  <?= esc_attr($post->post_title) ?>
							</p>

							<p style='margin:0px;font-size:14px;'>
							<?= $subText ?>
							</p>

							<p style='margin:0px;font-size:14px;overflow:hidden;display:none;'>
							<?= esc_attr($excerpt) ?>
							</p>
							</div>
						</a>
					<?
						}
					?>

				</div>


<div class="clearfix"></div>

<?
	require_once (WP_PLUGIN_DIR . '/handball/includes/class-handball-repository.php');
	$repo = new HandballMatchRepository();			
?>

<div class="content-column" style="margin-top:15px">
	
	<?
		$pastGames = $repo->findMatchesNextWeek();		
	?>

	<?
		$homeGames = array_filter($pastGames, function ($match) {
			return $match->isHomeGame();
		});
		if (!empty($homeGames)) {
			?>
			<header class="page-header" style="margin-bottom:0px;margin-top:20px;">
				<h1 class="widget-title" style="margin-bottom:5px;padding:0px;">Heimspiele</h1>
			</header>
			<div class="entry-content clearfix">
			<?
				$matches = $homeGames;
				if (empty($matches)) {
					echo 'Keine Heimspiele in nächster Zeit.';
				} else {
				  include dirname(__FILE__) . "/../templates/_gametable-upcoming.php";
				}
			?>
			</div>
			<?
		}
	?>

	<?
		$awayGames = array_filter($pastGames, function ($match) {
			return !$match->isHomeGame();
		});
		if (!empty($awayGames)) {
			?>
			<header class="page-header" style="margin-bottom:0px;margin-top:20px;">
				<h1 class="widget-title" style="margin-bottom:5px;padding:0px;">Auswärtsspiele</h1>
			</header>
			<div class="entry-content clearfix">
			<?
				$matches = $awayGames;
				if (empty($matches)) {
					echo 'Keine Auswärtsspiele in nächster Zeit.';
				} else {
				  include dirname(__FILE__) . "/../templates/_gametable-upcoming.php";
				}
			?>
			</div>
			<?
		}
	?>

	<header class="page-header" style="margin-top:20px;margin-bottom:0px;">
		<h1 class="widget-title" style="margin-bottom:5px;padding:0px;">Resultate</h1>
    </header>
    <div class="entry-content clearfix">
	<?
		$matches = $repo->findMatchesLastWeek();
		if (empty($matches)) {
		    echo 'Keine Spiele in letzter Zeit.';
		} else {
			include dirname(__FILE__) . "/../templates/_gametable-played.php";
		}
	?>
	</div>
</div>


</main><!-- #main -->
</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
