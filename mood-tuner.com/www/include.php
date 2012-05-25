<?php
extract(joshlib());

//get snippets
$snippets = db_table('SELECT title, content FROM user_snippets WHERE is_active = 1');
foreach ($snippets as &$s) $s['title'] = format_text_code($s['title']);
$snippets = array_key_promote($snippets);


function drawFirst($title=false, $meta_description=false, $meta_keywords=false) {
	global $snippets;
	if (!$title)			$title				= $snippets['site_name'];
	if (!$meta_description)	$meta_description	= $snippets['meta_description'];
	if (!$meta_keywords)	$meta_keywords		= $snippets['meta_keywords'];
	
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
		lib_get('jquery,modernizr,jscrollpane') .
		draw_javascript_src() .
		draw_javascript_src('/js/jquery.isotope.min.js') .
		draw_javascript_src('/js/global.js') .
		'<meta http-equiv="cleartype" content="on">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'
	) . 
	draw_body_open() . 
	'<div id="container">
		<div class="wrapper">';
	return $return;
}

function drawLast() {
	global $snippets;
	return '</div></div>' . draw_google_analytics($snippets['google_analytics']) . '</body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}