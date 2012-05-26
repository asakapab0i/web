<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

$content_width = 450;

automatic_feed_links();

if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

function drawGallery() {
    global $post, $wpdb;
    $children = $wpdb->get_results('SELECT 
			p.post_title, 
			p.post_name, 
			(SELECT id FROM wp_posts i WHERE i.post_parent = p.id AND post_mime_type = "image/jpeg" ORDER BY menu_order LIMIT 1) img_id 
		FROM wp_posts p 
		WHERE p.post_type = "page" AND p.post_parent = 5 AND post_status = "publish"
		ORDER BY p.menu_order');
	echo '<ul class="gallery">';
	$counter = 1;
	foreach ($children as $c) {
        echo '<li class="item_' . $counter . '"><a href="/' . $c->post_name . '/" class="img"><img src="' . wp_get_attachment_thumb_url($c->img_id) . '" width="160" height="160" alt="' . $c->post_title . '" title="' . $c->post_title . '" /></a></li>';
		$counter++;
	}
	echo '</ul>';
}

?>