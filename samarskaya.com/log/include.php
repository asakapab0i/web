<?php
extract(joshlib());

$snippets = array_key_promote(db_table('SELECT title, content FROM user_snippets WHERE is_active = 1'));

function drawPosts($posts, $terms=false) {
	global $request;
	$return = '';
	foreach ($posts as $p) {
		$meta = array();

		//add images, if applicable
		if ($p['images'] ) $meta[] = draw_link(false, 'Images', false, array('class'=>'images', 'name'=>$p['id']));
				
		//add links if applicable
		if ($p['links']) {
			$links = db_table('SELECT title, url FROM user_links WHERE post_id = ' . $p['id'] . ' AND is_active = 1 ORDER BY precedence');
			foreach ($links as &$l) $l = draw_link($l['url'], $l['title']);
			$meta = array_merge($meta, $links);
		}
		
		//permalink
		if (url_id()) {
			$meta[] = draw_link('/', 'Return to All Posts', false, array('rel'=>$p['id']));
		} else {
			$link = ($p['url']) ? $p['url'] : '/?id=' . $p['id'];
			$meta[] = draw_link($link, 'Permalink', false, array('class'=>'permalink', 'rel'=>$p['id']));
		}
		
		$meta[] = draw_link('https://twitter.com/intent/tweet?url=' . urlencode(url_base() . $link), 'Twitter', true, array('class'=>'twitter', 'rel'=>$p['id']));
		$meta[] = draw_link('http://www.facebook.com/sharer.php?u=' . urlencode(url_base() . $link) . '&t=' . urlencode($p['title']), 'Facebook', true, array('class'=>'facebook', 'rel'=>$p['id']));
		
		//add admin, if applicable
		if (user()) $meta[] = draw_link('/login/object/edit/?id=' . $p['id'] . '&object_id=4', 'edit', false, 'admin');
		
		//output
		$return .=	file_dynamic('user_posts', 'image', $p['id'], $p['image_type'], $p['updated']) . draw_img(file_dynamic('user_posts', 'image_1', $p['id'], $p['image_type'], $p['updated'])) .
					draw_p(format_date($p['date'], '', '%B %Y', false), 'date post_' . $p['id']) . 
					format_highlight($p['content'], $terms) . 
					draw_p('<span>[</span>' . implode('<span>|</span>', $meta) . '<span>]</span>', 'meta');
	}
	return $return;
}

function getPosts($id=false) {
	if ($id) $id = ' AND id = ' . $id;
	return db_table('SELECT 
			p.id, 
			p.title, 
			p.content, 
			p.date,
			(SELECT COUNT(*) FROM user_links l WHERE l.is_active = 1 AND l.post_id = p.id) links,
			(SELECT COUNT(*) FROM user_images i WHERE i.is_active = 1 AND i.post_id = p.id) images,
			' . db_updated('p') . ',
			p.image_type,
			p.url
		FROM user_posts p
		WHERE p.is_published = 1 AND p.is_active = 1 ' . $id . '
		ORDER BY p.date DESC');
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}