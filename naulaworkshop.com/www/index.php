<?php
include('include.php');

if (($request['sanswww'] != @$referrer['sanswww']) && ($image = db_grab('SELECT id, title, ' . db_updated() . ' FROM user_splash_images WHERE is_active = 1 AND is_published = 1 ORDER BY precedence'))) {
	echo draw_doctype() . draw_container('head', 
			draw_meta_utf8() .
			draw_title('naula workshop | custom high-end furniture manufacturing and unique upholstery') .
			draw_css('
				body { margin: 0; }
				a img { border: 0; }
				a { position: absolute; top: 50%; left:50%; margin: -218px 0 0 -400px; }
			')
		) . '<body>' . 
		draw_img(file_dynamic('user_splash_images', 'image', $image['id'], 'jpg', $image['updated']), '/', $image['title']) . 
		draw_google_analytics('UA-31847003-1') . 
		'</body></html>';
} else {
	echo drawTop();
	echo draw_img('/images/home.jpg');
	echo drawBottom();
}


