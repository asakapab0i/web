<? include("../include.php");

echo drawTop();

echo '<div class="left press">';
$press = array_sort($press, "desc");
foreach ($press as $p) {
	$p["pdf"]	= "/press/pdfs/" . $p["pdf"];
	$p["logo"]	= "/press/logos/" . $p["logo"];
	echo draw_img($p["logo"], $p["pdf"], "", "press");
	echo '<b><a href="' . $p["pdf"] . '">' . $p["title"] . '</a></b><br>';
	echo format_date($p["udate"], "", "l, F j, Y") . '<br>';
	echo $p["publication"];
	echo '<br><br>';
}
echo '</div>';

echo drawBottom();
?>