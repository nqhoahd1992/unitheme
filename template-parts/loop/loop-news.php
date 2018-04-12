<?php
/**
 * Template part for loop news posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package SH_Theme
 */

?>

<article class="<?php echo implode( ' ', get_post_class( 'item-new' ) );?>">
	<a class="alignleft" href="<?php the_permalink();?>" title="<?php the_title();?>">
		<?php if(has_post_thumbnail()) the_post_thumbnail("sh_thumb300x200",array("alt" => get_the_title()));?>
	</a>
	<h3><a title="<?php the_title();?>" href="<?php the_permalink();?>"><?php the_title();?></a></h3>
	<?php the_content_limit( 400 ,' ');?>
	<div class="clearfix"></div>
	<div class="meta-info clearfix">
	   	<div class="float-left">
	   		<span><?php the_time('j F Y') ?></span><span class="inline-sep">|</span>
	   		<?php echo get_the_category_list(', ');?>
	   	</div>
	   	<div class="float-right">
	   		<a href="<?php the_permalink();?>" class="ps-read-more"><?php _e( 'Read more', 'shtheme' );?></a>
	   	</div>
	</div>
</article>
