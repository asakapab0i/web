<?php
include('../include.php');

if (!url_id()) url_query_add(array('id'=>db_grab('SELECT id FROM user_projects WHERE is_active = 1 AND is_published = 1 ORDER BY precedence')));

$project = db_grab('SELECT id, title, description FROM user_projects WHERE is_published = 1 AND is_active = 1 AND id = ' . $_GET['id']);

$photos = db_table('SELECT id, title, ' . db_updated() . ' FROM user_photos WHERE is_published = 1 AND is_active = 1 AND project_id = ' . $project['id']);

echo drawTop($photos[0]['title'], $project['description']);

foreach ($photos as &$p) $p = draw_img(file_dynamic('user_photos', 'photo', $p['id'], 'jpg', $p['updated']), false, $p['title']);

echo draw_list($photos, 'slideshow numbers arrows');

echo drawBottom();