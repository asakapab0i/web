<?php
include('../include.php');

if (url_action('download')) {
	if (url_id() && $pdf = db_grab('SELECT id, title, pdf FROM user_magazines WHERE is_active = 1 AND id = ' . $_GET['id'])) {
		//file_download($pdf['pdf'], $pdf['title'], 'pdf');
		$filename = '/magazines/pdf/' . format_text_code($pdf['id'] . '_' . $pdf['title']) . '.pdf';
		file_put($filename, $pdf['pdf']);
		url_change($filename);
	} else {
		url_drop('action,id');
	}
} 

echo drawTop();

//get magazines from database
$magazines = db_table('SELECT id, title, (SELECT CASE WHEN pdf IS NULL THEN 0 ELSE 1 END) has_pdf, ' . db_updated() . ' FROM user_magazines WHERE is_active = 1 ORDER BY precedence');
foreach ($magazines as &$m) {
	$link = ($m['has_pdf']) ? url_query_add(array('action'=>'download', 'id'=>$m['id']), false) : false;
	$m = draw_img(file_dynamic('user_magazines', 'cover', $m['id'], 'jpg', $m['updated']), false, $m['title']);
	if ($link) $m = draw_link($link, $m, true);
}

//might need multiple pages
$pages = ceil(count($magazines) / 18);
echo draw_div('magazines', draw_list_sets($magazines, 18));

if ($pages > 1) {
	echo draw_div('magazines_pages', 
		draw_link('javascript:scroll_direction("left")', '&lt;') .
		draw_link('javascript:scroll_direction("right")', '&gt') .
		draw_container('span', '01', array('id'=>'counter')) . 
		draw_container('span', '/') . 
		draw_container('span', sprintf('%02d', $pages))
	);
	echo draw_javascript('scroll_init("magazines", ' . $pages . ', 820, true)');
}

echo drawBottom();
?>