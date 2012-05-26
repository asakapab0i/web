<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					
		
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php the_content('Read More &raquo;'); ?>
				<div class="meta">
					Posted by <a href="<?php the_author()?>"><?php the_author()?></a> on <?php the_time('F j, Y') ?> <?php edit_post_link('Edit', '| '); ?>
				</div>
			</div>
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>
	</div>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
