<?php
extract(joshlib());

$pages = getPages();
if ($page = db_grab('SELECT id, title, content, description, side_caption, ' . db_updated() . ' FROM user_pages WHERE url = \'' . $request['path'] . '\' AND is_active = 1 AND is_published = 1')) {
	$page		= array_merge($page, getPage($page['id']));
	$section	= getSectionAncestor($page['id']);
}

function drawBreadcrumbs() {
	global $page;
	$thispage = $page;
	$breadcrumbs = array(draw_link($thispage['url'], $thispage['title']));
	while ($thispage['parent_id']) {
		$thispage = getPage($thispage['parent_id']);
		$breadcrumbs[] = draw_link($thispage['url'], $thispage['title']);
	}
	$return = '';
	$return .= draw_tag('nav', 'breadcrumbs', implode('&gt;', array_reverse($breadcrumbs)));
	return $return;
}

function drawContent($text) {
	//recursive function to scan for [system-insert xxxx]
	$split		= NEWLINE . NEWLINE . '<!-- split -->' . NEWLINE . NEWLINE;
	$pattern	= '[system-insert ';
	$position	= stripos($text, $pattern);
	if ($position === false) return $text;
	$return		= substr($text, 0, $position) . $split;
	$after		= substr($text, strlen($pattern) + $position);
	if ($function = stristr($after, ']', true)) {
		$return .= drawFunction($function) . $split;
		return $return . drawContent(substr($after, strlen($function) + 1));
	}
}

function drawFirst() {
	global $page, $pages;
	
	$color = getColor();
	
	$utility = db_table('SELECT p.url, p.title FROM user_utility_nav_options o JOIN user_pages p ON o.page_id = p.id WHERE o.is_published = 1 AND o.is_active = 1 AND p.is_published = 1 AND p.is_active = 1 ORDER BY o.precedence');
	
	$return = url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_chrome_frame() . 
		draw_title($page['title']) . 
		draw_meta_description($page['description']) . 
		'<meta name="viewport" content="width=device-width, initial-scale=1.0">' . 
		lib_get('bootstrap') .
		draw_css_src()
		//draw_css_src('/css/ie.css', 'ie')
	) . 
	draw_body_open() . 
	'<div class="container">
		<div class="row top">
			<div class="span12">' . draw_nav_nested($pages[0]['children']) . '</div>
		</div>
		<div class="row banner">
			<div class="span12">
				<a href="/" class="logo"><img src="/images/logo-' . strtolower($color['title']) . '.png" alt="logo" width="150" height="99" /></a>
				<div class="tagline">Promoting health through design</div>
				' . draw_nav(array_key_promote($utility), 'text', 'utility') . '
			</div>
		</div>';
	return $return;
}

