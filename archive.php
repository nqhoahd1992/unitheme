<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

get_header(); ?>

	<div id="primary" class="content-sidebar-wrap">

		<?php do_action( 'before_main_content' ) ?>
		
		<main id="main" class="site-main" role="main">

			<?php do_action( 'before_loop_main_content' ) ?>

			<?php
			if ( have_posts() ) : 

				// Title 
				if( $sh_option['display-pagetitlebar'] != '1' ) {
					echo '<h1 class="page-title">';
					single_term_title();
					echo '</h1>';
				}
				the_archive_description( '<div class="archive-description">', '</div>' );
				
				if( $sh_option['display-hierarchy'] == '1' ) {

					// Content
					$archive_object = get_queried_object();
					$archive_id 	= $archive_object->term_id;
					$args = array(
						'parent'     	=> $archive_id,
						'hide_empty'  	=> 0,
						'taxonomy'    	=> $archive_object->taxonomy,
					);
					$categories = get_categories( $args );
					if( $categories ) {
						/* Start the Loop */
						foreach ( $categories as $value ) {
							echo '<div class="list-categories">';
						    	echo '<a class="item-category" href="' . get_term_link( $value->term_id, $archive_object->taxonomy ) . '">' . $value->name . '</a>';
						    	$args = array(
			                        'post_type' => 'post',
			                        'tax_query' => array(
			                            array(
			                                'taxonomy' 	=> $archive_object->taxonomy,
			                                'field' 	=> 'id',
			                                'terms' 	=> $value->term_id,
			                            )
			                        ),
			                        'paged'		=> get_query_var('paged'),
		                        );
		                        /* Start the Loop */
								echo '<div class="new-list">';
									$the_query = new WP_Query( $args );
									while($the_query -> have_posts()) : $the_query -> the_post();
										get_template_part( 'template-parts/loop/loop-news' );
									endwhile;
								echo '</div>';
								shtheme_pagination();
								wp_reset_postdata();
						    echo '</div>';
						}
					} else {
						/* Start the Loop */
						echo '<div class="new-list">';
							while ( have_posts() ) : the_post();
								get_template_part( 'template-parts/loop/loop-news' );
							endwhile;
						echo '</div>';
						shtheme_pagination();
						wp_reset_postdata();
					}

				} else {

					/* Start the Loop */
					echo '<div class="new-list">';
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/loop/loop-news' );
						endwhile;
					echo '</div>';
					shtheme_pagination();
					wp_reset_postdata();

				}
				
				
			else :

				_e('The content is being updated','shtheme');
				
			endif; ?>

		</main><!-- #main -->

		<?php do_action( 'sh_after_content' );?>

	</div><!-- #primary -->

<?php
get_footer();
