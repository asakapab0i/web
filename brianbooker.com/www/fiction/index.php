<?php
include('../include.php');

if (url_id()) {
	$r = db_grab('SELECT title, second_title, content, description FROM user_fiction WHERE is_active = 1 AND id = ' . $_GET['id']);
	echo drawTop($r['title']);
	echo draw_div('page_left', draw_div_class('inner', draw_container('h1', $r['title']) . draw_container('h2', $r['second_title']). $r['content']));
	echo draw_div('right', draw_img(file_dynamic('user_fiction', 'cover', $_GET['id'], 'jpg')) . draw_div_class('caption', $r['description']));
} else {
	echo drawTop();
	$fiction = db_table('SELECT id, title, second_title, description FROM user_fiction ORDER BY precedence');
	foreach ($fiction as &$f) $f = draw_link('./?id=' . $f['id'], $f['title'] . '<span class="second_title">' . $f['second_title'] . '</span>', false, array('class'=>'title')) . $f['description'];
	echo draw_div('page_left', draw_div_class('inner', draw_list($fiction, 'fiction')));
	echo draw_div('right', draw_img('/fiction/hotel-iv.jpg', '/artwork/?id=8') . draw_div_class('caption', '<a href="/artwork/?id=8" class="light">Hotel IV</a> (2004)'));
}

echo drawBottom();
?>