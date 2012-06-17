<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					

		<!-- <h2>Search &gt; <?php echo $_GET["s"]?></h2> -->
	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<?php drawPost()?>
			
		<?php endwhile; ?>

	<?php else : ?>

		<p>No posts found. Try a different search?</p>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>