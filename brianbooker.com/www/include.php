<?php
extract(joshlib());

function drawTop($title=false) {
	global $request;
	
	//navigation & title
	$sections = array('/'=>'Home', '/fiction/'=>'Fiction', '/artwork/'=>'Artwork', '/news/'=>'News', '/contact/'=>'Contact');
	if (!$title && in_array($request['path'], array_keys($sections))) $title = $sections[$request['path']];
	
	ob_start('browser_output');
	
	return url_header_utf8() . draw_doctype() . draw_container('head',
			draw_meta_utf8() .
			draw_meta_description('Brian Booker is a writer and artist living in Brooklyn, NY.') . 
			draw_container('title', $title) .
			draw_css_src('/css/global.css') . 
			draw_css_src('/css/ie.css', 'ie')
		) . 
		'<body><div id="container">' . 
		draw_div('banner', 
			draw_img('/images/banner.png', '/', 'Brian Booker') . 
			draw_nav($sections, 'text', 'navigation')
		);
}

function drawBottom() {
	return '</div>' . draw_google_analytics('UA-80350-18') . '</body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}