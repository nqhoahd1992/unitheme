<?php

add_shortcode('uni_product_slider', 'uni_shortcode_product_slider');
add_action('vc_build_admin_page', 'uni_load_product_slider_shortcode');
add_action('vc_after_init', 'uni_load_product_slider_shortcode');

function uni_shortcode_product_slider($atts, $content = null) {
    ob_start();
    if ($template = uni_shortcode_woo_template('uni_product_slider'))
        include $template;
    return ob_get_clean();
}

function uni_load_product_slider_shortcode() {
    $custom_class       = uni_vc_custom_class();
    $order_by_values    = uni_vc_woo_order_by();
    $order_way_values   = uni_vc_woo_order_way();
    $block_options      = uni_get_terms('product_cat');

    vc_map( array(
        'name'          => esc_html__('Product Slider', 'shtheme'),
        'base'          => 'uni_product_slider',
        'description'   => esc_html__('Show products slider in a category', 'shtheme'),
        'category'      => esc_html__('Advanced Element', 'shtheme'),
        'icon'          => get_template_directory_uri() . "/inc/vc_shortcode/assets/images/logo.svg",
        'weight'        => - 50,
        'params'        => array(
            array(
                'type'          => 'uni_vc_slider_type_field',
                'heading'       => esc_html__('Posts Count', 'shtheme'),
                'param_name'    => 'posts_per_page',
                'value'         => '10',
                'admin_label'   => true
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Number Column on Desktop Large (> 1200px)", 'shtheme'),
                "param_name" => "items_desktop_large",
                'std' => 3,
                'value' => array(
                    esc_html__('4', 'shtheme') => 4,
                    esc_html__('3', 'shtheme') => 3,
                    esc_html__('2', 'shtheme') => 2,
                    esc_html__('1', 'shtheme') => 1,
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Number Column on Desktop", 'shtheme'),
                "param_name" => "items_desktop",
                'std' => 2,
                'value' => array(
                    esc_html__('4', 'shtheme') => 4,
                    esc_html__('3', 'shtheme') => 3,
                    esc_html__('2', 'shtheme') => 2,
                    esc_html__('1', 'shtheme') => 1,
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Number Column on Tablets", "shtheme"),
                "param_name" => "items_tablets",
                'std' => 2,
                'value' => array(
                    esc_html__('4', 'shtheme') => 4,
                    esc_html__('3', 'shtheme') => 3,
                    esc_html__('2', 'shtheme') => 2,
                    esc_html__('1', 'shtheme') => 1,
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Number Column on Mobile", "shtheme"),
                "param_name" => "items_mobile",
                'std' => 1,
                'value' => array(
                    esc_html__('4', 'shtheme') => 4,
                    esc_html__('3', 'shtheme') => 3,
                    esc_html__('2', 'shtheme') => 2,
                    esc_html__('1', 'shtheme') => 1,
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Number row", "shtheme"),
                "param_name" => "number_row",
                'std' => 1,
                'value' => array(
                    esc_html__('4', 'shtheme') => 4,
                    esc_html__('3', 'shtheme') => 3,
                    esc_html__('2', 'shtheme') => 2,
                    esc_html__('1', 'shtheme') => 1,
                ),
            ),
            
            $custom_class,
            // post type
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Order by', 'shtheme' ),
                'param_name'    => 'orderby',
                'value'         => $order_by_values,
                'description'   => sprintf( esc_html__( 'Select how to sort retrieved products_category. More at %s.', 'shtheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                'group'         => 'Data'
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__( 'Order way', 'shtheme' ),
                'param_name'    => 'order',
                'value'         => $order_way_values,
                'description'   => sprintf( esc_html__( 'Designates the ascending or descending order. More at %s.', 'shtheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
                'group'         => 'Data'
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Choose a category', 'shtheme'),
                'param_name'    => 'categories',
                'value'         =>  $block_options,
                'admin_label'   => true,
                'group'         => 'Data'
            ),

            array(
                'type'          => 'dropdown',
                'heading'       => __('Dots Navigation', 'shtheme'),
                'param_name'    => 'data_dots',
                'std'           => 'true',
                'value'         => array(
                    esc_html__('Yes', 'shtheme')    => 'true',
                    esc_html__('No', 'shtheme')     => 'false',
                ),
                'group'         => 'Navigation',
            ),
            array(
                'type'          => 'dropdown',
                'heading'       => __('Arrows Navigation', 'shtheme'),
                'param_name'    => 'data_arrows',
                'std'           => 'false',
                'value'         => array(
                    esc_html__('Yes', 'shtheme')    => 'true',
                    esc_html__('No', 'shtheme')     => 'false',
                ),
                'group'         => 'Navigation',
            ),

            array(
                'type'          => 'css_editor',
                'heading'       => esc_html__( 'CSS box', 'shtheme' ),
                'param_name'    => 'css',
                'group'         => esc_html__( 'Design Options', 'shtheme' ),
            ),
        )
    ) );
}