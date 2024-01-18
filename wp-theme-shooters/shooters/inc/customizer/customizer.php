<?php
/**
 * Implement theme options in the Customizer
 *
 * @package WorldStar
 */
 
// Load Customizer Helper Functions.
require( get_template_directory() . '/inc/customizer/functions/custom-controls.php' );
require( get_template_directory() . '/inc/customizer/functions/sanitize-functions.php' );
require( get_template_directory() . '/inc/customizer/functions/callback-functions.php' );
// Load Customizer Section Files.
require( get_template_directory() . '/inc/customizer/sections/customizer-general.php' );
require( get_template_directory() . '/inc/customizer/sections/customizer-post.php' );
/**
 * Registers Theme Options panel and sets up some WordPress core settings
 *
 * @param object $wp_customize / Customizer Object.
 */
function worldstar_customize_register_options( $wp_customize ) {
	// Add Theme Options Panel.
	$wp_customize->add_panel( 'worldstar_options_panel', array(
		'priority'       => 180,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Theme Options', 'worldstar' ),
		'description'    => worldstar_customize_theme_links(),
	) );
	// Change default background section.
	$wp_customize->get_control( 'background_color' )->section   = 'background_image';
	$wp_customize->get_section( 'background_image' )->title     = esc_html__( 'Background', 'worldstar' );
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	// Add selective refresh for site title and description.
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector'        => '.site-title a',
		'render_callback' => 'worldstar_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector'        => '.site-description',
		'render_callback' => 'worldstar_customize_partial_blogdescription',
	) );
	// Add Display Site Title Setting.
	$wp_customize->add_setting( 'worldstar_theme_options[site_title]', array(
		'default'           => true,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[site_title]', array(
		'label'    => esc_html__( 'Display Site Title', 'worldstar' ),
		'section'  => 'title_tagline',
		'settings' => 'worldstar_theme_options[site_title]',
		'type'     => 'checkbox',
		'priority' => 10,
		)
	);
	// Add Display Tagline Setting.
	$wp_customize->add_setting( 'worldstar_theme_options[site_description]', array(
		'default'           => false,
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'worldstar_sanitize_checkbox',
		)
	);
	$wp_customize->add_control( 'worldstar_theme_options[site_description]', array(
		'label'    => esc_html__( 'Display Tagline', 'worldstar' ),
		'section'  => 'title_tagline',
		'settings' => 'worldstar_theme_options[site_description]',
		'type'     => 'checkbox',
		'priority' => 11,
		)
	);
} // worldstar_customize_register_options()
add_action( 'customize_register', 'worldstar_customize_register_options' );
/**
 * Render the site title for the selective refresh partial.
 */
function worldstar_customize_partial_blogname() {
	bloginfo( 'name' );
}
/**
 * Render the site tagline for the selective refresh partial.
 */
function worldstar_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
/**
 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
 */
function worldstar_customize_preview_js() {
	wp_enqueue_script( 'worldstar-customizer-preview', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20170627', true );
}
add_action( 'customize_preview_init', 'worldstar_customize_preview_js' );
/**
 * Returns Theme Links
 */
function worldstar_customize_theme_links() {
	ob_start();
	?>
		<div class="theme-links">
			<span class="customize-control-title"><?php esc_html_e( 'Theme Links', 'worldstar' ); ?></span>
			<p>
				<a href="<?php echo esc_url( __( 'https://themezee.com/themes/worldstar/', 'worldstar' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=worldstar&utm_content=theme-page" target="_blank">
					<?php esc_html_e( 'Theme Page', 'worldstar' ); ?>
				</a>
			</p>
			<p>
				<a href="http://preview.themezee.com/?demo=worldstar&utm_source=customizer&utm_campaign=worldstar" target="_blank">
					<?php esc_html_e( 'Theme Demo', 'worldstar' ); ?>
				</a>
			</p>
			<p>
				<a href="<?php echo esc_url( __( 'https://themezee.com/docs/worldstar-documentation/', 'worldstar' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=worldstar&utm_content=documentation" target="_blank">
					<?php esc_html_e( 'Theme Documentation', 'worldstar' ); ?>
				</a>
			</p>
			<p>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/worldstar/reviews/?filter=5', 'worldstar' ) ); ?>" target="_blank">
					<?php esc_html_e( 'Rate this theme', 'worldstar' ); ?>
				</a>
			</p>
		</div>
	<?php
	$theme_links = ob_get_contents();
	ob_end_clean();
	return $theme_links;
}
