<?php
/**
 * Template part for loop news posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

?>

<article class="<?php echo implode( ' ', get_post_class( $class ) );?>">
	<a class="alignleft" href="<?php the_permalink();?>" title="<?php the_title();?>">
		<?php echo get_the_post_thumbnail( get_the_ID(), 'sh_thumb300x200' );?>
	</a>
	<h3><a title="<?php the_title();?>" href="<?php the_permalink();?>" ><?php the_title();?></a></h3>
	<?php echo get_the_content_limit( 400 ,' ');?>
	<div class="clearfix"></div>
	<div class="ps-meta-info">
	   	<div class="ps-alignleft">
	   		<span><?php the_time('j F Y') ?></span><span class="ps-inline-sep">|</span>
	   		<?php echo get_the_category_list(', ');?>
	   	</div>
	   	<div class="ps-alignright">
	   		<a href="<?php the_permalink();?>" class="ps-read-more"><?php _e( 'Read more', 'shtheme' );?></a>
	   	</div>
	</div>
</article>
