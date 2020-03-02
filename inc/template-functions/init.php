<?php
/**
 * Init
 * @package Uni_Theme
 * @author  
 * @license 
 * @link    
 */

/**
 * Add Header Class
 */
function header_class( ) {
	global $sh_option;
	$array_class_header = array('site-header');
	$layout_header 		= $sh_option['opt-layout-header'];
	if( $layout_header == '1' ) {
		$array_class_header[] = 'header-banner';
	} elseif ( $layout_header == '2' ) {
		$array_class_header[] = 'header-logo';
	} elseif ( $layout_header == '3' ) {
		$array_class_header[] = 'header-logo-style2';
	}
    echo 'class="' . join( ' ', $array_class_header ) . '"';
}

/**
 * Display header.
 */
function uni_header_layout() {
	global $sh_option;
	$layout_header = $sh_option['opt-layout-header'];
	if( $layout_header == '1' ) {
		get_template_part( 'template-parts/header/header-banner' );
	} elseif ( $layout_header == '2' ) {
		get_template_part( 'template-parts/header/header-logo' );
	} elseif ( $layout_header == '3' ) {
		get_template_part( 'template-parts/header/header-logo-style2' );
	}
}

/**
 * Enqueue Script File And Css File
 */
function uni_scripts() {
	wp_enqueue_style( 'unitheme-style', get_stylesheet_uri() );
	// wp_enqueue_style( 'custom-style', UNI_DIR .'/lib/css/custom-style.css' );
}
add_action( 'wp_enqueue_scripts', 'uni_scripts', 51 );

/**
 * Remove Title
 */
add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    }
    return $title;
});

/**
 * Plugin Require Install
 */
function uni_plugin_activation() {

    $plugins = array(
        array(
            'name' 		=> 'Redux Framework',
            'slug' 		=> 'redux-framework',
            'required' 	=> true
        ),
        array(
            'name' 		=> 'Duplicate post',
            'slug' 		=> 'duplicate-post',
        ),
        array(
            'name' 		=> 'Contact Form 7',
            'slug' 		=> 'contact-form-7',
        ),
        array(
            'name' 		=> 'TinyMCE Advanced',
            'slug' 		=> 'tinymce-advanced',
        ),
        array(
            'name' 		=> 'User Role Editor',
            'slug' 		=> 'user-role-editor',
        ),
        array(
            'name' 		=> 'WP SMTP',
            'slug' 		=> 'wp-smtp',
        ),
        array(
            'name' 		=> 'Yoast SEO',
            'slug' 		=> 'wordpress-seo',
        ),
        array(
            'name' 		=> 'iThemes Security',
            'slug' 		=> 'better-wp-security',
        ),
        array(
            'name' 		=> 'WP Fastest Cache',
            'slug' 		=> 'wp-fastest-cache',
        ),
    );
    $configs = array(
        'menu' 			=> 'tp_plugin_install',
        'has_notice' 	=> true,
        'dismissable' 	=> false,
        'is_automatic' 	=> true
    );
    tgmpa( $plugins, $configs );

}
add_action('tgmpa_register', 'uni_plugin_activation');

/**
 * Security
 */
/* Disable Rest API */
function disable_rest_api() {
	if( ! is_user_logged_in() ) {
		return new WP_Error('Error!', __('Unauthorized access is denied!','rest-api-error'), array('status' => rest_authorization_required_code()));
	}
}
// add_filter('rest_authentication_errors','disable_rest_api');

/* Disable XML RPC */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Add Body Class
 */
function add_class_body_layout( $classes ) {
	global $sh_option;
	$layout 	 = $sh_option['opt-layout'];
	$site_layout = $sh_option['site-layout'];
	switch ( $layout ) {
	    case '1':
	        $classes[] = 'no-sidebar';
	        break;
	    case '2':
	        $classes[] = 'sidebar-content';
	        break;
	    case '3':
	        $classes[] = 'content-sidebar';
	        break;
	    case '4':
	        $classes[] = 'sidebar-content-sidebar';
	        break;
        case '5':
	        $classes[] = 'sidebar-sidebar-content';
	        break;
	    case '6':
	        $classes[] = 'content-sidebar-sidebar';
	        break;
	}

	switch ( $site_layout ) {
	    case '1':
	        $classes[] = 'site-full-width';
	        break;
	    case '2':
	        $classes[] = 'site-boxed';
	        break;
	}
	return $classes;
}
add_filter( 'body_class', 'add_class_body_layout' );


/**
 * Display Favicon
 */
function insert_favicon(){
	global $sh_option;
	$url_favicon = $sh_option['opt_settings_favicon']['url'];
	if( $url_favicon ) {
		echo '<link rel="shortcut icon" href="'. $url_favicon .'" type="image/x-icon" />';
	}
}
add_action( 'wp_head','insert_favicon' );

