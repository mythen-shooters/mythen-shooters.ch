<?= get_header() ?>

<?
require_once (plugin_dir_path(__FILE__) . '../../includes/class-handball-repository.php');
$repo = new HandballGalleryRepository();
$galleries = $repo->findAll();
?>

<style>
.center-cropped {
	display: inline-block;
	width: 100%;
	height: 200px;
	background-position: center center;
	background-size: cover;
}
</style>

<div class="wrap">
	<div id="primary" class="fullwidth-content-area content-area">
		<main id="main" class="site-main" role="main">
    		<h1 class="entry-title">Galerie</h1>
    		<div class="entry-content clearfix">
    		<?php
    		$i = 0;
			$open = false;
    		foreach ($galleries as $gallery) {
				if ($i % 3 == 0) {
					echo '<div style="overflow:hidden;">';
					$open = true;
				}

				?>
				<a class='content-column one_third' style='margin-bottom:20px;display:block;cursor:pointer;' href='<?= $gallery->getUrl() ?>'>
					<div style="background-color:var(--light-blue);">
						<?			
						$imgUrl = $gallery->getFirstImageUrlInPost();
						if (!empty($imgUrl)) {
							?>
								<div class='center-cropped' style="display:block;background-image: url('<?= $imgUrl ?>');"></div>
							<?
						}
						?>						
						<div style="padding-left:8px;padding-right:5px;padding-top:8px;color:white;height:70px;overflow:hidden;font-weight:bold;">
							<div style="font-size:14px;"><?= $gallery->formattedStartDateLong() ?></div>
							<div><?= esc_attr($gallery->getTitle()) ?></div>
						</div>
					</div>
				</a>
					
					<?
					if ($i % 3 == 2) {
						echo '</div>';
						$open = false;
					}
					$i++; 
    		}
			if ($open) { echo '</div>'; }
    		?>
    		</div>
		</main>
	</div>
</div>
<?= get_footer() ?>
