<?php
include('../include.php');

$array = array_ajax();
$words = explode(' ', $array['terms']);
$where = array();
foreach ($words as $w) $where[] = 'w.word = \'' . format_quotes($w) . '\'';
$where = '(' . implode(' OR ', $where) . ')';

$posts	= db_table('SELECT
			p.id,
			p.title,
			p.content,
			p.date,
			(SELECT COUNT(*) FROM user_links l WHERE l.is_active = 1 AND l.post_id = p.id) links,
			(SELECT COUNT(*) FROM user_images i WHERE i.is_active = 1 AND i.post_id = p.id) images			
		FROM words w
		JOIN user_posts_to_words p2w ON w.id = p2w.word_id
		JOIN user_posts p ON p2w.object_id = p.id
		WHERE p.is_published = 1 AND p.is_active = 1 AND ' . $where . '
		ORDER BY p.date DESC');

echo drawPosts($posts, $words);