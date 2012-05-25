<?php
include('../include.php');

echo drawFirst('About');

echo draw_div_class('side', 
	draw_img('/images/naomi-new.jpg') . 
	draw_div_class('caption', 'Site Design by <a href="http://joshreisner.com/">Josh Reisner</a>')
);

echo draw_div_class('content', '
	<p>Color, form and texture have always shaped how I view my surroundings. These have also been the elements of my training as an artist and my professional career as a graphic designer. </p>
	<p>After art studies at Hunter College and the School of Visual Arts – with Robert Motherwell, Richard Lippold and William Baziotes, among others – I went on to spend 20 years as a book designer and art director at Random House. My work there put me in contact with some of the best photography, typography, illustration and graphic design produced in America and Europe.</p>
	<p>That experience has inspired my current painting and work in collage. I collect material from catalogues, newspapers and books and use it, along with a variety of ephemera, in my work.</p>
	<p>When I start a new project, I make a rough grid on the canvas, which I cover in rich colors (to be layered over several times). I usually start with one large graphic collage and work around it, filling the grid with more collage elements and painted patterns to create depth and texture. Each piece grows organically until I feel it is finished.</p>
	
	<p>Solo show, Summer, 2008, Mojo Coffee, NYC
	
	<p><a href="http://www.ezairgallery.com/index_Naomi.html" target="new">Solo Show, April, 2006, Ezair Gallery, NYC</a></p>
	
	<p>Group Shows (2000 to 2002):
	<ul>
	<li><span>Limner Gallery, NYC.</span></li>
	<li><span>Gallery 214, Montclair, NJ.</span></li>
	<li><span>Period Gallery, Omaha, NE.</span></li>
	<li><span>Smithtown Township Arts Council, NY.</span></li>
	<li><span>Gallery on the Square, Denville, KY.</span></li>
	</ul>
	</p>
	
	<p>Private Collections: NY, CT, NJ, MA, CA.</p>
');
 
echo drawLast();