<?php
include('../include.php');

echo drawTop();

echo draw_div('contact', '
	<p>Brad Ascalon Studio NYC<br/>342 East 84th Street, 4th Floor<br/>New York, NY 10028</p>
	<p>T 917 509 4778</p>
	<p>For general inquiries<br/>' . draw_link('mailto:info@bradascalon.com') . '</p>
	<p>For press inquiries<br/>' . draw_link('mailto:press@bradascalon.com') . '</p>
');

echo draw_div('random', draw_img_random('/images/random/'));
echo draw_javascript('$(document).ready(showRandom);');

echo drawBottom();
?>

