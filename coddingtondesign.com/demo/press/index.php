<?php
include('../include.php');

echo drawFirst('Press');

cms_bar_link('/login/object/?id=7', 'Edit Press');

echo '<div class="column span3"><div class="row press">';

$press = db_table('SELECT id, title, link, date, (CASE WHEN pdf IS NULL THEN 0 ELSE 1 END) has_pdf, ' . db_updated() . ' FROM user_press WHERE is_active = 1 AND is_published = 1 ORDER BY date DESC');

$counter = 0;
foreach ($press as $p) {
	$counter++;
	$class = 'column';
	$more = 'Read Full Article';
	if ($p['has_pdf']) {
		$p['link'] = file_dynamic('user_press', 'pdf', $p['id'], 'pdf', $p['updated']);
		$more = 'Download PDF';
	}
	echo draw_div_class($class, 
		draw_img(file_dynamic('user_press', 'image', $p['id'], 'jpg', $p['updated']), $p['link'], false, false, true) .
		draw_p($p['title'] . ' (' . format_date($p['date'], false, '%B %Y') . ')' . BR . draw_link($p['link'], $more, true) . ' >', 'press')
	);
}

echo '</div></div>';

echo drawLast();