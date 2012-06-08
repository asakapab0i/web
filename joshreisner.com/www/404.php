<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					
		<div class="post">
			<h1>Something has gone terribly wrong.</h1>
				
			<p>Well, this is awkward!  The thing you were looking for isn't where you (or Google, more likely) thought it was.
			You could <a href="/">start at the home page</a> or try looking this way:</p>
		</div>
		<h3>Blog Posts by Date</h3>
		<div class="post">
			<br>
			<ul class="nospacing"><?php wp_get_archives('type=monthly'); ?></ul>
		</div>
	</div>

	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
