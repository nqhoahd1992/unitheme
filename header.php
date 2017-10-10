<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SH_Theme
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<?php global $sh_option;?>
<body <?php body_class(); ?>>
<div id="page" class="site">

	<header id="masthead" role="banner" <?php header_class();?>>
		<!-- Start Menu Mobile -->
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#NavbarMobile">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<a class="navbar-brand" href="<?php echo get_site_url();?>">Menu</a>
			</div>
			<div class="container-fluid">
				<?php
				wp_nav_menu( array(
	                'menu'              => 'primary',
	                'menu_id'        	=> 'primary-menu',
	                'theme_location'    => 'menu-1',
	                'depth'             => 2,
	                'container'         => 'div',
	                'container_class'   => 'collapse navbar-collapse',
	                'container_id'      => 'NavbarMobile',
	                'menu_class'        => 'nav navbar-nav',
	                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
	                'walker'            => new WP_Bootstrap_Navwalker())
	            );
	            ?>
       	 	</div>
		</div>
		<!-- End Menu Mobile -->
		<?php
		if( $sh_option['display-topheader-widget'] == 1 ) {
			?>
			<div class="top-header">
				<div class="container">
					<?php dynamic_sidebar( 'Top Header' );?>
				</div>
			</div>
			<?php
		}
		?>
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
				<nav id="site-navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" class="main-navigation">
					<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
				</nav><!-- #site-navigation -->
			</div>
		</div>
	</header><!-- #masthead -->
	
	<div id="content" class="site-content">

		<?php
		if( $sh_option['display-pagetitlebar'] == '1' && ! is_front_page() ) {
			echo '<div class="flex page-title-bar">';
				echo '<div class="container">';
					echo '<div class="title-bar-wrap">';
						if( is_page( ) || is_single( ) ) {
							echo '<h1 class="title">'.get_the_title( ).'</h1>';
						} elseif( is_category() ) {
							the_archive_title( '<h1 class="title">', '</h1>' );
						} elseif( is_search() ) {
							echo '<h1 class="title">Kết quả tìm kiếm cho từ khóa: '. get_search_query() .'</h1>';
						} elseif( is_product_category() ) {
							?><h1 class="title"><?php woocommerce_page_title(); ?></h1><?php
						} elseif( is_404() ) {
							echo '<h1 class="title">404</h1>';
						}
						breadcrumbs();
					echo '</div>';
				echo '</div>';
			echo '</div>';
		}
		?>

		<div class="container">
