<?php
include("../include.php");
echo drawTop("About", false, 'Photos: ' . draw_link('http://www.drewaltizer.com/', 'Drew Altizer'));
?>
<div class="big">
	Coddington Design specializes in exceptional residential interiors.  Hallmarks of our style are strong silhouettes, sophisticated use of color, and quality
	workmanship.
</div>

<div class="column">
	<p><?=draw_img('/about/melanie.jpg');?></p>
	<p><i>Melanie Coddington, Founding Principal</i></p>
	<p>A northern California native, Coddington earned a BA in psychology and MA in sociology&mdash;studies which would later inform her design practice&mdash;before embarking on a successful corporate career.  However, when she found herself spending her free time poring over shelter publications and attending showhouses, Coddington decided a career in design just might be more her style.  She took the leap in 2000, studying interior design at Berkeley and working at a top San Francisco firm before launching her own eponymous company in 2004.</p>
	<p>Coddington emerged as a talent to watch.  In 2005, after only two months on her own, she was selected to design a space at the San Francisco Decorator Showcase; in 2006 and 2008 she was again invited to participate in the city&rsquo;s premiere design event.</p>
	<p>Coddington is a member of the ASID and the Institute for Classical Architecture.</p>
</div>

<div class="column">
	<p><?=draw_img('/about/taylor.jpg');?></p>
	<p><i>Taylor Tanimoto, Senior Designer</i></p>
	<p>Taylor Tanimoto is a talented designer and draftsperson.  She ensures even the most complicated construction projects run smoothly and no detail is overlooked.</p>
	<p>Prior to joining Coddington Design in 2005, Taylor worked in high end residential design firms specializing in vacation homes.  She holds an Interior Architecture and Design degree from Academy of Art University and an undergraduate degree in Anthropology.</p>
</div>
<?=drawBottom();?>