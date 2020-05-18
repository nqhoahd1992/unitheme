<?php
/**
 * Include function woocommerce
 */
require get_template_directory() . '/inc/woocommerce/tooltip-product.php';
require get_template_directory() . '/inc/woocommerce/woocommerce-grid-list-toggle.php';

/**
 * Register Shop Widget Area
 */
function uni_add_sidebar_shop() {
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'shtheme' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Add widgets here.', 'shtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'uni_add_sidebar_shop' );

/**
 * Add Support Woocommrce
 */
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );

/**
 * Dev Disable Cart
**/
function dev_disable_cart() {
	global $sh_option;
	if( $sh_option['woocommerce-disable-cart'] == '0' ) {
		remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10 );
		remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart',30 );
	}
}
add_action( 'init','dev_disable_cart' );

function remove_menu_pages_disable_cart() {
	global $sh_option;
	if( $sh_option['woocommerce-disable-cart'] == '0' && ! current_user_can('administrator') ) {
    	remove_menu_page( 'woocommerce' );
    }
}
add_action( 'admin_init', 'remove_menu_pages_disable_cart' );

/**
 * Setup Layout Page Woocommerce
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function my_theme_wrapper_start() {
	echo '<div class="content-sidebar-wrap">';
	do_action( 'before_main_content' );
	echo '<main id="main" class="site-main" role="main">';
	do_action( 'before_loop_main_content' );
}

function my_theme_wrapper_end() {
	global $sh_option;
	$layout = $sh_option['opt-layout'];
	echo '</main>';
	if( $layout != '1' ) {
		echo '<aside class="sidebar sidebar-primary sidebar-shop" itemscope itemtype="https://schema.org/WPSideBar">';
			if( $sh_option['display-shopsidebar'] == 1 ) {
				dynamic_sidebar( 'sidebar-shop' );
			} else {
				dynamic_sidebar( 'sidebar-1' );
			}
		echo '</aside>';
	}
	echo '</div>';
}

add_action( 'woocommerce_before_main_content', 'my_theme_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'my_theme_wrapper_end', 10 );

/**
 * Set user role when create account woocommerce
 */
function set_user_role_woocommerce( $args ) {
	$args['role'] = 'subscriber';
	return $args;
}
add_filter( 'woocommerce_new_customer_data', 'set_user_role_woocommerce', 10, 1 );

/**
 * Display feature image of category product
 */
function woocommerce_category_image( $products ) {
    $thumbnail_id  = get_woocommerce_term_meta( $products, 'thumbnail_id', true );
    $thumbnail_arr = wp_get_attachment_image_src( $thumbnail_id, 'full' );
    $image = $thumbnail_arr[0];
    if ( $image ) {
	    $image_category = '<img src="' . $image . '" alt="" />';
	} else {
		$image_category = '<img src="'. get_stylesheet_directory_uri() .'/lib/images/img-not-available.jpg" alt="" />';
	}
	return $image_category;
}

/**
 * Edit number product show per page in category product
 */
function woocommerce_edit_loop_shop_per_page( $cols ) {
	global $sh_option;
	if ( $sh_option['number-products-cate'] ) {
		$cols = $sh_option['number-products-cate'];
	} else {
		$cols = get_option( 'posts_per_page' );
	}
	return $cols;
}
add_filter( 'loop_shop_per_page', 'woocommerce_edit_loop_shop_per_page', 20 );

/**
 * Add percent sale in content product template
 */
