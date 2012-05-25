<?php
include('include.php');
echo drawFirst();

$modules = db_table('SELECT title, summary, content, bg_color, label_color, text_color, class_name, expandable, precedence FROM user_modules WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
foreach ($modules as &$m) {
	//class
	$class = 'module ' . $m['class_name'];
	if ($m['expandable']) $class .= ($m['precedence'] == 1) ? ' expanded' : ' expandable';
	
	//content
	if ($m['class_name'] == 'movies') {
		$video = db_grab('SELECT url FROM user_vimeo_movies WHERE is_active = 1 and is_published = 1 ORDER BY RAND()');
		$video = str_replace('http://vimeo.com', 'http://player.vimeo.com/video', $video);
		
		$content = '<iframe src="' . $video . '?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1" width="654" height="482" frameborder="0"></iframe>';
	} elseif ($m['class_name'] == 'demo') {
		$slides = db_table('SELECT id, title, ' . db_updated() . ' FROM user_demo_slides WHERE is_active = 1 ORDER BY precedence');
		foreach ($slides as &$s) $s = draw_img(file_dynamic('user_demo_slides', 'image', $s['id'], 'jpg', $s['updated']), false, $s['title']);
		$content = draw_list($slides, 'slideshow');
	} elseif ($m['class_name'] == 'signup') {
		$content = '
			<form id="signup"><input type="text" id="email" placeholder="your email"/><input type="submit" id="submit" value="GO!"/></form>
			<a id="twitter" href="http://twitter.com/#/moodtuner">Follow us on Twitter</a>
			<a id="facebook" href="http://www.facebook.com/MoodTuner">Like us on Facebook</a>' . 
			draw_link('mailto:hello@mood-tuner.com', 'hello@mood-tuner.com', false, array('id'=>'email'));
	} elseif ($m['class_name'] == 'store') {
		$content = draw_img('/assets/images/app-store.png', 'http://itunes.apple.com/us/app/mood-tuner/id482814519?mt=8');
	} elseif ($m['class_name'] == 'wallpapers') {
		$wallpapers = db_table('SELECT id, title, date, ' . db_updated() . ' from user_wallpapers WHERE is_published = 1 AND is_active = 1 ORDER BY date DESC');
		foreach ($wallpapers as &$w) {
			$w = 
				draw_img(file_dynamic('user_wallpapers', 'thumbnail', $w['id'], 'jpg', $w['updated'])) . 
				draw_div_class('title', $w['title']) . 
				draw_div_class('date', format_date($w['date'], '', false, false)) . 
				draw_div_class('links',
					draw_link(file_dynamic('user_wallpapers', 'iphone', $w['id'], 'jpg', $w['updated']), '320 &times; 480', true) . ' | ' . 
					draw_link(file_dynamic('user_wallpapers', 'iphone_retina', $w['id'], 'jpg', $w['updated']), '640 &times; 960', true) . ' | ' . 
					draw_link(file_dynamic('user_wallpapers', 'ipad', $w['id'], 'jpg', $w['updated']), '1024 &times; 768', true)
				);
		}
		$content = draw_div_class('content jscrollpane', draw_div_class('tinymce', $m['content']) . draw_list($wallpapers));
	} else {
		//eg about, people, news
		$content = draw_div_class('summary tinymce', $m['summary']) . draw_div_class('content jscrollpane tinymce', $m['content']);
	}

	//output
	echo draw_div_class($class, draw_small($m['title'], array('style'=>'color:' . $m['label_color'])) . draw_div_class('inner', $content), array('style'=>'background-color:' . $m['bg_color'] . '; color:' . $m['text_color']));
}

echo drawLast();