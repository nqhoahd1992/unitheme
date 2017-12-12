<?php
/**
 * Breadcrumbs
 *
 *
 * @package SH_Theme
 * @author  Quang Hoa
 * @license 
 * @link    
 */

/**
 * @since
 *
 * @param 
 * @param
 * @return 
 */

function sh_create_breadcrumb(){
    global $sh_option;
    if( $sh_option['display-pagetitlebar'] == '1' && ! is_front_page() ) {
        echo '<div class="flex page-title-bar">';
            echo '<div class="container">';
                echo '<div class="title-bar-wrap">';
                    if( is_page( ) || is_single( ) ) {
                        echo '<h1 class="title">'. get_the_title( ) .'</h1>';
                    } elseif( is_archive() ) {
                        ?><h1 class="title"><?php single_term_title(); ?></h1><?php
                    } elseif( is_search() ) {
                        echo '<h1 class="title">Tìm kiếm cho từ khóa: '. get_search_query() .'</h1>';
                    } elseif( is_404() ) {
                        echo '<h1 class="title">404 - Trang không tồn tại</h1>';
                    }
                    if ( class_exists( 'WooCommerce' ) ) {
                        if( is_shop() ) {
                            echo '<h1 class="title">Sản phẩm</h1>';
                        }
                    }
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb('<div class="breadcrumb">','</div>');
                    }
                echo '</div>';
            echo '</div>';
        echo '</div>';
    } elseif ( ! is_front_page() ) {
        echo '<div class="container">';
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb('<div class="breadcrumb">','</div>');
        }
        echo '</div>';
    }
}
add_action( 'sh_before_main_content','sh_create_breadcrumb' );