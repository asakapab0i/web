<?php
include('include.php');
echo drawTop('Featured Projects');
echo draw_div_class('column', draw_img('/images/home/01-splash.jpg', '/projects/?id=5'));
echo draw_div_class('column', draw_img('/images/home/02-splash.jpg', '/projects/?id=3'));
echo draw_div_class('column last', draw_img('/images/home/05-splash.jpg', '/projects/?id=2'));
echo drawBottom();
?>