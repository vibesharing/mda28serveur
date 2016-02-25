<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'theme-stylesheet', get_stylesheet_directory_uri() . '/animate.css' );
    wp_enqueue_script( 'theme-stylesheet', get_stylesheet_directory_uri() . '/js/jquery-1.10.2.min.js');
}
