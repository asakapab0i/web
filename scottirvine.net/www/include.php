<?php
extract(joshlib());

function drawTop($title="Scott Irvine Photography") {
	$return = '<html>
		<head>
			<title>' . $title . '</title>
			<link rel="stylesheet" href="/styles/screen.css">
		</head>
		<body>';
	return $return;
}

function drawBottom() {
	$return = draw_google_tracker("UA-80350-7") . '</body>
	</html>';
	return $return;
}

function joshlib() {
	global $_josh;
	$possibilities = array(
		"/home/irvine/www/www/_site/joshlib/index.php", //icdsoft
		"/Users/joshreisner/Sites/joshlib/index.php" //macbook
	);
	foreach ($possibilities as $p) if (@include($p)) return $_josh;
	die("Can't locate library! " . $_SERVER["DOCUMENT_ROOT"]);
}

?>