function add_percent_sale() {
	global $product;
	if ( $product->is_on_sale() && $product->is_type( 'simple' ) ) {
		$regular_price 	= get_post_meta( get_the_ID(), '_regular_price', true);
		$sale_price 	= get_post_meta( get_the_ID(), '_sale_price', true);
		$per = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
		echo '<span class="percent">-'. $per .'%</span>';
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'add_percent_sale', 15 );

/**
 * Add button continue shopping
 */
function uni_continue_shopping_button() {
	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	echo '<div class="continue_shopping"><a href="'. $shop_page_url .'" class="button">'. __('Continue Shopping','shtheme') .' →</a></div>';
}
add_action( 'woocommerce_proceed_to_checkout', 'uni_continue_shopping_button' );

/**
 * Overwrite field checkout
 */
function custom_override_checkout_fields( $fields ) {
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_address_2'] );
    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'custom_override_checkout_fields' );

// woocomerce checkout disable required
add_filter( 'woocommerce_checkout_fields' , 'uni_custom_override_checkout_fields', 9999 );
function uni_custom_override_checkout_fields( $fields ) {
    $fields['billing']['billing_email']['required'] = false;
    return $fields;
}

/**
 * Return class layout product
 */
function get_column_product( $numcol ) {
	switch ( $numcol ) {
	    case '1':
	        $post_class = 'col-md-12';
	        break;
	    case '2':
	        $post_class = 'col-6';
	        break;
	    case '3':
	        $post_class = 'col-md-4 col-sm-6 col-6';
	        break;
	    case '4':
	        $post_class = 'col-md-3 col-sm-4 col-6';
	        break;
	    case '5':
	        $post_class = 'col-lg-15 col-md-3 col-sm-4 col-6';
	        break;
	    case '6':
	        $post_class = 'col-lg-2 col-md-3 col-sm-4 col-6';
	        break;
	}
	return $post_class;
}

/**
 * Tab Woocommerce
 */
function woo_remove_product_tabs( $tabs ) {
	// unset( $tabs['description'] );
    // unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_rename_tabs( $tabs ) {
	$tabs['description']['title'] 	= __( 'Information', 'shtheme' );
	$tabs['image']['title'] 		= __( 'Gallery', 'shtheme' );
	$tabs['video']['title'] 		= __( 'Video', 'shtheme' );
	$tabs['document']['title'] 		= __( 'Attachments', 'shtheme' );

	$tabs['image']['priority']		= 50;
	$tabs['video']['priority']		= 60;
	$tabs['document']['priority']	= 70;

	$tabs['image']['callback']		= 'content_tab_image';
	$tabs['video']['callback']		= 'content_tab_video';
	$tabs['document']['callback']	= 'content_tab_document';
	return $tabs;
}
// add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

/**
 * Customizer number product related
 */
function custom_numberpro_related_products_args( $args ) {
	global $sh_option;
	$args['posts_per_page'] = $sh_option['number-product-related']; // number related products
	// $args['columns'] 	= 2; // arranged in number columns
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'custom_numberpro_related_products_args' );

/**
 * Change text button add to cart in single product
 */
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Add to cart', 'shtheme' ); 
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );

/**
 * Add Button Quick Buy Simple Product In Single Product
 */
function insert_btn_quick_buy() {
	global $post, $product;
	if ( $product->is_type( 'simple' ) ) {
		echo '<a class="button buy_now ml-3" href="?quick_buy=1&add-to-cart='. $post->ID .'" class="qn_btn">'. __('Quick buy','shtheme') .'</a>';
	}
}
add_action( 'woocommerce_after_add_to_cart_button', 'insert_btn_quick_buy', 1 );

/**
 * Redirect To Checkout Page After Click Button Quick Buy
 */
function redirect_to_checkout( $checkout_url ) {
    global $woocommerce;
    if( ! empty( $_GET['quick_buy'] ) ) {
        $checkout_url = $woocommerce->cart->get_checkout_url();
    }
    return $checkout_url;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'redirect_to_checkout' );

/**
 * Modify price
 */
function invert_formatted_sale_price( $price, $regular_price, $sale_price ) {
	global $product;
	$price_html = '';
    $price_html .= '<ins>' . ( is_numeric( $sale_price ) ? wc_price( $sale_price ) : $sale_price ) . '</ins> <del>' . ( is_numeric( $regular_price ) ? wc_price( $regular_price ) : $regular_price ) . '</del>';
    if( is_product() && $product->is_on_sale() && $product->is_type('simple') ) {
    	$price_html .= '<span class="badge">' . __( 'Discount', 'shtheme' ) . ' ' . round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) . '%</span>';
    }
    return $price_html;
}
add_filter( 'woocommerce_format_sale_price', 'invert_formatted_sale_price', 10, 3 );

