<?php
include('include.php');

//test data
$_POST['payload'] = '{"pusher":{"name":"joshreisner","email":"josh@joshreisner.com"},"repository":{"name":"web","has_wiki":true,"size":173404,"created_at":"2012-05-25T07:33:53-07:00","private":false,"watchers":1,"language":"PHP","fork":false,"url":"https://github.com/joshreisner/web","pushed_at":"2012-06-02T09:15:44-07:00","open_issues":0,"has_downloads":true,"has_issues":true,"forks":1,"description":"some sites i\'\'m working on","owner":{"name":"joshreisner","email":"josh@joshreisner.com"}},"forced":false,"after":"79cca0fde6b08a23e200c97d6331529d41750265","head_commit":{"modified":["joshreisner.com/git/index.php"],"added":[],"removed":[],"author":{"name":"Josh Reisner","username":"joshreisner","email":"josh@joshreisner.com"},"timestamp":"2012-06-02T09:15:42-07:00","url":"https://github.com/joshreisner/web/commit/79cca0fde6b08a23e200c97d6331529d41750265","id":"79cca0fde6b08a23e200c97d6331529d41750265","distinct":true,"message":"last one for a while","committer":{"name":"Josh Reisner","username":"joshreisner","email":"josh@joshreisner.com"}},"deleted":false,"commits":[{"modified":["joshreisner.com/git/index.php"],"added":[],"removed":[],"author":{"name":"Josh Reisner","username":"joshreisner","email":"josh@joshreisner.com"},"timestamp":"2012-06-02T09:15:42-07:00","url":"https://github.com/joshreisner/web/commit/79cca0fde6b08a23e200c97d6331529d41750265","id":"79cca0fde6b08a23e200c97d6331529d41750265","distinct":true,"message":"last one for a while","committer":{"name":"Josh Reisner","username":"joshreisner","email":"josh@joshreisner.com"}}],"ref":"refs/heads/master","before":"e8b4d4a2c3d343b1c03f6a4fc55ce1941d56a939","compare":"https://github.com/joshreisner/web/compare/e8b4d4a...79cca0f","created":false}';
$_SERVER['REMOTE_ADDR'] = '207.97.227.253';
//*/

if (!empty($_POST['payload']) && in_array($_SERVER['REMOTE_ADDR'], array('207.97.227.253', '50.57.128.197', '108.171.174.178'))) {
	//incoming data is from valid github server
	
	$data = array_object(json_decode($_POST['payload']));

	$repository = $data['repository']['name'];
	
	$subject = 'new commit to ' . $repository;
	
	$body = draw_array($data);
	
	email('josh@joshreisner.com', $body, $subject);
}
?>
<h1>Git Auto-Deploy</h1>

<p>The purpose of this project is to hopefully catch post-commit webhooks from Github and auto-pull changes to a webserver.</p>

<p>This could be a terrible idea, btw.</p>