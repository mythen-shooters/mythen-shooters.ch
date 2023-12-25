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

				<div class="content-column clearfix" >
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

					<div style="background-color:var(--orange);height:8px;"></div>
					<div style="background-color:var(--blue);height:8px;"></div>

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
			






<div class="clearfix"></div>

			<?php
			require_once (WP_PLUGIN_DIR . '/handball/includes/class-handball-repository.php');
			$repo = new HandballMatchRepository();
			$upComingMatches = $repo->findMatchesNextWeek();
			$pastMatches = $repo->findMatchesLastWeek();
			?>

			<div class="content-column" style="margin-top:15px">
			   <div>
    			<header class="page-header" style="margin-bottom:0px;">
    				<h1 class="widget-title">Spielplan</h1>
    			</header>
    			<div class="entry-content clearfix" style="">
					<style>
						.gametable-cell {
							border:0px solid black;
							border-bottom: 1px solid white;
							color:white;
						}

						.club-logo {
							position:relative;
							top: 4px;
							margin-right:3px;
						}
						.responsive-table-container {
							width: 100%;
							overflow-y: auto;
							overflow: auto;
							margin: 0 0 1em;
						}
					</style>
					<div class="responsive-table-container">
					<table style="margin-bottom:0px;">
					<?php
					   if (empty($upComingMatches)) {
					       echo 'Keine Spiele in nächster Zeit.';
					   }
					   foreach ($upComingMatches as $match) {
						   $previewUrl = $match->getPostPreviewUrl();
						   ?>
						    <tr style="">
							  <td class="gametable-cell" style="width:120px"><? echo $match->getGameDateTimeFormattedShort() ?></td>	
							  <td class="gametable-cell" style="width:90px"><? echo $match->getLeagueShort() ?></td>
							  <td class="gametable-cell" style="width:400px;">
								<?php
								if (!empty($previewUrl)) {
									echo "<a href='$previewUrl'>";
								}
								$imageA = $match->getTeamAImageUrl("20");
								$imageB = $match->getTeamBImageUrl("20");
								echo "<img class='club-logo' src='$imageA' />";
								echo $match->getTeamAName();
								echo ' - ';
								echo "<img class='club-logo' src='$imageB' />";
								echo $match->getTeamBName();
								if (!empty($previewUrl)) {
									echo "</a>";
								}								
								?>
							  </td>
							  <td style="width:137px;"  class="gametable-cell"><? echo $match->getVenueShort(); ?> </td>

							  <td style="width:30px;padding:0px;text-align:center;margin:0px;"  class="gametable-cell">
							   <a style="display:block;height:100%;marign:0px;background-color:var(--orange);padding:0px;" href="">	>
							    </a>
							   </td>
					   		</tr>
						   <?php

					   }
					   ?>
					</table>
					</div>
    			</div>
					</div>
			</div>
			<div class="content-column"  style="margin-top:15px">
    			<header class="page-header">
    				<h1 class="widget-title">Resultate</h1>
    			</header>
    			<div class="entry-content clearfix">
				<div class="responsive-table-container">
					<table>
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

						   ?>
						   <tr>
							 <td class="gametable-cell" style="width:120px;"><? echo $match->getLeagueShort() ?></td>
							<td class="gametable-cell" style="width:400px;">
							 <?
								$imageA = $match->getTeamAImageUrl("20");
								$imageB = $match->getTeamBImageUrl("20");
								echo "<img class='club-logo' src='$imageA' />";
								echo $match->getTeamAName();
								echo ' - ';
								echo "<img class='club-logo' src='$imageB' />";
								echo $match->getTeamBName();
							 ?>
								</td>
							<td class="gametable-cell" style="width:140px;"><? echo $match->getScore(); ?> </td>
							
							<td class="gametable-cell" style="width:110px;">
								<a href="<? echo $match->getLivetickerUrl() ?>">Liveticker</a>
							</td>
							
							 
							</tr>
						  <?php
					   }
					?>
					</table>
					</div>
    			</div>
			</div>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
