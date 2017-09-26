<?php
/**
 * SH Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package SH_Theme
 */

function sh_constants() {
	define( 'PARENT_DIR', get_template_directory() );
	define( 'SH_DIR',  get_template_directory_uri() );
	define( 'SH_FUNCTIONS_DIR', PARENT_DIR . '/inc/functions' );
}
add_action( 'init', 'sh_constants' );

function sh_load_framework() {
	// Load Functions.
	require_once( SH_FUNCTIONS_DIR . '/init.php' );
	require_once( SH_FUNCTIONS_DIR . '/sidebar.php' );
	require_once( SH_FUNCTIONS_DIR . '/formatting.php' );
	require_once( SH_FUNCTIONS_DIR . '/breadcrumbs.php' );
	require_once( SH_FUNCTIONS_DIR . '/dashboard.php' );
}
add_action( 'init','sh_load_framework' );


/**
 * Register Widget Area
 *
 */
function shtheme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'shtheme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'shtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Secondary Sidebar', 'shtheme' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'shtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'shtheme_widgets_init' );


/**
 * Load Plugin Activation File.
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Load Shortcode
 */
require get_template_directory() . '/inc/shortcode/shortcode-blog.php';

require get_template_directory() . '/inc/shortcode/shortcode-product.php';

/**
 * Load Theme Options
 */
require get_template_directory() . '/inc/options.php';

/**
 * Load Function Woocomerce
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/function-woo.php';
}

/**
 * Load Menu Walker Bootstrap
 */
require get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

/**
 * Load Widget
 */
require get_template_directory() . '/inc/widgets/wg-post-list.php';

require get_template_directory() . '/inc/widgets/wg-support.php';

require get_template_directory() . '/inc/widgets/wg-fblikebox.php';

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/widgets/wg-product-slider.php';
}


/**
 * Inser Code To Header Footer
 */
function insert_code_to_header(){
	global $sh_option;
	$html_header = $sh_option['opt-textarea-header'];
	if( ! empty( $html_header ) ) {
		echo $html_header;
	}
}
add_action( 'wp_head','insert_code_to_header' );

function insert_code_to_footer(){
	global $sh_option;
	$html_footer = $sh_option['opt-textarea-footer'];
	if( ! empty( $html_footer ) ) {
		echo $html_footer;
	}
}
add_action( 'wp_footer','insert_code_to_footer' );



/**
 * Display Logo
 */
function display_logo(){
	global $sh_option;
	$url_logo = $sh_option['opt_settings_logo']['url'];
	if( ! empty( $url_logo ) ) {
		echo '<a href="'.get_site_url( ).'"><img src="'. $url_logo .'"></a>';
	}
}

/**
 * Move All Js File To Footer
**/
function footer_enqueue_scripts() {
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);
	add_action('wp_footer', 'wp_print_scripts', 5);
	add_action('wp_footer', 'wp_enqueue_scripts', 5);
	add_action('wp_footer', 'wp_print_head_scripts', 5);
}
// add_action('after_setup_theme', 'footer_enqueue_scripts');

/**
 * Add Widget Footer
 */
function sh_register_footer_widget_areas() {

	global $sh_option;
	$footer_widgets = $sh_option['opt-number-footer'];
	$footer_widgets_number = intval($footer_widgets);
	$counter = 1;
	while ( $counter <= $footer_widgets_number ) {

		register_sidebar( array(
			'name'          => sprintf( __( 'Footer %d', 'shtheme' ), $counter ),
			'id'            => sprintf( 'footer-%d', $counter ),
			'description'   => sprintf( __( 'Footer %d widget area.', 'shtheme' ), $counter ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

		$counter++;
	}

}
add_action( 'widgets_init','sh_register_footer_widget_areas' );

/**
 * Display Footer
 */
function sh_footer_widget_areas() {

	global $sh_option;

	$footer_widgets = $sh_option['opt-number-footer'];
	$footer_widgets_number = intval($footer_widgets);

	switch ($footer_widgets_number) {
	    case '1':
	        $classes = 'footer-widgets-area col-md-12';
	        break;
	    case '2':
	        $classes = 'footer-widgets-area col-md-6';
	        break;
	    case '3':
	        $classes = 'footer-widgets-area col-md-4';
	        break;
	    case '4':
	        $classes = 'footer-widgets-area col-md-3';
	        break;
	}

 	$counter = 1;
	while ( $counter <= $footer_widgets_number ) {

		echo '<div class="'. $classes .'">';
			dynamic_sidebar( 'footer-' . $counter );
		echo '</div>';
		$counter++;

	}

}
add_action( 'sh_footer', 'sh_footer_widget_areas' );


function shtheme_lib_scripts(){
	// Bootstrap
	wp_enqueue_script( 'bootstrap-js', SH_DIR . '/lib/js/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_style( 'bootstrap-style', SH_DIR .'/lib/css/bootstrap.min.css' );

	// Main js
	wp_enqueue_script( 'main-js', SH_DIR . '/lib/js/main.js', array(), '1.0', true );
	wp_localize_script( 'main-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	// Owl carousel
	wp_register_script( 'owlcarousel-js', SH_DIR . '/lib/js/owl.carousel.min.js', array('jquery'), '1.0', true );
	wp_register_style( 'owlcarousel-style', SH_DIR .'/lib/css/owl.carousel.min.css' );
	wp_register_style( 'owlcarousel-theme-style', SH_DIR .'/lib/css/owl.theme.default.min.css' );

	// Font Awesome
	wp_enqueue_style( 'fontawesome-style', SH_DIR .'/lib/css/font-awesome.min.css' );
}
add_action( 'wp_enqueue_scripts', 'shtheme_lib_scripts' , 1 );

/**
 * Add Thumb Size
**/
add_image_size( 'sh_thumb300x200', 300, 200, array( 'center', 'center' ) );


