<?php
add_shortcode('uni_static_block', 'uni_shortcode_static_block');
add_action('vc_build_admin_page', 'uni_load_static_block_shortcode');
add_action('vc_after_init', 'uni_load_static_block_shortcode');
function uni_shortcode_static_block($atts, $content = null) {
    ob_start();
    if ($template = uni_shortcode_template('uni_static_block'))
        include $template;
    return ob_get_clean();
}

function uni_load_static_block_shortcode() {
    $custom_class       = uni_vc_custom_class();
    $block_options      = array();
    $block_options[0]   = esc_html__('Choose a block to display', 'shtheme');
    $args = array(
        'posts_per_page'    => -1,
        'post_type'         => 'block',
        'post_status'       => 'publish',
    );
    $posts = get_posts($args);
    foreach( $posts as $_post ){
        $block_options[$_post->post_title] = $_post->ID;
    }
    vc_map( array(
        'name'          => esc_html__('Static Block', 'shtheme'),
        'base'          => 'uni_static_block',
        'description'   => esc_html__('Show static block', 'shtheme'),
        'category'      => esc_html__('Advanced Element', 'shtheme'),
        'icon'          => get_template_directory_uri() . "/inc/vc_shortcode/assets/images/logo.svg",
        'weight'        => - 50,
        'params'        => array(
            array(
                'type'          => 'dropdown',
                'heading'       => esc_html__('Static Block', 'shtheme'),
                'param_name'    => 'static',
                'value'         =>  $block_options,
                'admin_label'   => true
            ),
            $custom_class,
        )
    ));

}


