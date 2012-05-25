<?php
extract(joshlib());

function drawTop($title='Coddington Design', $caption=false) {
	global $request;
	$return = draw_doctype() . 
		draw_container('head', 
			draw_meta_utf8() .
			draw_container('title', (home() ? 'Coddington Design' : $title)) .
			draw_css_src() . 
			draw_javascript_src() . 
			draw_javascript_src('/javascript.js')
		) .
		draw_body_open() . '
			<div id="container">
				<div id="banner">';

	//don't show the title on the home page
	$return .= draw_div('title', $title) . 
		'</div>
				<div id="border">' . draw_img('/images/border.png') . '</div>
				
			<div id="left">
				<div id="logo">' . draw_img('/images/logo.png', '/') . '</div>
				<ul class="nav">';
	$sections = array(
		'/projects/'=>'Selected Projects',
		'/about/'=>'About',
		//'/news/'=>'News',
		'/press/'=>'Press',
		'/services/'=>'Services',
		'/contact/'=>'Contact',
		'http://girlymodern.com/'=>'Blog'	
	);
	foreach ($sections as $folder=>$name) {
		$class = ($folder == '/' . $request['folder'] . '/') ? 'selected' : false;
		$link = draw_link($folder, $name, false, array('class'=>$class));
		if (($request['folder'] == 'projects') && ($folder == '/projects/')) {
			$link .= draw_nav('SELECT CONCAT("/projects/?id=", id), title FROM user_projects WHERE is_active = 1 AND is_published = 1 ORDER BY precedence', 'text', 'subnavigation', 'path_query');
		} elseif (($request['folder'] == 'services') && ($folder == '/services/')) {
			$subsections = array(
				'/services/e-consulting/'=>'E-Consulting Room Service'
			);
			$link .= draw_nav($subsections, 'text', 'subnavigation');
		}
		$return .= draw_tag('li', array('class'=>$class), $link);
	}
	$return .= '</ul>';
	if ($caption) $return .= '<div id="caption">' . $caption . '</div>';
	$return .= '</div><div id="right">';
	return $return;
}

function drawBottom() {
	return '</div>' .
		draw_div('footer', 
			draw_div('inner', '
				415 285 2821&nbsp;&nbsp;<span style="color:#999;">San Francisco</span><br/>
				310 876 1060&nbsp;&nbsp;<span style="color:#999;">Los Angeles</span><br/>' . draw_link('mailto:info@coddingtondesign.com'))
		) . '</div>' . 
		draw_google_analytics('UA-21627032-1') . '
		</body>
	</html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, ../../joshlib.index.php, etc all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}