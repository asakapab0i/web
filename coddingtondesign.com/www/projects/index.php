<?php
include('../include.php');

//default to first project
if (!url_id()) url_query_add(array('id'=>db_grab('SELECT id FROM user_projects WHERE is_active = 1 AND is_published = 1 ORDER BY precedence')));

cms_bar_link('/login/object/edit?object_id=4&id=' . $_GET['id'], 'Edit Project');

//grab project info & gallery images
$project = db_grab('SELECT id, title, location, description FROM user_projects WHERE is_published = 1 AND is_active = 1 AND id = ' . $_GET['id']);
$photos = db_table('SELECT id, title, ' . db_updated() . ' FROM user_photos WHERE is_published = 1 AND is_active = 1 AND project_id = ' . $project['id']);

echo drawFirst($project['title'], draw_p($project['title'] . BR . $project['location']) . $project['description']);

$caption = $photos[0]['title'];

//draw gallery
foreach ($photos as &$p) $p = draw_img(file_dynamic('user_photos', 'photo', $p['id'], 'jpg', $p['updated']), false, $p['title']);

//output
echo draw_div('column span3', draw_list($photos, 'slideshow numbers arrows after') . draw_div('caption', $caption));

echo drawLast();