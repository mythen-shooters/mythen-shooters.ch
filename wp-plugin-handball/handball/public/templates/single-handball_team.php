<?php
get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?= the_ID() ?>" <?= post_class() ?>>
        	<header class="entry-header">
        		<?= the_title('<h1 class="entry-title">', '</h1>') ?>
        	</header>
			<style>
				.teaminfo {
				  display: none;
				}
				.active {
 				   display: block;
				}
				#teaminfolink:hover {
					text-decoration: underline;
					cursor: pointer;
				}
				#teaminfolink {
					font-weight:bold;
				}
				.teamimage {
				  display: none;
				}
			</style>
        	<div class="entry-content clearfix">
				<?
				  $imgUrl = WpPostHelper::getFirstImageUrlInPost($post);   
				?>
				<img src="<?= $imgUrl ?>" />
				<div style="text-align:right">
					<span id="teaminfolink">↓ Team-Informationen</span>
				</div>
				<div>
					<?php
						$teamSponsor = get_post_meta($post->ID, 'handball_team_sponsor', true);
						echo $teamSponsor;
					?>
				</div>
				<div class="teaminfo">
        			<?= the_content() ?>
				</div>
        	</div>			
			<script type="text/javascript">
			var teaminfo = document.getElementsByClassName("teaminfo")[0];
			var button = document.getElementById("teaminfolink");
			button.addEventListener("click", function() {
				teaminfo.classList.toggle("active");			
			});
			</script>
        </article>
        <?php

			global $post;

			require_once (plugin_dir_path(__FILE__) . '../../includes/class-handball-repository.php');

			$teamId = get_post_meta($post->ID, 'handball_team_id', true);

			$matchRepo = new HandballMatchRepository();
			$matches = $matchRepo->findMatchesForTeam($teamId);			

			$playedGames = array_filter($matches, function($game) {
				return $game->isPlayed();
			});
			$upComingGames = array_filter($matches, function($game) {
				return !$game->isPlayed();
			});


			if (!empty($playedGames)) {
			    echo '<h2>Resultate</h2>';
			}
			?>
			<div class="content-column"  style="margin-top:15px">
    			<div class="entry-content clearfix">
					<?php
					    $matches = $playedGames;
						include  "_gametable-played.php"
					?>
    			</div>
			</div>


			<?
			if (!empty($upComingGames)) {
			    echo '<h2>Spielplan</h2>';
			}
			?>
			<div class="content-column"  style="margin-top:15px">
    			<div class="entry-content clearfix">
				<div class="responsive-table-container">
					
					<?php
					    $matches = $upComingGames;
						include  "_gametable-upcoming.php"
					?>
					
					</div>
    			</div>
			</div>
			<?

			endwhile; ?>
			<?php
			$groupRepo = new HandballGroupRepository();
			$groups = $groupRepo->findGroupsByTeamId($teamId);

			if (!empty($groups)) {
			    echo '<h2>Ranglisten</h2>';
			}

			foreach ($groups as $group) {
                ?>
                <div>
					<div class="responsive-table-container">
                    	<table>
                    		<tr>
								<th class="td-ranking" style="width:200px;text-align:left;"><?= $group->getLeagueLong() ?></th>
    							<th class="td-ranking" style="width:50px;">Spiele</th>
    							<th class="td-ranking" style="width:50px;">Punkte</th>
    							<th class="td-ranking" style="width:50px;">Siege</th>
    							<th class="td-ranking" style="width:50px;">Unent.</th>
    							<th class="td-ranking" style="width:50px;">Nied.</th>
    							<th class="td-ranking" style="width:50px;">T+</th>
    							<th class="td-ranking" style="width:50px;">T-</th>
    							<th class="td-ranking" style="width:50px;">TD</th>
                    		</tr>
                    	<?php
                    	   foreach ($group->getRankings() as $ranking) {
								$bold = "";
								if ($ranking->isOurTeam()) {
									$bold = "font-weight:bold;";
								}
                    	       ?>
                    	       <tr>
                    	       	<td class="td-ranking" style="text-align:left;<?= $bold ?>">
									<?= $ranking->getRank(); ?>
									<img style="position:relative;top:5px;width:20px;" src="https://www.handball.ch/images/logo/<?= $ranking->getTeamId() ?>.png?fallbackType=club&fallbackId=<?= $ranking->getClubId() ?>&width=20&height=20&rmode=pad&format=png" />
									<?= $ranking->getTeamName(); ?>
								</td>
								<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalGames() ?></td>
                    	       	<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalPoints() ?></td>
                    	       	<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalWins(); ?></td>
                    	       	<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalDraws(); ?></td>
                    	       	<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalLoss(); ?></td>
                    	       	<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalScoresPlus(); ?></td>
                    	       	<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalScoresMinus(); ?></td>
                    	       	<td class="td-ranking" style="<?= $bold ?>"><?= $ranking->getTotalScoresDiff(); ?></td>
                    	       </tr>
                    	       <?php
                    	   }
                        ?>
                        </table>
                    </div>
                </div>
                <?php
			}
			?>
		</main>
	</section>
	
	<section id="secondary" class="sidebar widget-area clearfix" role="complementary">

		<?
		if (!empty($teamId)) {
		?>
			<h3 style="margin-bottom:10px;margin-top:8px;">Aktuelle Spiele</h3>

		<?
			$widget = new HandballFeaturedGameWidget();

			$args = [];
			$args['before_widget'] = '';
			$args['after_widget'] = '';
			$instance = [];
			$instance['teamId'] = $teamId;
			$widget->widget($args, $instance);
		?>
		<? include '_group.php'?>
		<?
		}
		?>

		
	</section>

<?php get_footer(); ?>