function uni_custom_contact_for_price() {
    return __( 'Contact', 'shtheme' );
}
add_filter( 'woocommerce_empty_price_html', 'uni_custom_contact_for_price' );

/**
 * Display Price For Variable Product Equal Price
 */
function display_equalprice_variable_pro( $available_variations, \WC_Product_Variable $variable, \WC_Product_Variation $variation ) {
    if ( empty( $available_variations['price_html'] ) ) {
        $available_variations['price_html'] = '<p class="price">' . $variation->get_price_html() . '</p>';
    }
    return $available_variations;
}
add_filter( 'woocommerce_available_variation', 'display_equalprice_variable_pro', 10, 3 );

/**
 * Title Product content-product.php
 */
function add_title_name_product() {
	echo '<h3 class="woocommerce-loop-product__title"><a 
	title="' . get_the_title() . '" 
	href=" '. get_the_permalink() .' ">' . get_the_title() . '</a></h3>';
}
add_action( 'woocommerce_shop_loop_item_title', 'add_title_name_product', 10 );

/**
 * Load JS CSS Files In Single Product  
 */
function load_script_single_product() {
	if ( is_product() ) {
		wp_enqueue_script( 'slick-js' );
        wp_enqueue_style( 'slick-style' );
        wp_enqueue_style( 'slick-theme-style' );
		wp_enqueue_script( 'fancybox-js' );
		wp_enqueue_style( 'fancybox-css' );
		wp_enqueue_script( 'zoom-js', UNI_DIR .'/lib/js/gallery-product/jquery.zoom.min.js', array('jquery'), '1.7.21', true );
		wp_register_script( 'gallery-front-js', UNI_DIR .'/lib/js/gallery-product/jquery.gallery.front.js',array('jquery'), '1.0', true );
		wp_enqueue_style( 'gallery-front-css', UNI_DIR .'/lib/css/gallery-product/gallery-front.css' );
		
		global $sh_option;
		$setting_array = array(
			'gallery_style'    		=> $sh_option['gallery-single-style'],
			'gallery_thumbnails'   	=> $sh_option['gallery-single-number-thumbnails'],
			'gallery_zoom'    		=> $sh_option['gallery-single-zoom'],
			'gallery_popup'   		=> $sh_option['gallery-single-lightbox'],
			'gallery_autoplay'		=> $sh_option['gallery-single-autoplay']
		);
		
		wp_localize_script( 'gallery-front-js', 'gallery_single_custom', $setting_array );
		
		// Enqueued script with localized data.
		wp_enqueue_script( 'gallery-front-js' );
	}
}
add_action( 'wp_enqueue_scripts', 'load_script_single_product' );

/**
 * Get first image of gallery product in content-product.php
 */
function woocommerce_swap_image_product() {
	global $product, $sh_option;
	if( $sh_option['woo-hover-flip-image'] == '1' ) {
		$attachment_ids = $product->get_gallery_image_ids();
		$attachment_ids = array_values( $attachment_ids );

		if( ! empty( $attachment_ids['0'] ) ) {
			$secondary_image_id 	= $attachment_ids['0'];
			$secondary_image_alt 	= get_post_meta( $secondary_image_id, '_wp_attachment_image_alt', true );
			$secondary_image_title 	= get_the_title( $secondary_image_id );

			echo wp_get_attachment_image(
				$secondary_image_id,
				'shop_catalog',
				'',
				array(
					'class' => 'secondary-image attachment-shop-catalog wp-post-image wp-post-image--secondary',
					'alt' 	=> $secondary_image_alt,
					'title' => $secondary_image_title,
				)
			);
		}
	}
}
add_action( 'woocommerce_shop_loop_item_image','woocommerce_swap_image_product' );

/**
 * Include JS CSS Files 
 */
