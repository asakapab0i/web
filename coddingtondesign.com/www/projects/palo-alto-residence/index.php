<?php
include("../../include.php");

list ($html, $count, $caption) = drawGallery();

echo drawTop("Palo Alto Residence", $count, $caption);

echo $html;

echo drawBottom();
?>