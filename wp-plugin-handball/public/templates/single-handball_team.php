<?php
get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        	<header class="entry-header">
        		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        	</header>
        	<div class="entry-content clearfix">
        		<?php the_content(); ?>
        	</div>
        </article>
        <?php

			global $post;

			require_once (plugin_dir_path(__FILE__) . '../../includes/class-handball-repository.php');

			$teamId = get_post_meta($post->ID, 'handball_team_id', true);

			$matchRepo = new HandballMatchRepository();
			$matches = $matchRepo->findMatchesForTeam($teamId);

			if (!empty($matches)) {
			    echo '<h2>Spiele</h2>';
			}

			foreach ($matches as $match) {
    			$showScore = $match->isPlayed();
    			$showPreviewLink = true;
    			$showReportLink= true;
    			$showLeague = false;
    			$showEncounterWithLeague = false;
    			$highlightHomeGame = false;
    			include '_match-detail.php';
			}

			endwhile; ?>


			<?php
			$groupRepo = new HandballGroupRepository();
			$groups = $groupRepo->findGroupsByTeamId($teamId);

			if (!empty($groups)) {
			    echo '<h2>Ranglisten</h2>';
			}

			foreach ($groups as $group) {
                ?>
                <div >
                	<h4><?= $group->getLeagueLong() ?></h4>
					<div class="responsive-table-container">
                    	<table>
                    		<tr>
								<th style="width:340px;"></th>
    							<th style="width:55px;">Spiele</th>
    							<th style="width:55px;">Pkt.</th>
    							<th style="width:55px;">Siege</th>
    							<th style="width:55px;">Unent.</th>
    							<th style="width:55px;">Nied.</th>
    							<th style="width:55px;">T+</th>
    							<th style="width:55px;">T-</th>
    							<th style="width:55px;">TD</th>
                    		</tr>
                    	<?php
                    	   foreach ($group->getRankings() as $ranking) {
                    	       ?>
                    	       <tr>
                    	       	<td class="">
									<?= $ranking->getRank(); ?>
									<img style="position:relative;top:15px;" src="https://www.handball.ch/images/logo/<?= $ranking->getTeamId() ?>.png?fallbackType=club&fallbackId=<?= $ranking->getClubId() ?>&width=35&height=35&rmode=pad&format=png" />
									<?= $ranking->getTeamName(); ?>
								</td>
								<td class="td-ranking"><?= $ranking->getTotalGames() ?></td>
                    	       	<td class="td-ranking"><?= $ranking->getTotalPoints() ?></td>
                    	       	<td class="td-ranking"><?= $ranking->getTotalWins(); ?></td>
                    	       	<td class="td-ranking"><?= $ranking->getTotalDraws(); ?></td>
                    	       	<td class="td-ranking"><?= $ranking->getTotalLoss(); ?></td>
                    	       	<td class="td-ranking"><?= $ranking->getTotalScoresPlus(); ?></td>
                    	       	<td class="td-ranking"><?= $ranking->getTotalScoresMinus(); ?></td>
                    	       	<td class="td-ranking"><?= $ranking->getTotalScoresDiff(); ?></td>
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

	<?php
	include '_group.php';
    ?>

	</section>

	

<?php get_footer(); ?>


<style>
.responsive-table-container
{
	width: 100%;
	overflow-y: auto;
	_overflow: auto;
	margin: 0 0 1em;
}
.td-ranking {
    text-align:center;
    width: 50px;
	border: 0px solid black;
}
</style>
