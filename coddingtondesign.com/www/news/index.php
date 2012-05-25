<?php
include("../include.php");

echo drawTop("Recent News", "Newsletter Archives / PDF<br/><br/>
	<a href='2009-summer.pdf' target='_blank'>Summer 2009&gt;</a><br/>	
	<a href='2009-winter.pdf' target='_blank'>Winter 2009&gt;</a><br/>	
	<a href='2007-autumn.pdf' target='_blank'>Autumn 2007&gt;</a>
	");
?>
<div class="column">
	<p><?=draw_img("/news/12-1-09-news.jpg")?></p>
	<p><i>Melanie Honored in House Beautiful</i></p>
	<p><i>House Beautiful</i> has named Melanie one of the country's top 20 young interior designers. Check out the story, <a href="http://www.housebeautiful.com/decorating/next-wave-melanie-coddington">The Next Wave</a>, in the December issue.</p>
</div>
<div class="column">
	<p><?=draw_img('/news/7x7-melanie-living-room.jpg')?></p>
	<p><i>Melanie Featured in 7x7 Magazine</i></p>
	<p>Melanie's own living room was featured in the October issue of 7x7.  Click <a href="7x7-melanie-living-room.pdf">here</a> to see the beaded wallpaper and eclectic art arrangement in her living room.</p>
</div>
<div class="column last">
	<p><?=draw_img("/news/melanie2.jpg")?></p>
	<p><i>Melanie as Stylemaker</i></p>
	<p><a href="http://www.sfgate.com/cgi-bin/article.cgi?f=/c/a/2009/04/19/HOHN16SD2O.DTL" target="_blank">Click here</a> to see what she has to say about matching dining room sets (Ew!) and her own girly modern home in Potrero Hill.</p>
</div>
<?=drawBottom();?>