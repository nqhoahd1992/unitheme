<?php
/**
 * The header for our theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SH_Theme
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<?php global $sh_option;?>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

<?php do_action( 'sh_before_header' );?>

<div id="page" class="site">

	<header id="masthead" <?php header_class();?> role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">

		<!-- Start Menu Mobile -->
		<div class="navbar fixed-top">
			<a id="showmenu" class="">
				<span class="hamburger hamburger--collapse">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</span>
			</a>
			<a class="navbar-brand" href="<?php echo get_site_url();?>">Menu</a>
		</div>
		<!-- End Menu Mobile -->
		
		<?php if( $sh_option['display-topheader-widget'] == 1 ) : ?>
			<!-- Start Top Header -->
			<div class="top-header">
				<div class="container">
					<?php dynamic_sidebar( 'Top Header' );?>
				</div>
			</div>
			<!-- End Top Header -->
		<?php endif; ?>

		<div class="container">
			<div class="site-branding">
				<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->

			<div class="header-content">
				<div class="logo">
					<?php display_logo();?>
				</div>
				<?php
				if( $sh_option['opt-layout-header'] == '2' ) {
					echo '<nav id="site-navigation" class="main-navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">';
						wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'menu_class' => 'menu clearfix' ) );
					echo '</nav>';
				}
				do_action( 'sh_after_menu' );
				?>
			</div>
			
		</div>
	</header><!-- #masthead -->

	<?php
	if( $sh_option['opt-layout-header'] == '1' ) {
		echo '<nav id="site-navigation" class="main-navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">';
			echo '<div class="container">';
				wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'menu_class' => 'menu clearfix' ) );
			echo '</div>';
		echo '</nav>';
	}
	?>
	
	<div id="content" class="site-content">

		<?php do_action( 'sh_before_main_content' ) ?>

		<div class="container">