/**
 * Display Pagination
**/
if ( ! function_exists( 'uni_pagination' ) ) {
	function uni_pagination() {
		global $wp_query;
		$big = 999999999;
		echo '<div class="page_nav">';
		echo paginate_links( array(
			'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' 	=> '?paged=%#%',
			'current' 	=> max( 1, get_query_var('paged') ),
			'total' 	=> $wp_query->max_num_pages
		) );
		echo '</div>';
	}
}

/**
 * Custom Pagination
**/
if ( ! function_exists( 'uni_custom_pagination' ) ) {
	function uni_custom_pagination( $custom_query ) {
		$total_pages = $custom_query->max_num_pages;
		$big = 999999999;
		echo '<div class="page_nav">';
			if ( $total_pages > 1 ) {
		        $current_page = max( 1, get_query_var('paged') );
		        echo paginate_links( array(
		            'base' 		=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		            'format' 	=> '?paged=%#%',
		            'current' 	=> $current_page,
		            'total' 	=> $total_pages,
		        ));
		    }
		echo '</div>';
	}
}

/**
 * Set view post
**/
function postview_set( $postID ) {
    $count_key 	= 'postview_number';
    $count 		= get_post_meta( $postID, $count_key, true );
    if( $count == '' ) {
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

/**
 * Get view post
**/
function postview_get( $postID ){
    $count_key 	= 'postview_number';
    $count 		= get_post_meta( $postID, $count_key, true );
    if ( $count == '' ){
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
        return '0 '.__( 'views', 'shtheme' );
    }
    return $count.' '. __( 'views', 'shtheme' );
}

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/**
 * Get term name
 */
function get_dm_name( $cat_id, $taxonomy ) {
	$cat_id 	= (int) $cat_id;
	$category 	= get_term( $cat_id, $taxonomy );
	if ( ! $category || is_wp_error( $category ) )
	return '';
	return $category->name;
}

/**
 * Get term link
 */
function get_dm_link( $category, $taxonomy ) {
	if ( ! is_object( $category ) )
	$category = (int) $category;
	$category = get_term_link( $category, $taxonomy );
	if ( is_wp_error( $category ) )
	return '';
	return $category;
}

/**
 * Responsive Video Youtube In Content
 *
 * @since 0.1.0
 *
 * @param string $content 
 */
function div_wrapper_video($content) {
   // match any iframes
   /*$pattern = '~<iframe.*</iframe>|<embed.*</embed>~'; // Add it if all iframe*/
   $pattern = '~<iframe.*src=".*(youtube.com|youtu.be).*</iframe>|<embed.*</embed>~'; //only iframe youtube
   preg_match_all($pattern, $content, $matches);
   foreach ($matches[0] as $match) {
     // wrap matched iframe with div
     $wrappedframe = '<div class="embed-responsive embed-responsive-16by9">' . $match . '</div>';
     //replace original iframe with new in content
     $content = str_replace($match, $wrappedframe, $content);
   }
   return $content; 
}
add_filter('the_content', 'div_wrapper_video');

function uni_comment($comment, $args, $depth)    {
    $GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class();?> id="li-comment-<?=get_comment_ID();?>">    
        <div id="comment-<?=get_comment_ID();?>" class="clearfix">
             <div class="comment-author vcard">
                <?php echo get_avatar($comment, $size='70', ''); ?>  
             </div><!-- end comment autho vcard-->
        
	         <div class="commentBody">
	        	 <div class="comment-meta commentmetadata">
	              <?php printf(('<p class="fn">%s</p>'), get_comment_author_link()); ?>	              
	             </div><!--end .comment-meta-->
	            <?php if($comment->comment_approved == '0') : ?>
	                <em><?php echo 'Your coment is waiting for moderation.';?></em>
	                <?php endif; ?>
				<div class="noidungcomment">
	            	<?php comment_text(); ?>
	            </div>
	            <div class="tools_comment">	                
		            <?php comment_reply_link(array_merge($args,array('respond_id' => 'formcmmaxweb','depth' => $depth, 'max_depth'=> $args['max_depth'])));?>		            
              		<?php edit_comment_link(__('Edit'),' ',''); ?>
              		<?php printf(('<a href="#comment-%d" class="ngaythang">%s</a>'),get_comment_ID(),get_comment_date('d/m/Y'));?>
	            </div>
	            	
	        </div><!--end #commentBody-->
        </div><!--end #comment-author-vcard-->
	</li>
<?php }

//validate comments
function comment_validation_init() {
	if(is_singular() && comments_open() ) { 
		wp_enqueue_script( 'validate-js' );
	?>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#commentform').validate({		 
			onfocusout: function(element) {
				this.element(element);
			},
			rules: {
				author: {
					required: true,
					minlength: 2
				},
				email: {
					required: true,
					email: true
				},
				comment: {
					required: true,
				}
			},
			messages: {
				author: "<?php echo __('The field is required.','shtheme');?>",
				email: "<?php echo __('The field is required.','shtheme');?>",
				comment: "<?php echo __('The field is required.','shtheme');?>"
			},
			errorElement: "div",
			errorPlacement: function(error, element) {
				element.after(error);
			}
		});
	});
	</script>
	<?php
	}
}
add_action('wp_footer', 'comment_validation_init');