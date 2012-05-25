<? include("../../include.php");

echo drawTop();?>
<div class="left">
Set design for the Danish premiere of Andrew Bovell's play, <i>Speaking in Tongues</i>, produced by <a href="http://www.eklektisk.dk/">Eklektisk Teaterproduktion</a> and Crossways.
<br>
<?=draw_img($request['path'] . "speaking.jpg")?>
<br>
Premiered in September of 2007 in Copenhagen.  Directed by Daniel Safer.

</div>

<div class="right">
	<!--<span class="caption">Set Rendering by PLC and Rebecca Yurek</span>-->
	<?=draw_img("/images/right/gallery.png");?>
	<ul class="gallery">
		<li><a href="venuswp-large.jpg" rel="lightbox[g]" title="By PLC and Rebecca Yurek"><img src="venuswp-small.jpg" width="84" height="84"></a></li>
		<li><a href="setting-large.jpg" rel="lightbox[g]" title="By PLC"><img src="setting-small.jpg" width="84" height="84"></a></li>
		<li><a href="leaning-large.jpg" rel="lightbox[g]" title="By PLC"><img src="leaning-small.jpg" width="84" height="84"></a></li>
		<li><a href="drawers-large.jpg" rel="lightbox[g]" title="By PLC"><img src="drawers-small.jpg" width="84" height="84"></a></li>
		<li><a href="looking-large.jpg" rel="lightbox[g]" title="By PLC"><img src="looking-small.jpg" width="84" height="84"></a></li>
	</ul>
</div>
<?=drawBottom();?>