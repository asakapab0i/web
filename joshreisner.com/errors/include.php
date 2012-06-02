<?php
extract(joshlib());

function drawErrors() {
	$errors = db_table('SELECT app_name, title, description, created_date, user_name, user_email FROM errors ORDER BY created_date DESC');
	foreach ($errors as &$e) {
		$e['created_date'] = format_date($e['created_date']);
		$e['#'] = '<span class="badge">1</span>';
	}
	
	$t = new table();
	$t->set_column('#');
	$t->set_column('app_name');
	$t->set_column('title');
	$t->set_column('created_date');
	$t->set_column('user_name');
	return $t->draw($errors);
}

function drawFirst() {
	$return = url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_title() . 
		lib_get('bootstrap') . 
		draw_css_src() . 
		draw_javascript_src('/js/global.js')
	) . draw_body_open() . draw_div_class_open('container');
	return $return;
}

function drawLast() {
	echo '</div></body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}