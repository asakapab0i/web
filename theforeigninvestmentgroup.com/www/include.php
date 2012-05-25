<?php
extract(joshlib());

function drawTop($title='The Foreign Investment Group') {
	//get pages from cms
	$pages = getPages();
	
	//start output
	return url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_container('title', $title) . 
		//draw_meta_description(db_grab('SELECT snippet FROM user_snippets WHERE id = 1')) . 
		draw_css_src('/css/global.css') . 
		lib_get('jquery') .
		draw_javascript_src('/js/global.js') . 
		draw_javascript_src()
	) . 
	draw_body_open() . 
	draw_div_open('bg') . 
	draw_div_open('container') . 
	draw_div('header', draw_img('/images/logo.png', '/') . draw_nav_nested($pages)) . 
	draw_div_open('page');
}

function drawBottom() {
	return '</div></div></div>' . cms_bar('796px') . '</body></html>';
}

function getPages() {
	if (!function_exists('attachToParent')) {
		function attachToParent(&$array, $parent_id, $child) {
			foreach ($array as &$a) {
				if ($a['id'] == $parent_id) {
					$a['children'][] = $child;
					return true;
				} elseif (count($a['children']) && attachToParent($a['children'], $parent_id, $child)) {
					return true;
				}
			}
			return false;
		}	
	}
	$return = array();
	$pages = db_table('SELECT id, title, parent_id, url, precedence, subsequence FROM user_pages WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
	foreach ($pages as $p) {
		$p['children'] = array();
		if (empty($p['parent_id'])) {
			$return[] = $p;
		} elseif (attachToParent(&$return, $p['parent_id'], $p)) {
			//attached child to parent node
		} else {
			//an error occurred, because a parent exists but is not in the tree
		}
	}
	return $return;
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}