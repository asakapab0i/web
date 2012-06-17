<?php
include("../include.php");
echo drawTop("About");
echo draw_javascript("
image1_on		= new Image;
image1_off		= new Image;
image1_on.src	= '/about/1-small_on.jpg';
image1_off.src	= '/about/1-small_off.jpg';
image2_on		= new Image;
image2_off		= new Image;
image2_on.src	= '/about/2-small_on.jpg';
image2_off.src	= '/about/2-small_off.jpg';
image3_on		= new Image;
image3_off		= new Image;
image3_on.src	= '/about/3-small_on.jpg';
image3_off.src	= '/about/3-small_off.jpg';
");
?>
<div class="pixrow">
	<a href="/about/1-large.jpg" rel="lightbox[pixrow]" onmouseover="img_roll('image1', 'on')" onmouseout="img_roll('image1', 'off')"><img src="/about/1-small_off.jpg" name="image1" width="288" height="305" border="0"></a>
	<a href="/about/2-large.jpg" rel="lightbox[pixrow]" onmouseover="img_roll('image2', 'on')" onmouseout="img_roll('image2', 'off')"><img src="/about/2-small_off.jpg" name="image2" width="282" height="305" border="0"></a>
	<a href="/about/3-large.jpg" rel="lightbox[pixrow]" onmouseover="img_roll('image3', 'on')" onmouseout="img_roll('image3', 'off')"><img src="/about/3-small_off.jpg" name="image3" width="277" height="305" border="0"></a>
</div>

<div class="left">
	<!--
	<p>Often saluted for her brains and quick wit, professional actress Audrey Dundee Hannah has the toughness, intensity, and drive for social justice that accompanies a childhood spent in downtown Manhattan. In high school in Palo Alto, California, she began performing in plays both classic and modern, but it was her summer job at an art-house movie theater that taught her what she was really meant to do.  Now based in Hollywood, Audrey&rsquo;s devotion to the medium of film and her rigorous work ethic make her an asset to any set, where she shows up early, prepared, and ready to follow directions.</p>
	<p>A member of the Screen Actors Guild, Audrey&rsquo;s recent credits include webisodes for FOX and Verizon, an untitled sketch comedy TV pilot, various independent films, and an MTV Movie Awards commercial which aired in theaters nationwide.  She honed her on-camera skills at Actor&rsquo;s Certified Training in North Hollywood; studied and performed comedy improvisation at the Upright Citizens Brigade Theater and Second City offshoot Off Off Campus at the University of Chicago; and workshopped her one-woman show at the Marsh in San Francisco.  Audrey holds a B.A. in Drama from Stanford University, where she won the prestigious Eleanor Prosser prize, awarded for excellence in scholarship and performance.</p>
	
	<p>Funny.  Smart.  Ballsy.</p>
	<p>Whether playing domineering alpha females or off-kilter enthusiasts, Audrey’s ability to blend her high-precision comedic sensibility with her intellectual chops and sense of mischief is paramount.</p>
	<p>Audrey is a member of SAG and AFTRA, and has starred in webisodes for FOX and Verizon, a sketch comedy TV pilot, various independent films, and an MTV Movie Awards commercial which aired in theaters nationwide. She honed her on-camera skills at Actor’s Certified Training in North Hollywood; studied and performed comedy improvisation at the Upright Citizens Brigade Theater in New York and Second City at the University of Chicago; and performed her one-woman show at the Marsh in San Francisco. Audrey holds a B.A. in Drama from Stanford University, where she won the prestigious Eleanor Prosser prize, awarded for excellence in scholarship and performance.  At graduation, she clucked “Pomp and Circumstance” over the loudspeaker.  Like a chicken. </p>
	-->
	
	<p>I’ve got smarts (book, street), strength (pillar of), and funny (noun).</p>
	<p>I’m a dramatic actress who loves a great script (degree in Drama from Stanford University, awarded the Eleanor Prosser Prize for excellence), an improviser at home in comedy (Second City and Upright Citizens Brigade trained), and able to play either an intelligent leading lady or a quirky supporting character (versatile).</p>
	<p>Currently, I’m starring in an international Swiffer campaign as a fashionable dirt-covered lady, studying with film director Dan Ireland through his master class, and making my web series "Conclusions To Be Drawn From the Internet."</p>
	
	<div class="title">Links</div>
	<?=draw_img("/images/pdf.png", "audrey-resume.pdf", array("class"=>"icon", "target"=>"_blank"))?><a href="audrey-resume.pdf" target="_blank">Audrey's Resume</a> | <a href="http://www.imdb.com/name/nm3425473/">IMDb</a> | <a href="http://www.youtube.com/user/audreydundeehannah/videos">YouTube</a>
</div>

<div class="right">
	<div class="title">Theatrical Reel</div>
	<object width="400" height="316"
	classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B"
	codebase="http://www.apple.com/qtactivex/qtplugin.cab">
	<param name="src" value="demo-reel.mov">
	<param name="autoplay" value="false">
	<param name="bgcolor" value="#ffffff">
	<param name="controller" value="true">
	
	<embed src="demo-reel.mov" width="400" height="316"
	autoplay="false" controller="true" bgcolor="#ffffff"
	pluginspage="http://www.apple.com/quicktime/download/">
	</embed>
	</object> 
</div>
<?=drawBottom();?>