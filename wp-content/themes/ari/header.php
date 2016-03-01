<?php 
/**
 * The header for our theme.
 *
 * @package ari
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrap" class="clearfix">
	<div id="sidebar-primary">

	<div class="logo">
	<?php if ( get_header_image() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-logo"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt=""></a>
	<?php endif; ?>

	<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1><p><?php bloginfo( 'description' ); ?></p>

	</div><!--end .logo-->

	<?php get_sidebar('primary'); ?>

	</div>
	<!--end Sidebar One-->