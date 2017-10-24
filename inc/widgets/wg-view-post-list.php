<?php
add_action('widgets_init', 'register_widget_top_view');

function register_widget_top_view() {
    register_widget('Gtid_Post_Top_View_Widget');
}

class Gtid_Post_Top_View_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'list_view_posts',
            '3B - Danh sách bài viết xem nhiều',
            array( 'description'  =>  'Hiển thị một danh sách bài viết theo lượt xem' )
        );
        
    }

    function widget($args, $instance) {
        extract($args);
        $instance = wp_parse_args( (array)$instance, array(  'title' => '', 'numpro' => '', 'image_alignment' => '', 'image_size' => '', 'postdate' => '', 'show_content' => 'content-limit','content_limit' => '', ) );
        echo $before_widget;

        if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        ?>
        <ul class="list-post-item">
            <?php
            function filter_where( $where = '' ) {
                global $postdate;
                $where .= " AND post_date > '" . date('Y-m-d', strtotime('-'.$postdate.' days')) . "'";
                return $where;
            }
            add_filter( 'posts_where', 'filter_where' );

            $args = array(
                'post_type'             => 'post',
                'showposts'             => $instance['numpro'],
                'meta_key'              => 'postview_number',
                'orderby'               => 'meta_value_num',
                'order'                 => 'DESC',
                'ignore_sticky_posts'   => -1,
            );
            $the_query = new WP_Query($args);
            remove_filter( 'posts_where', 'filter_where' );
            while($the_query->have_posts()):
            $the_query->the_post();
            ?>
                <li id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
                    <a class="<?php echo $instance['image_alignment'];?>" href="<?php the_permalink();?>" title="<?php the_title();?>">
                        <?php if(has_post_thumbnail()) the_post_thumbnail( $instance['image_size'] ,array( "alt" => get_the_title() ) );?>
                    </a>
                    <h3>
                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                            <?php the_title();?>
                        </a>
                    </h3>
                    <?php
                    if ( ! empty( $instance['show_content'] ) ) {
                        echo '<div class="entry-content">';
                            if ( 'excerpt' == $instance['show_content'] ) {
                                the_excerpt();
                            }
                            elseif ( 'content-limit' == $instance['show_content'] ) {
                                the_content_limit( (int) $instance['content_limit'], 'Xem thêm' );
                            }
                            else {
                                the_content();
                            }
                        echo '</div>';
                    }
                    ?>
                </li>
            <?php
            endwhile;
            wp_reset_postdata(); ?>
        </ul>
 
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
        $instance = wp_parse_args( 
        	(array)$instance, array( 
            		'title' 			=> '', 
            		'numpro' 			=> '3',
                    'image_alignment'   => '',
                    'image_size'        => '',
                    'postdate'          => '30',
                    'show_content'      => 'content-limit',
                    'content_limit'     => '',
        		) 
        	);
        ?>
        <p>
            <label for="<?php  echo $this->get_field_id('title'); ?>"><?php  _e('Tiêu đề', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label for="<?php  echo $this->get_field_id('numpro'); ?>"><?php  _e('Số bài hiển thị', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('numpro'); ?>" name="<?php echo $this->get_field_name('numpro'); ?>" value="<?php echo esc_attr( $instance['numpro'] ); ?>" />
        </p>
        
        <p>
            <label for="<?php echo $this-> get_field_id('postdate'); ?>"><?php _e('Độ tuổi bài viết','sh_theme'); ?>:</label>
            <input class="widefat" type="number" id="<?php echo $this->get_field_id('postdate'); ?>" name="<?php echo $this->get_field_name('postdate'); ?>" value="<?php echo esc_attr( $instance['postdate'] ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'image_alignment' ); ?>"><?php _e( 'Căn lề ảnh', 'sh_theme' ); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'image_alignment' ); ?>" name="<?php echo $this->get_field_name( 'image_alignment' ); ?>">
                <option value="alignnone">- <?php _e( 'Không căn lề', 'sh_theme' ); ?> -</option>
                <option value="alignleft" <?php selected( 'alignleft', $instance['image_alignment'] ); ?>><?php _e( 'Trái', 'sh_theme' ); ?></option>
                <option value="alignright" <?php selected( 'alignright', $instance['image_alignment'] ); ?>><?php _e( 'Phải', 'sh_theme' ); ?></option>
                <option value="aligncenter" <?php selected( 'aligncenter', $instance['image_alignment'] ); ?>><?php _e( 'Giữa', 'sh_theme' ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'image_size' ); ?>"><?php _e( 'Kích thước ảnh', 'sh_theme' ); ?>:</label>
            <select id="<?php echo $this->get_field_id( 'image_size' ); ?>" class="" name="<?php echo $this->get_field_name( 'image_size' ); ?>">
                <option value="thumbnail">thumbnail (<?php echo get_option( 'thumbnail_size_w' ); ?>x<?php echo get_option( 'thumbnail_size_h' ); ?>)</option>
                <?php
                $sizes = wp_get_additional_image_sizes();
                foreach( (array) $sizes as $name => $size )
                    echo '<option value="'.esc_attr( $name ).'" '.selected( $name, $instance['image_size'], FALSE ).'>'.esc_html( $name ).' ( '.$size['width'].'x'.$size['height'].' )</option>';
                ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>"><?php _e( 'Hiển thị nội dung', 'sh_theme' ); ?>:</label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'show_content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_content' ) ); ?>">
                <option value="content" <?php selected( 'content', $instance['show_content'] ); ?>><?php _e( 'Hiển thị đầy đủ', 'sh_theme' ); ?></option>
                <option value="excerpt" <?php selected( 'excerpt', $instance['show_content'] ); ?>><?php _e( 'Hiển thị tóm tắt', 'sh_theme' ); ?></option>
                <option value="content-limit" <?php selected( 'content-limit', $instance['show_content'] ); ?>><?php _e( 'Giới hạn số ký tự', 'sh_theme' ); ?></option>
                <option value="" <?php selected( '', $instance['show_content'] ); ?>><?php _e( 'Không nội dung', 'sh_theme' ); ?></option>
            </select>
        </p>
        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>"><?php _e( 'Số ký tự giới hạn', 'sh_theme' ); ?>
                <input type="text" id="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( intval( $instance['content_limit'] ) ); ?>" size="3" />
                <?php _e( 'ký tự', 'sh_theme' ); ?>
            </label>
        </p>
    <?php
    }
}
