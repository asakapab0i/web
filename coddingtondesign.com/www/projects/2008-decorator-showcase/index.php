<?php
include("../../include.php");

list ($html, $count, $caption) = drawGallery();

echo drawTop("2008 Decorator Showcase", $count, $caption);

echo $html;

echo drawBottom();
?>