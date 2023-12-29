<?php get_header(); ?>

<?php
require_once (plugin_dir_path(__FILE__) . '../../includes/class-handball-repository.php');

$repo = new HandballGalleryRepository();
$galleries = $repo->findAll();
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
    		<h1 class="entry-title">Galerie</h1>
    		<div class="entry-content clearfix">
    		<?php
    		$classFirst = "content-column one_third";
    		$classLast = "content-column one_third last_column";
    		$i = 0;
			$open = false;
    		foreach ($galleries as $gallery) {
				if ($i % 3 == 0) {
					echo '<div style="overflow:hidden;">';
					$open = true;
				}
			
    		    if ($i % 3 == 2) {
    		        echo "<div class='$classLast' style='padding-right:25px;'>";
    		    } else {
    		        echo "<div class='$classFirst' style='padding-right:25px;'>";					
    		    }

				echo '<span style="position:relative;top:35px;color:#aaa;font-size:12px;">'.$gallery->formattedStartDateLong().'</span>';
    		    echo '<h2 style="position:relative;top:15px;font-size:18px;">' . esc_attr($gallery->getTitle()) . '</h2>';
				

        		$imgUrl = $gallery->getFirstImageUrlInPost();
        		if (!empty($imgUrl)) {
        		  echo '<img style="height:225px;" src="' . $imgUrl .'" />';
        		}
        		?><br /><a href="<?= $gallery->getUrl() ?>" class="more-link">Album anschauen</a><?php
                echo '</div>';
				
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

<?php get_footer(); ?>

<style>
#primary {
    width: 100% !important;
}
</style>