function drawFunction($function) {
	switch($function) {
		case 'staff' :
		$staff = db_table('SELECT id, title, name, bio FROM user_staff WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
		foreach ($staff as &$s) $s = draw_div('photo') . draw_h2($s['name'] . ' ' . draw_span('title', $s['title']))  . $s['bio'];
		return draw_list($staff, 'staff');
		
		case 'contact-form' :
		
		$options = db_array('SELECT title FROM user_contact_professions WHERE is_active = 1 ORDER BY precedence');
		foreach ($options as &$o) $o = draw_tag('option', false, $o);
		$professions = implode('', $options);
		
		$options = db_array('SELECT title FROM user_contact_sectors WHERE is_active = 1 ORDER BY precedence');
		foreach ($options as &$o) $o = draw_tag('option', false, $o);
		$sectors = implode('', $options);
		
		return '
		<p>
		<i class="icon-map-marker"></i> <a href="http://maps.google.com/maps?q=30-30+Thomson+Avenue,+Long+Island+City,+New+York,+NY&hl=en&sll=40.744057,-73.936064&sspn=0.011412,0.020041&oq=30-30+Thomson+Street,+Long+Island+City+NY&gl=us&hnear=30-30+Thomson+Ave,+Queens,+New+York+11101&t=m&z=16">View Map</a><br>
		<i class="icon-envelope"></i> ' . draw_link('mailto:center@activedesign.us') . '<br>
		<i class="icon-volume-up"></i> <a href="tel:7185551212">(718) 555-1212</a>
		<br><br>
		</p>
		
		<form class="well contact">
			<h2>Contact Form</h2>
			
			<div><input type="text" class="span4" placeholder="Your name"></div>

			<div><input type="text" class="span4" placeholder="Your email address"></div>
			
			<div><select>
				<option selected="selected">Your profession</option>
				' . $professions . '
			</select></div>

			<div><select>
				<option selected="selected">Your professional sector</option>
				' . $sectors . '
			</select></div>

			<div><textarea placeholder="Type your message here."></textarea></div>
  
			<div><label class="checkbox">
				<input type="checkbox" checked="checked"> Add me to the mailing list
			</label></div>
  
			<button type="submit" class="btn">Submit</button>
		</form>';
		
		case 'in-the-news' :
		
		$categories = db_table('SELECT id, title FROM user_categories WHERE id <> 5 AND is_active = 1 ORDER BY title');
		foreach ($categories as &$c) $c = '<li><a data-id="' . $c['id'] . '">' . $c['title'] . '</a></li>';
		
		return draw_div('in-the-news',
			'<ul class="nav nav-pills">
				<li class="dropdown active">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">Filter by Category<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="active"><a href="#">All</a></li>
						<li class="divider"></li>
						' . implode('', $categories) . '
					</ul>
				</li>
			</ul>' . 
			draw_div('wrapper', drawInTheNews())
		);
		
		case 'support-form' :
		
		$options = db_array('SELECT title FROM user_contact_professions WHERE is_active = 1 ORDER BY precedence');
		foreach ($options as &$o) $o = draw_tag('option', false, $o);
		$professions = implode('', $options);
		
		$options = db_array('SELECT title FROM user_contact_sectors WHERE is_active = 1 ORDER BY precedence');
		foreach ($options as &$o) $o = draw_tag('option', false, $o);
		$sectors = implode('', $options);
		
		return '
		<form class="well contact">
			<h2>Make a Donation</h2>
			
			<div><input type="text" class="span4" placeholder="Your name"></div>

			<div><input type="text" class="span4" placeholder="Your email address"></div>

			<div class="input-prepend input-append">
				<span class="add-on">$</span><input class="span2" size="16" placeholder="0" type="text"><span class="add-on">.00</span>
			</div>
						
			<div><textarea placeholder="Type your message here."></textarea></div>
  
			<div><label class="checkbox">
				<input type="checkbox" checked="checked"> Add me to the mailing list
			</label></div>
  
			<button type="submit" class="btn">Submit</button>
		</form>';
		
	}
	error_handle('system-insert command not handled', 'The function ' . $function . ' was not handled.', __file__, __line__);	
}

function drawInTheNews($category_id=false) {
	if ($category_id) {
		$news = db_table('SELECT n.title, n.url, n.publication, n.date FROM user_news_to_categories n2c JOIN user_news n ON n2c.news_id = n.id WHERE n2c.categories_id = ' . $category_id . ' AND n.is_active = 1 AND n.is_published = 1 ORDER BY n.date DESC');
	} else {
		$news = db_table('SELECT title, url, publication, date FROM user_news WHERE is_active = 1 AND is_published = 1 ORDER BY date DESC');
	}
	foreach ($news as &$n) $n = 
			draw_h2(draw_link($n['url'], $n['title'])) . 
			draw_div('publication', $n['publication']) .
			draw_div('date', format_date($n['date']));

	return draw_list($news);
}

function drawLast() {
	global $pages;
	$footer_nav = array();
	foreach ($pages as $p) $footer_nav[$p['url']] = $p['title'];
	array_shift($footer_nav);
	$footer_nav['/faq/'] = 'FAQ';
	return '
		<div class="row footer_border">
			<div class="span12"></div>
		</div>
		<div class="row footer">
			<div class="span6 bottom_nav">
				' . draw_nav($footer_nav, 'text', false, 'path', false, false, false, '|') . '
			</div>
			<div class="span6 contact">
				<em>Center for Active Design</em> 30-30 Thomson Ave., 3rd Fl. L.I.C. NY 11101 &nbsp;T 718-391-1178
			</div>
		</div>
	</div>
	' . 
	draw_javascript_src('/js/global.js') . 
	cms_bar() . 
	'</body></html>';
}

function getColor() {
	global $page;
	if (!empty($page['color'])) return array('title'=>$page['color_title'], 'color'=>$page['color']);
	$thispage = $page;
	while ($thispage['parent_id']) {
		$thispage = getPage($thispage['parent_id']);
		if (!empty($thispage['color'])) return array('title'=>$thispage['color_title'], 'color'=>$thispage['color']);
	}
	return array('title'=>'Cyan', 'color'=>'#00aeef');
}

function getPage($page_id, $pages=false) {
	//recursive function to get page by id in the global pages array or a subset
	if (!$pages) global $pages;
	foreach ($pages as $p) {
		if ($p['id'] == $page_id) return $p;
		if (count($p['children']) && ($p = getPage($page_id, $p['children']))) return $p;
	}
	return false;
}

function getPages() {
	if (!function_exists('attachToParent')) {
		function attachToParent(&$array, $parent_id, $child) {
			foreach ($array as &$a) {
				if ($a['id'] == $parent_id) {
					$a['children'][] = $child;
					return true;
				} elseif (count($a['children']) && attachToParent($a['children'], $parent_id, $child)) {
					return true;
				}
			}
			return false;
		}	
	}
	$return = array();
	$pages = db_table('SELECT p.id, p.title, c.color, c.title color_title, p.parent_id, p.url, p.precedence, p.subsequence FROM user_pages p LEFT JOIN user_colors c ON p.color_id = c.id WHERE p.is_active = 1 AND p.is_published = 1 ORDER BY p.precedence');
	foreach ($pages as $p) {
		$p['children'] = array();
		if (empty($p['parent_id'])) {
			$return[] = $p;
		} elseif (attachToParent($return, $p['parent_id'], $p)) {
			//attached child to parent node
		} else {
			//an error occurred, because a parent exists but is not in the tree
		}
	}
	return $return;
}

function getSectionAncestor($page_id) {
	//return top page of the section, but don't return the home page
	$page = getPage($page_id);
	while (!empty($page['parent_id']) && $page['parent_id'] != 1) $page = getPage($page['parent_id']);
	return $page;
}

function joshlib() {
	//look for joshlib at joshlib/index.php, ../joshlib/index.php, all the way down
	global $_josh;
	$count = substr_count($_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'], '/');
	for ($i = 0; $i < $count; $i++) if (@include(str_repeat('../', $i) . 'joshlib/index.php')) return $_josh;
	die('Could not find Joshlib.');
}