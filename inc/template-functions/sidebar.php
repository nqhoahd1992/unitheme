<?php
/**
 * Sidebar
 * @package Uni_Theme
 * @author  
 * @license 
 * @link    
 */

function uni_sidebar(){
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	if( class_exists( 'WooCommerce' ) && ( is_cart() || is_account_page() || is_checkout() ) ) {
		$classes[] = 'no-sidebar';
	} else {
		if( $layout != '1' ) {
			get_sidebar();
		}
	}
	
}
add_action( 'after_main_content','uni_sidebar' );

function uni_sidebar_alt(){
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	if( class_exists( 'WooCommerce' ) && ( is_cart() || is_account_page() || is_checkout() ) ) {
		$classes[] = 'no-sidebar';
	} else {
		if( $layout == '4' || $layout == '5' || $layout == '6' ) {
			get_sidebar('alt');
		}
	}
}
add_action( 'after_content_sidebar_wrap','uni_sidebar_alt' );