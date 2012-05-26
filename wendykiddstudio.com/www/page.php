<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
get_header(); ?>

<div id="content" role="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="page" id="page-<?php the_ID(); ?>">
		<?php if (!is_front_page()) {?>
			<h2>
				<img src="<?php bloginfo('template_directory'); ?>/images/flourishes/left.png" width="28" height="17" border="0"/>
				<?php the_title(); ?>
				<img src="<?php bloginfo('template_directory'); ?>/images/flourishes/right.png" width="28" height="17" border="0"/>
			</h2>
		<?php } ?>
				
		<div class="entry">
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div>
		
		<? if (5 == $post->post_parent) {?>
			<a href="/gallery/">Back to Gallery</a>
		<? } elseif (5 == $post->ID) {
			drawGallery();
		} ?>
	</div>
	<?php endwhile; endif; ?>
	<?php edit_post_link('Edit Page', '<p class="edit">', '</p>'); ?>
</div>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
<style type="text/css">
div.imagecol { background-image:url(http://wendy.joshreisner.com/wp-content/themes/wendy/images/product_backing.png); background-repeat:no-repeat; position:relative; width:141px; height:118px; }
div.imagecol img { margin:10px 10px 10px 20px; }
div.producttext { margin-left:50px; padding:10px; }
</style>