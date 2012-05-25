<?php
include('../include.php');
echo drawTop('About Us');

echo drawSnippet(3);

//show the option types
$types = db_table('SELECT id, title, description FROM user_study_topics WHERE is_active = 1 ORDER BY precedence');
foreach ($types as &$t) $t = '<h3>' . draw_link('/studies/?topic=' . $t['id'], $t['title']) . '</h3>' . $t['description'];
echo draw_list($types, 'text_list');
echo drawBottom();
?>