<?php
include('../include.php');
$images = db_table('SELECT id, title, ' . db_updated() . ' FROM user_images WHERE is_active = 1 AND post_id = ' . $_GET['id']);
foreach ($images as &$i) {
	$filename = file_dynamic('user_images', 'image', $i['id'], 'jpg', $i['updated']);
	list($width, $height, $type, $attr) = getimagesize(DIRECTORY_ROOT . $filename);
	$i = draw_container('image', 
		draw_container('id', $i['id']) . 
		draw_container('title', $i['title']) . 
		draw_container('filename', $filename) . 
		draw_container('width', $width) . 
		draw_container('height', $height)
	);
}
echo header('Content-Type:text/xml') . '<?xml version="1.0" encoding="utf-8" ?>' . draw_container('images', implode(NEWLINE, $images));
?>