<?php
add_action('widgets_init', 'register_widget_information');

function register_widget_information() {
    register_widget('Gtid_Information_Widget');
}

class Gtid_Information_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'information',
            '3B - Thông tin',
            array( 'description'  =>  'Hiển thị thông tin gồm địa chỉ, số điện thoại, email, website' )
        );
        
    }

    function widget($args, $instance) {
        extract($args);
        $instance = wp_parse_args( (array)$instance, array(  'title' => '', 'address' => '', 'tel' => '' , 'email' => '', 'website' => '' ) );
        echo $before_widget;

        if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        ?>
        <ul>
            <?php 
            if( $instance['address'] ) {
                echo '<li><i class="fa fa-map-marker" aria-hidden="true"></i>Địa chỉ: '. $instance['address'] .'</li>';
            }
            if( $instance['tel'] ) {
                echo '<li><i class="fa fa-phone-square" aria-hidden="true"></i>Số điện thoại: '. $instance['tel'] .'</li>';
            }
            if( $instance['email'] ) {
                echo '<li><i class="fa fa-envelope" aria-hidden="true"></i>Email: '. $instance['email'] .'</li>';
            }
            if( $instance['website'] ) {
                echo '<li><i class="fa fa-globe" aria-hidden="true"></i>Website: '. $instance['website'] .'</li>';
            }
            ?>
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
            		'title' 	 => '', 
            		'address'    => '',  
            		'tel' 	     => '',
                    'email'      => '',
                    'website'    => '',
        		) 
        	);
        ?>
        <p>
            <label for="<?php  echo $this->get_field_id('title'); ?>"><?php  _e('Tiêu đề', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php  echo $this->get_field_name('title'); ?>" value="<?php  echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label for="<?php  echo $this->get_field_id('address'); ?>"><?php  _e('Địa chỉ', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php  echo $this->get_field_name('address'); ?>" value="<?php  echo esc_attr( $instance['address'] ); ?>" />
        </p>
        
        <p>
            <label for="<?php  echo $this->get_field_id('tel'); ?>"><?php  _e('Số điện thoại', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('tel'); ?>" name="<?php  echo $this->get_field_name('tel'); ?>" value="<?php  echo esc_attr( $instance['tel'] ); ?>" />
        </p>

        <p>
            <label for="<?php  echo $this->get_field_id('email'); ?>"><?php  _e('Email', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php  echo $this->get_field_name('email'); ?>" value="<?php  echo esc_attr( $instance['email'] ); ?>" />
        </p>

        <p>
            <label for="<?php  echo $this->get_field_id('website'); ?>"><?php  _e('Website', 'sh_theme'); ?>:</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('website'); ?>" name="<?php  echo $this->get_field_name('website'); ?>" value="<?php  echo esc_attr( $instance['website'] ); ?>" />
        </p>

    <?php
    }
}
