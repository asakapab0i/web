<?php
extract(joshlib());

function drawFirst($title='') {

	$return = url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_title($title) . 
		lib_get('bootstrap') .
		draw_css_src()
	) . 
	draw_body_open() . 
	'<div class="container">
		<div class="row banner">
			<div class="span12">
				<img src="/images/logo.png" alt="logo" width="580" height="52" />
			</div>
		</div>';
	return $return;
}

function drawLast() {
	return '
		<div class="row footer">
			<div class="span6 bottom_nav">
			</div>
			<div class="span6 contact">
			</div>
		</div>
	</div>
	' . 
		draw_javascript_src() . 
		draw_javascript_src('/js/global.js') . 
		cms_bar() . 
	'</body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}