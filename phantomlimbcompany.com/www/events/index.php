<?php
include("../include.php");
echo drawTop();
echo '<div class="left">';

foreach ($events as $e) {
	echo '<b><a href="' . $e["link"] . '">' . $e["title"] . '</a></b><br>';
	echo $e["date"] . '<br>';
	echo $e["location"];
	if (isset($e["extlink"])) echo '<br><a href="' . $e["extlink"] . '">EXTERNAL LINK</a>';
	echo '<br><br>';
}
echo '</div>';
echo drawBottom();