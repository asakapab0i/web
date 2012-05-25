<?php
include("../../include.php");

list ($html, $count, $caption) = drawGallery();

echo drawTop("2006 Showcase", $count, $caption);

echo $html;

echo drawBottom();
?>