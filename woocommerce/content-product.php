<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

global $post, $sh_option;

// Dev Feature Tooltip
if( $sh_option['woocommerce-tooltip'] == '1' ) {
	$string_tooltip = 'data-tooltip="stickyzoom" data-img-full="'. wp_get_attachment_url(get_post_thumbnail_id( $post->ID,'full' )) .'" ';
} else {
	$string_tooltip = '';
}

// Post Class
if( is_home() || $sh_option['layout-category-product'] == '1' ) {
	$numcol 				= $sh_option['number_product_row'];
	$post_class_homepage 	= get_column_product($numcol);
	$post_class 			= $post_class_homepage;
} elseif ( ! is_home() && $sh_option['layout-category-product'] == '0' ) {
	$numcol   				= $sh_option['number-column-product-cate'];
	$post_class_archive 	= get_column_product($numcol);
	$post_class 			= $post_class_archive;
}
?>
<li <?php post_class($post_class); ?>>
	<div class="wrap-product">
		<?php
		/**
		 * woocommerce_before_shop_loop_item hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		// do_action( 'woocommerce_before_shop_loop_item' );

		/**
		 * woocommerce_before_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		// do_action( 'woocommerce_before_shop_loop_item_title' );

		echo '<div class="image-product">';
			echo '<a class="img hover-zoom" '. $string_tooltip .' href="'. get_permalink( ) .'" title="'. get_the_title( ) .'">';
				echo woocommerce_get_product_thumbnail( );
			echo '</a>';
		echo '</div>';

		/**
		 * woocommerce_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );

		/**
		 * woocommerce_after_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_rating - 5
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );

		/**
		 * woocommerce_after_shop_loop_item hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_close - 5
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );
		?>
	</div>
</li>
