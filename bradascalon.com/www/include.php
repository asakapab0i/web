<?php
extract(joshlib());

$sections = array(
	'STUDIO'=>array(
		'/profile/'=>'Profile',
		'/clients/'=>'Clients',
		'/exhibitions/'=>'Exhibitions',
		'http://www.facebook.com/pages/Brad-Ascalon-Studio-NYC/162679722612'=>'News',
		'/contact/'=>'Contact'
	)
);

//add WORK, PACKAGING AND PROJECTS
$types = db_table('SELECT id, title FROM user_products_types WHERE is_active = 1 ORDER BY precedence');
foreach ($types as $t) {
	if ($products = db_table('SELECT url, title FROM user_products WHERE is_active = 1 AND is_published = 1 AND type_id = ' . $t['id'] . ' ORDER BY precedence')) {
		$sections[strToUpper($t['title'])] = array_key_promote($products);
	}
}

$sections['PRESS'] = array(
		'/magazines/'=>'Magazines',
		'/videos/'=>'Videos',
		'/books/'=>'Books'
	);

$section = false;
foreach ($sections as $s=>$pages) if (in_array($request['path'], array_keys($pages))) $section = strtolower($s);
if ($request['path'] == '/brokenoff/') $section = 'projects';


function drawGallery($description='', $manufacturer='') {
	//todo deprecate
	global $section;
	$images = file_folder(false, '.jpg', true);
	$count = count($images);
	echo draw_div('caption', 
		draw_div('numbers', ($count > 1 ? draw_link('#', '&lt;', false, array('class'=>'back')) . draw_link('#', '&gt;', false, array('class'=>'next')) : false) . '<span id="gallery_counter">01</span><span>/</span>' . sprintf('%02d', count($images))) .
		draw_div('description', $description, $section) .
		draw_div('manufacturer', $manufacturer)
	);
	foreach ($images as &$i) $i = draw_img($i);
	return draw_div('slideshow', implode('', $images)) . draw_javascript('function_attach(galleryInit);');
}

function drawTop($title=false, $section_id=false) {
	global $request, $sections;
		
	if (!$title) $title = 'Brad Ascalon'; //define default title
		
	//start output
	$return = url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_container('title', $title) . 
		//draw_meta_description(db_grab('SELECT snippet FROM user_snippets WHERE id = 1')) . 
		draw_css_src() . 
		lib_get('jquery') . 
		lib_get('jscrollpane') . 
		draw_javascript_src() . 
		draw_javascript_src('/js/javascript.js') . 
		draw_javascript_src('/js/menu.js') . 
		draw_typekit('gwi0tvz')
	) . 
	draw_body_open() . draw_div_open('container') . '<div id="left">' . draw_img('/images/logo.png', '/') . '<ul class="menu">';
	foreach ($sections as $section=>$pages) $return .= draw_tag('li', (in_array($request['path'], array_keys($pages)) ? 'expand' : false), draw_link('#', $section) . draw_nav($pages, 'text', 'acitem', 'path', false, false, false));
	$return .= '</ul>
		<ul class="social">
			<li><a class="twitter" target="_blank" href="https://twitter.com/#!/bradascnyc">Twitter</a></li>
			<li><a class="facebook" target="_blank" href="http://www.facebook.com/pages/Brad-Ascalon-Studio-NYC/162679722612">Facebook</a></li>
		</ul>
	</div><div id="right">';
	return $return;
}

function drawBottom() {
	return '</div></div>' . draw_google_analytics('UA-80350-11') . '<!--' . DIRECTORY_ROOT . '--></body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}