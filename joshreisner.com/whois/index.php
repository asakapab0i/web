<?php

extract(joshlib());

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}

if (isset($_GET['whois'])) {
	$site = url_parse($_GET['whois']);
	url_change('http://www.networksolutions.com/whois-search/' . $site['domain']);
}

?>
<html>
	<head>
		<title>WHOIS Bookmarklet</title>
		<style type="text/css">
			body { background-color: #e2e1e0; font-family: Helvetica, sans-serif; font-size: 18px; margin: 0; width: 100%; height: 100%; color: #333; }
			#container { width: 500px; height:200px; position: absolute; top: 50%; left: 50%; margin: -120px 0 0 -270px; padding: 20px; background-color: #fff; }
			#container h1 { margin: 0; }
			a.bookmarklet { color: #fff; border: 1px solid #333; background-color:#555; padding: 4px 9px; text-decoration: none; }
		</style>
	</head>
	<body>
		<div id="container">
			<h1>WHOIS Bookmarklet</h1>
			<p>Drag this link <a title="WHOIS" name="WHOIS" class="bookmarklet" href="javascript:location.href='http://whois.joshreisner.com/?whois='+window.location.host">WHOIS</a> to your browser's bookmarks bar.</p>
			<p>Then, when you're on a site and you want to see the WHOIS info for that site, just click that bookmark.</p>
		</div>
	</body>
</html>
