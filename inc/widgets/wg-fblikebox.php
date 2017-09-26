<?php
add_action( 'widgets_init', 'like_box_facebook_widget' );

function like_box_facebook_widget() {
    register_widget('Like_Box_Facebook');
}

class Like_Box_Facebook extends WP_Widget {
 

    function __construct() {
			parent::__construct (
	      	'facebook-like-widget',
	      	'3B - Facebook Like Box', 
	      	array(
	          	'description' => 'Hiển thị Like Box Fanpage Facebook'
	      	)
	    );
    }
 
    
    function form( $instance ) {
		$default = array(
		'title' => __('Like Facebook','genesis'),
		'page_url' => '',
		);
		$instance = wp_parse_args( (array) $instance, $default );
		$title = esc_attr($instance['title']);
		$page_url = esc_attr($instance['page_url']);

		echo '<p>Tiêu đề: <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
		echo '<p>Link fanpage: <input type="text" class="widefat" name="'.$this->get_field_name('page_url').'" value="'.$page_url.'" placeholder="'.$page_url.'" /></p>';

    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    function widget( $args, $instance ) {
		extract($args);
		$page_url = $instance['page_url'];
		echo $before_widget;
		if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;

		if( $page_url ): ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<div class="fb-page" 
			data-href="<?php echo $page_url; ?>" 
			data-small-header="false" 
			data-adapt-container-width="true" 
			data-hide-cover="false" 
			data-show-facepile="true">
			</div>
		<?php endif;
		echo $after_widget;
    }
}