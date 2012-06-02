<?php
include('include.php');

if (!empty($_POST['payload']) && in_array($_SERVER['REMOTE_ADDR'], array('207.97.227.253', '50.57.128.197', '108.171.174.178'))) {
	//incoming data is from valid github server
	
	$subject = 'New Commit Report';
	$body = draw_array(json_decode($_POST['payload']));
		
	email('josh@joshreisner.com', $body, $subject);
}
?>
<h1>Git Auto-Deploy</h1>

<p>The purpose of this project is to hopefully catch post-commit webhooks from Github and auto-pull changes to a webserver.</p>

<p>This could be a terrible idea, btw.</p>