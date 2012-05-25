<?php
include('../include.php');
echo drawTop();

if (!url_id('c')) {
	//main work page
	echo draw_img('work-details.jpg');
} else {
	if (url_id('i')) cms_bar_link('/login/object/edit/?id=' . $_GET['i'] . '&object_id=3', 'Edit Photo');

	echo draw_nav('SELECT 
		CONCAT("' . $request['path'] . '?c=", p.collection_id, "&p=", p.id, "&i=", (SELECT i.id FROM user_photos i WHERE i.product_id = p.id AND i.is_published = 1 AND i.is_active = 1 ORDER BY precedence LIMIT 1)), 
		p.title 
		FROM user_products p 
		WHERE 
			(SELECT COUNT(*) FROM user_photos i WHERE i.product_id = p.id AND i.is_published = 1 AND i.is_active = 1) > 0 AND
			p.collection_id = ' . $_GET['c'] . ' AND is_published = 1 AND is_active = 1 ORDER BY precedence', 'text', 'nav side', array('p'=>@$_GET['p']));
	
	if (!url_id('p') || !url_id('i')) {
		//collection home page
		echo draw_div_class('tinymce', db_grab('SELECT description FROM user_collections WHERE id = ' . $_GET['c']));
	} else {
		//numbers
		
		echo '<div class="main">'; 
		
		$numbers	= array();
		$images		= db_array('SELECT id FROM user_photos WHERE is_published = 1 AND is_active = 1 AND product_id = ' . $_GET['p'] . ' ORDER BY precedence');
		$counter	= 1;
		$count		= count($images);
		foreach ($images as $i) {
			if ($_GET['i'] == $i) {
				$link = $request['path'] . '?c=' . $_GET['c'] . '&p=' . $_GET['p'] . '&i=' . $images[($counter == $count) ? 0 : $counter];
			}
			$numbers[$request['path'] . '?c=' . $_GET['c'] . '&p=' . $_GET['p'] . '&i=' . $i] = str_pad($counter++, 2, "0", STR_PAD_LEFT);
		}
		echo draw_nav($numbers, 'text', 'nav numbers', 'path_query');
		
		$image = db_grab('SELECT title, ' . db_updated() . ' FROM user_photos WHERE id = ' . $_GET['i']);
		echo draw_img(file_dynamic('user_photos', 'image', $_GET['i'], 'jpg', $image['updated']), $link, $image['title']);
		
		//description
		if ($_GET['i'] == $images[0]) echo draw_div_class('tinymce', db_grab('SELECT description FROM user_products WHERE id = ' . $_GET['p']));
		
		echo '</div>';
	}
}

echo drawBottom();