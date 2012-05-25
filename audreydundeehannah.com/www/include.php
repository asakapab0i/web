<?php
extract(joshlib());

function drawTop($title="Audrey Dundee Hannah") {
	global $request;
	$pages = array('/about/'=>'About', '/contact/'=>'contact');
	$return = url_header_utf8() . '
	<head>
		' . draw_meta_utf8() . '
		<title>' . $title . '</title>
		' . draw_css_src("/styles/screen.css") . '
		<script type="text/javascript" src="/_site/lightbox/js/prototype.js"></script>
		<script type="text/javascript" src="/_site/lightbox/js/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/_site/lightbox/js/lightbox.js"></script>
		<link rel="stylesheet" href="/_site/lightbox/css/lightbox.css" type="text/css" media="screen" />
	</head>
	<body>
		<div id="container">
			<div id="banner">
			' . draw_img("/images/name.png", "/", array("id"=>"name")) .
			draw_nav($pages, 'rollovers') . '
			</div>
			<div id="content">';
	return $return;
}

function drawBottom() {
	global $year;
	return '</div></div>' . draw_div('footer', 'Copyright &copy; 2009&ndash;' . $year . ' Audrey Dundee Hannah') . draw_google_analytics("UA-80350-16") . '</body></html>';
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}