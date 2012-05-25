<?php
extract(joshlib());

function drawFirst($title='Naomi Osnos') {
	$meta_description = '';
	$meta_keywords = '';
	
	$return = url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_container('title', $title) . 
		draw_meta_description($meta_description) . 
		draw_meta_keywords($meta_keywords) . 
		'<meta name="HandheldFriendly" content="True">
 		<meta name="MobileOptimized" content="320">
  		<meta name="viewport" content="width=device-width, target-densitydpi=160, initial-scale=1.0">' .
  		'<link rel="shortcut icon" href="/assets/favicon.ico">' .
		draw_css_src('/css/global.css') . 
		lib_get('jquery') .
		draw_javascript_src() .
		draw_javascript_src('/js/global.js') .
		draw_javascript_src('/js/jquery.isotope.min.js') .
		'<meta http-equiv="cleartype" content="on">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'
	) . 
	draw_body_open() . 
	draw_div_open('container') . 
	draw_div('header',
		draw_img('/images/logo.png', '/', array('class'=>'logo')) .
		draw_nav(array('/about/'=>'About', '/gallery/'=>'Gallery', '/contact/'=>'Contact'), 'images', 'nav', 'path', false, false, false, draw_img('/images/nav/separator.png'))		
	);
	
	return $return;
}

function drawLast() {
	$return = '</div>' .
	cms_bar('694px') . 
	'</body></html>';
	return $return;
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}