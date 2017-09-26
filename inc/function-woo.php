<?php

/**
 * Setup layout page woocommerce
 */
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function my_theme_wrapper_start() {
	echo '<div class="content-sidebar-wrap">';
	echo '<div id="main" class="site-main" role="main">';
}

function my_theme_wrapper_end() {
	echo '</div>';
	do_action( 'sh_after_content' );
	echo '</div>';
}

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

/**
 * Enable Gallery
 */
add_theme_support( 'wc-product-gallery-zoom' );
// add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

function get_productcat_name( $cat_id ) {
	$cat_id = (int) $cat_id;
	$category = get_term( $cat_id, 'product_cat' );
	if ( ! $category || is_wp_error( $category ) )
	return '';
	return $category->name;
}

function get_productcat_link( $category ) {
	if ( ! is_object( $category ) )
	$category = (int) $category;
	$category = get_term_link( $category, 'product_cat' );
	if ( is_wp_error( $category ) )
	return '';
	return $category;
}

remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10 );

remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10 );

function woocommerce_category_image($products) {
    $thumbnail_id = get_woocommerce_term_meta( $products, 'thumbnail_id', true );
    $arr = wp_get_attachment_image_src( $thumbnail_id, 'sh_thumb124x124' );
    $image = $arr[0];
    if ( $image ) {
	    echo '<img src="' . $image . '" alt="" />';
	}
}

/**
 * Add percent sale in content product template
 */
function add_percent_sale(){
	global $product;
	if ($product->is_on_sale()){
		$per = round((( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
		echo "<span class='percent'>-$per%</span>";
	}
}
add_action( 'woocommerce_after_shop_loop_item','add_percent_sale',15 );

function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
    return $tabs;
}
// add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_rename_tabs( $tabs ) {
	$tabs['description']['title'] 	= __( 'Thông số kỹ thuật' );        // Rename the reviews tab
	$tabs['image']['title'] 		= __( 'Hình ảnh' );
	$tabs['video']['title'] 		= __( 'Video' );
	$tabs['document']['title'] 		= __( 'Tài liệu đính kèm' );

	$tabs['image']['priority']		= 50;
	$tabs['video']['priority']		= 60;
	$tabs['document']['priority']	= 70;

	$tabs['image']['callback']		= 'content_tab_image';
	$tabs['video']['callback']		= 'content_tab_video';
	$tabs['document']['callback']	= 'content_tab_document';
	return $tabs;
}
// add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );

function custom_numberpro_related_products_args( $args ) {
	global $sh_option;
	$numpro_related = $sh_option['number-column-product-related'];
	$args['posts_per_page'] = $numpro_related; // number related products
	// $args['columns'] 	= 2; // arranged in number columns
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'custom_numberpro_related_products_args' );


function custom_price_html( $price, $product ){
    return 'Giá: ' . str_replace( '<ins>', ' Giá khuyến mại: <ins>', $price );
}
add_filter( 'woocommerce_get_price_html', 'custom_price_html', 100, 2 );

function get_price_product(){
	global $product;
	$regular_price 	= $product->regular_price;
	$sale_price 	= $product->sale_price;
	if( empty( $regular_price ) ) {
		echo '<p class="price">Liên hệ</p>';
	} elseif ( ! empty( $regular_price ) && empty( $sale_price ) ) {
		echo '<p class="price">'. number_format( $regular_price, 0, '', '.' ) . ' đ</p>';
	} elseif ( ! empty( $regular_price ) && ! empty( $sale_price ) ) {
		echo '<p class="price"><ins>'. number_format( $regular_price, 0, '', '.' ) .' đ</ins><del>'. number_format( $sale_price,0,'','.' ) .' đ</del></p>';
	}
}
add_action( 'woocommerce_after_shop_loop_item','get_price_product',10 );

function add_title_name_product(){
	echo '<h3 class="woocommerce-loop-product__title"><a title="' . get_the_title() . '" href=" '. get_the_permalink() .' ">' . get_the_title() . '</a></h3>';
}
add_action( 'woocommerce_shop_loop_item_title','add_title_name_product',10 );

// archive-product.php
remove_action( 'woocommerce_before_shop_loop','woocommerce_result_count',20 );
remove_action( 'woocommerce_before_shop_loop','woocommerce_catalog_ordering',30 );
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar',10 );

// content-product.php
remove_action( 'woocommerce_after_shop_loop_item','woocommerce_template_loop_add_to_cart',10 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating',5 );
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10 );
remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title',10 );

// content-single-product.php
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta',40 );