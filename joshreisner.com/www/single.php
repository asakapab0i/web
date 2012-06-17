<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					
		
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php drawPost() ?>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
