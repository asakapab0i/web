<?php
include("../include.php");
echo drawTop();

$future	= array();
$past	= array();
$now	= date('U');
foreach ($events as $e) {
	if ($e['udate'] >= $now) {
		$future[] = $e;
	} else {
		$past[] = $e;
	}
}
if (count($future)) $future = array_sort($future);
if (count($past)) $past = array_sort($past, 'desc');


function drawEvents($events) {
	$return = '';
	foreach ($events as $e) {
		$return .= '<strong><a href="' . $e["link"] . '">' . $e["title"] . '</a></strong>' . BR .
			$e["date"] . BR . $e["location"];
		if (isset($e["extlink"])) $return .= ' <em>[<a href="' . $e["extlink"] . '">link</a>]</em>';
		$return .= BR . BR;
	}
	return $return;
}

echo '<div class="left"><h2>Events</h2>' . drawEvents($future) . drawEvents($past) . '</div>';

echo drawBottom();