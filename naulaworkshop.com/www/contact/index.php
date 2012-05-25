<?php
include('../include.php');
echo drawTop();
echo draw_div('contact', 
	draw_p('NAULA WORKSHOP' . BR . 'Showroom & Offices') . 
	draw_p('349 Suydam Street' . BR . 'Fourth Floor' . BR . 'Brooklyn, NY 11237') . 
	draw_p('Phone: 718.628.1912' . BR . 'Fax: 718.628.1916') . 
	draw_p('For general inquiries' . BR . draw_link('mailto:info@naulaworkshop.com')) . 
	draw_p('For press inquiries' . BR . draw_link('mailto:press@naulaworkshop.com')) . 
	draw_p(draw_img('facebook-icon.png', 'http://www.facebook.com/pages/Naula-Workshop/205974514756'))
);
echo draw_img('showroom.jpg', false, array('class'=>'showroom'));
echo drawBottom();
?>