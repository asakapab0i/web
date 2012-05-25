<?php
include('../include.php');
$array = array_ajax();
echo drawInTheNews(@$array['category_id']);