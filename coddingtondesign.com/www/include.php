<?php
extract(joshlib());

function drawFirst($title=false, $project_description=false) {

	$projects = db_table('SELECT id, title FROM user_projects WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
	foreach ($projects as &$p) $p = array('url'=>'/projects/?id=' . $p['id'], 'title'=>$p['title'], 'children'=>array());

	$pages = array(
		array('url'=>'/projects/', 'title'=>'Projects', 'children'=>$projects),
		array('url'=>'/about/', 'title'=>'About', 'children'=>array()),
		//array('url'=>'/news/', 'title'=>'News', 'children'=>array()),
		array('url'=>'/services/', 'title'=>'Services', 'children'=>array()),
		array('url'=>'/room-service/', 'title'=>'Room Service', 'children'=>array(
			array('url'=>'/room-service/get-started/', 'title'=>'How to Get Started', 'children'=>array()),
			array('url'=>'/room-service/faq/', 'title'=>'Frequently Asked Questions', 'children'=>array()),
			array('url'=>'/room-service/prices/', 'title'=>'Price List', 'children'=>array())
		)),
		array('url'=>'/press/', 'title'=>'Press', 'children'=>array()),
		array('url'=>'/contact/', 'title'=>'Contact', 'children'=>array()),
		array('url'=>'http://girlymodern.com/', 'title'=>'Blog', 'children'=>array())
	);
	
	$return = url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_title($title) . 
		draw_css_src('/css/normalize.css') . 
		draw_css_src()
	) . 
	draw_body_open() . 
	'<div class="container">
		<div class="banner">
			' . draw_img('/images/logo.png', '/') . '
		</div>
		<div class="border">
			<div class="column"></div>
			<div class="column span3"></div>
		</div>
		<div class="page">
			<div class="column side">' . 
			draw_nav_nested($pages, 'nav', 1, 'path_query') . 
			($project_description ? draw_div('description', draw_div('border') . $project_description) : '') . 	
			'</div>
		';
	return $return;
}

function drawLast() {
	return '
		</div>
		<div class="border">
			<div class="column side_bottom"></div>
			<div class="column span3"></div>
		</div>
		<div class="row footer">
			<div class="column"></div>
			<div class="column span3">
				<a href="tel:4152852821" class="inherit">415 285 2821</a> San Francisco<br>
				<a href="tel:3108761060" class="inherit">310 876 1060</a> Los Angeles<br>
				' . draw_link('mailto:info@coddingtondesign.com') . '
			</div>
		</div>
	</div>
	' . 
	draw_javascript_src() . 
	draw_javascript_src('/js/global.js') . 
	cms_bar('990px') . 
	'</body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}