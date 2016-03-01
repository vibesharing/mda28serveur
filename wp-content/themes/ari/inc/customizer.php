<?php
/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @package Ari
 */

function ari_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	// Add custom sections.
	$wp_customize->add_section( 'ari_themeoptions', array(
		'title'         => __( 'Theme Options', 'ari' ),
		'priority'      => 1,
	) );
	
	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'ari' );
	$wp_customize->get_section('header_image')->title = esc_html__( 'Logo', 'ari' );


	$wp_customize->add_section( 'ari_themeoptions', array(
		'title'         => esc_html__( 'Theme Options', 'ari' ),
		'priority'      => 135,
	) );

	// Custom Colors.
	// Link Color.
	$wp_customize->add_setting( 'link_color' , array(
    	'default'     		=> '#88C34B',
    	'sanitize_callback' => 'sanitize_hex_color',
		'transport'   		=> 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'		=> esc_html__( 'Link Color', 'ari' ),
		'section'	=> 'colors',
		'settings'	=> 'link_color',
	) ) );
	
	// Text Color.
	$wp_customize->add_setting( 'text_color' , array(
    	'default'     		=> '#4C4C4C',
    	'sanitize_callback' => 'sanitize_hex_color',
		'transport'   		=> 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'text_color', array(
		'label'		=> esc_html__( 'Text Color', 'ari' ),
		'section'	=> 'colors',
		'settings'	=> 'text_color',
	) ) );
	
	// Custom Theme Options.
	$wp_customize->add_setting( 'dark_theme', array(
		'default'	=> '',
		'sanitize_callback' => 'ari_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'dark_theme', array(
		'label'		=> __( 'Use dark theme version', 'ari' ),
		'section'	=> 'ari_themeoptions',
		'type'		=> 'checkbox',
		'priority'	=> 1,
	) );

}
add_action( 'customize_register', 'ari_customize_register' );

/**
 * Sanitize Checkboxes.
 */
function ari_sanitize_checkbox( $input ) {
	if ( 1 == $input ) {
		return true;
	} else {
		return false;
	}
}