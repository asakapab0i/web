<?php
include('include.php');

//configuration
$email			= false;
$repositories	= array(
	'joshlib'=>array(
		'path'=>'~/git/joshlib',
		'deploy'=>'~/joshlib'
	),
	'bb-login'=>array(
		'path'=>'~/git/bb-login',
		'deploy'=>'~/bb-login'
	)
);

//check whether post from a valid github server
if (!empty($_POST['payload']) && in_array($_SERVER['REMOTE_ADDR'], array('207.97.227.253', '50.57.128.197', '108.171.174.178'))) {

	//get repo name
	$data		= array_object(json_decode($_POST['payload']));
	$repository	= $data['repository']['name'];

	//update git, deploy to directory
	if (array_key_exists($repository, $repositories)) {
		$message = 'attempting to deploy from ' . $repositories[$repository]['path'] . ' to ' . $repositories[$repository]['deploy'];
		$message .= exec('whoami;cd ' . $repositories[$repository]['path'] . ';git fetch upstream;git merge upstream/master;git archive master | tar -x -C ' . $repositories[$repository]['deploy']);
	} else {
		$message = 'could not find definition for repo ' . $repository;		
	}
	
	//send email if configured
	if ($email) email($email, $message . draw_array($data), 'new commit to ' . $repository);		
}