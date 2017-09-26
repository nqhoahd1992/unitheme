<?php
add_action('widgets_init', 'register_gtid_support');

function register_gtid_support() {
    register_widget('Gtid_Support_Online');
}

class Gtid_Support_Online extends WP_Widget {

	function __construct() {
        parent::__construct(
            'supports',
            '3B - Hỗ trợ trực tuyến',
            array( 'description'  =>  'Hiển thị danh sách hỗ trợ trực tuyến' )
        );
    }

	function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args( (array)$instance, array(
			'title' 			=> '',
            'number_supporter' 	=> 1,
            'tel' 				=> '',
            // 'data_style' 		=> '',
		) );

		echo $before_widget;
		if (!empty($instance['title']))
		echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
        echo '<div class = "wrap-support">';
        ?>     	

        <div id="supporter-info" class="list-supporter <?php //echo $instance['data_style']; ?>">

        	<?php get_layout_support($instance);?>

		</div>

		<?php
        echo '</div>';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	function form($instance) {
		$instance = wp_parse_args( (array)$instance, array(
			'title' 			=> '',
            'number_supporter' 	=> 1,
		) );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php _e('Tiêu đề', 'sh_theme'); ?>:
			</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
        <p>
	    	<label for="<?php echo $this->get_field_id('number_supporter'); ?>">
	    		<?php _e('Số hỗ trợ viên', 'sh_theme'); ?>:
	    	</label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('number_supporter'); ?>" name="<?php echo $this->get_field_name('number_supporter'); ?>" value="<?php echo esc_attr( $instance['number_supporter'] ); ?>" />
		</p>
		<!-- <p>
	        <label for="<?php echo $this->get_field_id('data_style'); ?>">
	        	<?php _e('Giao diện', 'sh_theme'); ?>:
	        </label>
	    	<select class="widefat" id="<?php echo $this->get_field_id('data_style'); ?>" name="<?php echo $this->get_field_name('data_style'); ?>" style="width: 165px;">
		        <?php for ($i=1; $i < 9; $i++) {?>
			  		<option value="gd_support_<?php echo $i; ?>" <?php selected( 'gd_support_'.$i , $instance['data_style']); ?>>Giao diện <?php echo $i; ?></option>
		        <?php } ?>
	        </select>
	    </p> -->
	    <p>
	        <input type="submit" name="savewidget" id="savewidget" class="button-primary widget-control-save" value="Lưu" />
    	</p>

        <?php 
        // $giaodien =  substr($instance['data_style'], -1);
        for( $i = 1;$i<=$instance['number_supporter'];$i++ ) {
    	?>
            <div style="background: #eee;padding: 10px 10px;margin-bottom: 10px;">
         	
	            <strong><?php _e('Hỗ trợ viên ', 'sh_theme'); echo $i; ?></strong>
	           	
	           	<p>
					<label for="<?php echo $this->get_field_id('supporter_'.$i.'_name'); ?>">
						<?php _e('Tên', 'sh_theme'); ?>:
					</label>
		    		<input class="widefat" type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_name'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_name'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_name'] ); ?>" />
	    		</p>

	    		<p>
	    			<label for="<?php echo $this->get_field_id('supporter_'.$i.'_phone'); ?>">
	    				<?php _e('Sô điện thoại', 'sh_theme'); ?>:
	    			</label>
	    			<input class="widefat" type="tel" id="<?php echo $this->get_field_id('supporter_'.$i.'_phone'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_phone'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_phone'] ); ?>" />
	    		</p>

	    		<p>
		        	<label for="<?php echo $this->get_field_id('supporter_'.$i.'_email'); ?>">
		        		<?php _e('Email', 'sh_theme'); ?>:
		        	</label>
					<input class="widefat" type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_email'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_email'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_email'] ); ?>" />
				</p>

	    		<p>
	            	<label for="<?php echo $this->get_field_id('supporter_'.$i.'_skype'); ?>">
	            		<?php _e('Skype', 'sh_theme'); ?>:
	            	</label>
	    			<input class="widefat" type="text" id="<?php echo $this->get_field_id('supporter_'.$i.'_skype'); ?>" name="<?php echo $this->get_field_name('supporter_'.$i.'_skype'); ?>" value="<?php echo esc_attr( $instance['supporter_'.$i.'_skype'] ); ?>" />
	    		</p>
    		
            </div>
		<?php
		}
	}
}

function get_layout_support($instance) {

	$instance = wp_parse_args( (array)$instance, array(
        'number_supporter' => 1,
	) );

	for( $i = 1; $i <= $instance['number_supporter']; $i++ ) {
		$name 	= 	$instance['supporter_'.$i.'_name'];
		$phone 	= 	$instance['supporter_'.$i.'_phone'];
		$email 	= 	$instance['supporter_'.$i.'_email'];
		$skype 	= 	$instance['supporter_'.$i.'_skype'];
		?>
		<div id="support-<?php echo $i; ?>" class="supporter">
			<ul>
				<?php 
				if( ! empty( $name ) ) {
					echo '<li><i class="fa fa-comments" aria-hidden="true"></i> ' .$name. '</li>';
				}
				if( ! empty( $phone ) ) {
					echo '<li><i class="fa fa-phone" aria-hidden="true"></i> ' .$phone. '</li>';
				}
				if( ! empty( $email ) ) {
					echo '<li><i class="fa fa-envelope" aria-hidden="true"></i> ' .$email. '</li>';
				}
				if( ! empty( $skype ) ) {
					echo '<li><i class="fa fa-skype" aria-hidden="true"></i> ' .$skype. '</li>';
				}
				?>
			</ul>
		</div>
		<?php
	}

}
