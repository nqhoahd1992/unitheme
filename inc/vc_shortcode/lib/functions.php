<?php
/**
* Define input field type number
*/
if ( function_exists('vc_add_shortcode_param') ){
    vc_add_shortcode_param( 'uni_vc_slider_type_field', 'uni_vc_slider_type_field' );
}
if ( ! function_exists( 'uni_vc_slider_type_field' ) ) {
    function uni_vc_slider_type_field( $settings, $value ) {
        $output = '<input type="number" min="0" max="5" class="wpb_vc_param_value ' . $settings['param_name'] . '" name="' . $settings['param_name'] . '" value="'.$value.'" style="height:auto;" />';
        return $output;
    }
}

function uni_vc_woo_order_by() {
    return array(
        '',
        esc_html__( 'Date', 'shtheme' ) => 'date',
        esc_html__( 'ID', 'shtheme' ) => 'ID',
        esc_html__( 'Author', 'shtheme' ) => 'author',
        esc_html__( 'Title', 'shtheme' ) => 'title',
        esc_html__( 'Modified', 'shtheme' ) => 'modified',
        esc_html__( 'Random', 'shtheme' ) => 'rand',
        esc_html__( 'Comment count', 'shtheme' ) => 'comment_count',
        esc_html__( 'Menu order', 'shtheme' ) => 'menu_order',
    );
}

function uni_vc_woo_order_way() {
    return array(
        '',
        esc_html__( 'Descending', 'shtheme' ) => 'DESC',
        esc_html__( 'Ascending', 'shtheme' ) => 'ASC',
    );
}

function uni_shortcode_template( $name = false ) {
    if (!$name)
        return false;

    if ( $overridden_template = locate_template( 'vc_templates' . $name . '.php' ) ) {
        return $overridden_template;
    } else {
        // If neither the child nor parent theme have overridden the template,
        // we load the template from the 'templates' sub-directory of the directory this file is in
        return UNI_SHORTCODES_TEMPLATES . $name . '.php';
    }
}

function uni_shortcode_woo_template( $name = false ) {
    if (!$name)
        return false;
    
    if ( $overridden_template = locate_template( 'vc_templates' . $name . '.php' ) ) {
        return $overridden_template;
    } else {
        // If neither the child nor parent theme have overridden the template,
        // we load the template from the 'templates' sub-directory of the directory this file is in
        return UNI_SHORTCODES_WOO_TEMPLATES . $name . '.php';
    }
}

function uni_shortcode_extract_class( $el_class ) {
    $output = '';
    if ( $el_class != '' ) {
        $output = " " . str_replace( ".", "", $el_class );
    }

    return $output;
}

function uni_vc_custom_class() {
    return array(
        'type' => 'textfield',
        'heading' => esc_html__( 'Extra class name', 'shtheme' ),
        'param_name' => 'el_class',
        'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'shtheme' )
    );
}

function uni_shortcode_end_block_comment( $string ) {
    return WP_DEBUG ? '<!-- END ' . $string . ' -->' : '';
}

function uni_get_terms( $taxonomy ) {
    $block_options      = array();
    $block_options[0]   = esc_html__('Choose a category', 'shtheme');
    $terms = get_terms( array(
        'taxonomy'      => $taxonomy,
        'hide_empty'    => false,
    ) );
    foreach( $terms as $value ){
        $block_options[$value->name] = $value->term_id;
    }
    return $block_options;
}

function uni_link_init( $url, $target, $link_title, $rel ) {
    $uni_link_attr = '';
    if($url !== '')
        $uni_link_attr = 'href="'.$url.'" ';
    if($link_title !== '')
        $uni_link_attr .= 'title="'.$link_title.'" ';
    if($target !== '')
        $uni_link_attr .= 'target="'.$target.'" ';
    if($rel !== ''){
        if($target !== '' && $target === '_blank'){
            $uni_link_attr .= 'rel="'.$rel.' noopener" ';
        }
        else {
            $uni_link_attr .= 'rel="'.$rel.'" ';
        }
    }
    else {
        if($target !== '' && $target === '_blank'){
            $uni_link_attr .= 'rel="noopener" ';
        }
    }

    return $uni_link_attr;
}