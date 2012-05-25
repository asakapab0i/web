<?php
include("../../include.php");

echo drawTop("69&deg;S. : The Shackleton Project");

?>
<div class="left">
<i>69&deg;S. : The Shackleton Project</i> is a series of dynamic <i>tableau vivants</i> inspired by Sir Ernest Shackleton's 1914 Trans-Antarctic Expedition.  
Co-conceived by The Phantom Limb Company and The Kronos Quartet, this narrative installation-in-motion melds theatrical performance, puppetry, photography, and 
film with original contemporary music and an unconventional acoustic palette to create a stunning&mdash;and unprecedented&mdash;artistic and emotional journey.<br>

<?php echo draw_img($request['path'] . "view-1-render.jpg")?>
<span class="caption">Conceived by PLC and Rebecca Yurek</span>
PLC's <i>The 
Shackleton Project</i> aims to bring the unknown Antarctica to an audience, reinvigorating the spirit of forgoing individual glory for the sake of collective survival. <br>


<?php echo draw_img($request['path'] . "view-2-render.jpg")?>
<span class="caption">Conceived by PLC and Rebecca Yurek</span>

Ancient and universal themes including the price of knowledge, the inevitability of adversity and struggle, and ultimately, the power of endurance and camaraderie provide 
emotional ballast with re-interpretations that resonate powerfully in twenty-first century hearts and minds.<br>

<?php echo draw_img($request['path'] . "view-3-render.jpg")?>
<span class="caption">Conceived by PLC and Rebecca Yurek</span>
The Shackleton Project unites some of the finest contemporary 
musical, visual, and performance artists in the world in collaboration to explore the inherently bittersweet and complex nature of the Shackleton experience.<br>


<?php echo draw_img($request['path'] . "waving.jpg")?>
<span class="caption">Photo Frank Hurley</span>
</div>

<div class="right">
	<?php echo drawPress()?>
<a href="/events/" style="font-size:14px;">Come see the show!</a>
<br/><br/>

<?php echo draw_img($request['path'] . "shackleton.jpg");?>
Sir Ernest Shackleton, photo Frank Hurley<br/><br/> 

<a href="http://blog.phantomlimbcompany.com/">The Phantom Limb Antarctica Blog</a>
</div>

<?php
echo drawBottom();