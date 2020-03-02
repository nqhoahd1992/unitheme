<?php
define( 'PARENT_DIR', get_template_directory() );
define( 'UNI_DIR',  get_template_directory_uri() );
define( 'FUNCTIONS_DIR', PARENT_DIR . '/inc/template-functions' );
define( 'TAGS_DIR', PARENT_DIR . '/inc/template-tags' );

/**
 * Uni Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Uni_Theme
 */

if ( ! function_exists( 'unitheme_setup' ) ) :
	function uni_setup() {
		
		load_theme_textdomain( 'shtheme', PARENT_DIR . '/languages' );

		// Add theme support
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption',) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'uni_custom_background_args', array('default-color' => 'ffffff','default-image' => '',) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'shtheme' ),
		) );

		// Load Theme Options
		require PARENT_DIR . '/inc/options.php';

		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			Redux::init('sh_option');
		}
	}
endif;
add_action( 'after_setup_theme', 'uni_setup' );

function uni_load_framework() {
	// Load Functions.
	require_once( PARENT_DIR . '/inc/options-function.php' );
	require_once( FUNCTIONS_DIR . '/init.php' );
	require_once( FUNCTIONS_DIR . '/sidebar.php' );
	require_once( FUNCTIONS_DIR . '/breadcrumbs.php' );
	require_once( FUNCTIONS_DIR . '/dashboard.php' );
	require_once( FUNCTIONS_DIR . '/mobilemenu.php' );
	require_once( TAGS_DIR . '/formatting.php' );
	require_once( TAGS_DIR . '/class-tgm-plugin-activation.php' );
}
add_action( 'after_setup_theme','uni_load_framework' );

/**
 * Register Widget Area
 */
function uni_widgets_init() {

	global $sh_option;
	if( $sh_option['display-topheader-widget'] == '1' ) {
		register_sidebar( array(
			'name'          => __( 'Top Header', 'shtheme' ),
			'id'            => 'top-header',
			'description'   => __( 'Top Header widget area', 'shtheme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	// Footer Widget
	$footer_widgets_number = intval( $sh_option['opt-number-footer'] );
	$counter = 1;
	while ( $counter <= $footer_widgets_number ) {

		register_sidebar( array(
			'name'          => sprintf( __( 'Footer %d', 'shtheme' ), $counter ),
			'id'            => sprintf( 'footer-%d', $counter ),
			'description'   => sprintf( __( 'Footer %d widget area', 'shtheme' ), $counter ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );

		$counter++;
	}

	// Sidebar Widget
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
add_action( 'widgets_init', 'uni_widgets_init' );

/**
 * Load File
 */

// Load Custom Post Type
// require PARENT_DIR . '/inc/template-functions/cpt/cpt-abstract.php';
// require PARENT_DIR . '/inc/template-functions/cpt/khach-hang.php';
// require PARENT_DIR . '/inc/template-functions/cpt/cpt.php';
	
// Load Custom Taxonomy
// require PARENT_DIR . '/inc/template-functions/taxonomies/custom-taxonomy-abstract.php';
// require PARENT_DIR . '/inc/template-functions/taxonomies/khach-hang-cat.php';
// require PARENT_DIR . '/inc/template-functions/taxonomies/custom-taxonomy.php';

// Load Shortcode
require PARENT_DIR . '/inc/shortcode/shortcode-blog.php';
if ( class_exists( 'Vc_Manager' ) ) {
	require PARENT_DIR . '/inc/vc_shortcode/uni-shortcodes.php';
}

// Load Function Woocomerce
if ( class_exists( 'WooCommerce' ) ) {
	require PARENT_DIR . '/inc/shortcode/shortcode-product.php';
	require PARENT_DIR . '/inc/function-woo.php';
	require PARENT_DIR . '/inc/widgets/wg-product-slider.php';
}

// Load Widget
require PARENT_DIR . '/inc/widgets/wg-post-list.php';
require PARENT_DIR . '/inc/widgets/wg-support.php';
require PARENT_DIR . '/inc/widgets/wg-fblikebox.php';
require PARENT_DIR . '/inc/widgets/wg-page.php';
require PARENT_DIR . '/inc/widgets/wg-view-post-list.php';
require PARENT_DIR . '/inc/widgets/wg-information.php';
require PARENT_DIR . '/inc/widgets/wg-social.php';

function uni_lib_scripts(){

	// Bootstrap
	wp_enqueue_script( 'popper-js', UNI_DIR . '/lib/js/popper.min.js', array('jquery'), '1.0', true );
	wp_enqueue_script( 'bootstrap-js', UNI_DIR . '/lib/js/bootstrap.min.js', array('jquery'), '4.4.1', true );
	wp_enqueue_style( 'bootstrap-style', UNI_DIR .'/lib/css/bootstrap.min.css' );

	// Main js
	wp_enqueue_script( 'main-js', UNI_DIR . '/lib/js/main.js', array('jquery'), '1.0', true );
	wp_localize_script(	'main-js', 'ajax', array( 'url' => admin_url('admin-ajax.php') ) );

	// Slick Slider
	wp_register_script( 'slick-js', UNI_DIR . '/lib/js/slick.min.js', array('jquery'), '1.8.1', true );
	wp_register_style( 'slick-style', UNI_DIR .'/lib/css/slick/slick.css' );
	wp_register_style( 'slick-theme-style', UNI_DIR .'/lib/css/slick/slick-theme.css' );

	// Font Awesome
	wp_enqueue_style( 'fontawesome-style', UNI_DIR .'/lib/css/font-awesome-all.css' );

	// Fancybox
	wp_register_script( 'fancybox-js', UNI_DIR .'/lib/js/jquery.fancybox.min.js', array('jquery'), '3.5.7', true);
	wp_register_style( 'fancybox-css', UNI_DIR .'/lib/css/fancybox.min.css' );

	// Validate js
	wp_register_script( 'validate-js', UNI_DIR .'/lib/js/jquery.validate.min.js', array('jquery'), '1.19.0', true );

	// Ring Phone
	wp_register_style( 'phonering-style', UNI_DIR .'/lib/css/phone-ring.css' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'uni_lib_scripts', 1 );

/**
 * Add Thumb Size
**/
add_image_size( 'thumb300x200', 300, 200, array( 'center', 'center' ) );

