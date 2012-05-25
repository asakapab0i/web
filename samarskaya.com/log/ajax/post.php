<?php
include('../include.php');

$array = array_ajax();

$post = array(db_grab('SELECT 
			p.id, 
			p.title, 
			p.content, 
			p.date,
			(SELECT COUNT(*) FROM user_links l WHERE l.is_active = 1 AND l.post_id = p.id) links,
			(SELECT COUNT(*) FROM user_images i WHERE i.is_active = 1 AND i.post_id = p.id) images			
		FROM user_posts p
		WHERE p.is_published = 1 AND p.is_active = 1 AND p.id = ' . $array['id'] . '
		ORDER BY p.date DESC'));

echo drawPosts($post);