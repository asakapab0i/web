<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					

		<!-- <h2>Search &gt; <?php echo $_GET["s"]?></h2> -->
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<div class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2 class="with_h1_above"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php the_time('n/j') ?></h2>
				<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
				<?php edit_post_link('edit this post', '<div class="edit">', '</div>'); ?>
					<div class="meta">
						<span class="alignleft">
							<!-- by <?php the_author() ?> --> <?php comments_popup_link('no comments', 'one comment', '% comments'); ?> 
						</span>
						<span class="alignright">
							<?php the_tags('', ', ', '<br />'); ?>
						</span>
					</div>
				</div>
			</div>
			<!--<hr>-->

		<?php endwhile; ?>

	<?php else : ?>

		<p>No posts found. Try a different search?</p>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>