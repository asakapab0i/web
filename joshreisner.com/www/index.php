<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					
		
	<?php
	if (have_posts()) {
		while (have_posts()) : the_post(); 
			drawPost();
		endwhile;
	?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
		
	<?php } else { ?>

		<h2 class="center">Not Found</h2>
		<p class="center">Sorry, but you are looking for something that isn't here.</p>

	<?php } ?>
	</div>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
