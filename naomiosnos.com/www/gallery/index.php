<?php
include('../include.php');

if (url_id()) {
	if (!$a = db_grab('SELECT id, title, width, height, materials, ' . db_updated() . ' FROM user_artwork WHERE is_active = 1 AND is_published = 1 AND id = ' . $_GET['id'])) url_change('./');

	$gallery = db_array('SELECT id FROM user_artwork WHERE is_published = 1 AND is_active = 1 ORDER BY precedence');
	$pos = array_value_exists($gallery, $_GET['id']); //logically this should always return a value
	$link = './?id=' . (($pos == count($gallery)) ? $gallery[0] : $gallery[$pos + 1]);
	
	
	cms_bar_link('/login/object/edit?id=' . $_GET['id'] . '&object_id=1', 'Edit ' . $a['title']);
	
	echo drawFirst($a['title']);
	
	if (!($a['width'] % 12) && !($a['height'] % 12)) {
		//convert to feet
		$a['width'] = $a['width'] / 12 . '\'';
		$a['height'] = $a['height'] / 12 . '\'';
	} else {
		$a['width'] .= '"';
		$a['height'] .= '"';
	}
	
	echo draw_div_class('meta',
		draw_div_class('title', $a['title'] . 
			draw_div_class('dimensions', $a['height'] . ' &times; ' . $a['width'])		
		) . 
		draw_div_class('materials', $a['materials'])
	);
	
	echo draw_img(file_dynamic('user_artwork', 'image', $a['id'], 'jpg', $a['updated']), $link, $a['title']);
	
} else {
	cms_bar_link('/login/object/?id=1', 'Artwork List');

	echo drawFirst('Gallery');

	//header
	$artwork = db_table('SELECT id, title FROM user_artwork WHERE is_published = 1 AND is_active = 1 ORDER BY title');
	foreach ($artwork as &$a) $a = draw_link('/gallery/?id=' . $a['id'], $a['title']);
	echo draw_div_class('message', 'This is a gallery of ' . count($artwork) . ' recent images. Click on a picture or a name to enlarge the piece.');
	echo draw_list_columns($artwork, 3, 'gallery_list');

	//collage, tweak sizes
	$multiplier = 250 / 44; //used to be 48
	
	$artwork = db_table('SELECT id, title, width, height, ' . db_updated() . ' FROM user_artwork WHERE is_published = 1 AND is_active = 1 ORDER BY precedence');
	foreach ($artwork as &$a) {
		if (($a['width'] < 20) || ($a['height'] < 20)) {
			$a['width'] = $a['width'] * 1.5;
			$a['height'] = $a['height'] * 1.5;
		}
		
		$a = draw_div_class('title', $a['title']) . draw_img(file_dynamic('user_artwork', 'thumbnail', $a['id'], 'jpg', $a['updated']), '/gallery/?id=' . $a['id'], array('alt'=>$a['title'], 'width'=>round($a['width'] * $multiplier), 'height'=>round($a['height'] * $multiplier)));
	}
	echo draw_list($artwork, 'gallery');
}

echo drawLast();
