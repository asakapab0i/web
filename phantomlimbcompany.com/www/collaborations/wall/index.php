<? include("../../include.php");

echo drawTop();?>
<div class="left">
Phantom Limb collaborated with <a href="http://www.ulrikequade.nl/">Urlike Quade</a> at MassMoCA in the summer of 2007 and again in 2008 in Holland to create <i>The Wall</i>, a theater piece combining puppetry, music, dance and visual art.   Ulrike Quade is known for her innovative combination of puppetry dance and decor.  Jessica worked closely to develop the set designer Michiel Voet's concept on the decor and set dressing of The Wall as we finallized the piece in The Netherlands in the fall of 2008.  Erik Sanko's collaboration was musical.  He composed original music for this piece as well as blending some of his solo work into it to create a very powerful soundscape.
<br>
<?=draw_img($request['path'] . "thewall.jpg")?>
<span class="caption">Photo By Ben van Duin</span>
<i>The Wall</i> opened on November 12th, 2008 and toured the Netherlands for six weeks.  Subsequent tour dates include Paris at Theatre de la Marionette in May 2009.
</div>

<div class="right">
	<?=draw_img("/images/right/gallery.png");?>
	<ul class="gallery">
		<li><a href="thewall2-large.jpg" rel="lightbox[g]" title="Photo By Ben van Duin"><img src="thewall2-small.jpg" width="84" height="84"></a></li>
		<li><a href="thewall3-large.jpg" rel="lightbox[g]" title="Photo By Ben van Duin"><img src="thewall3-small.jpg" width="84" height="84"></a></li>
		<li><a href="thewall4-large.jpg" rel="lightbox[g]" title="Photo By Ben van Duin"><img src="thewall4-small.jpg" width="84" height="84"></a></li>
	</ul>
</div>
<?=drawBottom();?>