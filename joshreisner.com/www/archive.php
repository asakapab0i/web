<?php get_header(); ?>

<div class="row">
	<div class="span9 content">					

	<?php if (have_posts()) : ?>
 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<!-- <h1><?php single_cat_title(); ?></h1> -->
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1>Tag &gt; <?php single_tag_title(); ?></h1>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1>Day &gt; <?php the_time('F jS, Y'); ?></h1>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1>Month &gt; <?php the_time('F Y'); ?></h1>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1>Year &gt; <?php the_time('Y'); ?></h1>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1>Author Archive</h1>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1>Blog Archives</h1>
 	  <?php } ?>

		<?php while (have_posts()) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php the_time('n/j/Y') ?></h2>
				<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
				<?php edit_post_link('Edit Post', '<div class="edit">', '</div>'); ?>
				</div>
			</div>
		<?php endwhile; ?>

		<!--
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>
		-->
		<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>


	<?php else : ?>

		<h2 class="center">Not Found</h1>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
