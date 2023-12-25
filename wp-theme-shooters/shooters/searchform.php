<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<a href="https://www.instagram.com/hcgoldau/"><img style="width:45px;" class="social-media-icon" src="/wp-content/uploads/2017/08/instagram.png" /></a>
    <a href="https://www.facebook.com/hcgoldau/"><img style="width:45px;" class="social-media-icon" src="/wp-content/uploads/2017/08/facebook.png" /></a>
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'worldstar' ); ?></span>
		<input type="search" class="search-field"
			placeholder="<?php echo esc_attr_x( 'Suchen &hellip;', 'placeholder', 'worldstar' ); ?>"
			value="<?php echo get_search_query(); ?>" name="s"
			title="<?php echo esc_attr_x( 'Search for:', 'label', 'worldstar' ); ?>" />
	</label>
	<button type="submit" class="search-submit">
		<span class="genericon-search"></span>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Suchen', 'submit button', 'worldstar' ); ?></span>
	</button>
</form>
