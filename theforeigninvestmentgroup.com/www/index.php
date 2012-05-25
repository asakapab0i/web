<?php
include('include.php');

if ($page = db_grab('SELECT id, title, pull_quote, content FROM user_pages WHERE is_published = 1 AND is_active = 1 AND url = "' . $request['path'] . '" ORDER BY precedence')) {
	cms_bar_link('/login/object/edit/?id=' . $page['id'] . '&object_id=1', 'Edit Page');
	//a page was found for this address
	echo drawTop($page['title']);
	echo draw_div('left', $page['pull_quote']);
	echo draw_div('right', $page['content']);
} else {
	//404
	echo drawTop('Page Not Found');
	echo draw_div('left', '&nbsp;');
	echo draw_div('right', 'Sorry, the page you requested could not be found.');
}

echo drawBottom();