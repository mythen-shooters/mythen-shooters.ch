<?php
get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        	<header class="entry-header">
        		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
        	</header>

        	<?php
        		$time_string = sprintf( '<span title="%1$s" rel="bookmark"><time class="entry-date published updated" datetime="%2$s">%3$s</time></span>',
        		    esc_attr( get_the_time() ),
        		    esc_attr( get_the_date( 'c' ) ),
        		    esc_html( get_the_date() )
        		);
        		echo '<div class="entry-meta"><span class="meta-date">' . $time_string . '</span>';
        		echo '<span class="meta-author"><span class="author vcard" rel="author">' . esc_html( get_the_author()) . '</span></span></div>'
       		    ?>

        	<?php
    			global $post;
    			require_once (plugin_dir_path(__FILE__) . '../../includes/class-handball-repository.php');
    			$matchRepo = new HandballMatchRepository();
    			$matchId = get_post_meta($post->ID, 'handball_game_id', true);
    			$gameReportType = get_post_meta($post->ID, 'handball_game_report_type', true);

    			$match = $matchRepo->findById($matchId);
    			$showScore = $gameReportType == 'report';
    			$showPreviewLink = false;
    			$showReportLink= false;
    			$showLeague = true;
    			$showEncounterWithLeague = false;
    			$highlightHomeGame = false;
    			include '_match-detail.php';

    			the_content();
			?>

        </article>
        <?php endwhile;?>

		</main>
	</section>

<section id="secondary" class="sidebar widget-area clearfix" role="complementary">


  <?
  $teamId = $match->getTeamId();


	$teamRepo = new HandballTeamRepository();
	$team = $teamRepo->findById($teamId);
	if ($team != null) {
		$post = $team->findPost();
		$imgUrl = WpPostHelper::getFirstImageUrlInPost($post);

		?>

		<div>
		<h3>Team</h3>
		<img src="<? echo $imgUrl ?>" />

		</div>

		<?

	}
	
  ?>

<?
	
  	include '_group.php';
  ?>

</section>

<?
  get_footer();
?>
