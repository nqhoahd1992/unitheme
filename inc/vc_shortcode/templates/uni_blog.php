<?php
$html = $css_class = '';
extract(shortcode_atts(array(
    'style'             => '3',
    'posts_per_page'    => '3',
    'orderby'           => 'date',
    'order'             => 'desc',
    'categories'        => '',
    'el_class'          => '',
    'css'               => '',
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
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'uni_blog', $atts );
    $el_class = esc_html( uni_shortcode_extract_class( $el_class ) );

    $new_post = new uni_blog_shortcode();
    $html .= '<div class="uni_blog_container wpb_content_element '. $css_class .'">';
        $html .= '<div class="sh-blog-shortcode style-'. $style .' '. $el_class .'">';

            switch ( $style ) {
                case '1':
                    $html .= $new_post->sh_blog_style_1( $the_query, $atts );
                    break;
                case '2':
                    $html .= $new_post->sh_blog_style_2( $the_query, $atts );
                    break;
                case '3':
                    $html .= $new_post->sh_blog_style_3( $the_query, $atts );
                    break;
                case '4':
                    $html .= $new_post->sh_blog_style_4( $the_query, $atts );
                    break;
                case '5':
                    $html .= $new_post->sh_blog_style_5( $the_query, $atts );
                    break;
                case '6':
                    $html .= $new_post->sh_blog_style_6( $the_query, $atts );
                    break;
                case '7':
                    $html .= $new_post->sh_blog_style_7( $the_query, $atts );
                    break;
                case '8':
                    $html .= $new_post->sh_blog_style_8( $the_query, $atts );
                    break;
                default:
                    $html .= $new_post->sh_general_post_html( $the_query, $atts );
                    break;
            }

        $html .= '</div>';
    $html .= '</div>';
}

echo $html;
