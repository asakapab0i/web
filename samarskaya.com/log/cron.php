#!/usr/local/bin/php.cli
<?php
$_SERVER['HTTP_HOST']		= 'log.samarskaya.com';
$_SERVER['SCRIPT_NAME']		= '/cron.php';
$_SERVER['DOCUMENT_ROOT']	= '/home/samarska/www/log';

include('include.php');

if ($weather = array_rss('http://www.rssweather.com/rss.php?config=&forecast=zandh&place=new+york&state=ny&zipcode=&country=us&county=36061&zone=NYZ072&alt=rss20a')) {
	db_query('UPDATE cron SET weather = \'' . format_quotes($weather['channel']['item'][1]['description']) . '\'');
}

if ($news = array_rss('http://feeds.reuters.com/reuters/topNews?format=xml')) {
	db_query('UPDATE cron SET 
		news = \'' . format_quotes($news['channel']['item'][0]['title']) . '\',
		news_date = \'' . format_date($news['channel']['item'][0]['pubDate'], '', 'sql') . '\'
	');
}

echo 'done processing';