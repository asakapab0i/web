<?php
include('include.php');
$title = db_grab('SELECT title FROM user_greetings WHERE is_published = 1 AND is_active = 1 ORDER BY RAND()');
$posts = getPosts();
foreach ($posts as &$p) {
	$p['author'] = 'Ksenya';
	$p['description'] = $p['content'];
	$p['link'] = url_base() . (($p['url']) ? $p['url'] : '/?id=' . $p['id']);
}
echo file_rss($title, url_base() . '/', $posts);