<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					

	<?php if (have_posts()) : ?>
 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h3 class="context">You are viewing posts in the <em><?php single_cat_title(); ?></em> category.</h3>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h3 class="context">You are viewing posts tagged <em><?php single_tag_title(); ?></em>.</h3>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h3 class="context">You are viewing posts from <em><?php the_time('F jS, Y'); ?></em>.</h3>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h3 class="context">You are viewing posts from <em><?php the_time('F Y'); ?></em>.</h3>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h3 class="context">You are viewing posts from <em><?php the_time('Y'); ?></em>.</h3>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h3 class="context">Author Archive</h3>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h3 class="context">Blog Archives</h3>
 	  <?php } ?>

		<?php
		while (have_posts()) : the_post(); 
			drawPost();
		endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Not Found</h1>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
