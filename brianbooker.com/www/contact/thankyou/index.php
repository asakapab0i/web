<?php
include('../../include.php');

echo drawTop('Thank You');

echo draw_div('left', draw_img('/contact/prospect-house-hotel.jpg') . draw_div_class('caption', 'The Prospect House Hotel, after its decline.'));

echo draw_div('page_right', draw_div_class('inner', 
	draw_container('h1', 'Thank You') . 'Thank you for contacting me.'
));

echo drawBottom();
?>