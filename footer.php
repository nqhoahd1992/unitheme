<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package SH_Theme
 */

global $sh_option;
do_action( 'sh_after_content_sidebar_wrap' );
?>
		</div>
	</div><!-- #content -->

	<footer id="footer" class="site-footer" itemscope itemtype="https://schema.org/WPFooter">
		
		<div class="footer-widgets">
			<div class="container">
				<div class="wrap">
					<div class="row">
						<?php do_action( 'sh_footer' );?>
					</div>
				</div>
			</div>
		</div><!-- .footer-widgets -->

		<?php if( $sh_option['footer-copyright'] ) : ?>
			<div class="site-info">
				<div class="container">
					<div class="wrap">
						<div class="row">
							<div class="col-sm-12 text-center">
								<p id="copyright"><?php echo $sh_option['footer-copyright'];?></p>
							</div>
						</div>
					</div>
				</div>
			</div><!-- .site-info -->
		<?php endif; ?>
		
	</footer><!-- #colophon -->

	<p id="back-top"><a href="#top" target="_blank"><span></span></a></p>

	<?php do_action( 'sh_after_footer' );?>
	
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
