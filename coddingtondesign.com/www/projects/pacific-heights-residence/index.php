<?php
include("../../include.php");

list ($html, $count, $caption) = drawGallery();

echo drawTop("Pacific Heights Residence", $count, $caption);

echo $html;

echo drawBottom();
?>