<?php
include('../include.php');

echo drawTop();

$clients = db_table('SELECT id, title, link, ' . db_updated() . ' FROM user_clients WHERE is_active = 1 AND is_published = 1');
foreach ($clients as &$c) $c = draw_img(file_dynamic('user_clients', 'logo', $c['id'], 'jpg', $c['updated']), $c['link'], $c['title'], false, true);
echo draw_list($clients, 'clients');

echo drawBottom();