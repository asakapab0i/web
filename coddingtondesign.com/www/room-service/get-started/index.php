<?php
include('../../include.php');

echo drawFirst('How to Get Started');

echo draw_div('column span3', 
	draw_div('row',
		draw_div('column span3', draw_img('/images/room-service/interior.jpg'))
	) . 
	draw_div('row',
		draw_div('column', '
			<h2>How to Get Started</h2>
			<p>Start dreaming! If money were no object, what would you do in this room?  Send in our questionnaire along with as many inspirational photos as you can, and point out exactly what you like about them.  Reference specific colors or styles you like or dislike. The more specific you are, the better sense we will have of your style.  We will even follow you on Pinterest.</p>
			<p>Select your room to get started.  Once we receive payment we will send you measuring instructions and a detailed questionnaire.</p>
		') . 			
		draw_div('column bump', '
			<p>Take photos.  Stand in each corner of the room and include and furniture you want us to incorporate. Take accurate measurements.  We will e-mail you a guide.</p>
			<p>We will get to work analyzing your style and designing your room.  We use AutoCAD to create the best, most functional floor plan. Then we source furniture, rugs,  and lighting using our extensive network of vendors.  We always double check that we’ve included any existing furniture you would like to keep and the we’ve really captured your style and color preferences.  Finally, we create a photorealistic 3D rendering  of your room with all the new furniture. </p>
		') . 			
		draw_div('column bump', '
			<p>You will receive a unique log in to your own webpage for items purchased through Coddington Design.  These items include window treatments, custom furniture, or showrooms where we get special discounts for you.  We may ask you to order some items directly through a retailer’s website. 
			<p>Still have questions?  <a href="../faq/">Click here</a> for more information.</p>
		')
	)
);

echo drawLast();