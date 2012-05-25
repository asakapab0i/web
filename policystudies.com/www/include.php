<?php
//get library
extract(joshlib());

//text snippets from database, cached in this array
$snippets = array();

//if (!empty($_COOKIE['secret_key'])) @session_start();

//define sections for navigation
$sections = array(
	'/'=>'Home',
	'/about/'=>'About',
	'/studies/'=>'Studies',
	'/staff/'=>'Staff',
	'/jobs/'=>'Jobs',
	'/contact/'=>'Contact'
);

//need this in two places, on the home page and in drawTop
$google_form = '<form id="google" onsubmit="javascript:return google_search(this);"><input type="text" name="q" value="Google Search" onfocus="form_field_default(this, true, \'Google Search\')" onblur="form_field_default(this, false, \'Google Search\')"/></form>';

function drawTop($title=false) {
	global $request, $sections, $google_form;
	
	//define default title
	if (!$title) $title = 'Policy Studies Associates';
	
	//start output
	$return = url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_container('title', $title) . 
		draw_meta_description(drawSnippet(1, false)) . 
		draw_css_src() . 
		draw_css_src('/styles/print.css', 'print') . 
		draw_javascript_src() . 
		draw_javascript_src('/javascript.js')
	) . draw_body_open();
	
	//if we're not on the home page, write some more html, such as logo, navigation, etc
	if (!home()) {
		//prepend folder link to h1
		$title = draw_container('h1', $title);
		if ($request['path_query'] != '/' . $request['folder'] . '/') {
			$title = draw_link('/' . $request['folder'] . '/', format_title($request['folder'])) . draw_div_class('detail', $title);
		}
		$return .= draw_div_open('container') . draw_div('banner', draw_img('/images/logo-banner.png', '/') . $google_form . draw_nav($sections)) . '<div id="page"><div id="inner">' . draw_div_class('header', $title);
	}
	return $return;
}

function drawBottom() {
	global $request, $year;
	return (($request['folder']) ? draw_div('footer', 'Copyright &copy; ' . $year . ' Policy Studies Associates, Inc.') . '</div></div></div>' : '') . draw_google_analytics('UA-80350-19') . '</body></html>';
}

function drawSnippet($id, $editable=true) {
	global $snippets, $request;
	if (!isset($snippets[$id])) $snippets[$id] = db_grab('SELECT snippet FROM user_snippets WHERE id = ' . $id);
	if (!user() || !$editable) return draw_div('snippet_' . $id, $snippets[$id]);
	return draw_div('snippet_' . $id, $snippets[$id], array('class'=>'snippet', 'onclick'=>'location.href="/login/object/edit/?id=' . $id . '&object_id=7&return_to=' . rawurlencode($request['path_query']) . '"'));
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}