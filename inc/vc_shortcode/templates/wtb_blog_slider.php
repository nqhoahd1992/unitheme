<?php
$css_class = '';
extract(shortcode_atts(array(
    // 'style'             => '1',
    'posts_per_page'        => '10',
    'items_desktop_large'   => '3',
    'items_desktop'         => '2',
    'items_tablets'         => '2',
    'items_mobile'          => '1',
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
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), 'wtb_blog_slider', $atts );
    $el_class = esc_html( wtb_shortcode_extract_class( $el_class ) );

    wp_enqueue_script( 'slick-js' );
    wp_enqueue_style( 'slick-style' );
    wp_enqueue_style( 'slick-theme-style' );

    echo '<div class="wtb_blog_slider_container wpb_content_element '. $css_class .'">';
        echo '<div class="sh-blog-slider-shortcode '. $el_class .'">';

            echo '<div class="slick-carousel blog-slider" data-item="'. $items_desktop_large .'" data-item_md="'. $items_desktop .'" data-item_sm="'. $items_tablets .'" data-item_mb="'. $items_mobile .'" data-row="1" data-dots="'. $data_dots .'" data-arrows="'. $data_arrows .'" data-vertical="false">';
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
                );
                $the_query = new WP_Query( $args );
                // The Loop
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) { $the_query->the_post();
                        echo '<div class="blog-slider__item">';
                            echo '<div class="blog-slider__item__inner">';
                                echo '<div class="entry-thumb">';
                                    echo '<a class="d-block" href="'. get_the_permalink() .'" title="'. get_the_title() .'">';
                                        echo '<div class="blog-slider__item__hover"><i class="fas fa-link"></i></div>';
                                        if( has_post_thumbnail() ) : 
                                            echo '<img data-lazy="'. get_the_post_thumbnail_url( get_the_ID(), $image_size ) .'"/>';
                                        endif;
                                    echo '</a>';
                                echo '</div>';
                                echo '<div class="entry-content">';
                                    echo '<h3 class="entry-title"><a href="'. get_the_permalink() .'" title="'. get_the_title() .'">'. get_the_title() .'</a></h3>';
                                    // Metadata
                                    if ( $hide_meta == '1' ) {
                                        echo '<div class="entry-meta">';
                                            echo '<span class="date-time"><i class="fas fa-calendar-alt"></i> '. get_the_time('d/m/Y G:i') .'</span>';
                                        echo '</div>';
                                    }
                                    // Check display description
                                    if ( $hide_desc == '1' ) {
                                        echo '<div class="entry-description">'. get_the_content_limit( $number_character,' ' ) .'</div>';
                                    }
                                    // Check display view more button
                                    if ( $btn_viewmore == '1' ) {
                                        echo '<div class="text-left"><a class="view-detail" href="'. get_permalink() .'" title="'. get_the_title() .'">'. $viewmore_text .' <i class="fas fa-angle-double-right"></i></a></div>';
                                    }
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                    wp_reset_postdata();
                }
            echo '</div>';

        echo '</div>';
    echo '</div>';

}