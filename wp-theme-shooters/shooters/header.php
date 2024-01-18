<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	
	<?php wp_head(); ?>


	<link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/shooters/icons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/shooters/icons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/shooters/icons/favicon-16x16.png">
	<link rel="manifest" href="/wp-content/themes/shooters/icons/site.webmanifest">
	<link rel="mask-icon" href="/wp-content/themes/shooters/icons/safari-pinned-tab.svg" color="#ee9e34">
	<link rel="shortcut icon" href="/wp-content/themes/shooters/icons/favicon.ico">
	<meta name="msapplication-TileColor" content="#2b5797">
	<meta name="msapplication-config" content="/wp-content/themes/shooters/icons/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<style>
			#content {
	/*border-top: 5px solid var(--orange);
	border-bottom: 5px solid var(--orange);
	
	margin-top:5px;
	margin-bottom:5px;
	*/
	width:100%;
}

			.background-image {
	background-image: url("/wp-content/themes/shooters/images/mountains.png");
	background-position: right bottom;
    /*background-attachment: fixed;*/
	background-repeat: repeat-x;
	background-color: var(--orange);
	/*background-origin: content-box;*/
	width: 100%;
	height: 100%;
	background-size: contain;
    /*background-repeat: no-repeat;*/
	/*background-position: center;*/
	/*height: 500px; 
	width: 100%;*/
}
.background-image-right {
	background-image: url("/wp-content/themes/shooters/images/mountains.png");
	background-position: left bottom;
    /*background-attachment: fixed;*/
	background-repeat: repeat-x;
	background-color: var(--orange);
	/*background-origin: content-box;*/
	width: 100%;
	height: 100%;
	background-size: contain;
    /*background-repeat: no-repeat;*/
	/*background-position: center;*/
	/*height: 500px; 
	width: 100%;*/
}
#leftdiv {
	height: auto;
}

#rightdiv {
	height: auto;	
}
</style>
</head>
<body <?php body_class(); ?>>
	<div id="page" class="hfeed site" style="width:100%;">
		<?php do_action( 'worldstar_header_bar' ); ?>
		<header id="masthead" class="site-header clearfix" role="banner">
			<div class="background-blue">
				<div class="header-main container clearfix">
					<div id="logo" class="site-branding clearfix">
						<a href="/" class="custom-logo-link" rel="home" aria-current="page">
							<img src="/wp-content/themes/shooters/images/mythen-shooters-logo.png" class="custom-logo" alt="HSG Mythen-Shooters" decoding="async" />					
						</a>
					</div><!-- .site-branding -->
					<div class="header-widgets clearfix">
						<?php // Display Header Widgets.
						if ( is_active_sidebar( 'header' ) ) :
							dynamic_sidebar( 'header' );
						endif; ?>
					</div><!-- .header-widgets -->
				</div><!-- .header-main -->
			</div>
			<div id="main-navigation-wrap" class="primary-navigation-wrap">
				<nav id="main-navigation" class="primary-navigation navigation container clearfix" role="navigation">
					<?php
						// Display Main Navigation.
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'container' => false,
							'menu_class' => 'main-navigation-menu',
							'echo' => true,
							'fallback_cb' => 'worldstar_default_menu',
							)
						);
					?>
				</nav><!-- #main-navigation -->
			</div>
		</header><!-- #masthead -->

		<?php worldstar_header_image(); ?>
		<?php worldstar_breadcrumbs(); ?>
		

		<div style="display:flex;width:100%;margin-top:5px;margin-bottom:5px;">
		<div id="leftdiv" class="background-image"></div>

		<div id="content" class="site-content container" style="">

