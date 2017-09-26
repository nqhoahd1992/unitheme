<?php
add_action('widgets_init', 'register_gtid_post_by_cat');

function register_gtid_post_by_cat() {
    register_widget('Gtid_Post_Widget');
}

class Gtid_Post_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'list_posts',
            '3B - Danh sách bài viết',
            array( 'description'  =>  'Hiển thị một danh sách bài viết theo chuyên mục' )
        );
    }

    function widget($args, $instance) {
        extract($args);
        $instance = wp_parse_args( (array)$instance, array(  'title' => '', 'numpro' => '', 'cat' => '' , 'image_alignment' => '', 'image_size' => '' ) );
        echo $before_widget;

        if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        ?>
        <ul>
            <?php
            $args = array(
                'post_type' => 'post',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'category',
                        'field' => 'id',
                        'terms' => $instance['cat'],
                    )
                ),
                'showposts' => $instance['numpro'],
            );
            $the_query = new WP_Query($args);
            while($the_query->have_posts()):
            $the_query->the_post();
            ?>
                <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <a class="<?php echo $instance['image_alignment'];?>" href="<?php the_permalink();?>" title="<?php the_title();?>">
                        <?php if(has_post_thumbnail()) the_post_thumbnail( $instance['image_size'] ,array( "alt" => get_the_title() ) );?>
                    </a>
                    <h3>
                        <a href="<?php the_permalink();?>" title="<?php the_title();?>">
                            <?php the_title();?>
                        </a>
                    </h3>
                    <a class="viewmore" href="<?php the_permalink();?>" title="Xem thêm">Xem thêm</a>
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
            		'cat' 				=> '',
                    'image_alignment'   => '',
                    'image_size'        => '',
        		) 
        	);
        ?>
        <p>
            <label for="<?php  echo $this->get_field_id('title'); ?>"><?php  _e('Tiêu đề', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php  echo $this->get_field_name('title'); ?>" value="<?php  echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label for="<?php  echo $this->get_field_id('numpro'); ?>"><?php  _e('Số bài hiển thị', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('numpro'); ?>" name="<?php  echo $this->get_field_name('numpro'); ?>" value="<?php  echo esc_attr( $instance['numpro'] ); ?>" />
        </p>
        
        <p>
            <label for="<?php echo $this-> get_field_id('cat'); ?>"><?php  _e('Danh mục','sh_theme'); ?>:</label>
            <?php
            wp_dropdown_categories(array('name'=> $this->get_field_name('cat'),'selected'=>$instance['cat'],'orderby'=>'Name','hierarchical'=>1,'show_option_all'=>__('Chọn chuyên mục','sh_theme'),'hide_empty'=>'0'));
            ?>
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
    <?php
    }
}
