<?php
//add_action('admin_enqueue_scripts', 'my_admin_scripts2');
//add_action( 'admin_enqueue_scripts', 'my_admin_scripts2' );
// add_action( 'login_enqueue_scripts', 'my_admin_scripts2' );
// Thêm các script cần thiết cho bộ upload trong theme options
// function my_admin_scripts2() {
//         if ( ! did_action( 'wp_enqueue_media' ) ) {
//             wp_enqueue_media();
//         }  
//         wp_enqueue_script('my-admin-js2', get_stylesheet_directory_uri() .'/lib/js/upload.js', array('jquery'));
// }   

add_action('widgets_init', create_function('', "register_widget('GTID_Image_QC');"));

class GTID_Image_QC extends WP_Widget {

    function __construct() {
        parent::__construct(
            'images-ads',
            '3B - Ảnh quảng cáo',
            array( 'description'  =>  'Hiển thị một danh sách ảnh quảng cáo' )
        );
    }

    function widget($args, $instance) {
        extract($args);

        // defaults
        $instance = wp_parse_args( (array)$instance, array(
            'title' => '',
            'img_num' => 0,
        ) );

        echo $before_widget;

            if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
            ?>
                <div class="image-slider">
                        <?php for($i = 0; $i < $instance['img_num']; $i++) : ?>
                            <div class="images number-<?php echo $i; ?>">
                                <?php if ( !empty( $instance['img_src_'.$i] )) : ?>
                                    <div class="img">
                                        <a class="img" href="<?php echo $instance['img_link_'.$i]; ?>" rel="nofollow" target="_blank">
                                            <img src="<?php echo $instance['img_src_'.$i]; ?>" alt="Logo" />
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <?php if ( !empty( $instance['img_title_'.$i] )) : ?>
                                    <div class="title">
                                        <a href="<?php echo $instance['img_link_'.$i]; ?>" rel="nofollow" target="_blank">
                                            <?php echo $instance[ 'img_title_'.$i ]; ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                </div>

            <?php

        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {

        // ensure value exists
        $instance = wp_parse_args( (array)$instance, array(
            'title' => '',
            'link' => '',
            'img_num' => 0,
            'width'    => 200,
            'height'    => 200
        ) );

?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Tiêu đề', 'genesis'); ?>:</label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:99%;" /></p>

        <div style="overflow: hidden;"><label for="<?php echo $this->get_field_id('img_num'); ?>"><?php _e('Số lượng ảnh', 'genesis'); ?>:</label>
        <input type="text" id="<?php echo $this->get_field_id('img_num'); ?>" name="<?php echo $this->get_field_name('img_num'); ?>" value="<?php echo esc_attr( $instance['img_num'] ); ?>" size="2" />

            <p class="alignright">
                <img alt="" title="" class="ajax-feedback " src="<?php bloginfo('url'); ?>/wp-admin/images/wpspin_light.gif" style="visibility: hidden;" />
                <input type="submit" value="Lưu" class="button-primary widget-control-save" id="savewidget" name="savewidget" />
            </p>
        </div>

        <?php 
            for($i = 0; $i < $instance['img_num']; $i++) : 

        ?>
            <div class="form-image" style="background: #F5F5F5; margin-top: 10px; margin-bottom: 10px; padding: 3%; width: 94%; float: left;">
                <p><label for="<?php echo $this->get_field_id('img_src_'.$i); ?>"><?php _e('Đường dẫn ảnh trên thư viện ', shtheme); echo $i+1; ?>:</label>
                    <input name="<?php echo $this->get_field_name('img_src_'.$i); ?>" id="<?php echo $this->get_field_id('img_src_'.$i); ?>" class="upload upload_image_input widefat" type="text" value="<?php echo esc_attr( $instance['img_src_'.$i] ); ?>" />
                    <input onclick="load_ajax_button_image( jQuery(this) )" class="upload_image_button" type="button" value="Upload Image" />
                </p>

                <p><label for="<?php echo $this->get_field_id('img_title_'.$i); ?>"><?php _e('Tiêu đề ảnh ', shtheme); echo $i+1; ?>:</label>
                    <input type="text" id="<?php echo $this->get_field_id('img_title_'.$i); ?>" name="<?php echo $this->get_field_name('img_title_'.$i); ?>" value="<?php echo esc_attr( $instance['img_title_'.$i] ); ?>" class="widefat" />
                </p>

                <p><label for="<?php echo $this->get_field_id('img_link_'.$i); ?>"><?php _e('Link ảnh ', shtheme); echo $i+1; ?>:</label>
                    <input type="text" id="<?php echo $this->get_field_id('img_link_'.$i); ?>" name="<?php echo $this->get_field_name('img_link_'.$i); ?>" value="<?php echo esc_attr( $instance['img_link_'.$i] ); ?>" class="widefat" />
                </p>
            </div>
        <?php endfor; ?>

    <?php
    }

}