<?php
include('../include.php');

echo drawFirst('Room Service');

echo 
	draw_div('column span3', 
		draw_div('row', 
			draw_div('column span3 big', 
				'<p>Melanie Coddington + You = Room Service.<br>
				Making sure what you love, what you have, and what you can spend come<br>
				together seamlessly. DIY is now DIYD (Do It Yourself, with Designer).'
			) 
		) . 
		draw_div('row', 
			draw_div('column span2', '
				<ul class="slideshow">
					<li><img src="/images/room-service/slideshow/slide1.png" alt="slide1" width="480" height="364"></li>
					<li><img src="/images/room-service/slideshow/slide2.png" alt="slide1" width="480" height="364"></li>
					<li><img src="/images/room-service/slideshow/slide3.png" alt="slide1" width="480" height="364"></li>
					<li><img src="/images/room-service/slideshow/slide4.png" alt="slide1" width="480" height="364"></li>
					<li><img src="/images/room-service/slideshow/slide5.png" alt="slide1" width="480" height="364"></li>
					<li><img src="/images/room-service/slideshow/slide6.png" alt="slide1" width="480" height="364"></li>
					<li><img src="/images/room-service/slideshow/slide7.jpg" alt="slide1" width="480" height="364"></li>
				</ul>
				
				<h2>Our e-design service allows you to:</h2>
				<ul>
				<li>Design one room at a time on your schedule and within your budget.</li>
				<li>Visualize the entire, completed room before you purchase anything.</li>
				<li>Gain access to one of a kind pieces at an affordable price.  Room Service’s resources give you the extra edge to take your room from generic to custom and polished.</li>
				<li>Try before you buy.  Wondering how the walls might look in green?  Want to see how drapes vs. shades will look on your window?  We keep your 3-D rendering on file so you never have to guess.  Nominal $25 fee for each tweak to the design.</li>
				</ul>'
			)
		)
	);

echo drawLast();