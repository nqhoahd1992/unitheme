<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

?>

<section class="no-results not-found">
	<h1 class="page-title"><?php esc_html_e( 'Không tìm thấy kết quả', 'shtheme' ); ?></h1>

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'shtheme' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Không có kết quả tìm kiếm nào phù hợp với từ khóa của bạn. Xin hãy thử lại tìm kiếm với từ khóa khác.', 'shtheme' ); ?></p>
			<?php

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'shtheme' ); ?></p>
			<?php

		endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
