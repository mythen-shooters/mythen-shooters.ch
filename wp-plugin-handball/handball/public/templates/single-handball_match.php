<?php
get_header(); ?>

<?
  global $post;
  require_once(plugin_dir_path(__FILE__) . '../../includes/class-handball-repository.php');
  $matchId = get_post_meta($post->ID, 'handball_game_id', true);
  $gameReportType = get_post_meta($post->ID, 'handball_game_report_type', true);

  $matchRepo = new HandballMatchRepository();
  $match = $matchRepo->findById($matchId);
  $showEncounterWithLeague = false;  

  $previewUrl = $gameReportType == 'report' ? $match->getPostPreviewUrl() : null;
?>

<section id="primary" class="content-area">
  <main id="main" class="site-main" role="main">

    <?php while (have_posts()):
      the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
          <? the_title('<h1 class="entry-title">', '</h1>') ?>
        </header>
        <? the_content() ?>
        <?
        $time_string = sprintf('%3$s',
          esc_attr(get_the_time()),
          esc_attr(get_the_date('c')),
          esc_html(get_the_date())
        );
        ?>
        <div style="font-size:0.8em;border-top: 1px solid white;padding-top:5px;margin-bottom:20px;">
          <?= $time_string ?>, <?= esc_html(get_the_author()) ?>

          <?
            if ($previewUrl != null) {
          ?>
            | <a href="<?= $previewUrl ?>">zur Vorschau</a>
          <?
            }
          ?>
        </div>
      </article>
    <?php endwhile; ?>
  </main>
</section>

<section id="secondary" class="sidebar widget-area clearfix" role="complementary">
  <div class="entry-content clearfix" style="text-align:center;border-bottom:0px solid #eee;margin-bottom:5px;border:5px solid var(--orange);border-radius:10px;">
    <div style="background-color:var(--orange);">
      <h3 style="margin: 0px;padding:10px;"><?= $match->getLeagueLong() ?></h3>
    </div>

    <div style="padding-top:15px;padding-bottom:10px;">

      <div style="padding:5px;margin-bottom:5px;">
        <img style="position:relative;right:15px;width:60px;" src="<?= $match->getTeamAImageUrl(60) ?>" />
        <span style="position:relative;bottom:20px;font-weight:normal;font-size:30px;">-</span>
        <img style="position:relative;left:15px;width:60px;" src="<?= $match->getTeamBImageUrl(60) ?>" />
      </div>

    <div style="padding-left:5px;padding-right:5px;">
      <span style="font-size:20px;">
        <?= $match->getEncounter() ?>
      </span>
    </div>
    <?
    if (!$match->isPlayed()) {
      echo $match->getGameDateTimeFormattedShort();
      echo " Uhr in ";
      echo $match->getVenue();
    } else {
      echo $match->getScore();
    }
    ?>
    <div style="border-top:0px solid var(--orange);margin-top:5px;">
      <a href="<?= $match->getLivetickerUrl() ?>">Liveticker</a>
    </div>
  </div>
  </div>

  <?
  $teamId = $match->getTeamId();
  include '_group.php';
  ?>

  <?
    $halle = $match->getVenue() . "+" . $match->getVenueAddress() . "+" . $match->getVenueZip() . "+" . $match->getVenueCity();
  ?>

  <h3 style="margin-bottom:5px;">Halle</h3>
  <?= $match->getVenue() ?>
  <br />
  <?= $match->getVenueAddress() ?>
  <br />
  <?= $match->getVenueZip() ?>
  <?= $match->getVenueCity() ?>
  <iframe width="100%" height="600" style="margin-top:10px;height:300px;margin-bottom:10px;"
    src="https://maps.google.com/maps?width=100%&amp;height=300&amp;hl=de&amp;q=<?= $halle ?>&amp;ie=UTF8&amp;t=&amp;z=10&amp;iwloc=B&amp;output=embed"
    frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
  </iframe>

  <?
  $teamRepo = new HandballTeamRepository();
  $team = $teamRepo->findById($teamId);
  if ($team != null) {
    $post = $team->findPost();
    $imgUrl = WpPostHelper::getFirstImageUrlInPost($post);
    ?>
    <div>
      <h3 style="margin-bottom:05px;"><?= $team->getPostTitle() ?></h3>
      <a style="display:block" href="<?= $team->getTeamUrl() ?>">
        <img src="<? echo $imgUrl ?>" />
      </a>
    </div>
    <?
  }
  ?>
</section>

<?
get_footer();
?>