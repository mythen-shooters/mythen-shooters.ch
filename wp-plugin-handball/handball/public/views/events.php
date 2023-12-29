<?php get_header(); ?>

<?php
require_once (plugin_dir_path(__FILE__) . '../../includes/class-handball-repository.php');

$repo = new HandballEventRepository();
$upComingEvents = $repo->findUpComingEvents();
$pastEvents = $repo->findPastEvents();

$classFirst = "content-column one_third";
$classLast = "content-column one_third last_column";
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
    		<h1 class="entry-title" >Kommende Events</h1>
    		<div class="entry-content clearfix" style="position:relative;top:-25px;">
    		<?php
			$i = 0;
			$open = false;
    		foreach ($upComingEvents as $event) {
				if ($i % 3 == 0) {
					echo '<div style="overflow:hidden;">';
					$open = true;
				}
				
				if ($i % 3 == 0 || $i % 3 == 1) {
    		        $class = $classFirst;
    		    } else {
    		        $class = $classLasat;
    		    }
    		    include(WP_PLUGIN_DIR . '/handball/public/templates/_event-item.php');
				
				if ($i % 3 == 2) {
					echo '</div>';
					$open = false;
				}
				
				$i++;
    		}
			if ($open) { echo '</div>'; }
    		?>
    		</div>

			<div class="clearfix" style="margin-top:20px;"></div>
			
    		<h1 class="entry-title" style="position:relative;top:25px;">Vergangene Events</h1>
    		<div class="entry-content clearfix">
    		<?php
			$i = 0;
			$open = false;
    		foreach ($pastEvents as $event) {
				if ($i % 3 == 0) {
					echo '<div style="overflow:hidden;">';
					$open = true;
				}
				
				if ($i % 3 == 0 || $i % 3 == 1) {
    		        $class = $classFirst;
    		    } else {
    		        $class = $classLasat;
    		    }
    		    include(WP_PLUGIN_DIR . '/handball/public/templates/_event-item.php');
				
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
