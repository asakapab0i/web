<?php
include('../include.php');

$array = array_ajax('email');

if (!db_grab('SELECT COUNT(*) FROM user_subscribers WHERE email = \'' . $array['email'] . '\'')) {
	db_save('user_subscribers', false, $array);
}