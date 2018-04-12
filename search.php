<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package SH_Theme
 */

get_header(); ?>

	<div id="primary" class="content-sidebar-wrap">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

				<h1 class="page-title"><?php printf( esc_html__( 'Search for keyword: %s', 'shtheme' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

			<?php
			/* Start the Loop */
			echo '<div class="new-list">';

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/loop/loop-news' );

			endwhile;

			echo '</div>';

			shtheme_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->

		<?php do_action( 'sh_after_content' );?>
		
	</div><!-- #primary -->

<?php
get_footer();
