<?php
add_action('widgets_init', 'register_widget_social');

function register_widget_social() {
    register_widget('Gtid_Social_Widget');
}

class Gtid_Social_Widget extends WP_Widget {

    function __construct() {

        parent::__construct(
            'social',
            '3B - Mạng xã hội',
            array( 'description'  =>  'Hiển thị thông tin mạng xã hội' )
        );
        
    }

    function widget($args, $instance) {
        extract($args);
        $instance = wp_parse_args( (array)$instance, array(  'title' => '' ) );
        echo $before_widget;

        if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        ?>
        <ul>
            <?php
            global $sh_option;
            echo '<li><a href="'.$sh_option['social-facebook'].'" rel="nofollow" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>';
            echo '<li><a href="'.$sh_option['social-twitter'].'" rel="nofollow" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>';
            echo '<li><a href="'.$sh_option['social-google'].'" rel="nofollow" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>';
            echo '<li><a href="'.$sh_option['social-youtube'].'" rel="nofollow" target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a></li>';
            ?>
        </ul>
 
        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function form($instance) {
        ?>
        <p>Nội dung widget này được hiển thị từ trong <strong>Theme Options -> Mạng xã hội</strong></p>
    <?php
    }
}
