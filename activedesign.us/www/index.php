<?php
include('include.php');

if (!home() && !$page) header("HTTP/1.0 404 Not Found");

echo drawFirst();

if (home()) {
	cms_bar_link('/login/object/?id=2', 'Carousel');
	cms_bar_link('/login/object/?id=9', 'Thumbnails');
	
	//get items for carousel
	$carousel = db_table('SELECT c.id, c.caption, p.url, ' . db_updated('c') . ' FROM user_carousel_items c JOIN user_pages p ON c.page_id = p.id WHERE c.is_published = 1 AND c.is_active = 1 ORDER BY c.precedence');
	$caption = $carousel[0]['caption'];
	foreach ($carousel as &$c) $c = draw_img(file_dynamic('user_carousel_items', 'image', $c['id'], 'jpg', $c['updated']), $c['url'], $c['caption']);

	$thumbnails = db_table('SELECT t.id, t.title, p.url, ' . db_updated('t') . ' FROM user_thumbnails t JOIN user_pages p ON t.link_id = p.id WHERE t.is_active = 1 AND t.is_published = 1 ORDER BY t.precedence', 6);
	$titles = array();
	foreach ($thumbnails as &$t) {
		$titles[] = draw_div_class('span2', $t['title']); 
		$t = draw_div_class('span2', draw_img(file_dynamic('user_thumbnails', 'image', $t['id'], 'jpg', $t['updated']), $t['url'], $t['title']));
	}
	
	echo '
		<div class="row hero">
			<div class="span8 carousel">' . draw_list($carousel, array('class'=>'slideshow auto', 'data-timer'=>8000)) . '&nbsp;</div>
			<div class="span4 facts">
				<div class="inner">' . $caption . '</div>
			</div>
		</div>
		<div class="row thumbnails_head">
			' . implode('', $titles) . '
		</div>
		<div class="row thumbnails">
			' . implode('', $thumbnails) . '
		</div>
		';
} elseif ($page) {
	$side_images = db_table('SELECT id, title, ' . db_updated() . ' FROM user_side_images WHERE is_active = 1 AND is_published = 1 AND page_id = ' . $page['id'] . ' ORDER BY precedence');
	foreach ($side_images as &$s) $s = draw_img(file_dynamic('user_side_images', 'image', $s['id'], 'jpg', $s['updated'])) . draw_div_class('caption', $s['title']);
	
	if ($gallery_images = db_table('SELECT id, title, ' . db_updated() . ' FROM user_gallery_images WHERE is_active = 1 AND is_published = 1 AND page_id = ' . $page['id'] . ' ORDER BY precedence')) {
		foreach ($gallery_images as &$s) $s = draw_img(file_dynamic('user_gallery_images', 'image', $s['id'], 'jpg', $s['updated'])) . draw_div_class('caption', draw_div_class('inner', $s['title']));
		$gallery_images = draw_div_class('gallery', draw_list($gallery_images, 'slideshow'));
	} else {
		$gallery_images = false;
	}
	
	if ($resources = db_table('SELECT id, title, type, url FROM user_resources WHERE is_active = 1 AND is_published = 1 AND page_id = ' . $page['id'] . ' ORDER BY precedence')) {
		$classes = array();
		foreach ($resources as &$r) {
			if ($r['type']) {
				$icon = file_icon($r['type']);
				$r['url'] = '/dl/?id=' . $r['id'];
				$newwin = false;
			} else {
				$icon = draw_img('/images/link.png');
				$r['type'] = 'link';
				$newwin = true;
			}
			$classes[] = $r['type'];
			$r = draw_link($r['url'], $icon . $r['title'], $newwin) . ' ' . $r['type'];
		}
		$resources = draw_div_class('resources', draw_h3('Related Resources') . draw_list($resources, 'resources', 'ul', false, $classes));
	} else {
		$resources = false;
	}
	
	$is_section = ($page['id'] == $section['id']);
	
	echo '
		<div class="row page">
			<div class="span2 side_nav">
				<a class="section' . ($is_section ? ' selected' : '') . '" href="' . $section['url'] . '">' . $section['title'] . '</a>
				' . draw_nav_nested($section['children'], false) . '&nbsp;
			</div>
			<div class="span10 content">
				<div class="breadcrumbs">' . drawBreadcrumbs() . '</div>

				<h1>' . $page['title'] . '</h1>

				' . $gallery_images . '

				<div class="text span6">
					' . drawContent($page['content']) . '&nbsp;
				</div>

				<div class="side span4">
					' . $resources . draw_list($side_images, 'side_images') . '&nbsp;
				</div>
			</div>
		</div>
		';
} else {
	//404 error
	cms_bar_link('/login/object/edit/?object_id=1&url=' . $request['path'], 'Create Page Here');

	echo '
		<div class="row page">
			<div class="span2">&nbsp;</div>
			<div class="span10 content">
				<h1>404: Page Not Found</h1>
				<p>We could not find what you were looking for.  Please visit the <a href="/">Home Page</a> or the <a href="/map/">Site Map</a>.</p>
			</div>
		</div>';
}

echo drawLast();