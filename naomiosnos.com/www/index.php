<?php
include('include.php');

echo drawFirst();

echo draw_img('/images/poland.jpg', '/gallery/?id=8', array('class'=>'poland', 'alt'=>'Poland'));

echo draw_div_class('content', '
	<p>This work, acrylic/collage on canvas, celebrates the publication of a book about my husband’s family. It’s an example of the kind of painting I create to commemorate events or honor individuals.</p>
	<p>I use photocopies of photographs, letters, newspaper clippings, maps, ticket stubs and the like, and add graphic material from my own collections. The surface of the canvas is painted and textured for an overall richness and depth.</p>
	<p>Please look at my <a href="/gallery/">gallery of work</a> and <a href="/contact/">let me know</a> what you think of it and which pieces are your favorites.</p>
');

echo drawLast();