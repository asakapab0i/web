<?php
include('include.php');

$data = array_receive();

db_query('INSERT INTO errors (
	app_name,
	title,
	description,
	url,
	host,
	created_date,
	user_name,
	user_email
) VALUES ( 
	\'' . format_quotes($data['app_name']) . '\',
	\'' . format_quotes($data['title']) . '\',
	\'' . format_quotes($data['description']) . '\',
	\'' . format_quotes($data['url']) . '\',
	\'' . format_quotes($data['sanswww']) . '\',
	NOW(),
	\'' . format_quotes($data['user_name']) . '\',
	\'' . format_quotes($data['user_email']) . '\'
)');