<?php
include('../../include.php');

echo drawFirst('How to Get Started');

echo draw_div('column span3', 
	draw_div('row',
		draw_div('column', '
			<h2>Q:  What is the difference between full service interior design and room service?</h2>
			<p>A:  With full-service (on-location) design, we visit your space, take measurements, and ask about your lifestyle and decorating style. With online design services, you do most of the legwork and send your information, photos, and likes and dislikes to us via email. With full service design we engage with you over weeks and months and present many design solutions for many rooms, with Room Service, we present one plan for one room only.</p>
			
			<h2>Q:  What does the questionnaire involve?</h2>
			<p>A:  The questionnaire will ask you about how you currently use the room and how you would like to use it.  We ask you all about your preferences and dislikes and ask you to send along images of finished rooms or furniture that appeals to you.  Send as many inspirational photos as you can, and point out exactly what you like about them. Similarly, reference specific colors or styles you like or dislike. The more specific you are, the better sense we will have of your style. Point out any quirks about your space that might not show up in the photographs, like heater vents or cable outlets.</p>
			
			<h2>Q:  How do I determine my budget?</h2>
			<p>A:  Savvy Budget - up to $7500, Smart budget - up to $15,000, Posh budget - $25,000 and up.  Budgets will vary widely based on how much furniture, lighting, area rugs, etc. you need in the room.  With our expert eye on your project, we allocate your budget to maximize every dollar spent on your room.</p>
		') . 
		draw_div('column', '
			<h2>Q:  I’m too busy to take detailed measurements of my room.  Can you come out to measure for me?</h2>
			<p>A:  If you are in the greater Los Angeles, Carmel, or the San Francisco Bay Area we can take measurements and photos for a fee.  Please e-mail for more information.</p>
			
			<h2>Q:  Can I switch out items?</h2>
			<p>A:  Your Room Service design will come with a specification list for each item of furniture needed.  We are happy to reselect one or two items for you on a case-by-case basis.</p>
			
			<h2>Q:  I found something on a flash sale site I think might work better.  Can I see that item in my 3-D rendering?</h2>
			<p>A:  Yes, just e-mail roomservice@coddingtondesign.com a photo of the items and dimensions.  The fee is $25 per item.  We will work as quickly as we can but no guarantee the sale will still be going on.</p>
			
			<h2>Q:  I  love the design but is it possible to see another color on the walls in the 3-D rendering?</h2>
			<p>A:  Yes, the fee is $25 per color.</p>
			
			<h2>Q:  Will you send me a box with fabric swatches and photos?</h2>
			<p>A:  No, Room Service by Melanie Coddington is a purely virtual service.  We provide you with digital images of all materials, but if you want to touch and feel the fabric, swatches will be mailed either from us or directly from the manufacturer.</p>
		') . 
		draw_div('column', '
			<h2>Q:  How do I order the items you specified for me?</h2>
			<p>A:  The items that list Coddington Design as the vendor will be available in your personal studio website.  Please click “approve” next to the items you want to order and mail a check to us for the proper amount.  If the vendor is not listed as Coddington Design, click on the link in your specification sheet and order directly through the vendor’s website.</p>
			
			<h2>Q:  How do I know whether I will like the paint color you select for me?</h2>
			<p>A:  We love color but we know this can be a really challenging part of the design process for many people.  We specify wall, trim, and ceiling color including manufacturer and color name and number.  We suggest you purchase a sample can of the paint and paint sample squares on your wall.  Be sure to look at the paint color in natural light during the day and at night. If the color seems to strong, you can have your local paint store add 50% white and try that on the wall.</p>
			
			<h2>Q:  Will my designer contact me during the design process?</h2>
			<p>A:  We may e-mail you if we have questions.  Feel free to reach out to us via e-mail to check status or pass along additional information.</p>
			
			<h2>Q:  How long will my Room Service design take?</h2>
			<p>A:  Generally 4-6 weeks depending on our workload.  In a hurry?  Let us know and we will do our best to meet your deadline.</p>
		')
	)
);

echo drawLast();