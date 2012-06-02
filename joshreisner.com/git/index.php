<?php
if (!empty($_POST['payload']) && in_array($_SERVER['REMOTE_ADDR'], array('207.97.227.253', '50.57.128.197', '108.171.174.178'))) {
	//incoming data is from valid github server
	
	$data = $_POST['payload']; 
	
	$subject = count($data['commits']) . " new commits";
	$body = "New code has been committed to the project: \n"; 
	
	foreach($data['commit'] as $commit) { 
		$body .= "Commit: " . $commit['id'] . "\n"; 
		$body .= $commit['message'] . "\n\n"; 
	} 
	
	$body .= '<pre>' . var_export($data) . '</pre><hr>';
		
	mail('josh@joshreisner.com', $subject, $body);
}

echo '<h1>Hi There</h1>';