<?php
/**
 * Callback Functions
 *
 * Used to determine whether an option setting is displayed or not.
 * Called via the active_callback parameter of the add_control() function
 *
 * @package WorldStar
 */
 
/**
 * Adds a callback function to retrieve wether post content is set to excerpt or not
 *
 * @param object $control / Instance of the Customizer Control.
 * @return bool
 */
function worldstar_control_post_content_callback( $control ) {
	// Check if excerpt mode is selected.
	if ( 'excerpt' === $control->manager->get_setting( 'worldstar_theme_options[post_content]' )->value() ) :
		return true;
	else :
		return false;
	endif;
}
/**
 * Adds a callback function to retrieve wether featured is activated or not
 *
 * @param object $control / Instance of the Customizer Control.
 * @return bool
 */
function worldstar_featured_activated_callback( $control ) {
	// Check if Featured Posts is turned on.
	if ( true === $control->manager->get_setting( 'worldstar_theme_options[featured_blog]' )->value() ) :
		return true;
	elseif ( true === $control->manager->get_setting( 'worldstar_theme_options[featured_magazine]' )->value() ) :
		return true;
	else :
		return false;
	endif;
}
