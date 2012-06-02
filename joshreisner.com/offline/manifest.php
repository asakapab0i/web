<?php
include('include.php');
header('Content-Type: text/cache-manifest');
echo 'CACHE MANIFEST' . NEWLINE;
echo lib_location('jquery') . NEWLINE;
echo lib_location('modernizr') . NEWLINE;
echo '/css/global.css' . NEWLINE;
echo '/js/global.js' . NEWLINE;
