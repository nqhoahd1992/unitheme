<?php
/**
 * SH Theme Init functions
 *
 * @link 
 *
 * @package SH_Theme
 */

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
 * Security
 */
/* Disable Rest API */
function disable_rest_api(){
	if(!is_user_logged_in()){
		return new WP_Error('Error!', __('Unauthorized access is denied!','rest-api-error'), array('status' => rest_authorization_required_code()));
	}
}
// add_filter('rest_authentication_errors','disable_rest_api');
/* Disable XML RPC */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Optimize
 */
function shtheme_optimize() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    add_filter('the_generator', '__return_false');
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action('after_setup_theme', 'shtheme_optimize');

/**
 * Add Body Class
 */
function add_class_body_layout( $classes ) {
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	switch ( $layout ) {
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
 * Add Header Class
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
 * Display Favicon
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
 * Display Pagination
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
