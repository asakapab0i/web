<?php
include('include.php');
echo drawTop();

if (home()) {
	//this page is also being called by 404s via htaccess, so

	if ($request['sanswww'] == @$referrer['sanswww']) {
		echo draw_javascript('$(document).ready(showRandom);');	
	} else {
		echo draw_css('
			#left { opacity:0.0; filter:alpha(opacity=0); }
			img.corner { opacity:0.0; filter:alpha(opacity=0); }
		');
		echo draw_div('splash', draw_img('/images/splash.png'));
		echo draw_javascript('$(document).ready(splashInit);');
	}
	
	echo draw_div('random', draw_img_random('/images/random/'));
} elseif ($p = db_grab('SELECT id, title, client, year, description FROM user_products WHERE is_active = 1 AND url = "' . $request['path'] . '"')) {
	//product page
	$images = db_table('SELECT id, ' . db_updated() . ' FROM user_products_images WHERE is_active = 1 AND is_published = 1 AND product_id = ' . $p['id'] . ' ORDER BY precedence');
	$count	= count($images);
	echo draw_div('caption', 
		draw_div('numbers', ($count > 1 ? draw_link('#', '&lt;', false, array('class'=>'back')) . draw_link('#', '&gt;', false, array('class'=>'next')) : false) . '<span id="gallery_counter">01</span><span>/</span>' . sprintf('%02d', $count)) .
		'<div id="description" class="' . $section . '">' . $p['description'] . '</div>' . 
		draw_div('manufacturer', $p['client'] . BR . $p['year'])
	);
	foreach ($images as &$i) $i = draw_img(file_dynamic('user_products_images', 'image', $i['id'], 'jpg', $i['updated']));
	echo draw_div('slideshow', implode('', $images)) . draw_javascript('function_attach(galleryInit);');
}

echo drawBottom();