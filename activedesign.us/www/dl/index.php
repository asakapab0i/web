<?php
include('../include.php');

if (!url_id()) return false;

if (!$file = db_grab('SELECT title, file, type FROM user_resources WHERE is_active = 1 AND is_published = 1 AND id = ' . $_GET['id'])) exit;
file_download($file['file'], $file['title'], $file['type']);
