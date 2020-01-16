<?php
/**
 * Uni Theme Sidebar functions
 *
 * @link 
 *
 * @package Uni_Theme
 */

function uni_sidebar(){
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	if( $layout != '1' ) {
		get_sidebar();
	}
}
add_action( 'after_main_content','uni_sidebar' );

function uni_sidebar_alt(){
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	if( $layout == '4' || $layout == '5' || $layout == '6' ) {
		get_sidebar('alt');
	}
}
add_action( 'after_content_sidebar_wrap','uni_sidebar_alt' );