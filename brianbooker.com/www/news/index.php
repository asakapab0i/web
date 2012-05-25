<?php
include('../include.php');
echo drawTop();

echo draw_div('left', draw_img('/news/bio.jpg') . draw_div_class('caption', 'Site Design by <a href="http://joshreisner.com/" style="color:#eae2cd;">Josh Reisner</a>'));

echo draw_div('page_right', draw_div_class('inner', '
	<p>Brian is a fiction writer and visual artist living in Brooklyn.  His assemblages are often situated in collaged wooden boxes, in which blocks of clear resin--containing preserved biological specimens, glass vials, antique texts, cloth, and other items--are mounted. These box constructions involve images and themes which also occur in his stories.  He is interested in the Wunderkammer or cabinet of curiosities as a genre with both plastic and literary possibilities.</p>
	<p>Brian\'s short stories have appeared in <i>AGNI Online, The Antioch Review, Conjunctions, Epoch, The L Magazine Online, Literal Latté, New England Review, One Story, Oyster Boy Review, Post Road, Shenandoah, Tin House</i>, and <i>TriQuarterly</i>. His stories have been nominated for the Pushcart Prize three times, and his collection <i>The Sleeping Sickness</i> was a finalist in the 2005 Iowa Short Fiction Awards. He has been awarded residencies at Blue Mountain Center in the Adirondacks and Hall Farm Center in Vermont.  He holds a Ph.D. in English & American Literature from New York University, with a dissertation on David Foster Wallace\'s <i>Infinite Jest</i>.  Brian taught courses in the English and Expository Writing programs.</p>
	<p>Brian is the Grace Paley Writing Fellow for 2009-2010 at the Fine Arts Work Center in Provincetown, Massachussetts.  His public reading is on March 13th, 2010.</p>
	<p>Watch Brian read from his story ' . draw_link('/fiction/?id=2', 'Gumbo Limbo') . ' at the studios of Provincetown Community Television on January 21st, 2010.</p>
	<p><object width="485" height="275"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=9960032&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=b19d82&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=9960032&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=b19d82&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="485" height="275"></embed></object></p>
	<p><a href="http://www.monomaga.net/wpp/shop/ProductDetail.aspx?sku=606" target="_blank"><img src="/news/mono.png" style="float:left; border:none; margin:0px 20px 20px 0px;"></a> Brian\'s artwork has been featured in <a href="http://www.monomaga.net/wpp/shop/ProductDetail.aspx?sku=606" target="_blank">Mono Magazine</a> and is available for sale at his <a href="http://www.etsy.com/shop.php?user_id=6157455" target="_blank">Etsy shop</a>.</p>'));

echo drawBottom();
?>