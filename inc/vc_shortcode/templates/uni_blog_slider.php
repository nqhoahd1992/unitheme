<?php
$html = $css_class = '';
extract(shortcode_atts(array(
    // 'style'             => '1',
    'posts_per_page'        => '10',
    'item'                  => '3',
    'item_lg'               => '2',
    'item_md'               => '2',
    'item_sm'               => '1',
    'item_mb'               => '1',
    'number_row'            => '1',
    'image_size'            => 'thumbnail',
    'hide_meta'             => '0',
    'hide_desc'             => '0',
    'number_character'      => '80',
    'viewmore_text'         => __( 'Read more', 'shtheme' ),
    'btn_viewmore'          => '0',
    'order'                 => 'desc',
    'orderby'               => 'date',
    'categories'            => '',
    'data_dots'             => 'true',
    'data_arrows'           => 'false',
    'el_class'              => '',
    'css'                   => '',
), $atts));

$args = array(
    'post_type' => 'post',
    'tax_query' => array(
        array(
            'taxonomy'  => 'category',
            'field'     => 'id',
            'terms'     => $categories
        )
    ),
    'posts_per_page'    => $posts_per_page,
    'orderby'           => $orderby,
    'order'             => $order,
);

$the_query = new WP_Query( $args );
// The Loop
if ( $the_query->have_posts() ) {
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'uni_blog_slider', $atts );
    $el_class = esc_html( uni_shortcode_extract_class( $el_class ) );

    wp_enqueue_script( 'slick-js' );
    wp_enqueue_style( 'slick-style' );
    wp_enqueue_style( 'slick-theme-style' );

    $new_post = new uni_blog_slide_shortcode();
    $html .= '<div class="uni_blog_slider_container wpb_content_element '. $css_class .'">';
        $html .= '<div class="sh-blog-slider-shortcode '. $el_class .'">';

            $html .= '<div class="slick-carousel blog-slider" data-item="'. $item .'" data-item_lg="'. $item_lg .'" data-item_md="'. $item_md .'" data-item_sm="'. $item_sm .'" data-item_mb="'. $item_mb .'" data-row="'. $number_row .'" data-dots="'. $data_dots .'" data-arrows="'. $data_arrows .'" data-vertical="false">';
                
                while ( $the_query->have_posts() ) { $the_query->the_post();

                    $html .= $new_post->sh_general_post_html( $the_query, $atts );

                }
                wp_reset_postdata();

            $html .= '</div>';

        $html .= '</div>';
    $html .= '</div>';
}

echo $html;
