<?php
extract(joshlib());

include(DIRECTORY_ROOT . '/events/data.php');
include(DIRECTORY_ROOT . '/press/data.php');

function drawPress() {
	global $press, $_josh;
	$press = array_sort($press, 'desc', 'udate');
	$thispress = array_key_filter($press, 'link', $_josh['request']['path']);
	//die(draw_array($press));
	if (!count($thispress)) return false;
	$return = '<div class="press">' . draw_img('/images/right/press.png') . '<br><br>';
	foreach ($thispress as $p) $return .= draw_link('/press/pdfs/' . $p['pdf'], $p['publication']) . ' ' . format_date($p['udate'], '', '%m/%d/%y') . BR;
	$return .= '</div>';
	return $return;
}

function drawTop($title='Phantom Limb Company') {
	global $request;
	$return = url_header_utf8() . draw_doctype() . '<html>
		<head>' .
			draw_meta_utf8() .
			draw_title($title) .
			draw_favicon('/images/logo.png') . 
			draw_css_src('/style.css') . '
			<script type="text/javascript" src="/_site/lightbox/js/prototype.js"></script>
			<script type="text/javascript" src="/_site/lightbox/js/scriptaculous.js?load=effects,builder"></script>
			<script type="text/javascript" src="/_site/lightbox/js/lightbox.js"></script>

			<script type="text/javascript" src="http://use.typekit.com/clc2xmh.js"></script>
			<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

			<link rel="stylesheet" href="/_site/lightbox/css/lightbox.css" type="text/css" media="screen" />
		</head>
		' . draw_body_open() . '
		<div id="container">';
	$return .= draw_div('banner', draw_img('/images/logo.png', '/')) . 
			draw_div('navigation', draw_nav(array(
				'/'=>'Home',
				'/about/'=>'About',
				'/projects/'=>'Projects',
				'/collaborations/'=>'Collaborations',
				'/events/'=>'Events',
				'/press/'=>'Press',
				'/contact/'=>'Contact'
			), 'text', 'navigation', '/' . $request['folder'] . '/'));
	if (!home()) $return .= draw_div('header', draw_img($request['path'] . 'header.png'));
	return $return;
}

function drawBottom() {
	return '</div>' . 
	/* draw_div('footer', '
	<a class="twitter" href="http://twitter.com/#!/PhantomLimbCo"><span class="icon"></span>Follow us on Twitter</a>
	<a class="facebook" href="http://www.facebook.com/pages/Phantom-Limb-Company/167188836649776?v=wall"><span class="icon"></span>Follow us on Facebook</a>
	') . */
	'</body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}