<?php
include('include.php');

//custom urls
if (!home() && !url_id() && !$_GET['id'] = db_grab('SELECT id FROM user_posts WHERE url = \'' . $request['path'] . '\'')) url_change('/missing.html');

$title	= db_grab('SELECT title FROM user_greetings WHERE is_published = 1 AND is_active = 1 ORDER BY RAND()');
$cron	= db_grab('SELECT weather, news, news_date FROM cron');
$posts	= getPosts(url_id());

echo url_header_utf8() . draw_doctype() . draw_container('head',
		draw_meta_utf8() . 
		draw_container('title', $title) . 
		draw_meta_description($snippets['Meta Description']) . 
		draw_meta_keywords($snippets['Meta Keywords']) . 
		draw_favicon('/assets/icons/favicon.ico') . 
		'<meta name="viewport" content="width=420, initial-scale=1" />
		<link rel="apple-touch-icon" href="/assets/icons/apple-touch-icon-57.png"/>
		<link rel="apple-touch-icon" sizes="72x72" href="/assets/icons/apple-touch-icon-72.png"/>
		<link rel="apple-touch-icon" sizes="114x114" href="/assets/icons/apple-touch-icon-114.png"/>' . 
		draw_css_src('/css/global.css') . 
		draw_rss_link('/rss.php') . 
		lib_get('jquery') .
		draw_javascript_src('/js/jquery-ui-1.8.11.custom.min.js') . 
		draw_javascript_src('/js/jquery.scrollTo-min.js') . 
		draw_javascript_src('/js/global.js') . 
		draw_javascript_src()
	) . 
	draw_body_open() . 
	draw_div_open('source');

echo draw_div('intro',
	draw_p('G&#8217;Day') . 
	draw_p(
		'Welcome to samarskaya.com, a gateway and accumulation of various projects and initiatives that I have been involved with. Am based in Brooklyn, NY where it is ' . 
		draw_span('em', $cron['weather']) . 
		' Generally, input exceeds output, but the latest updates on are ' . 
		draw_span('em', $posts[0]['title']) . ' (' . format_date($posts[0]['date'], '', false, false) . ') 
		and out beyond this site ' .
		draw_span('em', $cron['news']) . ' (' . format_date($cron['news_date'], '', false, false) . ').'
	) . 
	draw_list(array(
			draw_link('tel:5304307734', draw_img('/assets/images/telephone.gif') . draw_img('/assets/images/telephone-number.gif')),
			draw_link('mailto:info@samarskaya.com', draw_img('/assets/images/electronicmail.gif') . draw_img('/assets/images/electronicmail-address.gif')),
			draw_link('http://twitter.com/#!/samarskaya', draw_img('/assets/images/twitter.gif') . draw_img('/assets/images/twitter-handle.gif'))
	), 'contact') . 
	 draw_p('copywrite 2006&ndash;' . $year . '. ' . 
		draw_span('mobile', 'You&#8217;re currently viewing a truncated version of the log. For the full experience, which includes photographs of the glossed-over work, please visit from a supported browser.') .
		draw_span('controls', 
			draw_span('search', draw_link('#search', 'Search', false, 'search') . ', ') .
			draw_span('clear', draw_link('/', 'Clear Results') . ', ') . 
			' navigate [&larr;] [&rarr;] or follow via ' . 
			draw_link('/rss.php', 'RSS') . '. '
		)
	, 'copyright')
);

echo drawPosts($posts);

echo '</div>' . 
	draw_div('target') . 
	draw_link(false, draw_img('/assets/images/div_close.png') . 'CLOSE ALL IMAGES', false, 'close_all') . 
	draw_google_analytics('UA-275571-1') . '
	</body></html>';