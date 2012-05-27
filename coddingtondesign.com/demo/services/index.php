<?php
include('../include.php');

echo drawFirst('Room Service');

echo draw_div('column span2', 
	draw_div('row', draw_div('column span2', draw_img('/images/services/interior.jpg'))) . 
	draw_div('row', 
		draw_div('column', '
			<h2>Full Service Residential Interior Design</h2>
			<p>Coddington Design provides comprehensive design services, expertly managing all details from concept to installation.  We keep it fresh, and keep it “you” by involving you in every step of the design process, whether that means starting with a blank canvas or incorporating favorite existing furnishings and heirlooms. Coddington Design cultivates an extensive network of the best ateliers, shops and workrooms, enabling us to create singular, luxurious homes, and our resources include antiquarians, art advisors, home technology/AV consultants and many other trade specialists.</p>
		') . 
		draw_div('column', '
			<h2>Full Service Commercial Design</h2>
			<p>Located in San Francisco-just north of Silicon Valley-as well as in Los Angeles-the heart of the entertainment industry-Coddington Design is privileged to work with innovative entrepreneurs.  We thrive on creating stylish office, retail and commercial spaces that help drive business and media buzz for your company.</p>
			
			<h2>3-D Renderings</h2>
			<p>In addition to AutoCAD floor plans and elevations, we bring your room design to life with photorealistic three dimensional renderings of your rooms.</p>
		')
	)
) . 
draw_div('column', '
	<h2>New Construction</h2>
	<p>From concept to housewarming, we can collaborate with your architectural and GC group, or bring in our experienced Coddington team to realize your vision of home.</p>
	
	<h2>Residential Remodeling</h2>
	<p>Whether you’ve purchased a new home or are adding to your current residence, Coddington Design has the project management experience and expertise to keep your project on track, on time, and on budget.</p>
	
	<h2>Custom Furniture Design</h2>
	<p>Our clients appreciate knowing that we work with exceptional ateliers and workrooms to create impeccable custom pieces. Coddington Design’s design capabilities include seating, casegoods, lighting and more.</p>
	
	<h2>Consultation</h2>
	<p>Coddington Design can provide advice and create a plan for your space that includes color and fabic selections, furniture layout, and more. We can also help you refine existing elements and make suggestions to guide you in the right direction. Please contact us for additional information.</p>
	
	<p>Coddington Design services are available nationally and internationally via our <a href="/room-service/">virtual design service</a>.</p>
');

echo drawLast();