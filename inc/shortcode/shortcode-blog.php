<?php
/**
 * Shortcode news
 *
 * @link 
 *
 * @package SH_Theme
 */

class sh_blog_shortcode {

	public static $args;

	public function __construct() {

		add_shortcode( 'shblog', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $atts, $content = '') {
		$html = '';

		global $sh_option;
		$layout = $sh_option['opt-number-column'];

		extract( shortcode_atts( array(
			'posts_per_page'				=> '5',
			'categories'					=> '',
			'custom_text'					=> 'Xem Thêm',
			'hide_category'					=> '1',
			'hide_viewmore'					=> '1',
			'hide_meta'						=> '1',
			'hide_thumb'					=> '1',
			'hide_desc'						=> '1'
		), $atts ) );

		$args = array(
			'post_type' => 'post',
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'category',
					'field'     => 'id',
					'terms' 	=> $categories
				)
			),
			'posts_per_page'	=> $posts_per_page,
		);

		$the_query = new WP_Query( $args );

		// The Loop

		if ( $the_query->have_posts() ) {

			$html .= '<div class="sh-blog-shortcode column-'. $layout .'"><div class="row">';

			while ( $the_query->have_posts() ) {

				$the_query->the_post();

				$html .= $this->rt_general_post_html( $the_query, $atts );

			}
			wp_reset_postdata();

			$html .= '</div></div>';

		}

		return $html;
		
	}

	/**
	 *
	 * General post html
	 *
	 * @param  $post_class: class of post
	 * @return $html: html of post
	 *
	 */
	function rt_general_post_html ( $post_class = array(), $atts = array(), $image_size = 'sh_thumb190x120' ) {
		extract( shortcode_atts( array(
			'posts_per_page'				=> '5',
			'categories'					=> '',
			'custom_text'					=> 'Xem Thêm',
			'hide_category'					=> '0',
			'hide_viewmore'					=> '0',
			'hide_meta'						=> '0',
			'hide_thumb'					=> '1',
			'hide_desc'						=> '1'
		), $atts ) );
		
		global $sh_option;
		$layout = $sh_option['opt-number-column'];
		switch ($layout) {
		    case '1':
		        $post_class = 'col-md-12';
		        break;
		    case '2':
		        $post_class = 'col-md-6';
		        break;
		    case '3':
		        $post_class = 'col-md-4 col-sm-6';
		        break;
		    case '4':
		        $post_class = 'col-md-3';
		        break;
	        case '5':
		        $post_class = 'col-md-five';
		        break;
		    case '6':
		        $post_class = 'col-md-2';
		        break;
		}

		$html = '';
		$html .= '<article id="post-'. get_the_ID() .'" class="'. implode( ' ', get_post_class( $post_class ) ) .'"><div class="post-inner">';
		// Check display thumb of post
		if ( $hide_thumb == '1' && has_post_thumbnail() ) :
			$html .= '<div class="entry-thumb">';
				$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a>';
			$html .= '</div>';
		endif;
		$html .= '<div class="entry-content">';
			// Check display category
			if ( $hide_category == '1' ) {
				$categories = wp_get_post_categories( get_the_ID() );
				if ( count( $categories ) > 0 ) {
					$html .= '<div class="entry-cat">';
					foreach ( $categories as $key => $cat_id ) {
						$category = get_category( $cat_id );
						if ( $key == ( count( $categories ) - 1 ) ) {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>';	
						} else {
							$html .= '<a href="'. get_term_link( $category ) .'" title="'. $category->name .'">'. $category->name .'</a>, ';
						}
					}
					$html .= '</div>';
				}
			}
			$html .= '<h3 class="entry-title"><a href="'. get_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
			// Metadata
			if ( $hide_meta == '1' ) {
				$html .= '<div class="meta">';
					$html .= '<span class="date-time"><i class="fa fa-clock-o" aria-hidden="true"></i>'. get_the_time('d/m/Y') .'</span>';
					$comments_count = wp_count_comments( get_the_ID() );
					$html .= '<span class="number-comment"><i class="fa fa-commenting-o" aria-hidden="true"></i>'. $comments_count->approved . ' ' . __( 'Comments', 'shtheme' ) . '</span>';
				$html .= '</div>';
			}
			// Check display description
			if ( $hide_desc == '1' ) {
				$html .= '<div class="entry-description">'. get_the_content_limit('100',' ') .'</div>';
			}
			// Check display view more button
			if ( $hide_viewmore == '1' ) {
				$html .= '<a href="'. get_permalink() .'" title="'. get_the_title() .'" class="view-more">'. __( 'Xem thêm', 'shtheme' ) .' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>';
			}
		$html .= '</div>';
		$html .= '</div></article>';
		return $html;
	}

}
new sh_blog_shortcode();