<?php
include("../../include.php");

list($html, $count, $caption) = drawGallery();

echo drawTop("Pasadena Residence", $count, $caption);

echo $html;

echo drawBottom();
?>