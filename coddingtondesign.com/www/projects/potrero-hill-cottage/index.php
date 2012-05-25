<?php
include('../../include.php');

list($html, $count, $caption) = drawGallery();

echo drawTop('Potrero Hill Cottage', $count, $caption);

echo $html;

echo drawBottom();
?>