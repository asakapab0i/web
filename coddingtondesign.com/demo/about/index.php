<?php
include('../include.php');

echo drawFirst('About');

echo draw_div('column span3', 
	draw_div('row',
		draw_div('column span2', draw_img('/images/about/melanie.jpg')) . 
		draw_div('column bio', draw_div('inner',
			'<h2>Melanie Coddington, Creative Director</h2>
			<p>Interior designer Melanie Coddington is known for spaces with elegance, charm and just the right amount of glam. Named one of the country’s Top 20 young interior designers by House Beautiful, Coddington designs residences and creative commercial spaces from studios in San Francisco and Los Angeles. Coddington’s recent projects include homes in Los Angeles, Pacific Heights, Napa Valley and Carmel.  Her work has been featured in InStyle, House Beautiful, Traditional Home, California Home & Design, San Francisco Magazine, and many other publications.</p>'
		))
	) .
	draw_div('row',
		draw_div('column span2', draw_img('/images/about/taylor.jpg')) . 
		draw_div('column bio', draw_div('inner',
			'<h2>Taylor Tanimoto, Senior Designer</h2>
			<p>Taylor Tanimoto is a talented designer and draftsperson. She ensures even the most complicated construction projects run smoothly and no detail is overlooked.</p>
			<p>Prior to joining Coddington Design in 2005, Taylor worked in high end residential design firms specializing in vacation homes. She holds an Interior Architecture and Design degree from Academy of Art University and an undergraduate degree in Anthropology.</p>'
		))
	)
);

echo drawLast();