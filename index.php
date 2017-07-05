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
$list_cat = $sh_option['opt-multi-select-category'];
$numpost  = $sh_option['opt-number-new'];
get_header(); ?>
	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">

			<?php
			if( $list_cat ) {
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
