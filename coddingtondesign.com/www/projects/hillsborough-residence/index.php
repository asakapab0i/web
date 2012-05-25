<?php
include("../../include.php");

list($html, $count, $caption) = drawGallery();

echo drawTop("Hillsborough Residence", $count, $caption);

echo $html;

echo drawBottom();
?>