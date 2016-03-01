<?php
/**
 * Implement a custom logo for Ari
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package Ari
 */

function ari_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '88C34B',
		'width'                  => 240,
		'height'                  => 60,
		'flex-width'             => false,
		'flex-height'            => true,
		'wp-head-callback'       => 'ari_header_style',
	);

	add_theme_support( 'custom-header', $args );

}
add_action( 'after_setup_theme', 'ari_custom_header_setup', 11 );


/**
 * Style the header text displayed on the blog.
 *
 * @return void
 */
function ari_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="ari-header-css">
	<?php
		if ( ! empty( $header_image ) and  display_header_text()) :
	?>
	
	<?php
		endif;

		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
	
	.logo h1 a {display: none !important;}

	<?php

		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.logo h1 a {color: #<?php echo esc_attr( $text_color ); ?>;}
	<?php endif; ?>
	</style>
	<?php
}