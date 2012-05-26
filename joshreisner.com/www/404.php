<?php get_header(); ?>

<div id="content">
	<div class="post">
		<h1>Page Not Found</h1>
		
		<div class="entry">

		<p>Sorry!  The thing you were looking for isn't where you (or Google, more likely) thought it was.  It probably moved when I <a href="/new-new-new/">switched over to WordPress</a> in August 2008.</p>
		<p>You could <a href="/">start at the home page</a> or try looking this way:</p>
		
		<h3>Blog Posts by Date</h3><br>
			<ul class="nospacing"><?php wp_get_archives('type=monthly'); ?></ul>
		</div>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>