<?= get_header() ?>

<div class="wrap">
	<div id="primary" class="fullwidth-content-area content-area">
		<main id="main" class="site-main" role="main">
    		<h1 class="entry-title">Events</h1>
    		<div class="entry-content clearfix">
			<?
 				$widget = new HandballNextEventWidget();
			    $args = [];
				$args['before_widget'] = '';
				$args['after_widget'] = '';
				$instance = [];
				$instance['eventsToShow'] = "-1";
				$widget->widget($args, $instance);
			?>
			</div>
		</main>
	</div>
</div>

<?= get_footer() ?>
