<?php
if ( is_active_sidebar( 'sidebar' ) ) : ?>
	<section id="secondary" class="sidebar widget-area clearfix" role="complementary">
		<?php dynamic_sidebar( 'sidebar' ); ?>
	</section><!-- #secondary -->
<?php
endif;
