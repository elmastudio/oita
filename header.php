<?php
/**
 * The theme Header.
 *
 * @package Oita 
 * @since Oita 1.0
 */
?><!DOCTYPE html>
<html  id="doc" class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php $options = get_option('oita_theme_options'); ?>
<?php if( $options['custom_favicon'] != '' ) : ?>
<link rel="shortcut icon" type="image/ico" href="<?php echo $options['custom_favicon']; ?>" />
<?php endif  ?>
<?php if( $options['custom_apple_icon'] != '' ) : ?>
<link rel="apple-touch-icon" href="<?php echo $options['custom_apple_icon']; ?>" />
<?php endif  ?>
<script type="text/javascript">
	var doc = document.getElementById('doc');
	doc.removeAttribute('class', 'no-js');
	doc.setAttribute('class', 'js');
</script>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="menu">

	<nav class="off-canvas-nav">
		<span class="menu-item"><a class="menu-button" href="#menu" title="<?php _e( 'Menu', 'oita' ); ?>"><?php _e( 'Menu', 'oita' ); ?></a></span>
		<span class="sidebar-item"><a class="sidebar-button" href="#sidebar" title="<?php _e( 'Sidebar', 'oita' ); ?>"><?php _e( 'Sidebar', 'oita' ); ?></a></span>
	</nav><!-- end .off-canvas-navigation -->
	<a class="mask-left" href="#menu"></a>
	<a class="mask-right" href="#menu"></a>
	
	<div class="column-wrap">

	<div class="container">

		<?php get_sidebar('left'); ?>

		<section class="content-wrap">
			<header id="site-header" role="banner">
				<hgroup class="site-title">
				<?php if( $options['custom_logo'] != '' ) : ?>
					<a href="<?php echo home_url( '/' ); ?>" class="logo"><img src="<?php echo $options['custom_logo']; ?>" alt="<?php bloginfo('name'); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" /></a>
				<?php else: ?>
					<h1 class="title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				<?php endif  ?>
				</hgroup>
			</header><!-- end .branding -->
