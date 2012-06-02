<?php
extract(joshlib());

function drawFirst() {
	$return = url_header_utf8() . draw_doctype('en', '/manifest.php') . draw_container('head',
		draw_meta_utf8() . 
		draw_container('title', 'Offline Web App') . 
		draw_css_src('/css/global.css', false, false) . 
		lib_get('jquery,modernizr') .
		draw_javascript_src('/js/global.js')
	) . 
	draw_body_open() . 
	'<div id="container">';
	return $return;
}

function drawLast() {
	return '</div></body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}