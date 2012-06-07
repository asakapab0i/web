<?php
include('../include.php');
echo drawTop();
echo draw_div('contact', 
	draw_p('<strong>Naula Showroom</strong>' . BR . '349 Suydam Street' . BR . 'Third Floor' . BR . 'Brooklyn, NY 11237' . BR . 'T: 212.470.6796') . 
	draw_p('<strong>Naula Offices</strong>' . BR . '349 Suydam Street' . BR . 'Fourth Floor' . BR . 'Brooklyn, NY 11237' . BR . 'T: 718.628.1912' . BR . 'F: 718.628.1916') . 
	draw_p('For general inquiries' . BR . draw_link('mailto:michael@naulaworkshop.com')) . 
	draw_p('For showroom appointments' . BR . draw_link('mailto:showroom@naulaworkshop.com')) . 
	draw_p('For press inquiries' . BR . draw_link('mailto:kai@naulaworkshop.com')) . 
	draw_p('
			<ul class="social">
				<li><a href="http://www.facebook.com/NaulaWorkshop"><i class="icon-facebook-sign"></i></a></li>
				<li><a href="https://twitter.com/#!/NaulaShowroom"><i class="icon-twitter-sign"></i></a></li>
				<li><a href="http://www.linkedin.com/pub/angel-naula/18/3b4/635"><i class="icon-linkedin-sign"></i></a></li>
			</ul>
	')
);
echo draw_img('showroom.jpg', false, array('class'=>'showroom'));
echo drawBottom();
?>