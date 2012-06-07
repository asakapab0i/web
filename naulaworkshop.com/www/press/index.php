<?php
include('../include.php');
echo drawTop();

if (url_id()) {
	//show press images
	cms_bar_link('/login/object/edit/?id=' . $_GET['id'] . '&object_id=5', 'Edit Press');
	echo '<div class="center">';
	$images = db_table('SELECT id, ' . db_updated() . ' FROM user_press_images WHERE is_active = 1 AND is_published = 1 AND press_id = ' . $_GET['id'] . ' ORDER BY precedence');
	foreach ($images as &$i) echo draw_p(draw_img(file_dynamic('user_press_images', 'image', $i['id'], 'jpg', $i['updated'])));
	echo '<p><a href="./">Go Back</a></p></div>';
} else {
	//press list
	cms_bar_link('/login/object/edit/?id=5', 'Press List');
	$press = db_table('SELECT id, title, date, ' . db_updated() . ' FROM user_press WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
	foreach ($press as &$p) $p = draw_img(file_dynamic('user_press', 'cover', $p['id'], 'jpg', $p['updated']), './?id=' . $p['id']) . draw_link('./?id=' . $p['id'], $p['title']) . BR . $p['date'];
	echo draw_div_class('center', 
		draw_p('For press inquiries, contact Kai Cole ' . draw_link('mailto:kai@naulaworkshop.com') . '.') . BR .
		draw_list($press)
	);
}
echo drawBottom();
