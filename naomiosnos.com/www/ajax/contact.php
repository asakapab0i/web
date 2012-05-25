<?php
include('../include.php');
$array = array_ajax();

email_array('NOSNOS1@nyc.rr.com', 'Message from Your Website', false, $array);

echo 'Thank you for your message';