function unitheme_lib_woocommerce_scripts() {

	// Main js
	wp_enqueue_script( 'main-woo-js', UNI_DIR . '/lib/js/main-woo.js', array(), '1.0', true );
	// wp_localize_script( 'main-woo-js', 'ajax', array( 'url' => admin_url('admin-ajax.php') ) );
	
	// Woocommerce Style
	wp_enqueue_style( 'woocommerce-style', UNI_DIR .'/lib/css/custom-woocommerce.css' );
	wp_enqueue_style( 'woocommerce-layout-style', UNI_DIR .'/lib/css/layout-woocommerce.css' );

}
add_action( 'wp_enqueue_scripts', 'unitheme_lib_woocommerce_scripts', 50 );

/**
 * Insert button share single product
 */
function insert_share_product() {
	?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57e482b2e67c850b"></script>
	<div class="addthis_inline_share_toolbox_4524"></div>
	<?php
}
add_action( 'woocommerce_share', 'insert_share_product' );

/**
 * Mini Cart
 *
 * @return string
 */
if( ! function_exists( 'sh_woocommerce_get__cart_menu_item__content' ) ) {
	function sh_woocommerce_get__cart_menu_item__content() {
	?>
	<div class="cart-block">
		<div class="navbar-actions">
			<div class="navbar-actions-shrink shopping-cart">
				<span class="shopping-cart-icon-container ffb-cart-menu-item">
					<span class="shopping-cart-icon-wrapper" title="<?php echo WC()->cart->get_cart_contents_count();?>">
						<img src="<?php echo get_stylesheet_directory_uri();?>/lib/images/icon-cart.png">
					</span>
				</span>
				<div class="shopping-cart-menu-wrapper">
					<div class="cart-heading">
						<h3 class="cart-title"><?=__('Cart','shtheme') ?></h3>
						<span class="close-side-cart"><?=__('Close','shtheme') ?></span>
					</div>
					<div class="cart-body">
						<?php wc_get_template( 'cart/mini-cart.php', array( 'list_class' => '' ) );?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	add_action( 'sh_after_menu', 'sh_woocommerce_get__cart_menu_item__content' );
}

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	
		<div class="navbar-actions">
			<div class="navbar-actions-shrink shopping-cart">
				<span class="shopping-cart-icon-container ffb-cart-menu-item">
					<span class="shopping-cart-icon-wrapper" title="<?php echo WC()->cart->get_cart_contents_count();?>">
						<img src="<?php echo get_stylesheet_directory_uri();?>/lib/images/icon-cart.png">
					</span>
				</span>
				<div class="shopping-cart-menu-wrapper">
					<div class="cart-heading">
						<h3 class="cart-title"><?=__('Cart','shtheme') ?></h3>
						<span class="close-side-cart"><?=__('Close','shtheme') ?></span>
					</div>
					<?php wc_get_template( 'cart/mini-cart.php', array( 'list_class' => '' ) );?>
				</div>
			</div>
		</div>
	<?php
	$fragments['.navbar-actions'] = ob_get_clean();
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

/**
 * Overlay Cart
 */
if ( class_exists( 'WooCommerce' ) ) { 
	function insert_overlay_cart() {
		echo '<div class="overlay-cart"></div>';
	}
}
add_action( 'after_footer', 'insert_overlay_cart', 1 );
/**
 * Button Detail In File content-product.php
 */
function insert_btn_detail(){
	?>
	<div class="text-center wrap-detail">
		<a href="<?php the_permalink( );?>" title="<?php _e( 'View detail', 'shtheme' );?>">
			<?php _e( 'View detail', 'shtheme' );?>
		</a>
	</div>
	<?php
}
// add_action( 'woocommerce_after_shop_loop_item', 'insert_btn_detail', 15 );

/**
 * Hook Woocommerce
 */
// File archive-product.php
// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
// remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// File content-product.php
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
// remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// File content-single-product.php

function wrap_before_button_cart(){
	echo '<div class="d-flex flex-wrap align-items-center wrap-btn-cart">';
	echo '<span class="mr-5">Chọn số lượng</span>';
}
add_action( 'woocommerce_before_add_to_cart_quantity', 'wrap_before_button_cart' );

function wrap_after_button_cart(){
	echo '</div>';
	echo '<div class="clearfix"></div>';
}
add_action( 'woocommerce_after_add_to_cart_quantity', 'wrap_after_button_cart' );