<?php
include('../include.php');

echo drawTop();

$books = file_folder(false, '.jpg', true);
foreach ($books as &$b) $b = draw_img($b);
$pages = count($books);
echo draw_div('books', draw_list($books));

if ($pages > 1) {
	echo draw_div('books_pages', 
		draw_link('javascript:scroll_direction("left")', '&lt;') .
		draw_link('javascript:scroll_direction("right")', '&gt') .
		draw_container('span', '01', array('id'=>'counter')) . 
		draw_container('span', '/') . 
		draw_container('span', sprintf('%02d', $pages)) .
		draw_container('span', 'Product Design Now: Renderings Author, Cristian Campos Published by Harper Collins, 2010') 
	);
	echo draw_javascript('scroll_init("books", ' . $pages . ', 794, true)');
}

/* for making img
echo draw_div('book_column', '
The Spindle table is a tribute to two opposing styles: minimalism and ornamentalism.  The juxtaposition is not trying to be ironic or humoristic,
but respectful to the history and the importance of both styles.  Brad Ascalon Studio NYC considered dozens of possibilities and worked on a 
multitude of sketches, small models, and renderings before opting for the definitive model.  The table has been made from glass 0.39 inches thick,
laquered wood, and steel.  Measurements are 14.6 inches high, 49.2 inches long, and 16.9 inches wide.
', array('style'=>'width:407px;margin:20px;text-align:justify;')
);*/

echo drawBottom();
?>