<?php
include('../include.php');

if (url_id()) {
	$j = db_grab('SELECT title, description FROM user_jobs WHERE id = ' . $_GET['id']);
	echo drawTop($j['title']) . $j['description'];
	echo draw_container('p', draw_link('./', '&lt; Go Back'));
} else {
	echo drawTop('Jobs');
	
	echo drawSnippet(5);
	
	if ($jobs = db_table('SELECT t.id, t.title FROM user_jobs t WHERE t.is_active = 1 AND t.is_published = 1 ORDER BY t.precedence')) {
		foreach ($jobs as &$j) $j = draw_link('/jobs/?id=' . $j['id'], $j['title']);
		echo draw_container('h3', 'Current Open Positions') . draw_list($jobs);
	}
}

echo drawBottom();
?>