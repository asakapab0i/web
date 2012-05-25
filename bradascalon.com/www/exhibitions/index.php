<?php
include('../include.php');

echo drawTop();

$exhibitions = db_table('SELECT title, second_line FROM user_exhibitions WHERE is_active = 1 AND is_published = 1 ORDER BY precedence');
foreach ($exhibitions as &$e) $e = $e['title'] . BR . $e['second_line'];

echo draw_list_columns($exhibitions, 3, 'exhibitions');

echo drawBottom();