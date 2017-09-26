<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

global $sh_option;
// Category
if( ! empty( $sh_option['opt-multi-select-category'] ) ) {
	$list_cat = $sh_option['opt-multi-select-category'];
}
if( ! empty( $sh_option['opt-number-new'] ) ) {
	$numpost = $sh_option['opt-number-new'];
}
// Product
if ( class_exists( 'WooCommerce' ) ) {
	if( ! empty( $sh_option['opt-multi-select-product-cat'] ) ) {
		$list_pro = $sh_option['opt-multi-select-product-cat'];
	}
	if( ! empty( $sh_option['opt-number-product'] ) ) {
		$numpro = $sh_option['opt-number-product'];
	}
	if( ! empty( $sh_option['opt-number-product-column'] ) ) {
		$numcolpro = $sh_option['opt-number-product-column'];
	}
}

get_header(); ?>
	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">

			<?php
			if( !empty( $list_pro ) ) {
				echo '<div class="product-wrap">';
					foreach ($list_pro as $key => $idpost) {
						echo '<h2 class="heading"><a href="'. get_productcat_link( $idpost ) .'">'. get_productcat_name( $idpost ) .'</a></h2>';
						echo do_shortcode('[shproduct posts_per_page="' . $numpro . '" categories="' . $idpost . '" numcol="' . $numcolpro . '"]');
					}
				echo '</div>';
			}
			?>

			<?php
			if( !empty( $list_cat ) ) {
				echo '<div class="news-wrap">';
					foreach ($list_cat as $key => $idpost) {
						echo '<h2 class="heading"><a href="'. get_category_link( $idpost ) .'">'. get_cat_name( $idpost ) .'</a></h2>';
						echo do_shortcode('[shblog posts_per_page="' . $numpost . '" categories="' . $idpost . '" custom_text="Xem Thêm"]');
					}
				echo '</div>';
			}
			?>

		</main><!-- #main -->

		<?php do_action( 'sh_after_content' );?>

	</div><!-- #primary -->
	
<?php
get_footer();