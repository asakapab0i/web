<?php
include("../../include.php");

list($html, $count, $caption) = drawGallery();

echo drawTop("Nob Hill", $count, $caption);

echo $html;

echo drawBottom();
?>