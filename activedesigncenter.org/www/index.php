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
	$controller = array();
	$counter = 1;
	foreach ($carousel as &$c) {
		$controller[] = $counter;
		$counter++;
		$c = draw_div('item', draw_img(file_dynamic('user_carousel_items', 'image', $c['id'], 'jpg', $c['updated']), $c['url'], $c['caption']));
	}

	$thumbnails = db_table('SELECT t.id, t.title, p.url, ' . db_updated('t') . ' FROM user_thumbnails t JOIN user_pages p ON t.link_id = p.id WHERE t.is_active = 1 AND t.is_published = 1 ORDER BY t.precedence', 6);
	foreach ($thumbnails as &$t) {
		$t = draw_div_class('span2', 
			draw_img(file_dynamic('user_thumbnails', 'image', $t['id'], 'jpg', $t['updated']), $t['url'], $t['title']) . 
			draw_div('caption_hover', draw_div('inner', $t['title']))
		);
	}
	
	echo '
		<div class="row hero">
			<div class="carousel_wrapper">
				<div class="span8 carousel slide">' . draw_div('carousel-inner', implode('', $carousel)) . '</div>
				' . draw_list($controller, 'controller') . '
			</div>
			<div class="span4 facts">
				<div class="inner">' . $caption . '</div>
			</div>
		</div>
		<div class="row thumbnails">
			' . implode('', $thumbnails) . '
		</div>
		';
} elseif ($page) {
	cms_bar_link('/login/object/edit/?id=' . $page['id'] . '&object_id=1', 'Edit Page');
	cms_bar_link('/login/object/edit/?object_id=1', 'New Page');

	$side_images = db_table('SELECT id, title, ' . db_updated() . ' FROM user_side_images WHERE is_active = 1 AND is_published = 1 AND page_id = ' . $page['id'] . ' ORDER BY precedence');
	foreach ($side_images as &$s) $s = draw_img(file_dynamic('user_side_images', 'image', $s['id'], 'jpg', $s['updated'])) . draw_div_class('caption', $s['title']);
	
	if ($gallery_images = db_table('SELECT id, title, ' . db_updated() . ' FROM user_gallery_images WHERE is_active = 1 AND is_published = 1 AND page_id = ' . $page['id'] . ' ORDER BY precedence')) {
		foreach ($gallery_images as &$s) $s = draw_div('item', draw_img(file_dynamic('user_gallery_images', 'image', $s['id'], 'jpg', $s['updated'])) . draw_div_class('caption', draw_div_class('inner', $s['title'])));
		$gallery_images = draw_div('gallery carousel slide', implode('', $gallery_images));
	} elseif ($page['id'] == 4) { 
		cms_bar_link('/login/object/?id=21', 'Initiatives');
	
		$initiatives = db_table('SELECT id, title, location, description FROM user_initiatives WHERE is_active = 1 AND is_published = 1');
		foreach ($initiatives as &$i) {
			list($lat, $lng, $zoom) = explode(',', $i['location']);
			$i = 'map.addMarker({
				lat: ' . $lat . ',
				lng: ' . $lng . ',
				title: "' . $i['title'] . '",
				infoWindow: {
					content: "<div class=\'infowindow\'><h2>' . $i['title'] . '</h2>' . $i['description'] . '</div>"
				}
			});';
		}
		
		//initiatives page map
		$gallery_images = 
			drawFilter('user_case_study_categories') . 
			draw_javascript_src('http://maps.google.com/maps/api/js?sensor=true') . 
			draw_javascript_src('/js/gmaps.js') . 
			draw_javascript_ready('
				map = new GMaps({
					div: "#map",
					lat: 28.304380682962808,
					lng: 12.65625,
					mapTypeControl : false,
					scrollwheel: false,
					panControl : false,
					streetViewControl : false,
					zoomControl: true,
					zoom : 2,
					zoomControlOptions: {
						style: google.maps.ZoomControlStyle.SMALL
					}
				});
				' . implode('', $initiatives) . '
		') . 
		draw_div('#map');

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
				$icon = '<i class="icon-external-link"></i>';
				$r['type'] = 'link';
				$newwin = true;
			}
			$classes[] = $r['type'];
			$r = draw_link($r['url'], $icon . $r['title'], $newwin) . ' ' . $r['type'];
		}
		$resources = draw_div_class('resources', draw_h3('Resources') . draw_list($resources, 'resources', 'ul', false, $classes));
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
				<!--<div class="breadcrumbs">' . drawBreadcrumbs() . '</div>-->

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
	cms_bar_link('/login/object/edit/?object_id=1&url=' . $request['path'], 'New Page');

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