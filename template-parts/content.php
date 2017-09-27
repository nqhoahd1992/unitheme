<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'shtheme' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );

			// wp_link_pages( array(
			// 	'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shtheme' ),
			// 	'after'  => '</div>',
			// ) );
		?>
		<div class="socials-share">
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-like" data-href="<?php the_permalink();?>" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>

			<!-- Đặt thẻ này vào phần đầu hoặc ngay trước thẻ đóng phần nội dung của bạn. -->
			<script src="https://apis.google.com/js/platform.js" async defer>
			  {lang: 'vi'}
			</script>
			<!-- Đặt thẻ này vào nơi bạn muốn nút chia sẻ kết xuất. -->
			<div class="g-plus" data-action="share"></div>
			
			<script>window.twttr = (function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0],
			t = window.twttr || {};
			if (d.getElementById(id)) return t;
			js = d.createElement(s);
			js.id = id;
			js.src = "https://platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js, fjs);
			t._e = [];
			t.ready = function(f) {
			t._e.push(f);
			};
			return t;
			}(document, "script", "twitter-wjs"));</script>
			<a class="twitter-share-button"
			  href="<?php the_permalink();?>">
			Tweet</a>
		</div>

		<div class="l-section-h i-cf">
			<div class="row">
				<?php
				$next_post 		= get_next_post();
				$next_id 		= $next_post->ID;
				$previous_post 	= get_previous_post();
				$previous_id 	= $previous_post->ID;
				?>
				<?php if( ! empty( $next_id ) ) : ?>
					<div class="col-sm-6">
						<div class="post-next-prev-content">
							<span>Bài viết trước</span>
							<a href="<?php echo get_the_permalink( $next_id ); ?>"><?php echo get_the_title( $next_id ); ?></a>
						</div>
					</div>
				<?php endif;?>
				<?php if( ! empty( $previous_id ) ) : ?>
					<div class="col-sm-6">
						<div class="post-next-prev-content">
							<span>Bài kế tiếp</span>
							<a href="<?php echo get_the_permalink( $previous_id ); ?>"><?php echo get_the_title( $previous_id ); ?></a>
						</div>
					</div>
				<?php endif;?>
				
			</div>
		</div>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
