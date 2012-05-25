<?php
include('../include.php');

echo drawTop();

echo draw_div_class('text_wide',
	'<p>Born outside of Philadelphia, Pennsylvania (USA), Brad Ascalon was immersed in the world of art and design from an early age. His grandfather was a noted sculptor and industrial designer, and his father is renowned for his large scale art installations throughout North America. Ascalon earned his Masters’ degree in Industrial Design from New York’s Pratt Institute in 2005, and that same year was recognized by <em>Wallpaper*</em> magazine as one of the world’s "Ten Most Wanted” emerging designers.</p>
	<p>Brad Ascalon Studio NYC was founded in 2006. The multidisciplinary design studio specializes in furniture, packaging, consumer products, environment design and development, as well as site-specific sound composition and installation art projects. Working with clients ranging from large-scale manufacturers to smaller start-ups, branding agencies and private clients, Ascalon’s collaborators have included Fasem, Ligne Roset, Design Within Reach, Bernhardt Design, L’Oreal, Shu Uemura, <em>Esquire</em> magazine, Intel and many others.</p>
	<p>Ascalon’s work has been exhibited globally, from Milan’s Salone Internazionale del Mobile, the world’s largest forum for design, to IMM Cologne in Germany, Maison et Objet in Paris, London’s 100% Design Festival, and the International Contemporary Furniture Fair (ICFF) in New York. Ascalon is also represented by New York’s R’Pure Gallery and Triode Gallery in Paris. His work has been featured globally in publications including <em>Wallpaper*</em>, <em>The New York Times</em>, <em>Architectural Digest</em>, <em>Dwell</em>, <em>Metropolis</em>, <em>Art Review</em>, <em>Le Figaro</em>, <em>Surface Magazine</em> and <em>Interior Design</em>.</p>
	<p>Ascalon lives and works in New York City.</p>
');



echo draw_div_class('photo_caption_wrapper',
	draw_div_class('photo_caption', 'photo: Steve Belkowitz') . 
	draw_img('profile-new.jpg', false, array('class'=>'corner'))
);

echo drawBottom();
