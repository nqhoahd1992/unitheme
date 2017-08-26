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
	define( 'CHILD_DIR',  get_stylesheet_directory() );
	define( 'SH_FUNCTIONS_DIR', PARENT_DIR . '/inc/functions' );
}
add_action( 'init', 'sh_constants' );

function sh_load_framework() {
	// Load Functions.
	require_once( SH_FUNCTIONS_DIR . '/sidebar.php' );
	require_once( SH_FUNCTIONS_DIR . '/formatting.php' );
}
add_action( 'init','sh_load_framework' );

if ( ! function_exists( 'shtheme_setup' ) ) :
	function shtheme_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on SH Theme, use a find and replace
		 * to change 'shtheme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'shtheme', get_template_directory() . '/languages' );

		// Add theme support
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'shtheme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'shtheme_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'shtheme_setup' );

/**
 * Register Widget Area
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
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
 * Enqueue Script File And Css File
 */
function shtheme_scripts() {
	wp_enqueue_style( 'shtheme-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'shtheme_scripts' );

function shtheme_lib_scripts(){
	// Bootstrap
	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/lib/js/bootstrap.min.js', array('jquery'), '1.0', true );
	wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() .'/lib/css/bootstrap.min.css' );

	// if ( class_exists( 'WooCommerce' ) ) {
	// 	wp_enqueue_style( 'woocommerce-style', get_template_directory_uri() .'/lib/css/custom-woocommerce.css' );
	// }

	// Owl carousel
	wp_register_script( 'owlcarousel-js', get_template_directory_uri() . '/lib/js/owl.carousel.min.js', array('jquery'), '1.0', true );
	wp_register_style( 'owlcarousel-style', get_template_directory_uri() .'/lib/css/owl.carousel.min.css' );
	wp_register_style( 'owlcarousel-theme-style', get_template_directory_uri() .'/lib/css/owl.theme.default.min.css' );
}
add_action( 'wp_enqueue_scripts', 'shtheme_lib_scripts' , 1 );

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
 * Load Woocomerce
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/function-woo.php';
}

/**
 * Load Menu Walker Bootstrap
 */
require get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

/**
 * Remove Title
 */
add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
            $title = single_cat_title( '', false );
        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );
        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>';
        }
    return $title;
});

/**
 * Plugin Require Install
 */
function sh_plugin_activation() {

    $plugins = array(
        array(
            'name' 		=> 'Redux Framework',
            'slug' 		=> 'redux-framework',
            'required' 	=> true
        )
    );

    $configs = array(
        'menu' 			=> 'tp_plugin_install',
        'has_notice' 	=> true,
        'dismissable' 	=> false,
        'is_automatic' 	=> true
    );
    tgmpa( $plugins, $configs );
 
}
add_action('tgmpa_register', 'sh_plugin_activation');

/**
 * Add Body Class
 */
function add_class_body_layout( $classes ) {
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	switch ($layout) {
	    case '1':
	        $classes[] = 'no-sidebar';
	        break;
	    case '2':
	        $classes[] = 'sidebar-content';
	        break;
	    case '3':
	        $classes[] = 'content-sidebar';
	        break;
	    case '4':
	        $classes[] = 'sidebar-content-sidebar';
	        break;
        case '5':
	        $classes[] = 'sidebar-sidebar-content';
	        break;
	    case '6':
	        $classes[] = 'content-sidebar-sidebar';
	        break;
	}
	return $classes;

}
add_filter( 'body_class', 'add_class_body_layout' );

/**
 * Add header class
 */
function header_class( ) {
	global $sh_option;
	$array_class_header = array('site-header');
	$layout_header 		= $sh_option['opt-layout-header'];
	if( $layout_header == '1' ) {
		$array_class_header[] = 'logo-center';
	} else {
		$array_class_header[] = 'logo-left';
	}
    echo 'class="' . join( ' ', $array_class_header ) . '"';
}

/**
 * Show logo
 */
function display_logo(){
	global $sh_option;
	$url_logo = $sh_option['opt_settings_logo']['url'];
	if( ! empty( $url_logo ) ) {
		echo '<a href="'.get_site_url( ).'"><img src="'. $url_logo .'"></a>';
	}
}

/**
 * Favicon
 */
function insert_favicon(){
	global $sh_option;
	$url_favicon = $sh_option['opt_settings_favicon']['url'];
	if( ! empty( $url_favicon ) ) {
		echo '<link rel="shortcut icon" href="'. $url_favicon .'" type="image/x-icon" />';
	}
}
add_action( 'wp_head','insert_favicon' );

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

/**
 * Add Thumb Size
**/
add_image_size( 'sh_thumb300x200', 300, 200, array( 'center', 'center' ) );

add_image_size( 'sh_thumb190x120', 190, 120, array( 'center', 'center' ) );

add_image_size( 'sh_thumb124x124', 124, 124, array( 'center', 'center' ) );


/**
 * Pagination
**/
if ( ! function_exists( 'shtheme_pagination' ) ) {
	function shtheme_pagination() {
		global $wp_query;
		$big = 999999999;
		echo '<div class="page_nav">';
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
		echo '</div>';
	}
}

/**
 * Remove Admin Bar
**/
function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->remove_node('comments');
}
add_action('admin_bar_menu', 'remove_wp_logo', 999);

/**
 * Hide Menu Page If User not admin3b
**/
function remove_menus() {
	global $current_user;
	$username = $current_user->user_login;
	if ($username == 'admin3b') {
	 	remove_menu_page( 'plugins.php' );
	 	remove_menu_page( 'tools.php' );
	 	remove_menu_page( 'options-general.php' );
	 	remove_menu_page( 'edit-comments.php' );
	}
}
add_action( 'admin_menu', 'remove_menus', 999 );

function remove_unnecessary_wordpress_menus(){
	global $current_user;
	$username = $current_user->user_login;
	if ($username == 'admin3b') {
		global $submenu;
		unset($submenu['index.php'][10]);
	    unset($submenu['themes.php'][5]);
	    unset($submenu['themes.php'][20]);
	    unset($submenu['themes.php'][22]);
	}
}
add_action('admin_menu', 'remove_unnecessary_wordpress_menus', 999);

/**
 * Remove Dashboard
**/
function disable_default_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['high']['redux_dashboard_widget']);

}
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);

/**
 * Move All File js To Footer
**/
function footer_enqueue_scripts() {
	remove_action('wp_head', 'wp_print_scripts');
	remove_action('wp_head', 'wp_print_head_scripts', 9);
	remove_action('wp_head', 'wp_enqueue_scripts', 1);
	add_action('wp_footer', 'wp_print_scripts', 5);
	add_action('wp_footer', 'wp_enqueue_scripts', 5);
	add_action('wp_footer', 'wp_print_head_scripts', 5);
}
add_action('after_setup_theme', 'footer_enqueue_scripts');